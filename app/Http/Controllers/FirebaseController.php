<?php

namespace App\Http\Controllers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\Facades\Log;

class FirebaseController extends Controller
{
    public function testFirestore()
    {
        try {
            $firestore = new FirestoreClient([
                'keyFilePath' => storage_path('app/firebase/firebase_credentials.json'),
                'projectId' => 'taxi-app-65709',
                'transport' => 'rest',
            ]);

            $collection = $firestore->collection('test');
            $docRef = $collection->add([
                'message' => 'Firestore test from Controller',
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'status' => '✅ Success',
                'documentId' => $docRef->id(),
            ]);

        } catch (\Exception $e) {
            Log::error('Firestore Error: ' . $e->getMessage());
            return response()->json([
                'status' => '❌ Failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}