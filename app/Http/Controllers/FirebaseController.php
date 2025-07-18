<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;

class FirebaseController extends Controller
{
    public function testFirestore(FirestoreService $firestore)
    {
        // Add new doc
        $firestore->addUser([
            'name' => 'Meherul Bhai',
            'email' => 'meherul@example.com',
        ]);

        // Read doc
        $data = $firestore->getUsers();

        dd($data);
    }

}
