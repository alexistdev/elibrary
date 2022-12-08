<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\GuruTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdmin extends Controller
{
    use GuruTrait;


    public function index()
    {
        return view('admin.dashboard',array(
            'judul' => "Dashboard Administrator | FavoriteIDN",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'dataUser' => $this->users,
        ));
    }
}
