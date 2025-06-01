<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProduk' => Product::count(),
            'totalKategori' => Category::count(),
            'totalPesanan' => Order::count(),
            'totalPengguna' => User::count(),
        ]);
    }
}

