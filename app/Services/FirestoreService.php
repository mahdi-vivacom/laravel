<?php

namespace App\Services;

class FirestoreService
{
    public function addTestDocument($id, $name)
    {
        $data = [
            'id' => $id,
            'name' => $name,
        ];

        $firebase = app('firebase.firestore')
            ->database()
            ->collection('Test')
            ->document($id);

        $documentSnapshot = $firebase->snapshot();

        \Log::info('Firestore Document Path: ' . $firebase->name());

        if ($documentSnapshot->exists()) {
            \Log::info('Document exists. Updating...');
            $firebase->set($data, ['merge' => true]);
        } else {
            \Log::info('Document does not exist. Creating new...');
            $firebase->set($data);
        }

        \Log::info('Data sent to Firestore: ', $data);

        return $firebase;
    }

}
