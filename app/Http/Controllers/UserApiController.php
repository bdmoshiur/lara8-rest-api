<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function showUser( $id = null ) {
        if ( $id =='' ) {
            $users = User::all();
            return response()->json([ 'users' => $users ], 200);
        } else {
            $users = User::findOrFail( $id );
            return response()->json([ 'users' => $users ], 200);
        }

    }

    public function addUser( Request $request ) {
    
        if( $request->isMethod('post')) {

            $data = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ];

            $message = [
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'email.email' => 'Must be Valid email required',
                'password.required' => 'required',
            ];
            $validator = Validator::make( $data, $rules, $message );

            if ( $validator->fails() ) {
                return response()->json( $validator->errors(), 422 );
            }

            $user = new User();

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt( $data['password'] );
            $user->save();

            $message = "User added successfully";

            return response()->json( [ 'message' => $message ], 201 );

        }
    }

    public function addMultiUser( Request $request ) {
    
        if( $request->isMethod('post')) {

            $data = $request->all();

            $rules = [
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];

            $message = [
                'users.*.name.required' => 'Name field is required',
                'users.*.email.required' => 'Email field is required',
                'users.*.email.email' => 'Must be Valid email required',
                'users.*.password.required' => 'required',
            ];
            $validator = Validator::make( $data, $rules, $message );

            if ( $validator->fails() ) {
                return response()->json( $validator->errors(), 422 );
            }

            foreach( $data['users'] as $user) {

                $users = new User();
                $users->name = $user['name'];
                $users->email = $user['email'];
                $users->password = bcrypt( $user['password'] );
                $users->save();
                $message = "User added successfully";
            }

            return response()->json( [ 'message' => $message ], 201 );
        }
    }

     public function updateUser( Request $request, $id ) {
    
        if( $request->isMethod('put')) {

            $data = $request->all();

            $rules = [
                'name' => 'required',
                'password' => 'required',
            ];

            $message = [
                'name.required' => 'Name field is required',
                'password.required' => 'required',
            ];
            $validator = Validator::make( $data, $rules, $message );

            if ( $validator->fails() ) {
                return response()->json( $validator->errors(), 422 );
            }

            $user = User::findOrFail( $id );

            $user->name = $data['name'];
            $user->password = bcrypt( $data['password'] );
            $user->save();

            $message = "User Updated successfully";

            return response()->json( [ 'message' => $message ], 202 );;

        }

    }

    public function updateSingleUser( Request $request, $id ) {
    
        if( $request->isMethod('patch')) {

            $data = $request->all();

            $rules = [
                'name' => 'required',
            ];

            $message = [
                'name.required' => 'Name field is required',
            ];
            $validator = Validator::make( $data, $rules, $message );

            if ( $validator->fails() ) {
                return response()->json( $validator->errors(), 422 );
            }

            $user = User::findOrFail( $id );

            $user->name = $data['name'];
            $user->save();

            $message = "User Updated successfully";

            return response()->json( [ 'message' => $message ], 202 );;

        }

    }

}
