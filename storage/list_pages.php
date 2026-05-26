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
    if (preg_match('/INSERT INTO [`"]wp_posts[`"]/i', $line)) {
        // Let's scan tuples manually
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
                    // Split the row into fields
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
                    
                    $postType = trim($fields[20] ?? '', "'\"");
                    if ($postType === 'page') {
                        $id = $fields[0] ?? 'Unknown';
                        $title = trim($fields[5] ?? 'Unknown', "'\"");
                        $status = trim($fields[7] ?? 'Unknown', "'\"");
                        echo " - ID: $id | Title: '$title' | Status: '$status'\n";
                    }
                    $currentRow = '';
                    continue;
                }
            }
        }
    }
}
fclose($handle);
