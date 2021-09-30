<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

     public function updateUser( Request $request, $id = null ) {
    
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

            return response()->json( [ 'message' => $message ], 202 );

        }

    }

    public function updateSingleUser( Request $request, $id = null ) {
    
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

            $message = "Single User Updated successfully";

            return response()->json( [ 'message' => $message ], 202 );

        }

    }
    
    public function deleteSingleUser( $id = null ) {

            $user = User::findOrFail( $id );
            $user->delete();

            $message = "User Deleted successfully";
            return response()->json( [ 'message' => $message ], 200 );
    }

    public function deleteSingleUserJson( Request $request ) {

        if ( $request->isMethod('delete')) {
            $data = $request->all();
            $user = User::where('id', $data['id'] );
            $user->delete();
            $message = "Json Single User Deleted successfully";
            return response()->json( [ 'message' => $message ], 200 );
        }


    }


    public function deleteMultiUser( $ids = null ) {

        $ids = explode( ',', $ids );
        $user = User::whereIn('id', $ids );
        $user->delete();

        $message = "Multiple User Deleted successfully";
        return response()->json( [ 'message' => $message ], 200 );
    }


    public function deleteMultiUserJson( Request $request ) {

        $header = $request->header('Authorization');
        if ( $header == '' ) {
            $message = "Authorization is Required";
            return response()->json( [ 'message' => $message ], 422 );
        } else {
            if ($header == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Im1vc2hpdXIgcmFobWFuIiwiaWF0IjoxNTE2MjM5MDIyfQ.rMFCvU6fhCopwjOF6nl_57k0QhUq5Y_pWuQQdm84h7Q' ) {
                if ( $request->isMethod('delete')) {
                    $data = $request->all();
                    $user = User::whereIn('id', $data['ids'] );
                    $user->delete();
        
                    $message = "Json Multiple User Deleted successfully";
                    return response()->json( [ 'message' => $message ], 200 );
                }
            } else {
                $message = "Authorization dose not match";
                return response()->json( [ 'message' => $message ], 422 );
            }
        }
    }

    public function registerUserUsingPassport( Request $request ) {
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

            if ( Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token'=> $access_token]);

                $message = "User Register successfully";
                return response()->json( [ 'message' => $message, 'access_token' => $access_token ], 201 );
            } else {
                $message = "Opps Somthing went Wrong";
                return response()->json( [ 'message' => $message ], 422 );
            }

        }
    }


}
