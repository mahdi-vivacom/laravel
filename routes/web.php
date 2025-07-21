<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Protobuf\Timestamp;

Route::get('/firestore-grpc', function () {
    try {
        $firestore = new FirestoreClient([
            'projectId' => 'taxi-app-65709',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            // NO transport => REST here; gRPC is default
        ]);

        // Create a protobuf timestamp
        $timestamp = new Timestamp();
        $timestamp->setSeconds(time());

        $docRef = $firestore->collection('test')->add([
            'check' => 'gRPC connection successful',
            'time' => $timestamp // ✅ Safe for gRPC
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

