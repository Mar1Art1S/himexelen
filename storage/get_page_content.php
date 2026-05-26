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

echo "Extracting post_content for Page ID 848...\n";
while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    if (strpos($line, '(') === 0) {
        $fields = [];
        $currentField = '';
        $inStr = false;
        $strChar = '';
        $esc = false;
        $len = strlen($line);
        
        for ($i = 0; $i < $len; $i++) {
            $c = $line[$i];
            if ($esc) {
                $currentField .= $c;
                $esc = false;
                continue;
            }
            if ($c === '\\') {
                $currentField .= $c;
                $esc = true;
                continue;
            }
            if ($inStr) {
                $currentField .= $c;
                if ($c === $strChar) {
                    $inStr = false;
                }
                continue;
            }
            if ($c === '\'' || $c === '"') {
                $currentField .= $c;
                $inStr = true;
                $strChar = $c;
                continue;
            }
            if ($c === ',') {
                $fields[] = trim($currentField);
                $currentField = '';
                continue;
            }
            $currentField .= $c;
        }
        $fields[] = trim($currentField);
        
        if (count($fields) >= 21) {
            $id = trim($fields[0], "()");
            if ($id == '848') {
                $content = trim($fields[4], "'\"");
                // Unescape SQL string
                $content = str_replace(
                    ['\\\'', '\\"', '\\\\', '\\n', '\\r', '\\t'],
                    ['\'', '"', '\\', "\n", "\r", "\t"],
                    $content
                );
                echo "Post ID 848 Content (Length: " . strlen($content) . "):\n";
                echo $content . "\n";
                
                // Let's also check if there is elementor data in postmeta for 848!
                break;
            }
        }
    }
}
fclose($handle);
