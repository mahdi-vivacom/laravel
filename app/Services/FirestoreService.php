<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    protected $db;

    public function __construct()
    {
        $this->db = new FirestoreClient([
            'keyFilePath' => storage_path('app/firebase/firebase_credentials.json'),
            'transport' => 'rest',
        ]);
    }

    public function addUser(array $data)
    {
        return $this->db->collection('users')->add($data);
    }

    public function getUsers()
    {
        return $this->db->collection('users')->documents();
    }
}
