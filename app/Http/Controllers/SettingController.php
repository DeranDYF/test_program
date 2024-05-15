<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $data['menu'] = 'home';
        $data['title'] = 'Setting';
        return view('setting', $data);
    }

    protected function getUser()
    {
        $data = Auth::user();
        return response()->json($data);
    }

    protected function updateUserAvatar(Request $request)
    {
        try {
            $request->validate([
                'setting-user-avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:800',
            ], [
                'setting-user-avatar.image' => 'Gambar profil harus berupa gambar.',
                'setting-user-avatar.mimes' => 'Ekstensi Gambar profil tidak didukung.',
                'setting-user-avatar.max' => 'Gambar profil harus dibawah 800 KB.'
            ]);

            try {
                $data = Auth::user();
                $path = 'assets/img/avatars';
                if ($data->avatar != null) {
                    $file_path = public_path($data->avatar);
                    unlink($file_path);
                }
                $extension = $request->file('setting-user-avatar')->getClientOriginalExtension();
                $fileName = uniqid() . '_' . $data->name . '_avatar.' . $extension;
                $request->file('setting-user-avatar')->move(public_path('assets/img/avatars'), $fileName);
                $data->update([
                    'avatar' => $path . '/' . $fileName,
                ]);
                $data->refresh();

                return response()->json(['success' => true, 'msg' => 'Mengubah Profil Berhasil.']);
            } catch (QueryException $exception) {
                return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
            }
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $errorMessages = [];
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages[] = $message;
                }
            }
            return response()->json(['success' => false, 'msg' => $errorMessages]);
        }
    }

    protected function updateUser(Request $request)
    {
        try {
            $request->validate([
                'setting-user-telepon' => ['numeric', 'regex:/^0\d+$/'],
            ], [
                'setting-user-telepon.numeric' => 'Telepon harus berupa angka.',
                'setting-user-telepon.regex' => 'Angka awal harus 0.',
            ]);
            try {
                $data = Auth::user();
                $data->update([
                    'name' => $request->input('setting-user-nama'),
                    'alamat' => $request->input('setting-user-alamat'),
                    'telepon' => $request->input('setting-user-telepon'),

                ]);
                $data->refresh();
                return response()->json(['success' => true, 'msg' => 'Mengubah User Berhasil.']);
            } catch (QueryException $exception) {
                return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
            }
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $errorMessages = [];
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages[] = $message;
                }
            }
            return response()->json(['success' => false, 'msg' => $errorMessages]);
        }
    }

    protected function updateUserPassword(Request $request)
    {
        try {
            $request->validate([
                'setting-user-password' => 'required|min:8',
                'setting-user-confirm-password' => 'required|same:setting-user-password',
            ], [
                'setting-user-password.min' => 'Password minimal harus 8 karakter.',
                'setting-user-confirm-password.same' => 'Confirm password harus dengan password baru.',
            ]);

            try {
                $data = Auth::user();
                $data->update([
                    'password'    => Hash::make($request->input('setting-user-password')),
                ]);
                $data->refresh();

                return response()->json(['success' => true, 'msg' => 'Mengubah Password Berhasil.']);
            } catch (QueryException $exception) {
                return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
            }
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $errorMessages = [];
            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages[] = $message;
                }
            }
            return response()->json(['success' => false, 'msg' => $errorMessages]);
        }
    }
}
