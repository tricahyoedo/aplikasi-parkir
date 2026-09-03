<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$petugasName = Auth::guard('petugas')->getName();
$ownerName = Auth::guard('owner')->getName();
echo "Petugas Guard Session Key: " . $petugasName . "\n";
echo "Owner Guard Session Key: " . $ownerName . "\n";
