<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BorrowedBook;
use App\Models\Book;
use Carbon\Carbon;

class BorrowedBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $borrowed = BorrowedBook::get();

        if(count($borrowed) < 1){
            return response()->json([
                'success' => false,
                'data' => 'Data peminjaman kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $borrowed,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'book_id'   => 'required',
            'murid_id'  => 'required',
            'staff_id'  => 'required',
        ],
        [
            'book_id'   => 'Data buku tidak boleh kosong',
            'murid_id'  => 'Data murid tidak boleh kosong',
            'staff_id'  => 'Data staff tidak boleh kosong',
        ]);

        if($validated){
            $borrowed = new BorrowedBook;
            $borrowed->book_id         = $request->book_id;
            $borrowed->murid_id        = $request->murid_id;
            $borrowed->staff_id        = $request->staff_id;
            $borrowed->tanggal_pinjam  = Carbon::now();
    
            $hasil = $borrowed->save();
            return response()->json([
                'success' => true,
                'message' => 'Data peminjaman berhasil ditambahkan',
                'data' => $borrowed,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman gagal ditambahkan'
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
        $borrowed = BorrowedBook::where('id', $id)->first();

        if(!isset($borrowed)){
            return response()->json([
                'data' => 'Data peminjaman kosong',
            ]);
        }

        return response()->json([
            'data' => $borrowed,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $borrowed = BorrowedBook::find($id);

        if(isset($borrowed)){            
            $validated = $this->validate($request,[
                'book_id'   => 'required',
                'murid_id'  => 'required',
                'staff_id'  => 'required',
            ],
            [
                'book_id.required'  => 'Data buku tidak boleh kosong',
                'murid_id.required' => 'Data murid tidak boleh kosong',
                'staff_id.required' => 'Data staff tidak boleh kosong',
            ]);

            if($validated){
                $borrowed->update([
                    'book_id'   => $request->book_id,
                    'murid_id'  => $request->murid_id,
                    'staff_id'  => $request->staff_id
                ]);
        
                return response()->json([
                    'success' => true,
                    'message' => 'Data peminjaman berhasil diupdate',
                    'data' => $borrowed,
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman gagal diupdate',
                'data' => $borrowed,
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
        $borrowed = BorrowedBook::find($id);

        if(!isset($borrowed)){
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman gagal dihapus',
                'data' => $borrowed,
            ]);
        }
        
        $borrowed->delete();
        return response()->json([
            'success' => true,
            'Message' => 'Data peminjaman berhasil di hapus'
        ]);
    }

    public function listBorrowedBook()
    {
        $book = Book::where('status','0')->get();
        
        if(count($book) < 1){
            return response()->json([
                'success' => false,
                'data' => 'Data buku dipinjam kosong',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }

    public function returnProcess(Request $request, $id)
    {
        $borrowed = BorrowedBook::find($id);

        if(isset($borrowed)){
            $validated = $this->validate($request,[
                'book_id'           => 'required',
                'murid_id'          => 'required',
                'staff_id'          => 'required',
            ],
            [
                'book_id.required'  => 'Data buku tidak boleh kosong',
                'murid_id.required' => 'Data murid tidak boleh kosong',
                'staff_id.required' => 'Data staff tidak boleh kosong',
            ]);
            
            if($validated){
                $tanggal_pinjam = $borrowed->tanggal_pinjam;
                $tanggal_kembali = Carbon::now();
                $selisih = $tanggal_kembali->diff($tanggal_pinjam);
                $selisih_hari = $selisih->days;
                $denda = 0;
                if($selisih_hari > 7){
                    $denda = 200 * $selisih_hari;
                }

                $borrowed->book_id          = $request->book_id;
                $borrowed->murid_id         = $request->murid_id;
                $borrowed->staff_id         = $request->staff_id;
                $borrowed->tanggal_pinjam   = $borrowed->tanggal_pinjam;
                $borrowed->tanggal_kembali  = Carbon::now();
                $borrowed->status_pinjam    = '1';
                $borrowed->jumlah_denda     = $denda;
                $borrowed->status_denda     = $request->status_denda;
                $borrowed->update();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data peminjaman berhasil diupdate',
                    'data' => $borrowed,
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data peminjaman gagal diupdate',
                'data' => $borrowed,
            ]);
        }
    }
}
