<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Validated;
use League\CommonMark\Extension\Embed\Embed;
use PhpParser\Node\Expr\Cast\String_;
use PhpParser\Node\Expr\Empty_;

class BookController extends Controller
{

    const API_URL = 'http://127.0.0.1:8000/api/book';

    public function requestAPI($method, $urlSuffix = '', $data = [])
    {
        $client = new Client();
        $options = [];

        // Jika method adalah POST atau PUT, gunakan form_params untuk mengirim data
        if (in_array($method, ['POST', 'PUT'])) {
            if (!empty($data)) {
                $options['form_params'] = $data;
            }
        }
        // Jika method adalah GET atau DELETE, gunakan query untuk menyisipkan data ke URL
        elseif (in_array($method, ['GET', 'DELETE'])) {
            if (!empty($data)) {
                $options['query'] = $data;
            }
        }

        // Kombinasi base URL dengan URL suffix (contoh: /book/123)
        // rtrim(static::API_URL, '/'): Menghapus trailing slash yang ada pada API_URL, jika ada.
        // ltrim($urlSuffix, '/'): Menghapus leading slash pada $urlSuffix, jika ada.
        $url = rtrim(static::API_URL, '/') . '/' . ltrim($urlSuffix, '/');

        // Mengirim request dengan method yang sesuai
        $response = $client->request($method, $url, $options);

        // Mendapatkan body dari response
        $responseData = $response->getBody()->getContents();
        $book = json_decode($responseData, true);

        // Jika key 'data' ada, maka nilai yang terkandung dalam $book['data'] akan dikembalikan, Jika key 'data' tidak ada, maka mengembalikan null sebagai default.
        return isset($book['data']) ? $book['data'] : null;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $current_url =  url()->current();

        $page = request()->get('page', 1); // Ambil halaman dari query string, default ke 1

        // Ambil data dari API dan sertakan parameter `page`
        $items = $this->requestAPI('GET', '/', ['page' => $page]);

        // Ganti URL pada pagination jika ada
        $paginationKeys = ['first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url'];
        foreach ($paginationKeys as $key) {
            if (isset($items[$key])) {
                $items[$key] = str_replace(static::API_URL, $current_url, $items[$key]);
            }
        }

        foreach ($items['links'] as $key => $value) {
            $items['links'][$key]['url2'] = str_replace(static::API_URL, $current_url, $value['url']);
        };


        // Tampilkan data ke view
        return view('books.index', [
            'data' => $items,
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

        $title = $request->title;
        $author = $request->author;
        $publish_date = $request->publish_date;

        $items = $this->requestAPI('POST',  '/', [
            'title' => $title,
            'author' => $author,
            'publish_date' => $publish_date
        ]);

        return redirect('/book')->with('create', 'Success Create Book');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $book_id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $book_id)
    {
        // Ambil data dari API
        $items = $this->requestAPI('GET', $book_id);

        return view('books.edit', [
            'data' => $items // Berikan detail data buku ke view
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $book_id)
    {

        $title = $request->title;
        $author = $request->author;
        $publish_date = $request->publish_date;

        $items = $this->requestAPI('PUT',  $book_id, [
            'title' => $title,
            'author' => $author,
            'publish_date' => $publish_date
        ]);

        return redirect('/book')->with('success', 'Book updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $book_id)
    {

        $this->requestAPI('DELETE', $book_id);

        // mengembalikan ke halaman yang sedang dibuka
        return redirect()->to(url()->previous())->with('delete', 'Success Delete Book');
    }
}
