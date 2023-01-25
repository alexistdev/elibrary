<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\DateModified;
use App\Http\Traits\AdminTrait;
use App\Models\Author;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Stokbuku;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockController extends Controller
{
    use AdminTrait;

    /** route:  admin.stock */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stock = Stokbuku::get();
            return DataTables::of($stock)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $id = base64_encode($row->id);
                    $btn = " <a href=\"#\" class=\"btn btn-outline-primary px-5 open-edit\" data-bs-toggle=\"modal\" data-id=\"$id\" data-nama=\"$row->name\"  data-tahun=\"$row->tahun_terbit\" data-kategori=\"$row->kategori_id\" data-author=\"$row->author_id\" data-bs-target=\"#modalEdit\"> Edit</a>";
                    $btn = $btn . " <a href=\"#\" class=\"btn btn-outline-danger px-5 open-hapus\" data-id=\"$row->id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> Delete</i></a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.stock', array(
            'judul' => "Dashboard Guru | $this->title",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'dataKategori' => Kategori::orderBy('name')->get(),
        ));
    }

    public function ajax_getBuku_byKategori(Request $request){
        $data = collect();
        if($request->get('kategori_id') !== null){
            $data = Buku::where('kategori_id', $request->kategori_id)->get();
        }
        return response()->json($data);
    }
}
