<?php

$sqlFile = __DIR__ . '/../resources/127_0_0_1 (1).sql';
$outputFile = __DIR__ . '/../resources/extracted_calculator_form_528.json';

if (!file_exists($sqlFile)) {
    echo "SQL file not found.\n";
    exit(1);
}

$content = file_get_contents($sqlFile);

$pattern = '/\(\s*\d+\s*,\s*528\s*,\s*[\'"]forminator_form_meta[\'"]\s*,\s*[\'"](.*?)[\'"]\s*\)/s';
if (preg_match($pattern, $content, $matches)) {
    $escapedSerialized = $matches[1];
    $serialized = str_replace(
        ['\\\'', '\\"', '\\\\', '\\n', '\\r', '\\t'],
        ['\'', '"', '\\', "\n", "\r", "\t"],
        $escapedSerialized
    );
    
    echo "Found serialized meta for 528! Length: " . strlen($serialized) . "\n";
    
    $data = unserialize($serialized);
    if ($data === false) {
        // Fix string length mismatches
        $repairedSerialized = preg_replace_callback(
            '/s:(\d+):"(.*?)";/s',
            function ($m) {
                return 's:' . strlen($m[2]) . ':"' . $m[2] . '";';
            },
            $serialized
        );
        $data = unserialize($repairedSerialized);
    }
    
    if ($data !== false) {
        file_put_contents($outputFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Successfully extracted form 528 to resources/extracted_calculator_form_528.json!\n";
    } else {
        echo "Failed to unserialize 528. Saving raw to resources/raw_serialized_528.txt\n";
        file_put_contents(__DIR__ . '/../resources/raw_serialized_528.txt', $serialized);
    }
} else {
    echo "Regex pattern did not match 528. Let's try manually extracting from line 3721...\n";
    $lines = explode("\n", $content);
    $targetLine = $lines[3721 - 1] ?? '';
    if (preg_match('/528\s*,\s*[\'"]forminator_form_meta[\'"]\s*,\s*[\'"](a:\d+:.*?)[\'"]\s*,/s', $targetLine, $m)) {
        $escapedSerialized = $m[1];
        $serialized = str_replace(
            ['\\\'', '\\"', '\\\\', '\\n', '\\r', '\\t'],
            ['\'', '"', '\\', "\n", "\r", "\t"],
            $escapedSerialized
        );
        
        $data = @unserialize($serialized);
        if ($data === false) {
            $repairedSerialized = preg_replace_callback(
                '/s:(\d+):"(.*?)";/s',
                function ($matches) {
                    return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
                },
                $serialized
            );
            $data = @unserialize($repairedSerialized);
        }
        
        if ($data !== false) {
            file_put_contents($outputFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo "Successfully manually extracted form 528 to resources/extracted_calculator_form_528.json!\n";
        } else {
            echo "Manual unserialize failed for 528. Saving raw.\n";
            file_put_contents(__DIR__ . '/../resources/raw_serialized_528.txt', $serialized);
        }
    } else {
        echo "Could not manually extract 528 from line 3721.\n";
    }
}
