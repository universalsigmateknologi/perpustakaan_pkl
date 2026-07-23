<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $gender = $request->input('jenis_kelamin');

        $members = Member::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_member', 'like', "%{$search}%")
                  ->orWhere('nis_nip', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($gender, function ($query) use ($gender) {
            $query->where('jenis_kelamin', $gender);
        })
        ->latest()
        ->paginate(10);

        return view('main_menu.members.index', compact('members'));
    }

    public function create()
    {
        return view('main_menu.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nis_nip'       => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:15',
            'email'         => 'nullable|email|max:255',
        ]);

        // Generate kode member otomatis (MBR-0001)
        $lastMember = Member::latest('id')->first();
        $lastNumber = $lastMember ? (int) str_replace('MBR-', '', $lastMember->kode_member) : 0;
        $validated['kode_member'] = 'MBR-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Set tanggal daftar otomatis
        $validated['tanggal_daftar'] = now()->toDateString();
        $validated['status'] = 'aktif';

        Member::create($validated);

        return redirect()->route('members.index')
                         ->with('success', 'Anggota baru berhasil didaftarkan.');
    }

    public function edit(Member $member)
    {
        return view('main_menu.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nis_nip'       => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:15',
            'email'         => 'nullable|email|max:255',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
                         ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        // Opsional: Cek jika anggota masih punya pinjaman aktif sebelum hapus
        $member->delete();

        return redirect()->route('members.index')
                         ->with('success', 'Data anggota berhasil dihapus.');
    }
}