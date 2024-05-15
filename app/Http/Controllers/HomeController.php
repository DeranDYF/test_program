<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\Customer;
use App\Models\Barang;

class HomeController extends Controller
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
        $data['title'] = "Home";
        $data['menu'] = "home";
        $data['customer'] = Customer::all();
        $data['customer_count'] = Customer::count();
        $data['barang_count'] = Barang::count();
        $data['transaksi_count'] = Sale::count();
        return view('home', $data);
    }
}
