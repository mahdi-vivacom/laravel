<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseController extends Controller
{
    public function testGrpc()
    {
        try {
            $firestore = new FirestoreClient([
                'projectId' => 'firestore-grpc',
                'keyFilePath' => base_path('storage/app/firebase/firebase_credentials.json'),
            ]);

            $docRef = $firestore->collection('test')->add([
                'check' => 'gRPC connection successful',
                'timestamp' => now()->toDateTimeString(),
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
    }
}