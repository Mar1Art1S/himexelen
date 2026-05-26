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

echo "Tables in 127_0_0_1 (1).sql:\n";
while (($line = fgets($handle)) !== false) {
    if (preg_match('/CREATE TABLE [`"]([^`"]+)[`"]/i', $line, $matches)) {
        echo " - " . $matches[1] . "\n";
    }
}
fclose($handle);
