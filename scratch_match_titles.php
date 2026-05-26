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
    echo "==================================================\n";
    echo "POST ID: $postId\n";
    echo "==================================================\n";
    foreach ($metas as $key => $val) {
        if ($key === '_elementor_data') {
            $valClean = $val;
            $decoded = null;
            $attempts = [$valClean, stripslashes($valClean), stripslashes(stripslashes($valClean))];
            foreach ($attempts as $attempt) {
                $dec = json_decode($attempt, true);
                if ($dec) {
                    $decoded = $dec;
                    break;
                }
            }

            if ($decoded) {
                $flatWidgets = [];
                foreach ($decoded as $rootEl) {
                    flattenWidgets($rootEl, $flatWidgets);
                }

                // Print all widgets in order
                foreach ($flatWidgets as $w) {
                    if ($w['type'] === 'video') {
                        echo '  [VIDEO] URL: '.($w['settings']['youtube_url'] ?? '')."\n";
                    } elseif ($w['type'] === 'heading') {
                        echo '  [HEADING] Title: '.($w['settings']['title'] ?? '')."\n";
                    } elseif ($w['type'] === 'text-editor') {
                        echo '  [TEXT] Editor: '.substr(strip_tags($w['settings']['editor'] ?? ''), 0, 100)."...\n";
                    } else {
                        echo '  [WIDGET: '.$w['type']."]\n";
                    }
                }
            }
        }
    }
}

function flattenWidgets($el, &$flat)
{
    if (! is_array($el)) {
        return;
    }
    if (isset($el['widgetType'])) {
        $flat[] = [
            'type' => $el['widgetType'],
            'settings' => $el['settings'] ?? [],
        ];
    }
    if (isset($el['elements']) && is_array($el['elements'])) {
        foreach ($el['elements'] as $subEl) {
            flattenWidgets($subEl, $flat);
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
