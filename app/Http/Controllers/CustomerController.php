<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
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
        $data['title'] = "Customer";
        $data['menu'] = "customer";
        return view('customer', $data);
    }

    protected function getCustomer()
    {
        $data = Customer::all();
        return response()->json($data);
    }

    protected function getCustomerById($id)
    {
        $data = Customer::where('id', $id)
            ->first();
        return response()->json($data);
    }

    protected function addCustomer(Request $request)
    {

        try {
            $request->validate([
                'tambah-nama-customer' => 'required',
                'tambah-telepon-customer' => 'numeric|regex:/^0\d+$/|digits_between:11,13',
            ], [
                'tambah-nama-customer.required' => 'Nama Customer harus diisi.',
                'tambah-telepon-customer.required' => 'Telepon harus diisi.',
                'tambah-telepon-customer.numeric' => 'Telepon harus berupa angka.',
                'tambah-telepon-customer.regex' => 'Angka awal harus 0.',
                'tambah-telepon-customer.digits_between' => 'Telepon harus memiliki panjang antara 11 hingga 13 digit.',
            ]);
            $find = Customer::where('nama', $request->input('tambah-nama-customer'))->first();
            if ($find) {
                return response()->json(['success' => false, 'msg' => 'Nama Customer sudah terdaftar!']);
            } else {
                try {
                    Customer::create([
                        'kode'      => Customer::generateKode(),
                        'nama'      => $request->input('tambah-nama-customer'),
                        'telp'      => $request->input('tambah-telepon-customer'),
                    ]);
                    return response()->json(['success' => true, 'msg' => 'Customer telah ditambahkan!']);
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

    protected function editCustomer(Request $request)
    {
        try {
            $request->validate([
                'edit-nama-customer' => 'required',
                'edit-telepon-customer' => 'numeric|regex:/^0\d+$/|digits_between:11,13',
            ], [
                'edit-nama-customer.required' => 'Nama Customer harus diisi.',
                'edit-telepon-customer.required' => 'Telepon harus diisi.',
                'edit-telepon-customer.numeric' => 'Telepon harus berupa angka.',
                'edit-telepon-customer.regex' => 'Angka awal harus 0.',
                'edit-telepon-customer.digits_between' => 'Telepon harus memiliki panjang antara 11 hingga 13 digit.',
            ]);
            try {
                $edit_customer = Customer::find($request->input('edit-id-customer'));
                $edit_customer->update([
                    'nama'         => $request->input('edit-nama-customer'),
                    'telp'         => $request->input('edit-telepon-customer'),
                    'updated_at'   => now(),
                ]);
                return response()->json(['success' => true, 'msg' => 'Data customer telah diubah!.']);
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

    public function deleteCustomer($id)
    {
        try {
            $delete_customer = Customer::find($id);
            $delete_customer->delete();

            return response()->json(['success' => true, 'msg' => 'Customer telah dihapus!']);
        } catch (QueryException $exception) {
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }
}
