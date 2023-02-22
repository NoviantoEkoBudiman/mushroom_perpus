<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookshelf;

class BookshelfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookshelf = Bookshelf::get();

        if(count($bookshelf) < 1){
            return response()->json([
                'data' => 'Data staff kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $bookshelf,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request,[
            'nama_rak'      => 'required|max:100'
        ],
        [
            'nama_rak.required' => 'Nama rak tidak boleh kosong',
            'nama_rak.max' => 'Nama rak tidak boleh lebih dari 100 baris',
        ]);

        if($validated){
            $bookshelf = new Bookshelf;
            $bookshelf->nama_rak   = $request->nama_rak;
    
            $hasil = $bookshelf->save();
            return response()->json([
                'success' => true,
                'message' => 'Data rak berhasil ditambahkan',
                'data' => $bookshelf,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data rak gagal ditambahkan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookshelf = Bookshelf::where('id', $id)->first();

        if(!isset($bookshelf)){
            return response()->json([
                'data' => 'Data rak tidak ditemukan',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $bookshelf,
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
        $bookshelf = Bookshelf::find($id);

        if(!isset($bookshelf)){
            return response()->json([
                'success' => true,
                'message' => 'Data rak gagal diupdate',
                'data' => $bookshelf,
            ]);
        }

        $bookshelf->update([
            'nama_rak'      => $request->nama_rak,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data rak berhasil diupdate',
            'data' => $bookshelf,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookshelf = Bookshelf::find($id);

        if(!isset($bookshelf)){
            return response()->json([
                'success' => false,
                'message' => 'Data rak buku gagal dihapus',
                'data' => $bookshelf,
            ]);
        }
        
        $bookshelf->delete();
        return response()->json([
            'success' => true,
            'Message' => 'Data rak buku berhasil di hapus'
        ]);
    }
}
