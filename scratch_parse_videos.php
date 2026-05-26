<?php

$sqlPath = __DIR__.'/resources/127_0_0_1 (1).sql';
if (! file_exists($sqlPath)) {
    exit("SQL file not found at $sqlPath\n");
}

$handle = fopen($sqlPath, 'r');
$currentTable = '';
$count = 0;

$metaTargetIds = [22, 24, 26, 28];
$metaData = [];

while (($line = fgets($handle)) !== false) {
    $count++;
    $trimmed = trim($line);
    if (empty($trimmed)) {
        continue;
    }

    if (preg_match('/^INSERT INTO `([^`]+)`/i', $trimmed, $m)) {
        $currentTable = $m[1];

        continue;
    }

    if (in_array($currentTable, ['wp_postmeta', 'beelg_postmeta'])) {
        if ($trimmed[0] === '(') {
            $rows = parseSqlValues($trimmed);
            foreach ($rows as $rowStr) {
                $fields = parseSqlFields($rowStr);
                // meta_id, post_id, meta_key, meta_value
                if (count($fields) >= 4) {
                    $postId = (int) $fields[1];
                    $metaKey = $fields[2];
                    $metaValue = $fields[3];

                    if (in_array($postId, $metaTargetIds)) {
                        $metaData[$postId][$metaKey] = $metaValue;
                    }
                }
            }
        }
    }
}
fclose($handle);

foreach ($metaData as $postId => $metas) {
    echo "Post ID: $postId\n";
    foreach ($metas as $key => $val) {
        if ($key === '_elementor_data') {
            echo "  Key: $key\n";
            // Clean up and decode Elementor JSON data
            // Sometimes it has escaped characters or is serialized PHP
            $decoded = json_decode($val, true);
            if ($decoded) {
                echo "  Decoded Elementor JSON successfully!\n";
                // Let's print out the structure or look for video widgets
                printVideoWidgets($decoded);
            } else {
                echo '  Failed to json_decode Elementor data directly. Length: '.strlen($val)."\n";
                // Let's try to unescape slashes
                $unescaped = stripslashes($val);
                $decoded = json_decode($unescaped, true);
                if ($decoded) {
                    echo "  Decoded after stripslashes!\n";
                    printVideoWidgets($decoded);
                } else {
                    // Let's dump a snippet of the raw string to inspect
                    echo '  Snippet: '.substr($val, 0, 1000)."\n";
                }
            }
        } else {
            echo "  Key: $key | Value snippet: ".substr($val, 0, 200)."\n";
        }
    }
    echo "======================================================================\n\n";
}

function printVideoWidgets($elements)
{
    foreach ($elements as $el) {
        findVideoWidgets($el);
    }
}

function findVideoWidgets($el)
{
    if (! is_array($el)) {
        return;
    }

    // Check if it's a widget of type 'video' or 'video-playlist'
    if (isset($el['widgetType'])) {
        $widgetType = $el['widgetType'];
        $settings = $el['settings'] ?? [];
        if ($widgetType === 'video') {
            $title = $settings['youtube_url'] ?? $settings['link'] ?? 'Unknown URL';
            echo '    [Widget: Video] Title/Url: '.json_encode($title)."\n";
        } else {
            echo "    [Widget: {$widgetType}] Settings: ".json_encode($settings)."\n";
        }
    }

    // Process elements
    if (isset($el['elements']) && is_array($el['elements'])) {
        foreach ($el['elements'] as $subEl) {
            findVideoWidgets($subEl);
        }
    }
}

function parseSqlValues($valuesStr)
{
    $len = strlen($valuesStr);
    $inString = false;
    $escape = false;
    $rows = [];
    $depth = 0;
    $rowStr = '';

    for ($i = 0; $i < $len; $i++) {
        $c = $valuesStr[$i];
        if ($escape) {
            $rowStr .= $c;
            $escape = false;

            continue;
        }
        if ($c === '\\') {
            $rowStr .= $c;
            $escape = true;

            continue;
        }
        if ($c === "'") {
            $inString = ! $inString;
            $rowStr .= $c;

            continue;
        }
        if (! $inString) {
            if ($c === '(') {
                $depth++;
                if ($depth === 1) {
                    $rowStr = '';

                    continue;
                }
            }
            if ($c === ')') {
                $depth--;
                if ($depth === 0) {
                    $rows[] = $rowStr;

                    continue;
                }
            }
        }
        if ($depth > 0) {
            $rowStr .= $c;
        }
    }

    return $rows;
}

function parseSqlFields($rowStr)
{
    $len = strlen($rowStr);
    $inString = false;
    $escape = false;
    $fields = [];
    $field = '';

    for ($i = 0; $i < $len; $i++) {
        $c = $rowStr[$i];
        if ($escape) {
            $field .= $c;
            $escape = false;

            continue;
        }
        if ($c === '\\') {
            $field .= $c;
            $escape = true;

            continue;
        }
        if ($c === "'") {
            $inString = ! $inString;

            continue;
        }
        if ($c === ',' && ! $inString) {
            $fields[] = trim($field);
            $field = '';

            continue;
        }
        $field .= $c;
    }
    $fields[] = trim($field);

    return $fields;
}
