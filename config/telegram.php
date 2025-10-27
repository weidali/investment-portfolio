<?php

return [
    'token' => env('TELEGRAM_TOKEN'),
    'webhook_url' => env('TELEGRAM_WEBHOOK_URL'),
    
    'api' => [
        'base_url' => 'https://api.telegram.org',
        'timeout' => 30,
    ],

    // Сообщения об ошибках
    'messages' => [
        'error' => '❌ Ошибка: ',
        'success' => '✅ Успешно!',
        'invalid_command' => '❌ Неверная команда. Используй /help',
    ],
];