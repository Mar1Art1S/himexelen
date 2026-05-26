<?php

header('Content-Type: text/plain; charset=utf-8');

$resourcesDir = __DIR__ . '/../resources';
echo "=== FILES IN RESOURCES ===\n";
if (file_exists($resourcesDir)) {
    print_r(scandir($resourcesDir));
} else {
    echo "Resources directory not found\n";
}

$wpSql = __DIR__ . '/../resources/127_0_0_1 (1).sql';
$joomlaSql = __DIR__ . '/../resources/127_0_0_1.sql';

function searchSql($path, $keywords) {
    if (!file_exists($path)) {
        echo "File not found: $path\n";
        return;
    }
    echo "\nSearching in $path (Size: " . filesize($path) . " bytes)...\n";
    $handle = fopen($path, 'r');
    $matches = [];
    $lineNum = 0;
    while (($line = fgets($handle)) !== false) {
        $lineNum++;
        
        // Decode Unicode escapes for comparison
        $decodedLine = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $line);

        foreach ($keywords as $kw) {
            if (stripos($decodedLine, $kw) !== false) {
                $matches[] = "Line $lineNum matches '$kw': " . substr(trim($decodedLine), 0, 500);
                if (count($matches) >= 30) {
                    echo "Found more than 30 matches, truncating.\n";
                    break 2;
                }
            }
        }
    }
    fclose($handle);
    echo implode("\n\n", $matches) . "\n";
}

$keywords = ['Дно', 'Дах', 'Крыша', 'Корпус', 'Кормушка', 'Годівниця', 'Коробка', 'дах 8', 'дно 8', 'dah'];
searchSql($wpSql, $keywords);

if (file_exists($joomlaSql)) {
    searchSql($joomlaSql, $keywords);
} else {
    // Check if there is another name
    $files = scandir($resourcesDir);
    foreach ($files as $file) {
        if (strpos($file, '127_0_0_1') !== false && $file !== '127_0_0_1 (1).sql') {
            searchSql($resourcesDir . '/' . $file, $keywords);
        }
    }
}
