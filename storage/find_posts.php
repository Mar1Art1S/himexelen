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

echo "Searching for post_types containing 'forminator' in wp_posts inserts...\n";
while (($line = fgets($handle)) !== false) {
    if (preg_match('/INSERT INTO [`"]wp_posts[`"]/i', $line)) {
        // Find all occurrences of forminator post types
        // Let's search for matches of (ID, ..., 'forminator_...')
        // We can do a preg_match_all to find all rows
        preg_match_all('/\(\s*(\d+)\s*,.*?,.*?,.*?,.*?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?,[^,]+?\)/is', $line, $matches);
        
        // Wait, a simpler way is to just find tuples containing 'forminator_'
        // Standard SQL row pattern: (col1, col2, ...)
        // Let's use a character-by-character scanner on the line to parse all rows in this INSERT statement.
        preg_match('/VALUES\s*(.*)$/is', $line, $valMatches);
        if (isset($valMatches[1])) {
            $valuesStr = rtrim(trim($valMatches[1]), ';');
            $len = strlen($valuesStr);
            $inString = false;
            $stringChar = '';
            $escaped = false;
            $currentRow = '';
            
            for ($i = 0; $i < $len; $i++) {
                $c = $valuesStr[$i];
                if ($escaped) {
                    $currentRow .= $c;
                    $escaped = false;
                    continue;
                }
                if ($c === '\\') {
                    $currentRow .= $c;
                    $escaped = true;
                    continue;
                }
                if ($inString) {
                    $currentRow .= $c;
                    if ($c === $stringChar) {
                        $inString = false;
                    }
                    continue;
                }
                if ($c === '\'' || $c === '"') {
                    $currentRow .= $c;
                    $inString = true;
                    $stringChar = $c;
                    continue;
                }
                if ($c === '(') {
                    $currentRow = '';
                    continue;
                }
                if ($c === ')') {
                    // We finished a row! Let's check if it contains forminator_
                    if (strpos($currentRow, 'forminator_') !== false) {
                        // Let's split this row to get ID, Title, and Post Type
                        // Parse fields
                        $fields = [];
                        $currentField = '';
                        $inFStr = false;
                        $fStrChar = '';
                        $fEsc = false;
                        $rLen = strlen($currentRow);
                        for ($j = 0; $j < $rLen; $j++) {
                            $ch = $currentRow[$j];
                            if ($fEsc) {
                                $currentField .= $ch;
                                $fEsc = false;
                                continue;
                            }
                            if ($ch === '\\') {
                                $currentField .= $ch;
                                $fEsc = true;
                                continue;
                            }
                            if ($inFStr) {
                                $currentField .= $ch;
                                if ($ch === $fStrChar) {
                                    $inFStr = false;
                                }
                                continue;
                            }
                            if ($ch === '\'' || $ch === '"') {
                                $currentField .= $ch;
                                $inFStr = true;
                                $fStrChar = $ch;
                                continue;
                            }
                            if ($ch === ',') {
                                $fields[] = trim($currentField);
                                $currentField = '';
                                continue;
                            }
                            $currentField .= $ch;
                        }
                        $fields[] = trim($currentField);
                        
                        $id = $fields[0] ?? 'Unknown';
                        $title = trim($fields[5] ?? 'Unknown', "'\"");
                        $postType = trim($fields[20] ?? 'Unknown', "'\"");
                        echo "Post ID: $id | Title: '$title' | Type: '$postType'\n";
                    }
                    $currentRow = '';
                    continue;
                }
            }
        }
    }
}
fclose($handle);
