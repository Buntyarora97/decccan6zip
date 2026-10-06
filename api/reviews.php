<?php
/** API: publish visitor feedback immediately after explicit consent. */
declare(strict_types=1);

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/reviews.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['ok' => false, 'message' => 'Invalid request.'], 405);
}
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    json_response(['ok' => false, 'message' => 'Your session expired. Refresh the page and try again.'], 403);
}
if (!empty($_POST['website'])) {
    json_response(['ok' => true, 'message' => 'Thank you for your feedback.']);
}
if (rate_limited('public_review', 3, 3600)) {
    json_response(['ok' => false, 'message' => 'Too many reviews were submitted from this session. Please try again later.'], 429);
}

$name = clean((string) ($_POST['name'] ?? ''), 80);
$text = clean((string) ($_POST['review'] ?? ''), 1800);
$text = preg_replace('/[ \t]+/u', ' ', $text) ?? $text;
$text = preg_replace('/\n{3,}/u', "\n\n", $text) ?? $text;
$ratingValue = (string) ($_POST['rating'] ?? '');
$rating = preg_match('/^[1-5]$/', $ratingValue) ? (int) $ratingValue : 0;

if (mb_strlen($name) < 2) {
    json_response(['ok' => false, 'message' => 'Please enter your name.'], 422);
}
if ($rating < 1 || $rating > 5) {
    json_response(['ok' => false, 'message' => 'Please choose a star rating.'], 422);
}
if (mb_strlen($text) < 10) {
    json_response(['ok' => false, 'message' => 'Please add a little more detail to your review.'], 422);
}
if (empty($_POST['consent'])) {
    json_response(['ok' => false, 'message' => 'Please confirm that your review and any photo may be shown publicly.'], 422);
}

$id = bin2hex(random_bytes(12));
$imagePath = '';
$savedImage = '';

try {
    $photo = $_FILES['photo'] ?? null;
    if (is_array($photo) && ($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        if (($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('The photo could not be uploaded. Please try a smaller image.');
        }
        if (!is_uploaded_file((string) ($photo['tmp_name'] ?? ''))) {
            throw new InvalidArgumentException('Please choose a valid image file.');
        }
        if ((int) ($photo['size'] ?? 0) > 5 * 1024 * 1024) {
            throw new InvalidArgumentException('Please choose an image smaller than 5 MB.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file((string) $photo['tmp_name']);
        $formats = [
            'image/jpeg' => ['extension' => 'jpg', 'decoder' => 'imagecreatefromjpeg'],
            'image/png' => ['extension' => 'png', 'decoder' => 'imagecreatefrompng'],
            'image/webp' => ['extension' => 'webp', 'decoder' => 'imagecreatefromwebp'],
        ];
        if (!isset($formats[$mime]) || !function_exists($formats[$mime]['decoder'])) {
            throw new InvalidArgumentException('Use a JPEG, PNG or WebP image.');
        }

        $imageInfo = @getimagesize((string) $photo['tmp_name']);
        if (!$imageInfo || $imageInfo[0] < 1 || $imageInfo[1] < 1 || ($imageInfo[0] * $imageInfo[1]) > 8000000) {
            throw new InvalidArgumentException('This image is too large to process. Please choose a smaller photo.');
        }

        $source = @$formats[$mime]['decoder']((string) $photo['tmp_name']);
        if (!$source) {
            throw new InvalidArgumentException('This image could not be read. Please choose another photo.');
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min(1, 1800 / max($width, $height));
        $targetWidth = max(1, (int) round($width * $scale));
        $targetHeight = max(1, (int) round($height * $scale));
        $target = imagecreatetruecolor($targetWidth, $targetHeight);

        if ($mime === 'image/jpeg') {
            $white = imagecolorallocate($target, 255, 255, 255);
            imagefill($target, 0, 0, $white);
        } else {
            imagealphablending($target, false);
            imagesavealpha($target, true);
            $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
            imagefill($target, 0, 0, $transparent);
        }

        imagecopyresampled($target, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $uploadDir = __DIR__ . '/../uploads/reviews';
        if (!is_dir($uploadDir) && !@mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
            imagedestroy($source);
            imagedestroy($target);
            throw new RuntimeException('Photo storage is unavailable. Please submit without a photo.');
        }

        $fileName = $id . '-' . bin2hex(random_bytes(4)) . '.' . $formats[$mime]['extension'];
        $absolutePath = $uploadDir . '/' . $fileName;
        $saved = match ($mime) {
            'image/jpeg' => imagejpeg($target, $absolutePath, 84),
            'image/png' => imagepng($target, $absolutePath, 6),
            'image/webp' => function_exists('imagewebp') && imagewebp($target, $absolutePath, 82),
        };

        imagedestroy($source);
        imagedestroy($target);

        if (!$saved) {
            @unlink($absolutePath);
            throw new RuntimeException('The photo could not be saved. Please submit without a photo.');
        }

        $imagePath = 'uploads/reviews/' . $fileName;
        $savedImage = $absolutePath;
    }
} catch (InvalidArgumentException $e) {
    json_response(['ok' => false, 'message' => $e->getMessage()], 422);
} catch (Throwable $e) {
    error_log('Review photo processing failed: ' . $e->getMessage());
    json_response(['ok' => false, 'message' => 'The photo could not be processed. Please try again or submit without it.'], 500);
}

$review = [
    'id' => $id,
    'name' => $name,
    'rating' => $rating,
    'text' => $text,
    'image_path' => $imagePath,
    'created_at' => gmdate('c'),
];

if (!dm_store_public_review($review)) {
    if ($savedImage !== '') {
        @unlink($savedImage);
    }
    error_log('Visitor review could not be written to the private review store.');
    json_response(['ok' => false, 'message' => 'Reviews are temporarily unavailable. Please try again later.'], 500);
}

json_response([
    'ok' => true,
    'message' => 'Thank you, ' . $name . '. Your review is now visible.',
    'review' => [
        'id' => $id,
        'name' => $name,
        'rating' => $rating,
        'text' => $text,
        'image_url' => $imagePath !== '' ? dm_url($imagePath) : '',
        'created_at' => $review['created_at'],
        'date_label' => date('M j, Y'),
    ],
], 201);
