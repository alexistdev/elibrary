<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\AdminTrait;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BukuController extends Controller
{
    use AdminTrait;

    /** route:  admin.kategori */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $buku = Buku::with('author','kategori')->orderBy('id', 'desc')->get();
            return DataTables::of($buku)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $id = base64_encode($row->id);
                    $btn = " <a href=\"#\" class=\"btn btn-outline-primary px-5 open-edit\" data-bs-toggle=\"modal\" data-id=\"$id\" data-nama=\"$row->name\" data-bs-target=\"#modalEdit\"> Edit</a>";
                    $btn = $btn . " <a href=\"#\" class=\"btn btn-outline-danger px-5 open-hapus\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> Delete</i></a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.buku', array(
            'judul' => "Dashboard Guru | $this->title",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }
}
