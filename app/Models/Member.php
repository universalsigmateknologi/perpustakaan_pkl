<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'kode_member',
        'nama',
        'nis_nip',
        'jenis_kelamin',
        'alamat',
        'telepon',
        'email',
        'tanggal_daftar',
        'status',
    ];

    // Relasi ke transaksi peminjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}