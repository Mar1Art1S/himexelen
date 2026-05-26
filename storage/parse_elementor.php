<?php

$jsonFile = __DIR__ . '/../resources/page_848_elementor_data.json';

if (!file_exists($jsonFile)) {
    echo "JSON file not found.\n";
    exit(1);
}

$raw = file_get_contents($jsonFile);
$data = json_decode($raw, true);

if ($data === null) {
    echo "Failed to decode JSON: " . json_last_error_msg() . "\n";
    exit(1);
}

echo "Successfully decoded Elementor JSON! Sections found: " . count($data) . "\n\n";

function extractText($el) {
    $results = [];
    if (isset($el['settings'])) {
        $settings = $el['settings'];
        if (isset($settings['title'])) {
            $results[] = "Heading: " . strip_tags($settings['title']);
        }
        if (isset($settings['editor'])) {
            $results[] = "Text Editor: " . strip_tags($settings['editor']);
        }
        if (isset($settings['html'])) {
            $results[] = "HTML: " . strip_tags($settings['html']);
        }
        if (isset($settings['carousel'])) {
            $imgUrls = [];
            foreach ($settings['carousel'] as $img) {
                if (isset($img['url'])) {
                    $imgUrls[] = $img['url'];
                }
            }
            $results[] = "Carousel with " . count($imgUrls) . " images: " . implode(", ", $imgUrls);
        }
        if (isset($settings['image']['url'])) {
            $results[] = "Image: " . $settings['image']['url'];
        }
    }
    
    if (isset($el['elements']) && is_array($el['elements'])) {
        foreach ($el['elements'] as $subEl) {
            $results = array_merge($results, extractText($subEl));
        }
    }
    
    return $results;
}

foreach ($data as $sectionIndex => $section) {
    echo "--- Section " . ($sectionIndex + 1) . " ---\n";
    $texts = extractText($section);
    foreach ($texts as $txt) {
        echo "  " . $txt . "\n";
    }
    echo "\n";
}
