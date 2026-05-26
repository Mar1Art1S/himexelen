<?php

$sqlFile = __DIR__ . '/../resources/127_0_0_1 (1).sql';

if (!file_exists($sqlFile)) {
    echo "SQL file not found.\n";
    exit(1);
}

$handle = fopen($sqlFile, 'r');
if (!$handle) {
    echo "Failed to open file.\n";
    exit(1);
}

echo "First few wp_posts lines:\n";
$count = 0;
while (($line = fgets($handle)) !== false) {
    if (preg_match('/INSERT INTO [`"]wp_posts[`"]/i', $line)) {
        echo "Line length: " . strlen($line) . "\n";
        echo "Start: " . substr($line, 0, 500) . "\n";
        $count++;
        if ($count >= 5) break;
    }
}
fclose($handle);
