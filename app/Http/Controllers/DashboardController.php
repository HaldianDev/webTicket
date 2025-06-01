<?php


namespace App\Http\Controllers;

use App\Models\Layanan;

class DashboardController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('dashboard', compact('layanans'));
    }

}
