<?php

$sqlPath = __DIR__.'/resources/127_0_0_1 (1).sql';
$handle = fopen($sqlPath, 'r');
$count = 0;
while (($line = fgets($handle)) !== false) {
    $count++;
    if (strpos($line, '3.26.4') !== false) {
        echo "Found '3.26.4' on line $count (length: ".strlen($line).")\n";
        echo substr($line, 0, 500)."...\n";
    }
}
fclose($handle);
