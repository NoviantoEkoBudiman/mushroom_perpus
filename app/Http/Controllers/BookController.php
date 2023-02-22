<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::get();

        if(count($book) < 1){
            return response()->json([
                'data' => 'Data staff kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $book,
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
            'title'         => 'required|max:25',
            'description'   => 'required',
            'penerbit'      => 'required|max:25',
            'penulis'       => 'required|max:25',
            'bookshelf_id'  => 'required',
        ],
        [
            'title.required'        => 'Judul tidak boleh kosong',
            'description.required'  => 'Deskripsi tidak boleh kosong',
            'penerbit.required'     => 'Penerbit tidak boleh kosong',
            'penulis.required'      => 'Penulis tidak boleh kosong',
            'bookshelf_id.required' => 'Rak tidak boleh kosong',
        ]);

        if($validated){
            $book = new Book;
            $book->title        = $request->title;
            $book->description  = $request->description;
            $book->penerbit     = $request->penerbit;
            $book->penulis      = $request->penulis;
            $book->bookshelf_id = $request->bookshelf_id;
    
            $hasil = $book->save();
            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil ditambahkan',
                'data' => $book,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data buku gagal ditambahkan'
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
        $book = Book::where('id', $id)->first();

        if(!isset($book)){
            return response()->json([
                'data' => 'Data buku kosong',
            ]);
        }

        return response()->json([
            'data' => $book,
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
        $book = Book::find($id);

        if(isset($book)){            
            $validated = $this->validate($request,[
                'title'         => 'required|max:25',
                'description'   => 'required',
                'penerbit'      => 'required|max:25',
                'penulis'       => 'required|max:25',
                'bookshelf_id'  => 'required|max:20',
            ],
            [
                'title.required'        => 'Judul tidak boleh kosong',
                'description.required'  => 'Deskripsi tidak boleh kosong',
                'penerbit.required'     => 'Penerbit tidak boleh kosong',
                'penulis.required'      => 'Penulis tidak boleh kosong',
                'bookshelf_id.required' => 'Rak buku tidak boleh kosong',

                'title.max'             => 'Judul tidak boleh lebih dari 25 karakter',
                'penerbit.max'          => 'Penerbit tidak boleh lebih dari 25 karakter',
                'penulis.max'           => 'Penulis tidak boleh lebih dari 25 karakter',
                'bookshelf_id.max'      => 'Rak buku tidak boleh lebih dari 25 karakter',
            ]);

            if($validated){
                $book->update([
                    'title'         => $request->title,
                    'description'   => $request->description,
                    'penerbit'      => $request->penerbit,
                    'penulis'       => $request->penulis,
                    'bookshelf_id'  => $request->bookshelf_id,
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Data buku berhasil diupdate',
                    'data' => $book,
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data buku gagal diupdate',
                'data' => $book,
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
        $book = Book::find($id);
        if(isset($book)){
            $book->delete();
            return response()->json([
                'success' => true,
                'Message' => 'Data buku berhasil di hapus'
            ]);
        }else{
            return response()->json([
                'success' => true,
                'Message' => 'Data buku gagal dihapus'
            ]);
        }
    }
}