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

echo "Listing unique post types in wp_posts inserts...\n";
$postTypes = [];

while (($line = fgets($handle)) !== false) {
    if (strpos($line, '(') === 0) {
        // This is a value row line!
        // Split row by comma but handle quotes
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
        
        // Let's check how many fields. Typically wp_posts has 23 fields.
        // Field 20 (0-indexed) is post_type
        if (count($fields) >= 21) {
            $postType = trim($fields[20], "'\"");
            // Let's also check if it's a valid post type name (letters, underscores, hyphens)
            if (preg_match('/^[a-z0-9_-]+$/i', $postType)) {
                $postTypes[$postType] = ($postTypes[$postType] ?? 0) + 1;
            }
        }
    }
}
fclose($handle);

arsort($postTypes);
foreach ($postTypes as $type => $count) {
    echo " - $type: $count\n";
}
