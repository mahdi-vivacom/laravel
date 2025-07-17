<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;

class FirebaseController extends Controller
{
    public function testFirestore(FirestoreService $firestore)
    {
        // Add new doc
        $firestore->addDocument('users', 'user_1234', [
            'name' => 'Meherul Bhai',
            'email' => 'meherul@example.com',
        ]);

        // Read doc
        $data = $firestore->getDocument('users', 'user_123');

        dd($data);
    }

}
