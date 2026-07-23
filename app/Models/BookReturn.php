<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    // Mengarah ke tabel 'returns' sesuai migration awal Anda
    protected $table = 'returns'; 

    protected $fillable = [
        'kode_kembali', 'loan_id', 'user_id', 'tanggal_kembali', 
        'terlambat_hari', 'denda', 'catatan'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}