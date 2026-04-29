<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index(Request $request, $current_team)
    {
        $search = $request->search;
        $status = $request->status;

        $lapangans = Lapangan::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('jenis', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.lapangan.index', compact('lapangans', 'current_team'));
    }

    public function create($current_team)
    {
        return view('admin.lapangan.create', compact('current_team'));
    }

    public function store(Request $request, $current_team)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, png, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $targetFolder = (file_exists(base_path('public_html')) ? base_path('public_html/uploads/lapangan') : public_path('uploads/lapangan'));
            
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }
            
            $file->move($targetFolder, $filename);
            $validated['gambar'] = 'lapangan/' . $filename;
        }

        Lapangan::create($validated);

        return redirect()->route('lapangan.index', $current_team)
            ->with('success', 'Data lapangan berhasil ditambahkan.');
    }

    public function edit($current_team, Lapangan $lapangan)
    {
        return view('admin.lapangan.edit', compact('lapangan', 'current_team'));
    }

    public function update(Request $request, $current_team, Lapangan $lapangan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus berformat jpg, jpeg, png, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Tentukan folder tujuan (public/uploads/lapangan)
            $targetFolder = (file_exists(base_path('public_html')) ? base_path('public_html/uploads/lapangan') : public_path('uploads/lapangan'));
            
            // Pastikan folder ada
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }
            
            // Pindahkan file secara brutal/langsung
            $file->move($targetFolder, $filename);
            $validated['gambar'] = 'lapangan/' . $filename;
        }

        $lapangan->update($validated);

        return redirect()->route('lapangan.index', $current_team)
            ->with('success', 'Data lapangan berhasil diupdate.');
    }

    public function destroy($current_team, Lapangan $lapangan)
    {
        try {
            if ($lapangan->gambar) {
                // Hapus dari folder uploads (jalur baru)
                $oldPath = public_path('uploads/' . $lapangan->gambar);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
                
                // Cek juga di folder storage lama
                if (Storage::disk('public')->exists($lapangan->gambar)) {
                    Storage::disk('public')->delete($lapangan->gambar);
                }
            }

            $lapangan->delete();

            return redirect()->route('lapangan.index', $current_team)
                ->with('success', 'Data lapangan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('lapangan.index', $current_team)
                ->with('error', 'Gagal menghapus! Lapangan ini masih memiliki data booking yang aktif.');
        }
    }
   

    public function userIndex(Request $request, $current_team)
{
    $search = $request->search;
    $status = $request->status;

    $lapangans = Lapangan::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('jenis', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->paginate(6)
        ->withQueryString();

    return view('user.lapangan.index', compact('lapangans', 'current_team', 'search', 'status'));
}
}