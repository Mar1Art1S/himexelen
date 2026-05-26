<?php

$sqlPath = __DIR__.'/resources/127_0_0_1 (1).sql';
if (! file_exists($sqlPath)) {
    exit("SQL file not found at $sqlPath\n");
}

$handle = fopen($sqlPath, 'r');
$currentTable = '';
$count = 0;

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
                if (count($fields) >= 4) {
                    $postId = (int) $fields[1];
                    $metaKey = $fields[2];
                    $metaValue = $fields[3];

                    if ($postId == 22 && $metaKey === '_elementor_data') {
                        echo "Table: $currentTable | Post ID: $postId | Length: ".strlen($metaValue)."\n";
                        $decoded = null;
                        $attempts = [$metaValue, stripslashes($metaValue), stripslashes(stripslashes($metaValue))];
                        foreach ($attempts as $attempt) {
                            $dec = json_decode($attempt, true);
                            if ($dec) {
                                $decoded = $dec;
                                break;
                            }
                        }
                        if ($decoded) {
                            echo "Decoded successfully!\n";
                            foreach ($decoded as $rootEl) {
                                printWidgetTypes($rootEl);
                            }
                        } else {
                            echo "Failed to decode!\n";
                        }
                        echo "--------------------------------------------------\n";
                    }
                }
            }
        }
    }
}
fclose($handle);

function printWidgetTypes($el)
{
    if (! is_array($el)) {
        return;
    }
    if (isset($el['widgetType']) && $el['widgetType'] === 'video') {
        $settings = $el['settings'] ?? [];
        echo '  [Video Widget] URL: '.($settings['youtube_url'] ?? 'none').' | Title: '.($settings['title'] ?? 'none').' | yt_title: '.($settings['yt_title'] ?? 'none')."\n";
    }
    if (isset($el['elements']) && is_array($el['elements'])) {
        foreach ($el['elements'] as $subEl) {
            printWidgetTypes($subEl);
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
