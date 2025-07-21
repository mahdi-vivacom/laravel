<?php

use Illuminate\Support\Facades\Route;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\FieldValue;

use App\Http\Controllers\FirebaseController;

Route::get('/grpc', [FirebaseController::class, 'testGrpc']);


Route::get('/firestore-grpc', function () {
    try {
        $firestore = new FirestoreClient([
            'projectId' => 'fir-project-d34b6',
            'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
        ]);

        $docRef = $firestore->collection('test')->add([
            'check' => 'gRPC connection successful'
            //'time' => FieldValue::timestamp(new \DateTime()) // ✅ Firestore-safe timestamp
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
;

