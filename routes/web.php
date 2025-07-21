<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;

Route::get('/firestore-test', function () {
    try {
        $firestore = new FirestoreClient([
            'projectId' => 'taxi-app-65709',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            'transport' => 'rest', // ✅ Forces REST transport
        ]);

        $collection = $firestore->collection('test');
        $docRef = $collection->add([
            'check' => 'REST connection successful',
            'time' => date('Y-m-d H:i:s') // ✅ Safe (not Carbon)
        ]);

        return response()->json([
            'status' => '✅ Document created',
            'document_id' => $docRef->id()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => '❌ Failed',
            'error' => $e->getMessage()
        ], 500);
    }
});

