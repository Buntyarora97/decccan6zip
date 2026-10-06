<?php
/**
 * <head> — meta, fonts, styles. $seo array index.php se aata hai.
 */
$ogImage = dm_url($seo['image'] ?? 'assets/img/hospital-shoot/hospital-exterior-front.webp');
$canonical = $seo['canonical'] ?? null;
$robots = $seo['robots'] ?? 'index, follow';
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($seo['title']) ?></title>
<meta name="description" content="<?= e($seo['desc']) ?>">
<?php if ($canonical): ?><link rel="canonical" href="<?= e($canonical) ?>"><?php endif; ?>
<meta name="robots" content="<?= e($robots) ?>">
<?php if (!empty($seo['preloadImage'])): ?><link rel="preload" as="image" href="<?= e(dm_url($seo['preloadImage'])) ?>" fetchpriority="high"><?php endif; ?>
<meta name="google-site-verification" content="p8XYC4RvDDep8JSWlyko6NKMch8KpjwQV7fjVIZc7kk" />
<meta name="theme-color" content="#102b50">
<!-- Open Graph -->
<meta property="og:type" content="<?= e($seo['ogType'] ?? 'website') ?>">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:title" content="<?= e($seo['title']) ?>">
<meta property="og:description" content="<?= e($seo['desc']) ?>">
<meta property="og:locale" content="en_IN">
<?php if ($canonical): ?><meta property="og:url" content="<?= e($canonical) ?>"><?php endif; ?>
<meta property="og:image" content="<?= e($ogImage) ?>">
<?php if (!empty($seo['published'])): ?><meta property="article:published_time" content="<?= e($seo['published']) ?>"><?php endif; ?>
<?php if (!empty($seo['updated'])): ?><meta property="article:modified_time" content="<?= e($seo['updated']) ?>"><?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($seo['title']) ?>">
<meta name="twitter:description" content="<?= e($seo['desc']) ?>">

<!-- Favicon -->
<link rel="icon" type="image/webp" href="<?= e(dm_url('assets/img/favicon-brand.webp')) ?>">
<link rel="apple-touch-icon" type="image/webp" href="<?= e(dm_url('assets/img/favicon-brand.webp')) ?>">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"></noscript>

<!-- Vendor CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Main CSS -->
<link rel="stylesheet" href="<?= e(dm_url('assets/css/style.css')) ?>?v=1.0.21">
<link rel="stylesheet" href="<?= e(dm_url('assets/css/phase-one-refresh.css')) ?>?v=1.0.9">
<link rel="stylesheet" href="<?= e(dm_url('assets/css/mega-menu-refresh.css')) ?>?v=1.0.1">
<link rel="stylesheet" href="<?= e(dm_url('assets/css/facilities-page-refresh.css')) ?>?v=1.0.0">

<?= dm_schema_organization() ?>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
