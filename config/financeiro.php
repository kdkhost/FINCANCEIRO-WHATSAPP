<?php

return [
    'admin_allowed_ips' => array_filter(array_map('trim', explode(',', (string) env('ADMIN_ALLOWED_IPS', '')))),
    'upload_limits_mb' => [
        'images' => (int) env('UPLOAD_LIMIT_IMAGES_MB', 10),
        'videos' => (int) env('UPLOAD_LIMIT_VIDEOS_MB', 50),
        'audio' => (int) env('UPLOAD_LIMIT_AUDIO_MB', 20),
        'contracts' => (int) env('UPLOAD_LIMIT_CONTRACTS_MB', 30),
        'documents' => (int) env('UPLOAD_LIMIT_DOCUMENTS_MB', 20),
    ],
    'billing' => [
        'reminder_days' => [10, 7, 3, 1],
        'enable_proration' => true,
    ],
    'maintenance' => [
        'allow_ip_release' => true,
        'allow_device_release' => true,
    ],
];
