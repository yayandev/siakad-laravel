<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function profile()
    {
        if (auth()->user()->role == 'admin') {
            return view('account.admin.profile');
        } else if (auth()->user()->role == 'guru') {
            $guru = Guru::where('id_user', auth()->user()->id)->first();
            return view('account.guru.profile', compact('guru'));
        } else if (auth()->user()->role == 'siswa') {
            $siswa = Siswa::where('id_user', auth()->user()->id)->with('user')->first();
            return view('account.siswa.profile', compact('siswa'));
        } else {
            return redirect('/');
        }
    }


    public function changeProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');

        $image->storeAs('public/users', $image->hashName());

        $user = auth()->user();

        $oldImage = $user->profile_picture;

        if (basename($oldImage) !== 'default.png') {
            Storage::delete('public/users/' . basename($oldImage));
        }

        User::where('id', $user->id)->update([
            'profile_picture' => $image->hashName(),
        ]);

        return redirect('/account/profile')->with(['success' => 'Profile picture successfully changed!']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|same:confirmNewPassword',
            'confirmNewPassword' => 'required',
        ]);

        $user = auth()->user();

        $currentPasswordStatus = Hash::check($request->oldPassword, $user->password);

        if ($currentPasswordStatus) {
            User::where('id', $user->id)->update([
                'password' => bcrypt($request->newPassword),
            ]);
            return redirect('/settings/change_password')->with(['success' => 'Password successfully changed!']);
        } else {
            return redirect('/settings/change_password')->with(['error' => 'Wrong password!']);
        }
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $currentPasswordStatus = Hash::check($request->password, auth()->user()->password);

        if ($currentPasswordStatus) {
            User::where('id', auth()->user()->id)->update([
                'email' => $request->email
            ]);
            return redirect('/settings/change_email')->with(['success' => 'Email successfully changed!']);
        } else {
            return redirect('/settings/change_email')->with(['error' => 'Wrong password!']);
        }
    }

    public function resetPassword(Request $request, $id)
    {

        $user = User::with('siswa')->where('id', $id)->first();

        if (!$user) {
            return redirect('/users')->with(['error' => 'User not found!']);
        }

        if ($user->role === 'siswa') {
            $user->update([
                'password' => bcrypt($user->siswa->nis)
            ]);

            return redirect('/users')->with(['success' => 'Password di reset ke ' . $user->siswa->nis]);
        } else {

            $pass = random_int(100000, 999999);
            $user->update([
                'password' => bcrypt($pass)
            ]);

            return redirect('/users')->with(['success' => 'Password di reset ke ' . $pass]);
        }
    }
}
