<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FirebaseController::class, 'testFirestore']);

use Google\Cloud\Firestore\FirestoreClient;

Route::get('/test-firestore-rest', function () {
    try {
                $firestore = new \Google\Cloud\Firestore\FirestoreClient([
            'projectId' => 'taxi-app-65709',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            'transport' => 'rest', // ✅ This must be respected
        ]);
        echo '<pre>';
        print_r($firestore);exit;
         $firestore->collection('test')->add([
            'check' => 'REST connection successful',
            'time' => date('Y-m-d H:i:s') // ✅ Safe native string
        ]);

        return '✅ Firestore REST is working';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

