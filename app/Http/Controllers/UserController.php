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
            ->create();

	$auth = $firebase->getAuth();
	$users = $auth->listUsers();
	$user = $auth->getUser('PT01uQpFYPbsn4y8hgTAIc4s2wJ2');
	$list = [];

        foreach ($users as $user) {
    		array_push($list,$user);
	}   	
	
        return response()->json([
            'status'    => '200',
            'data'      => $list
    	]);
        
    }

    public function createUser(){

	$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/common-api-config.json');
	$firebase = (new Factory)
    		->withServiceAccount($serviceAccount)
    		->create();

	$auth = $firebase->getAuth();

	$userProperties = [
    		'email' 	=> 'user@example.com',
    		'emailVerified' => false,
    		'phoneNumber' 	=> '+15555550100',
    		'password' 	=> 'secretPassword',
    		'displayName' 	=> 'John Doe',
    		'photoUrl' 	=> 'http://www.example.com/12345678/photo.png',
    		'disabled' 	=> false,
	];

	$createdUser = $auth->createUser($userProperties);

	return response()->json([
            'status'    => '200',
            'data'      => $createdUser
    	]);

    
    }


    public function loginUser(Request $request){

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/common-api-config.json');
        $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();

        $auth = $firebase->getAuth();
        $user = $auth->signInWithEmailAndPassword($request->email,$request->passwword);
	$userInfo = $auth->getUserInfo($user->getUid());

        return response()->json([
            'status'    => '200',
            'data'      => $userInfo
        ]);


    }
}
