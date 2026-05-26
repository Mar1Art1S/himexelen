<?php

$sqlPath = __DIR__.'/resources/127_0_0_1 (1).sql';
$handle = fopen($sqlPath, 'r');
$count = 0;
while (($line = fgets($handle)) !== false) {
    $count++;
    if ($count >= 5650 && $count <= 5665) {
        echo "Line $count: ".substr($line, 0, 200)."...\n";
    }
}
fclose($handle);
