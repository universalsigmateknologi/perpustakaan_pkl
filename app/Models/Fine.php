<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $table = 'fines';

    protected $fillable = [
        'kode_denda', 'member_id', 'loan_id', 'jumlah', 'keterangan', 'status', 'tanggal_bayar'
    ];
}