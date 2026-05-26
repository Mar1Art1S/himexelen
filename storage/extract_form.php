<?php

$sqlFile = __DIR__ . '/../resources/127_0_0_1 (1).sql';
$outputFile = __DIR__ . '/../resources/extracted_forms.json';

if (!file_exists($sqlFile)) {
    echo "SQL file not found at: $sqlFile\n";
    exit(1);
}

echo "Reading SQL file...\n";
$handle = fopen($sqlFile, 'r');
if (!$handle) {
    echo "Failed to open SQL file.\n";
    exit(1);
}

$foundForms = [];
$insertBuffer = '';

while (($line = fgets($handle)) !== false) {
    // We are looking for lines inserting into wp_posts (case-insensitive, accommodating backticks or quotes)
    if (preg_match('/INSERT INTO [`"]wp_posts[`"]/i', $line)) {
        // Find all forminator_forms records in this insert statement
        // SQL insert statement format: INSERT INTO `wp_posts` VALUES (1, ...), (2, ...);
        // Let's extract values
        // A simple way is to search if 'forminator_forms' is in the line.
        if (strpos($line, 'forminator_forms') !== false) {
            echo "Found possible forminator_forms in line!\n";
            // Let's parse individual tuples from the INSERT statement.
            // Since it's a standard MySQL dump, it's typically: INSERT INTO `wp_posts` VALUES (values), (values)...;
            // Let's write the whole line to a temp file or parse it.
            $insertBuffer .= $line;
        }
    }
}
fclose($handle);

if (empty($insertBuffer)) {
    echo "No forminator_forms records found in INSERT statements.\n";
    exit(0);
}

// Write the lines containing forminator_forms to a temporary file for analysis
file_put_to_file_content:
file_put_contents(__DIR__ . '/../resources/raw_form_inserts.sql', $insertBuffer);
echo "Saved raw SQL inserts to resources/raw_form_inserts.sql\n";

// Let's write a simple parser to extract the post_content and post_title of forminator_forms.
// To do this, let's write a regex parser or use a simpler tokenizer.
// Since the SQL file has inserts, each row is formatted like:
// (ID, post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count)
// Note: forminator_forms is the post_type (21st field).
// Let's use a robust PHP tokenizer or simple regex to match rows in the SQL dump.

// Let's read the INSERT statement and extract tuples
// A tuple starts with '(' and ends with ')' followed by ',' or ';'
// Wait, post_content can contain escaped quotes and parentheses. So simple regex like \((.*?)\) might fail.
// We can use a character-by-character parser to split the VALUES part into rows.
preg_match('/VALUES\s*(.*)$/is', $insertBuffer, $matches);
if (isset($matches[1])) {
    $valuesStr = rtrim(trim($matches[1]), ';');
    $len = strlen($valuesStr);
    $inString = false;
    $stringChar = '';
    $escaped = false;
    $currentRow = '';
    $rows = [];
    
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
            $rows[] = $currentRow;
            $currentRow = '';
            continue;
        }
        
        if ($c === ',') {
            continue;
        }
    }
    
    echo "Total parsed rows: " . count($rows) . "\n";
    
    foreach ($rows as $rowIdx => $row) {
        // Parse fields. A field is comma-separated but strings can contain commas.
        // Let's write a simple field tokenizer for the row.
        $fields = [];
        $currentField = '';
        $inFieldString = false;
        $fieldStringChar = '';
        $fieldEscaped = false;
        $rowLen = strlen($row);
        
        for ($i = 0; $i < $rowLen; $i++) {
            $c = $row[$i];
            if ($fieldEscaped) {
                $currentField .= $c;
                $fieldEscaped = false;
                continue;
            }
            if ($c === '\\') {
                $currentField .= $c;
                $fieldEscaped = true;
                continue;
            }
            if ($inFieldString) {
                $currentField .= $c;
                if ($c === $fieldStringChar) {
                    $inFieldString = false;
                }
                continue;
            }
            if ($c === '\'' || $c === '"') {
                $currentField .= $c;
                $inFieldString = true;
                $fieldStringChar = $c;
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
        
        // Let's check if this row has 'forminator_forms' as its post_type
        // In wp_posts, post_type is field index 20 (0-indexed).
        // Let's inspect the fields around that.
        $isForm = false;
        foreach ($fields as $idx => $f) {
            if (strpos($f, 'forminator_forms') !== false) {
                $isForm = true;
                break;
            }
        }
        
        if ($isForm) {
            // Let's decode fields. Typically post_content is field 4, post_title is field 5, post_type is field 20.
            // Let's find post_content (usually the largest JSON-like string) and post_title.
            $jsonContent = null;
            $title = '';
            foreach ($fields as $f) {
                $clean = trim($f, "'\"");
                // Strip SQL escaping
                $clean = str_replace(["\\'", '\\"', '\\\\', '\\n', '\\r', '\\t'], ["'", '"', '\\', "\n", "\r", "\t"], $clean);
                if (strpos($clean, '{"type":"form"') === 0 || strpos($clean, '{"type":"') !== false && strpos($clean, 'fields') !== false) {
                    $jsonContent = json_decode($clean, true);
                    if ($jsonContent === null) {
                        // Let's try to clean it more
                        echo "Failed decoding JSON, trying alternate decode...\n";
                    }
                } elseif (strlen($clean) > 0 && strlen($clean) < 100 && !is_numeric($clean) && strpos($clean, 'http') === false && strpos($clean, '-') === false) {
                    $title = $clean;
                }
            }
            
            if ($jsonContent) {
                $foundForms[] = [
                    'title' => $title,
                    'content' => $jsonContent
                ];
                echo "Successfully extracted form: '$title'\n";
            }
        }
    }
}

file_put_contents($outputFile, json_encode($foundForms, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Successfully exported " . count($foundForms) . " forms to resources/extracted_forms.json\n";
