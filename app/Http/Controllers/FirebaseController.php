<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirebaseController extends Controller
{
    public function test()
    {
        // Create the Firebase factory
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase_credentials.json'));

        // Create Firestore client
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        // Write a test document
        $docRef = $database->collection('Test')->document('ping');
        $docRef->set([
            'message' => 'Hello from Laravel!',
            'timestamp' => now()->toDateTimeString(),
        ]);

        // Read it back
        $snapshot = $docRef->snapshot();

        if ($snapshot->exists()) {
            return response()->json([
                'status' => 'success',
                'data' => $snapshot->data(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document does not exist',
            ], 404);
        }
    }
}
