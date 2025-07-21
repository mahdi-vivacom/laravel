<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;

Route::get('/firestore-grpc', function () {
    try {
        $firestore = new FirestoreClient([
            'projectId' => 'taxi-app-65709',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            // no need to set transport, defaults to gRPC
        ]);

        $docRef = $firestore->collection('test')->add([
            'check' => 'gRPC connection successful',
            'time' => new \DateTime() // ✅ This works with gRPC!
        ]);

        return response()->json([
            'status' => '✅ gRPC document created',
            'document_id' => $docRef->id()
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => '❌ Error',
            'message' => $e->getMessage()
        ], 500);
    }
});

