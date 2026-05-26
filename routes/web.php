<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/video', 'pages.video')->name('video');
Route::get('/instruction', function () {
    return redirect()->to(route('video', ['tab' => 'instruction']));
})->name('instruction');
Route::get('/sizes', function () {
    return redirect()->to(route('video', ['tab' => 'sizes']));
})->name('sizes');
Route::view('/calculator', 'pages.calculator')->name('calculator');
Route::view('/catalog', 'pages.catalog')->name('catalog');
Route::view('/ecosystem', 'pages.ecosystem')->name('ecosystem');

Route::get('/temp-parse', function () {
    $path = base_path('resources/127_0_0_1 (1).sql');
    if (! file_exists($path)) {
        return '127_0_0_1 (1).sql not found';
    }

    $handle = fopen($path, 'r');
    $posts = [];
    $postmeta = [];

    // Simple fast line-by-line parsing of SQL dump
    while (($line = fgets($handle)) !== false) {
        // Find wp_posts inserts
        if (strpos($line, 'INSERT INTO `wp_posts` VALUES') !== false || strpos($line, 'INSERT INTO `beelg_posts` VALUES') !== false) {
            // Find all rows in this insert
            // Format is (ID, post_author, post_date, ..., post_title, ..., post_name, ..., post_type, ...)
            // We can match patterns like (ID, ..., 'product')
            preg_match_all("/\(\s*(\d+)\s*,[^)]*?'product'[^)]*?\)/i", $line, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $rowStr = $match[0];
                $id = $match[1];
                // Let's parse out the single quoted strings to find the title
                preg_match_all("/'([^']*)'/u", $rowStr, $strMatches);
                $strings = $strMatches[1];
                // Usually the first long string or the 4th/5th element is the title
                // Let's store all string segments for now
                $posts[$id] = [
                    'id' => $id,
                    'strings' => $strings,
                ];
            }
        }

        // Find wp_postmeta inserts
        if (strpos($line, 'INSERT INTO `wp_postmeta` VALUES') !== false || strpos($line, 'INSERT INTO `beelg_postmeta` VALUES') !== false) {
            // Format is (meta_id, post_id, meta_key, meta_value)
            preg_match_all("/\(\s*\d+\s*,\s*(\d+)\s*,\s*'(_price|_regular_price)'\s*,\s*'([^']*)'\s*\)/i", $line, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $postId = $match[1];
                $key = $match[2];
                $val = $match[3];
                $postmeta[$postId][$key] = $val;
            }
        }
    }
    fclose($handle);

    // Now let's combine and format them
    $output = "Parsed WooCommerce Products:\n\n";
    $productCount = 0;

    foreach ($posts as $id => $post) {
        $price = $postmeta[$id]['_price'] ?? ($postmeta[$id]['_regular_price'] ?? 'N/A');

        // Find the title - it usually is a segment that matches beekeeping keywords
        $title = 'Unknown Product';
        foreach ($post['strings'] as $str) {
            // Decode unicode or clean up
            $strClean = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($m) {
                return mb_convert_encoding(pack('H*', $m[1]), 'UTF-8', 'UCS-2BE');
            }, $str);

            if (preg_match('/(?:Дах|Дно|Корпус|Годівниця|МПЗ|МЛП|ВПЗ|ВЛП|Заставна|Мікронуклеус)/ui', $strClean)) {
                $title = $strClean;
                break;
            }
        }

        // If not found by keyword, just pick the longest string of first 10
        if ($title === 'Unknown Product' && ! empty($post['strings'])) {
            $longest = '';
            foreach (array_slice($post['strings'], 0, 10) as $str) {
                if (strlen($str) > strlen($longest) && strlen($str) < 150) {
                    $longest = $str;
                }
            }
            $title = $longest;
        }

        $output .= "ID: $id | Title: $title | Price: $price UAH\n";
        $productCount++;
    }

    $output = "Total products found: $productCount\n\n".$output;

    file_put_contents(base_path('resources/extracted_clean_prices.txt'), $output);

    return 'Successfully parsed SQL and saved to resources/extracted_clean_prices.txt';
});

if (! function_exists('parseSqlValues')) {
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
}

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
