<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class BarangController extends Controller
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
        $data['title'] = "Barang";
        $data['menu'] = "barang";
        return view('barang', $data);
    }

    protected function getBarang()
    {
        $data = Barang::all();
        return response()->json($data);
    }

    protected function getBarangById($id)
    {
        $data = Barang::where('id', $id)
            ->first();
        return response()->json($data);
    }

    protected function addBarang(Request $request)
    {
        try {
            $request->validate([
                'tambah-nama-barang' => 'required',
                'tambah-harga-barang' => 'required',
            ], [
                'tambah-nama-barang.required' => 'Nama Barang harus diisi.',
                'tambah-harga-barang.required' => 'Barang harus diisi.',
            ]);
            $find = Barang::where('nama', $request->input('tambah-nama-barang'))->first();
            if ($find) {
                return response()->json(['success' => false, 'msg' => 'Nama barang sudah terdaftar!']);
            } else {
                try {
                    Barang::create([
                        'kode'      => Barang::generateKode(),
                        'nama'      => $request->input('tambah-nama-barang'),
                        'harga'     => str_replace('.', '', $request->input('tambah-harga-barang')),
                    ]);
                    return response()->json(['success' => true, 'msg' => 'Barang telah ditambahkan!']);
                } catch (QueryException $exception) {
                    return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
                }
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

    protected function editBarang(Request $request)
    {
        try {
            $request->validate([
                'edit-nama-barang' => 'required',
                'edit-harga-barang' => 'required',
            ], [
                'edit-nama-barang.required' => 'Nama Barang harus diisi.',
                'edit-harga-barang.required' => 'Barang harus diisi.',
            ]);
            try {
                $edit_Barang = Barang::find($request->input('edit-id-barang'));
                $edit_Barang->update([
                    'nama'         => $request->input('edit-nama-barang'),
                    'harga'        => str_replace('.', '', $request->input('edit-harga-barang')),
                    'updated_at'   => now(),
                ]);
                return response()->json(['success' => true, 'msg' => 'Data barang telah diubah!.']);
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

    public function deleteBarang($id)
    {
        try {
            $delete_barang = Barang::find($id);
            $delete_barang->delete();

            return response()->json(['success' => true, 'msg' => 'Barang telah dihapus!']);
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }
}
