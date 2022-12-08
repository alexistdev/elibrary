<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\AdminTrait;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    use AdminTrait;

    /** route:  admin.kategori */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kategori = Kategori::orderBy('id', 'desc')->get();
            return DataTables::of($kategori)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
//                    $url = route('', base64_encode($row->id));
                    $url = "";
                    $btn = " <a href=\"$url\" class=\"btn btn-outline-primary px-5\"> Edit</a>";
//                    $btn = $btn . " <a href=\"#\" class=\"btn btn-danger btn-sm ml-auto open-hapus\" data-id=\"$row->id\" data-bs-toggle=\"modal\" data-bs-target=\"#hapusModal\"><i class=\"fas fa-trash\"></i> Delete</i></a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.kategori', array(
            'judul' => "Dashboard Guru | FavoriteIDN",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }


    /** route: adm.kategori.add */
    public function store(Request $request)
    {
        if ($request->routeIs('adm.*')) {
            $rules = [
                'nama' => 'required|unique:kategoris,name|max:255',
            ];
            $message = [
                'nama.required' => "Nama Kategori harus diisi!",
                'nama.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'nama.unique' => "Nama kategori sudah ada di dalam database!",
            ];
            $request->validateWithBag('tambah', $rules, $message);
            DB::beginTransaction();
            try {
                $kategori = new Kategori();
                $kategori->name = $request->nama;
                $kategori->save();
                DB::commit();
                return redirect(route('adm.kategori'))->with(['success' => "Data berhasil ditambahkan!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.kategori'))->with(['error' => $e->getMessage()]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }
}
