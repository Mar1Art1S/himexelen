<?php

$wpDir = __DIR__ . '/../resources/beelg__WP';

if (!is_dir($wpDir)) {
    echo "WordPress directory not found.\n";
    exit(1);
}

function searchDir($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            // Ignore some standard WordPress folders to make it fast
            if ($file === 'wp-admin' || $file === 'wp-includes' || $file === 'languages' || $file === 'cache') {
                continue;
            }
            searchDir($path);
        } else {
            if (stripos($file, 'calc') !== false || stripos($file, 'price') !== false) {
                echo "Found file: $path\n";
            }
        }
    }
}

echo "Searching WordPress directory for calculator/price files...\n";
searchDir($wpDir);
