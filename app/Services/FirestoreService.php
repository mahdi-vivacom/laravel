<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class FirestoreService
{
    /**
     * Add or update a test document in Firestore.
     *
     * @param string $id
     * @param string $name
     * @return JsonResponse
     */
    // public function addTestDocument(string $id, string $name): JsonResponse
    // {
    //     try {
    //         $firebase = app('firebase.firestore')
    //             ->database()
    //             ->collection('Test')
    //             ->document($id);

    //         $data = [
    //             'id' => $id,
    //             'name' => $name,
    //         ];

    //         // Safely retrieve the snapshot
    //         $snapshot = $firebase->snapshot();

    //         if ($snapshot->exists()) {
    //             // Log minimal safe data (avoid infinite recursion issues)
    //             Log::info('Firestore document already exists', [
    //                 'document_id' => $id,
    //                 'path' => $firebase->name(),
    //                 'fields' => is_array($snapshot->data()) ? array_keys($snapshot->data()) : [],
    //             ]);

    //             // Update (merge) existing document
    //             $firebase->set($data, ['merge' => true]);
    //         } else {
    //             // Log new creation
    //             Log::info('Firestore document does not exist. Creating new.', [
    //                 'document_id' => $id,
    //                 'path' => $firebase->name(),
    //             ]);

    //             // Create new document
    //             $firebase->set($data);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Document handled successfully',
    //             'path' => $firebase->name(),
    //         ]);
    //     } catch (\Throwable $e) {
    //         // Log full exception trace
    //         Log::error('Firestore error', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString(),
    //         ]);

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Firestore exception: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function addTestDocument(string $id, string $name)
    // {
    //     // $firebase = app('firebase.firestore')
    //     //         ->database()
    //     //         ->collection('Test')
    //     //         ->document($id);

    //     $doc = $firebase->collection('Test')->document('ping')->snapshot();

    //     if ($doc->exists()) {
    //         // Process result
    //     } else {
    //         // Handle not found
    //     }

    //     return response()->json(['done' => true]);
    // }
}
