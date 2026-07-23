<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table = 'loans';

    protected $fillable = [
        'kode_pinjam', 'member_id', 'user_id', 'tanggal_pinjam', 
        'tanggal_kembali', 'tanggal_dikembalikan', 'status', 'catatan'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }
}