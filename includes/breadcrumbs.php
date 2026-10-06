<?php
/**
 * Breadcrumbs — usage: dm_breadcrumbs(['Home' => '', 'Departments' => 'departments', 'Neurosurgery' => null]);
 * Last item (null URL) = current page. JSON-LD bhi emit hota hai.
 */
declare(strict_types=1);

function dm_breadcrumbs(array $items): void
{
    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    $total = count($items);
    $i = 0;
    foreach ($items as $label => $url) {
        $i++;
        if ($url !== null && $i < $total) {
            echo '<a href="' . e(dm_url($url)) . '">' . e($label) . '</a>';
            echo '<span class="sep" aria-hidden="true">/</span>';
        } else {
            echo '<span aria-current="page">' . e($label) . '</span>';
        }
    }
    echo '</nav>';
    echo dm_schema_breadcrumbs(array_filter($items, fn($u) => $u !== null));
}
