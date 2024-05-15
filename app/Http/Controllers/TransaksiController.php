<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Saledet;
use App\Models\Barang;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
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
        $data['title'] = "Transaksi";
        $data['menu'] = "transaksi";
        return view('transaksi', $data);
    }

    protected function getTransaksi()
    {
        $data = Sale::join('customers', 'sales.cust_id', '=', 'customers.id')
            ->select('sales.*', 'customers.nama as nama_customer')
            ->orderBy('sales.tgl', 'desc')
            ->get();
        return response()->json($data);
    }

    protected function getTransaksiById($id)
    {
        $data = Sale::with(['saledets.barang'])
            ->join('customers', 'sales.cust_id', '=', 'customers.id')
            ->select('sales.*', 'customers.nama as nama_customer')
            ->where('sales.id', $id)
            ->first();
        return response()->json($data);
    }

    protected function addTransaksi(Request $request)
    {
        try {

            $tambahQty = $request->input('tambah-qty');
            foreach ($tambahQty as $qty) {
                if ($qty == 0) {
                    return response()->json(['success' => false, 'msg' => 'Qty Minimal harus 1']);
                }
            }

            DB::beginTransaction();
            $sale = Sale::create([
                'kode'           => Sale::generateKode(),
                'tgl'            => $request->input('tambah-tanggal-transaksi'),
                'cust_id'        => $request->input('tambah-daftar-customer-transaksi'),
                'jumlah_barang'  => $request->input('tambah-jumlah-barang'),
                'subtotal'       => str_replace('.', '', $request->input('tambah-subtotal-transaksi')),
                'diskon'         => str_replace('.', '', $request->input('tambah-diskon-transaksi')),
                'ongkir'         => str_replace('.', '', $request->input('tambah-ongkir-transaksi')),
                'total_bayar'    => str_replace('.', '', $request->input('tambah-total-bayar-transaksi')),
            ]);

            foreach ($request->input('tambah-kode-barang') as $index => $barangId) {
                $qty = $request->input('tambah-qty')[$index];
                $diskon = $request->input('tambah-diskon')[$index];

                $find_barang = Barang::where('id', $barangId)->first();
                $diskon_nilai = $find_barang->harga * $diskon / 100;
                $harga_diskon = $find_barang->harga - $diskon_nilai;
                Saledet::create([
                    'sales_id'        => $sale->id,
                    'barang_id'       => $barangId,
                    'harga_bandrol'   => $find_barang->harga,
                    'qty'             => $qty,
                    'diskon_pct'      => $diskon,
                    'diskon_nilai'    => $diskon_nilai,
                    'harga_diskon'    => $harga_diskon,
                    'total_harga'     => $harga_diskon * $qty,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Transaksi telah ditambahkan!']);
        } catch (QueryException $exception) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }

    protected function editTransaksi(Request $request)
    {
        // dd($request->input());
        try {
            $tambahQty = $request->input('edit-qty');
            foreach ($tambahQty as $qty) {
                if ($qty == 0) {
                    return response()->json(['success' => false, 'msg' => 'Qty Minimal harus 1']);
                }
            }

            DB::beginTransaction();
            $edit_sale = Sale::find($request->input('edit-id-transaksi'));
            $edit_sale->update([
                'tgl'            => $request->input('edit-tanggal-transaksi'),
                'jumlah_barang'  => $request->input('edit-jumlah-barang'),
                'subtotal'       => str_replace('.', '', $request->input('edit-subtotal-transaksi')),
                'diskon'         => str_replace('.', '', $request->input('edit-diskon-transaksi')),
                'ongkir'         => str_replace('.', '', $request->input('edit-ongkir-transaksi')),
                'total_bayar'    => str_replace('.', '', $request->input('edit-total-bayar-transaksi')),
            ]);

            $editKodeBarang = $request->input('edit-kode-barang');
            $editQty = $request->input('edit-qty');
            $editDiskon = $request->input('edit-diskon');

            $existingBarangIds = Saledet::where('sales_id', $request->input('edit-id-transaksi'))
                ->pluck('barang_id')
                ->toArray();

            foreach ($editKodeBarang as $index => $barangId) {
                $qty = $editQty[$index];
                $diskon = $editDiskon[$index];

                $findBarang = Barang::where('id', $barangId)->first();
                $diskonNilai = $findBarang->harga * $diskon / 100;
                $hargaDiskon = $findBarang->harga - $diskonNilai;

                if (in_array($barangId, $existingBarangIds)) {

                    Saledet::where('sales_id', $request->input('edit-id-transaksi'))
                        ->where('barang_id', $barangId)
                        ->update([
                            'harga_bandrol' => $findBarang->harga,
                            'qty' => $qty,
                            'diskon_pct' => $diskon,
                            'diskon_nilai' => $diskonNilai,
                            'harga_diskon' => $hargaDiskon,
                            'total_harga' => $hargaDiskon * $qty,
                            'updated_at' => now(),
                        ]);

                    $key = array_search($barangId, $existingBarangIds);
                    unset($existingBarangIds[$key]);
                } else {

                    Saledet::create([
                        'sales_id' => $request->input('edit-id-transaksi'),
                        'barang_id' => $barangId,
                        'harga_bandrol' => $findBarang->harga,
                        'qty' => $qty,
                        'diskon_pct' => $diskon,
                        'diskon_nilai' => $diskonNilai,
                        'harga_diskon' => $hargaDiskon,
                        'total_harga' => $hargaDiskon * $qty,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            Saledet::where('sales_id', $request->input('edit-id-transaksi'))
                ->whereIn('barang_id', $existingBarangIds)
                ->delete();
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Transaksi telah ditambahkan!']);
        } catch (QueryException $exception) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }


    public function deleteTransaksi($id)
    {
        try {
            DB::beginTransaction();
            Saledet::where('sales_id', $id)->delete();
            Sale::find($id)->delete();
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Transaksi telah dihapus!']);
        } catch (QueryException $exception) {
            DB::rollback();
            return response()->json(['success' => false, 'msg' => $exception->getMessage()]);
        }
    }
}
