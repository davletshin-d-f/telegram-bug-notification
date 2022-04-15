<?php

return [
    'base_url' => env('TELEGRAM_URL', 'https://api.telegram.org'),
    'token' => env('TELEGRAM_TOKEN'),
    'chat_id' => env('TELEGRAM_CHAT_ID'),
    'file_storage' => env('TELEGRAM_FILE_STORAGE', storage_path('app/exceptions')),
    'stacktrace_url' => env('TELEGRAM_STACKTRACE_URL', rtrim(config('app.url'), '//') . '/stacktrace'),
];
