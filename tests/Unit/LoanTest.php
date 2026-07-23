<?php

namespace Tests\Unit;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    public function test_date_attributes_are_cast_to_date_format()
    {
        $loan = new Loan();

        $casts = $loan->getCasts();

        $this->assertSame('date', $casts['tanggal_pinjam']);
        $this->assertSame('date', $casts['tanggal_kembali']);
        $this->assertSame('date', $casts['tanggal_dikembalikan']);
    }
}
