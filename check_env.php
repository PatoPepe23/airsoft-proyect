<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';

echo 'APP_ENV: ' . env('APP_ENV') . '<br>';
echo 'Config app.env: ' . config('app.env');
