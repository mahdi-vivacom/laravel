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
            ];

            \Log::info('Firestore: ' . $firebase);
            // 🔒 No snapshot, just try writing to Firestore
            $firebase->set($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Document written successfully',
                'path' => $firebase->name()
            ]);

        } catch (\Exception $e) {
            \Log::error('Firestore error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
