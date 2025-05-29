<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AcountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userss = User::with(['profile']) // eager load relasi
                ->where('id', '!=', auth()->id())
                ->latest()
                ->get();
        return view('account.index', compact('userss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::all(); // kirim ke view
        return view('account.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|confirmed|min:8',
                'menu_ids' => 'array|nullable',
                'id_akun' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'telepon' => 'required|string|max:20',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'pegawai',
            ]);

            // Simpan data profil
            $user->profile()->create([
                'id_akun' => $validatedData['id_akun'] ?? null,
                'alamat' => $validatedData['alamat'] ?? null,
                'telepon' => $validatedData['telepon'] ?? null,
            ]);

            // Simpan menu jika ada
            if ($request->has('menu_ids')) {
                $user->menus()->sync($request->menu_ids);
            }

            return redirect()->route('acount.index')->with('success', 'Akun berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan akun.');
        }
    }

    public function edit(User $user)
    {
        $menus = Menu::all();
        $userMenuIds = $user->menus->pluck('id')->toArray();
        $user->load('profile');

        return view('account.edit', compact('user', 'menus', 'userMenuIds'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|confirmed|min:8',
                'menu_ids' => 'array|nullable',
                'id_akun' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
                'telepon' => 'required|string|max:20',
            ]);

            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                unset($validatedData['password']);
            }

            $user->update($validatedData);

            // Update atau buat profile
            $user->profile()->updateOrCreate([], [
                    'id_akun' => $validatedData['id_akun'] ?? null,
                    'alamat' => $validatedData['alamat'] ?? null,
                    'telepon' => $validatedData['telepon'] ?? null,
                ],
            );

            // Update menu
            if ($user->role == 'pegawai') {
                $user->menus()->sync($request->menu_ids ?? []);
            }

            return redirect()->route('acount.index')->with('success', 'Akun berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui akun.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->back()->with('success', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Akun. Silakan coba lagi.');
        }
    }
}
