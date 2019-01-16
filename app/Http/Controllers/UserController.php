<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class UserController extends Controller
{
    public function index(){

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/common-api-config.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://common-api-stack.firebaseio.com/')
            ->create();
            
        $database   = $firebase->getDatabase();
        $reference  = $database->getReference('/api/users/user');
        $value      = $reference->getValue();
            
        return response()->json([
            'status'    => '200',
            'data'      => $value
        ]);
        
    }
}
