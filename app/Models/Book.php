<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'kode_buku',
        'judul',
        'isbn',
        'category_id',
        'publisher_id',
        'author_id',
        'shelf_id',
        'tahun_terbit',
        'jumlah',
        'tersedia',
        'cover',
        'deskripsi',
    ];

    // Relasi
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelve::class);
    }
}