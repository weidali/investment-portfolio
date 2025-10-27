<?php

return [
    // API Finnhub
    'finnhub' => [
        'api_key' => env('FINNHUB_API_KEY'),
        'base_url' => env('FINNHUB_BASE_URL', 'https://finnhub.io/api/v1'),
        'timeout' => 10,
        'rate_limit' => 60, // 60 запросов в минуту для free tier
    ],

    // API Alpha Vantage (fallback)
    'alpha_vantage' => [
        'api_key' => env('ALPHA_VANTAGE_API_KEY'),
        'base_url' => env('ALPHA_VANTAGE_BASE_URL', 'https://www.alphavantage.co/query'),
        'timeout' => 10,
        'rate_limit' => 5, // 5 запросов в минуту для free tier
    ],

    // Комиссии
    'commission_percentage' => (float)env('COMMISSION_PERCENTAGE', 0.1), // 0.1%

    // Рекомендации
    'recommendations' => [
        'buy_threshold' => (float)env('RECOMMENDATION_BUY_THRESHOLD', 5),     // % ниже средней
        'sell_threshold' => (float)env('RECOMMENDATION_SELL_THRESHOLD', 5),   // % выше средней
        'check_interval_minutes' => 15,                                       // Проверяем каждые 15 минут
    ],

    // Кэширование
    'cache' => [
        'price_ttl' => 3600,           // Цена кэшируется на 1 час
        'history_ttl' => 86400,        // История кэшируется на 1 день
    ],
];