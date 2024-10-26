<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Validated;
use League\CommonMark\Extension\Embed\Embed;
use PhpParser\Node\Expr\Cast\String_;
use PhpParser\Node\Expr\Empty_;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::orderBy('book_id', 'asc')->paginate(5);
        return response([
            'status' => true,
            'message' => "sukses",
            'data' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publish_date' => 'required|date',
        ]);
        $create = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publish_date' => $request->publish_date,
        ]);
        if ($create) {
            return response([
                'status' => true,
                'message' => "sukses",
                'data' => $create
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => "sukses",
                'data' => []
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $book_id)
    {

        $book_detail = Book::where('book_id', $book_id)->first();

        if ($book_detail) {
            return response([
                'status' => true,
                'message' => "sukses",
                'data' => $book_detail
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => "data tidak ditemukan",
                'data' => $book_detail
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $book_id)
    {

        $id_book_detail = Book::where('book_id', $book_id)->first();

        if (empty($id_book_detail)) {
            return response([
                'status' => false,
                'message' => "data tidak ditemukan",
                'data' => []
            ], 200);
        }

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publish_date' => 'required|date',
        ]);
        $update = $id_book_detail->update([
            'title' => $request->title,
            'author' => $request->author,
            'publish_date' => $request->publish_date,
        ]);

        if ($update) {
            return response([
                'status' => true,
                'message' => "sukses",
                'data' => $id_book_detail
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => "sukses",
                'data' => []
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $book_id)
    {

        $id_book_detail = Book::where('book_id', $book_id)->first();

        $delete = $id_book_detail->delete();

        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => "Berhasil Hapus Data"
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Gagal Hapus Data"
            ], 200);
        }
    }
}
