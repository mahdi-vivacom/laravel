<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    protected FirestoreClient $db;

    public function __construct()
    {
        $this->db = new FirestoreClient([
            'keyFilePath' => base_path(env('FIREBASE_CREDENTIALS')),
        ]);
    }

    public function addDocument(string $collection, string $docId, array $data)
    {
        $document = $this->db->collection($collection)->document($docId);
        $document->set($data);
        return $document->snapshot()->data();
    }

    public function getDocument(string $collection, string $docId)
    {
        $document = $this->db->collection($collection)->document($docId);
        return $document->snapshot()->data();
    }

    public function updateDocument(string $collection, string $docId, array $data)
    {
        $document = $this->db->collection($collection)->document($docId);
        $document->update($data);
        return $document->snapshot()->data();
    }

    public function deleteDocument(string $collection, string $docId)
    {
        $document = $this->db->collection($collection)->document($docId);
        $document->delete();
        return true;
    }
}
