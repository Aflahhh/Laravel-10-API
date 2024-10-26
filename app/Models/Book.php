<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // mendefinisikan tabel
    protected $table = 'books';

    // mendefinisikan primary key
    protected $primaryKey = "book_id";

    // mendefinisikan tidak auto increment
    public $incrementing = false;

    // mendefinisikan type data primary key
    protected $keyType = 'string';
    protected $fillable = [
        'title',
        'author',
        'publish_date'
    ];

    public static function boot()
    {
        parent::boot();

        // Tambahkan event creating untuk menghasilkan kode sebelum disimpan
        static::creating(function ($book) {
            // Ambil kode terakhir dari database
            $lastBook = Book::orderBy('book_id', 'desc')->first();

            // Tentukan kode default pertama
            $newCode = 'B-001';

            if ($lastBook) {
                // Ambil angka terakhir dari kode (contoh: B-001 menjadi 001)
                $lastCodeNumber = (int) substr($lastBook->book_id, 2);

                // Buat kode baru dengan menambah 1 pada angka terakhir
                $newCode = 'B-' . str_pad($lastCodeNumber + 1, 3, '0', STR_PAD_LEFT);
            }

            // Set kode baru ke model sebelum menyimpan
            $book->book_id = $newCode;
        });
    }
}
