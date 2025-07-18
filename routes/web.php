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
            'projectId' => 'your-project-id',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            'transport' => 'rest', // ✅ THIS IS CRUCIAL
        ]);

        $firestore->collection('test')->add([
            'check' => 'REST connection successful',
            'time' => now()->toDateTimeString()
        ]);

        return '✅ Firestore REST is working';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

