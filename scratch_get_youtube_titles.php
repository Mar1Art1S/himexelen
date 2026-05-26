<?php

$urls = [
    'https://www.youtube.com/watch?v=pYkorO8frvc',
    'https://www.youtube.com/watch?v=UbwPcW29kbo',
    'https://www.youtube.com/watch?v=KCti6YD28lI',
    'https://www.youtube.com/watch?v=bqXjQN2bKi8',
    'https://www.youtube.com/watch?v=fEeT5fEpNWY',
    'https://www.youtube.com/watch?v=P05o9Y4RoRg',
];

foreach ($urls as $url) {
    $api = 'https://www.youtube.com/oembed?url='.urlencode($url).'&format=json';

    // Set a user agent to avoid being blocked
    $options = [
        'http' => [
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
            'timeout' => 5,
        ],
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($api, false, $context);

    if ($response) {
        $data = json_decode($response, true);
        echo "$url => ".($data['title'] ?? 'Unknown Title')."\n";
    } else {
        echo "$url => Failed to fetch\n";
    }
}
