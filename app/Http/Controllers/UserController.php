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

    private $firebase;

    /**
    * Calculates sum of squares of an array
    *
    * Loops over each element in the array, squares it, and adds it to 
    * total. Returns total.
    * 
    * This function can also be implemented using array_reduce();
    * 
    * @param array $arr
    * @return int
    * @throws Exception If element in array is not an integer
    */
    
    public function __construct(){

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/common-api-config.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)           
            ->create();
        $this->firebase = $firebase;

    }

    /**
    * Calculates sum of squares of an array
    *
    * Loops over each element in the array, squares it, and adds it to 
    * total. Returns total.
    * 
    * This function can also be implemented using array_reduce();
    * 
    * @param array $arr
    * @return int
    * @throws Exception If element in array is not an integer
    */

    public function index(){

        $auth = $this->firebase->getAuth();
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

    /**
    * Calculates sum of squares of an array
    *
    * Loops over each element in the array, squares it, and adds it to 
    * total. Returns total.
    * 
    * This function can also be implemented using array_reduce();
    * 
    * @param array $arr
    * @return int
    * @throws Exception If element in array is not an integer
    */

    public function createUser(){

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/common-api-config.json');
        $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();

        $auth = $this->firebase->getAuth();

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

    /**
    * Calculates sum of squares of an array
    *
    * Loops over each element in the array, squares it, and adds it to 
    * total. Returns total.
    * 
    * This function can also be implemented using array_reduce();
    * 
    * @param array $arr
    * @return int
    * @throws Exception If element in array is not an integer
    */

    public function loginUser(Request $request){

        $auth = $this->firebase->getAuth();
        $user = $auth->signInWithEmailAndPassword($request->email,$request->passwword);
	    $userInfo = $auth->getUserInfo($user->getUid());

        return response()->json([
            'status'    => '200',
            'data'      => $userInfo
        ]);


    }
}
