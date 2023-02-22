<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = User::where('level', '0')->get();

        if(count($staff) < 1){
            return response()->json([
                'success' => false,
                'data' => 'Data staff kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $staff,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = User::where('level', '0')->where('id', $id)->first();

        if(!isset($staff)){
            return response()->json([
                'success' => false,
                'data' => 'Data staff tidak ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $staff = User::where('level','0')->find($id);

        if(isset($staff)){
            $staff->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => $request->password,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data staff berhasil diupdate',
                'data' => $staff,
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Data staff gagal diupdate',
                'data' => $staff,
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('level','0')->find($id);

        if(isset($user)){
            $user->delete();
            return response()->json([
                'success' => true,
                'Message' => 'Data staff berhasil di hapus'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Data staff gagal di hapus'
            ]);
        }
    }
}
