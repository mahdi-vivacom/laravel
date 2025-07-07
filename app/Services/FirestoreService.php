<?php

namespace App\Services;

class FirestoreService
{
    public function addTestDocument($id, $name)
    {
        try {
            $firebase = app('firebase.firestore')
                ->database()
                ->collection('Test')
                ->document($id);

            $data = [
                'id' => $id,
                'name' => $name,
                'timestamp' => now()->toDateTimeString()
            ];

            // ✅ Just try a write first (no snapshot)
            $firebase->set($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Firestore write successful',
                'path' => $firebase->name()
            ]);

        } catch (\Exception $e) {
            \Log::error('Firestore error', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
