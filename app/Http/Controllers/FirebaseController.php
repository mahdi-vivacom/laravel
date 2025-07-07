<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;

class FirebaseController extends Controller
{
    public function test(FirestoreService $firestore, $id, $name)
    {
        $firestore = new FirestoreService();
        $response = $firestore->addTestDocument($id, $name);

        return $response;
    }
}

