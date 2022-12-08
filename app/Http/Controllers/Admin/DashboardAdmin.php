<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\AdminTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdmin extends Controller
{
    use AdminTrait;


    public function index()
    {
        return view('admin.dashboard',array(
            'judul' => "Dashboard Administrator | Elibrary",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'dataUser' => $this->users,
        ));
    }
}
