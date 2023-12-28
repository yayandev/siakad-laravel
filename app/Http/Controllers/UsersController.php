<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {

        if (request()->has('search')) {
            $users = User::where('name', 'like', '%' . request('search') . '%')->where('email', 'like', '%' . request('search') . '%')->paginate(4);
            return view('users.index', compact('users'));
        }

        $users = User::paginate(4);
        return view('users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required',
            'status' => 'required'
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect('/users')->with(['error' => 'User not found']);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status
        ]);

        return redirect('/users')->with(['success' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/users')->with(['error' => 'User not found']);
        }

        $user->delete();

        return redirect('/users')->with(['success' => 'User deleted successfully']);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required',
        ]);


        $hashPassword = bcrypt($request->password);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
            'password' => $hashPassword
        ]);

        if (!$user) {
            return redirect('/users')->with(['error' => 'User not created']);
        }

        if ($request->role === 'siswa') {
            $year = date('y');
            $month = date('m');
            $day = date('d');
            $nis = $year . $month . $day . $user->id;

            $siswa = Siswa::create([
                'id_user' => $user->id,
                'name' => $request->name,
                'nis' => $nis
            ]);

            if (!$siswa) {
                return redirect('/users')->with(['error' => 'Siswa not created']);
            }
        } else if ($request->role === 'guru') {
            $guru = Guru::create([
                'id_user' => $user->id,
                'name' => $request->name
            ]);

            if (!$guru) {
                return redirect('/users')->with(['error' => 'Guru not created']);
            }
        }

        return redirect('/users')->with(['success' => 'User created successfully']);
    }
}
