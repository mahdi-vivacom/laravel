<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;

class FirebaseController extends Controller
{
    public function testFirestore(FirestoreService $firestore)
    {
        // Add new doc
        $firestore->addDocument('users', 'user_123', [
            'name' => 'Meherul',
            'email' => 'meherul@example.com',
        ]);

        // Read doc
        $data = $firestore->getDocument('users', 'user_123');

        dd($data);
    }

}
