<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;

Route::get('/firestore-grpc', function () {
    try {
        $firestore = new FirestoreClient([
            'projectId' => 'fir-project-d34b6',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
        ]);
        echo "<pre>";
        print_r($firestore);

        $docRef = $firestore->collection('test')->add([
            'check' => 'gRPC connection successful',
            'time' => (new \DateTime())->format('Y-m-d H:i:s') // avoid Google\Protobuf\Timestamp
        ]);

        return response()->json([
            'status' => '✅ gRPC document created',
            'document_id' => $docRef->id() // This returns only the ID string
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'status' => '❌ Error',
            'message' => $e->getMessage()
        ], 500);
    }
});
