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

echo "Listing all pages (post_type = 'page') in wp_posts...\n";
while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    if (strpos($line, '(') === 0) {
        // Parse row fields
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
            $postType = trim($fields[20], "'\"");
            if ($postType === 'page') {
                $id = $fields[0];
                $title = trim($fields[5], "'\"");
                $status = trim($fields[7], "'\"");
                $name = trim($fields[11], "'\"");
                echo " - ID: $id | Title: '$title' | Name (Slug): '$name' | Status: '$status'\n";
            }
        }
    }
}
fclose($handle);
