<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$users = App\Models\User::all(['email', 'role']);
foreach ($users as $user) {
    echo "Email: " . $user->email . " | Role: " . $user->role . "\n";
}
