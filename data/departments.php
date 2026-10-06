<?php
/**
 * Departments loader — saare departments merge karke return karta hai.
 */
declare(strict_types=1);

function dm_departments(): array
{
    static $depts = null;
    if ($depts === null) {
        $depts = array_merge(
            require __DIR__ . '/departments-1.php',
            require __DIR__ . '/departments-2.php',
            require __DIR__ . '/departments-3.php'
        );
    }
    return $depts;
}
