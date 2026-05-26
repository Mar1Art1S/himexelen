<?php

$sqlFile = __DIR__ . '/../resources/127_0_0_1 (1).sql';
$outputFile = __DIR__ . '/../resources/page_848_elementor_data.json';

if (!file_exists($sqlFile)) {
    echo "SQL file not found.\n";
    exit(1);
}

$content = file_get_contents($sqlFile);

// Let's find the postmeta record for 848 and _elementor_data.
// Example: (12345, 848, '_elementor_data', '[{\\\"id\\\":\\\"7045fa48\\\", ...}]')
// Let's use a regex to find '_elementor_data' and the next value for post 848
$pattern = '/\(\s*\d+\s*,\s*848\s*,\s*[\'"]_elementor_data[\'"]\s*,\s*[\'"](.*?)[\'"]\s*,\s*[\'"]\w+[\'"]\s*\)/s';
// Wait, sometimes there is no fifth column. Let's do a broader regex.
$pattern = '/\(\s*\d+\s*,\s*848\s*,\s*[\'"]_elementor_data[\'"]\s*,\s*[\'"](.*?)[\'"]\s*\)/s';

if (preg_match($pattern, $content, $matches)) {
    $escapedJson = $matches[1];
    
    // Let's clean the SQL escaping
    // Enclosed in single quotes: single quotes are escaped as \', backslashes as \\
    // Double quotes inside the JSON string were escaped as \" or \\\"
    // Let's unescape it in PHP:
    $json = str_replace(
        ['\\\'', '\\"', '\\\\', '\\n', '\\r', '\\t'],
        ['\'', '"', '\\', "\n", "\r", "\t"],
        $escapedJson
    );
    
    echo "Found raw JSON! Length: " . strlen($json) . "\n";
    
    // Clean control characters and BOM if any
    $json = preg_replace('/[\x00-\x1F\x7F]/', '', $json); 
    
    $data = json_decode($json, true);
    if ($data === null) {
        echo "Failed to decode JSON: " . json_last_error_msg() . "\n";
        // Let's try stripslashes or simple regex replacement
        $json2 = stripslashes($escapedJson);
        $data = json_decode($json2, true);
        if ($data === null) {
            echo "Alternative stripslashes decode also failed.\n";
            file_put_contents(__DIR__ . '/../resources/raw_escaped.txt', $escapedJson);
            echo "Saved raw escaped to resources/raw_escaped.txt\n";
        } else {
            echo "Alternative decode succeeded!\n";
        }
    }
    
    if ($data !== null) {
        file_put_contents($outputFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Successfully exported Elementor data to resources/page_848_elementor_data.json!\n";
    }
} else {
    echo "Regex pattern did not match _elementor_data for post 848.\n";
    
    // Let's try manual substring search
    $pos = strpos($content, "'_elementor_data'");
    if ($pos !== false) {
        echo "Found '_elementor_data' at character position $pos.\n";
    }
}
