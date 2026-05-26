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

$results = [];

foreach ($metaData as $postId => $metas) {
    $results[$postId] = [
        'title' => '',
        'videos' => [],
    ];

    if ($postId == 22) {
        $results[$postId]['title'] = 'Відео';
    }
    if ($postId == 24) {
        $results[$postId]['title'] = 'Інструкція';
    }
    if ($postId == 26) {
        $results[$postId]['title'] = 'Розміри';
    }
    if ($postId == 28) {
        $results[$postId]['title'] = 'Контакти';
    }

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

            if (! $decoded) {
                $attempt = str_replace(['\\"', '\\/'], ['"', '/'], $valClean);
                $dec = json_decode($attempt, true);
                if ($dec) {
                    $decoded = $dec;
                }
            }

            if ($decoded) {
                $videos = [];
                // Traverse elements of the root array
                foreach ($decoded as $rootEl) {
                    extractVideos($rootEl, $videos);
                }
                $results[$postId]['videos'] = $videos;
            } else {
                // If it fails to decode, we log it
                error_log("Failed to decode _elementor_data for Post ID $postId");
            }
        }
    }
}

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

function extractVideos($el, &$videos)
{
    if (! is_array($el)) {
        return;
    }
    if (isset($el['widgetType'])) {
        $widgetType = $el['widgetType'];
        $settings = $el['settings'] ?? [];
        if ($widgetType === 'video') {
            $youtubeUrl = $settings['youtube_url'] ?? $settings['link'] ?? '';
            $title = $settings['title'] ?? '';
            if ($youtubeUrl) {
                $videos[] = [
                    'title' => $title,
                    'youtube_url' => $youtubeUrl,
                ];
            }
        }
    }
    if (isset($el['elements']) && is_array($el['elements'])) {
        foreach ($el['elements'] as $subEl) {
            extractVideos($subEl, $videos);
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
