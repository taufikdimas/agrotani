<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Untuk tampilan awal
        if (! $request->ajax()) {
            return view('user.index');
        }

        $perPage = $request->input('per_page', 10);
        $search  = $request->input('search', '');

        $users = User::query();

        if (! empty($search)) {
            $users->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        $users = $users->paginate($perPage);

        return response()->json([
            'users' => $users->items(),
            // 'pagination' => $users->links()->toHtml(),
        ]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', 'in:Super Admin,User'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            User::create([
                'nama'     => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'User berhasil ditambahkan',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menambahkan user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'password' => ['nullable', 'string', 'min:6'],
            'role'     => ['required', 'in:Super Admin,User'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $user->nama     = $request->nama;
            $user->username = $request->username;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->save();

            return response()->json([
                'status'  => true,
                'message' => 'User berhasil diperbarui',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memperbarui user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function confirm($id)
    {
        $user = User::find($id);
        return view('user.confirm', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();

            return response()->json([
                'status'  => true,
                'message' => 'User berhasil dihapus',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus user',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}