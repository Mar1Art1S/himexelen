<?php

$keywords = ['ДНО', 'ДАХ', 'КОРПУС', 'ГОДІВНИЦЯ', 'МПЗ', 'МЛП', 'ВПЗ', 'ВЛП', 'цена'];
$wpSql = __DIR__ . '/../resources/127_0_0_1 (1).sql';

if (!file_exists($wpSql)) {
    echo "WP SQL dump not found.\n";
    exit(1);
}

echo "Reading SQL file...\n";
$content = file_get_contents($wpSql);

echo "Decoding unicode escapes...\n";
$decoded = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}, $content);

echo "Splitting into lines...\n";
$lines = explode("\n", $decoded);
$matches = [];

echo "Searching for keywords...\n";
foreach ($lines as $num => $line) {
    foreach ($keywords as $kw) {
        if (stripos($line, $kw) !== false) {
            $matches[] = "Line " . ($num + 1) . ": " . trim($line);
            break;
        }
    }
}

echo "Found " . count($matches) . " matches.\n";
file_put_contents(__DIR__ . '/../resources/extracted_components.txt', implode("\n\n", array_slice($matches, 0, 500)));
echo "Saved to resources/extracted_components.txt\n";
