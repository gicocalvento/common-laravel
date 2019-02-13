<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
use Firebase\Auth\Token\Exception\InvalidToken;

class AuthController extends Controller
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

    public function verifyUserSessionToken($token){

        try {
            $verifiedIdToken = $this->firebase->getAuth()->verifyIdToken($token);
            $uid = $verifiedIdToken->getClaim('sub');
            $user = $this->firebase->getAuth()->getUser($uid);
            return response()->json([
                'status'    => 'success',
                'message'   => 'This user has a valid session token',    
                'data'      => $user
            ]);
        } catch (InvalidToken $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => $e->getMessage()    
            ],500);
        }
        
    }



}
