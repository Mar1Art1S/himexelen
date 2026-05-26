<?php

// Read parsed components JSON to extract names and prices
$path = __DIR__.'/../resources/extracted_components_parsed.json';
if (! file_exists($path)) {
    echo "File not found at: $path\n";
    exit;
}

$data = json_decode(file_get_contents($path), true);
$sample = $data['sample'] ?? [];

$matches = [];
foreach ($sample as $item) {
    $line = $item['line'] ?? '';

    // Decode double escaped unicode sequences
    $line = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $line);

    // Look for prices in грн
    if (preg_match_all('/(?:[0-9\s]+)\s*грн/u', $line, $priceMatches)) {
        $matches[] = [
            'raw' => $line,
            'prices' => $priceMatches[0],
        ];
    }
}

echo 'Found matches: '.count($matches)."\n\n";

foreach ($matches as $match) {
    // Let's print clean representation
    // Try to extract the title (usually inside single quotes)
    if (preg_match_all("/'([^']+)'/", $match['raw'], $titleMatches)) {
        $titles = $titleMatches[1];
        echo 'Titles: '.implode(' | ', $titles)."\n";
        echo 'Prices: '.implode(', ', $match['prices'])."\n";
        echo "-------------------------------------\n";
    }
}
