<?php
/**
 * Public visitor reviews are stored as newline-delimited JSON outside the
 * public URL space. The data directory is blocked by .htaccess and the
 * Replit preview router.
 */
declare(strict_types=1);

function dm_review_store_path(): string
{
    return __DIR__ . '/../data/submitted-reviews.jsonl';
}

/** @return list<array{id:string,name:string,rating:int,text:string,image_path:string,created_at:string,date_label:string}> */
function dm_public_reviews(int $limit = 12): array
{
    $limit = max(0, min($limit, 100));
    if ($limit === 0) {
        return [];
    }

    $handle = @fopen(dm_review_store_path(), 'rb');
    if (!$handle) {
        return [];
    }
    if (!flock($handle, LOCK_SH)) {
        fclose($handle);
        return [];
    }

    $reviews = [];
    while (($line = fgets($handle)) !== false) {
        $record = json_decode($line, true);
        if (!is_array($record)) {
            continue;
        }

        $id = (string) ($record['id'] ?? '');
        $name = trim((string) ($record['name'] ?? ''));
        $text = trim((string) ($record['text'] ?? ''));
        $rating = (int) ($record['rating'] ?? 0);
        $createdAt = (string) ($record['created_at'] ?? '');
        $timestamp = strtotime($createdAt);
        $imagePath = (string) ($record['image_path'] ?? '');

        if (
            !preg_match('/^[a-f0-9]{24}$/', $id)
            || $name === ''
            || $text === ''
            || $rating < 1
            || $rating > 5
            || !$timestamp
        ) {
            continue;
        }

        if (!preg_match('#^uploads/reviews/[a-f0-9-]+\.(?:jpg|png|webp)$#D', $imagePath)) {
            $imagePath = '';
        }

        $reviews[] = [
            'id' => $id,
            'name' => $name,
            'rating' => $rating,
            'text' => $text,
            'image_path' => $imagePath,
            'created_at' => $createdAt,
            'date_label' => date('M j, Y', $timestamp),
        ];
    }

    flock($handle, LOCK_UN);
    fclose($handle);

    return array_reverse(array_slice($reviews, -$limit));
}

function dm_store_public_review(array $review): bool
{
    $handle = @fopen(dm_review_store_path(), 'ab');
    if (!$handle) {
        return false;
    }
    if (!flock($handle, LOCK_EX)) {
        fclose($handle);
        return false;
    }

    $line = json_encode($review, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    $written = fwrite($handle, $line);
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);

    return $written === strlen($line);
}
