<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fine;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $fines = Fine::with(['member', 'loan'])
            ->when($search, function ($query) use ($search) {
                $query->where('kode_denda', 'like', "%{$search}%")
                      ->orWhereHas('member', function ($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode_member', 'like', "%{$search}%");
                      });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('main_menu.denda.index', compact('fines'));
    }

    public function pay(Fine $fine)
    {
        // Pastikan denda belum lunas
        if ($fine->status == 'lunas') {
            return back()->with('error', 'Denda ini sudah berstatus lunas.');
        }

        $fine->update([
            'status' => 'lunas',
            'tanggal_bayar' => now()->toDateString(),
        ]);

        return redirect()->route('denda.index')
                         ->with('success', 'Pembayaran denda berhasil dikonfirmasi. Status sekarang LUNAS.');
    }
}