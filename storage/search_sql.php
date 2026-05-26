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

$lineNumber = 0;
while (($line = fgets($handle)) !== false) {
    $lineNumber++;
    if (stripos($line, 'forminator') !== false) {
        echo "Line $lineNumber contains 'forminator' (Length: " . strlen($line) . ")\n";
        // Print some characters around the word
        $pos = stripos($line, 'forminator');
        $start = max(0, $pos - 100);
        $length = 300;
        echo "Snippet: ... " . substr($line, $start, $length) . " ...\n\n";
    }
}
fclose($handle);
