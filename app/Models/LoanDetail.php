<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    protected $table = 'loan_details';

    protected $fillable = ['loan_id', 'book_id', 'jumlah', 'kondisi'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}