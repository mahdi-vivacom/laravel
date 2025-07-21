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
        $firestore = new FirestoreClient([
            'keyFilePath' => storage_path('app/firebase/firebase_credentials.json'),
                'projectId' => 'taxi-app-65709',
                'transport' => 'rest',
        ]);

         $firestore->collection('test')->add([
            'check' => 'REST connection successful',
            'time' => date('Y-m-d H:i:s') // ✅ Safe native string
        ]);

        return '✅ Firestore REST is working';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

