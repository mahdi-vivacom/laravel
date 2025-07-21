<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;

Route::get('/firestore-grpc', function () {
    try {
        $firestore = new \Google\Cloud\Firestore\FirestoreClient([
            'projectId' => 'fir-project-d34b6',
            'keyFilePath' => storage_path('app/firebase/firebase_credentials.json'),
        ]);

        $docRef = $firestore->collection('test')->add([
            'check' => 'gRPC connection successful',
            'time' => (new \DateTime())->format('Y-m-d H:i:s') // Use plain string for time
        ]);

        return response()->json([
            'status' => '✅ gRPC document created',
            'document_id' => $docRef->id() // ✅ only the string ID
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => '❌ Error',
            'message' => $e->getMessage()
        ], 500);
    }
});
