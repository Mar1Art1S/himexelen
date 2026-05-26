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

$keywords = ['6-рамоч', '6 рамок', '6-рамок', '6-ти рамоч'];
echo "Searching WordPress SQL dump for 6-frame hive references...\n";
$lineNumber = 0;
while (($line = fgets($handle)) !== false) {
    $lineNumber++;
    foreach ($keywords as $kw) {
        if (stripos($line, $kw) !== false) {
            $pos = stripos($line, $kw);
            $start = max(0, $pos - 150);
            $snippet = substr($line, $start, 350);
            echo "Line $lineNumber (contains '$kw'):\n";
            echo "... " . htmlspecialchars($snippet) . " ...\n\n";
            break;
        }
    }
}
fclose($handle);
