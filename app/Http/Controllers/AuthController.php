<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function RegisterMurid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json()([
                'success' => false,
                'message' => 'data register gagal disimpan, harap di cek kembali',
                'data' => $validator->errors(),
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['level'] = '1';
        $user = User::create($input);

        $result['token'] = $user->createToken('auth_token')->plainTextToken;
        $result['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'User berhasil teregistrasi',
            'data' => $result,
        ]);
    }
    
    public function RegisterStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json()([
                'success' => false,
                'message' => 'data register gagal disimpan, harap di cek kembali',
                'data' => $validator->errors(),
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['level'] = '0';
        $user = User::create($input);

        $result['token'] = $user->createToken('auth_token')->plainTextToken;
        $result['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'User berhasil teregistrasi',
            'data' => $result,
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['auth'] = $auth;

            return response()->json([
                'success' => true,
                'message' => 'User berhasil login',
                'data' => $success,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'User gagal login',
                'data' => $result,
            ]);
        }
        
    }
}
