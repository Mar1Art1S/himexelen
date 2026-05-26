<?php

$lines = explode("\n", file_get_contents(__DIR__ . '/../resources/extracted_components.txt'));
$count = 0;
foreach ($lines as $line) {
    if (str_starts_with($line, 'Line ')) {
        $count++;
        echo "$count: " . substr($line, 0, 180) . "...\n";
    }
}
