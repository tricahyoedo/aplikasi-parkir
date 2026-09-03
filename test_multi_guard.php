<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

$petugas = User::where('role', 'petugas')->first();
$owner = User::where('role', 'owner')->first();

echo "Petugas ID: " . $petugas->id_user . "\n";
echo "Owner ID: " . $owner->id_user . "\n";

// Simulate request 1: Login Petugas
$request1 = Illuminate\Http\Request::create('/login', 'POST');
app()->instance('request', $request1);
session()->start();
Auth::guard('petugas')->login($petugas);
$sessionData1 = session()->all();
session()->save();
$sessionId1 = session()->getId();
echo "Session after Petugas Login: " . json_encode(array_keys($sessionData1)) . "\n";

// Simulate request 2: Login Owner (using same session ID)
session()->setId($sessionId1);
session()->start();
Auth::guard('owner')->login($owner);
$sessionData2 = session()->all();
session()->save();
echo "Session after Owner Login: " . json_encode(array_keys($sessionData2)) . "\n";

// Check Auth state
echo "Petugas check: " . (Auth::guard('petugas')->check() ? 'true' : 'false') . "\n";
echo "Owner check: " . (Auth::guard('owner')->check() ? 'true' : 'false') . "\n";
