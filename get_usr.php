<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::first();
if ($user) {
    echo "Email: " . $user->email . "\n";
    echo "Password: password\n"; // Usually 'password' if seeded by factory
}
else {
    echo "No users found in database.\n";
}
