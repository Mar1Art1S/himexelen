<?php

$sqlPath = __DIR__.'/resources/127_0_0_1 (1).sql';
$handle = fopen($sqlPath, 'r');
$count = 0;
$currentTable = '';
while (($line = fgets($handle)) !== false) {
    $count++;
    if (preg_match('/^INSERT INTO `([^`]+)`/i', trim($line), $m)) {
        $currentTable = $m[1];
    }
    if (stripos($line, '_elementor_data') !== false) {
        // Check if this line has 22 or 24 or 26 or 28
        foreach ([22, 24, 26, 28] as $id) {
            if (preg_match("/\(\s*\d+\s*,\s*$id\s*,\s*'_elementor_data'/i", $line)) {
                echo "Line $count | Table: $currentTable | ID: $id | Length: ".strlen($line)."\n";
            }
        }
    }
}
fclose($handle);
