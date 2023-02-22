<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BorrowedBook;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $murid = User::where('level', '1')->first();

        if(!isset($murid)){
            return response()->json([
                'success' => false,
                'data' => 'Data murid kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $murid,
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
        $murid = User::where('level', '1')->where('id', $id)->first();

        if(!isset($murid)){
            return response()->json([
                'success' => false,
                'data' => 'Data murid tidak ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $murid,
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
        $murid = User::find($id);

        if(isset($murid)){            
            $validated = $this->validate($request,[
                'name'      => 'required|max:25',
                'email'     => 'required|max:25',
                'password'  => 'required|max:255',
            ],
            [
                'name.required'     => 'Data nama tidak boleh kosong',
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'password tidak boleh kosong',
                'name.max'          => 'Data nama tidak boleh lebih dari 25 karakter',
                'username.max'      => 'Username tidak boleh lebih dari 25 karakter',
                'password.max'      => 'password tidak boleh lebih dari 25 karakter',
            ]);

            if($validated){
                $murid->update([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => $request->password,
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diupdate',
                    'data' => $murid,
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data gagal diupdate',
                'data' => $murid,
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
        $user = User::where('level','1')->find($id);
        if(isset($user)){
            $user->delete();
            return response()->json([
                'success' => true,
                'Message' => 'Data murid berhasil di hapus'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'Message' => 'Data murid gagal dihapus'
            ]);
        }
    }

    public function FinedStudents()
    {
        $borrowed = BorrowedBook::with('murid')->where('jumlah_denda','>','0')->get();
    }
}