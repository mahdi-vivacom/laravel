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

            // Safely check if document exists
            $snapshot = $firebase->snapshot();

            if ($snapshot->exists()) {
                \Log::info('Firestore document already exists', [
                    'document_id' => $id,
                    'current_data' => json_decode(json_encode($snapshot->data()), true),
                    'path' => $firebase->name(),
                ]);

                // Merge new data into existing document
                $firebase->set($data, ['merge' => true]);
            } else {
                \Log::info('Firestore document does not exist. Creating new.', [
                    'document_id' => $id,
                    'path' => $firebase->name(),
                ]);

                $firebase->set($data);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Document handled successfully',
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
