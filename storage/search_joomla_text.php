<?php

$sqlFile = __DIR__ . '/../resources/127_0_0_1.sql';

if (!file_exists($sqlFile)) {
    echo "SQL file not found.\n";
    exit(1);
}

$handle = fopen($sqlFile, 'r');
if (!$handle) {
    echo "Failed to open file.\n";
    exit(1);
}

$keywords = ['калькулятор', 'комплектація', 'коробка', 'кришка', 'годівниця', 'рамок', 'дно', 'корпус', 'скидк'];
echo "Searching Joomla SQL dump for calculator keywords...\n";
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
