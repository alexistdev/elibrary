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
                    $id = base64_encode($row->id);
                    $btn = " <a href=\"#\" class=\"btn btn-outline-primary px-5 open-edit\" data-bs-toggle=\"modal\" data-id=\"$id\" data-nama=\"$row->name\" data-bs-target=\"#modalEdit\"> Edit</a>";
                    $btn = $btn . " <a href=\"#\" class=\"btn btn-outline-danger px-5 open-hapus\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> Delete</i></a>";
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

    /** route: adm.kategori.edit */
    public function update(Request $request)
    {
        if ($request->routeIs('adm.*')) {
            $rules = [
                'nama' => 'required|max:255',
                'idKategori' => 'required|max:255',
            ];
            $message = [
                'nama.required' => "Nama Kategori harus diisi!",
                'nama.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'nama.unique' => "Nama kategori sudah ada di dalam database!",
                'idKategori.required' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
                'idKategori.max' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
            ];
            $request->validateWithBag('edit', $rules, $message);
            DB::beginTransaction();
            try {
                Kategori::where('id',base64_decode($request->idKategori))->update([
                   'name' => $request->nama,
                ]);
                DB::commit();
                return redirect(route('adm.kategori'))->with(['success' => "Data berhasil diperbaharui!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.kategori'))->with(['error' => $e->getMessage()]);
            }

        } else {
            return abort("404", "NOT FOUND");
        }

    }

    /** route: adm.kategori.delete */
    public function destroy(Request $request){
        if ($request->routeIs('adm.*')) {
            $rules = [
                'idKategori' => 'required|max:255',
            ];
            $message = [
                'idKategori.required' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
                'idKategori.max' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
            ];
            $request->validateWithBag('hapus', $rules, $message);
            DB::beginTransaction();
            try {
                $kategori = Kategori::findOrFail(base64_decode($request->idKategori));
                $kategori->delete();
                DB::commit();
                return redirect(route('adm.kategori'))->with(['warning' => "Data berhasil dihapus!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.kategori'))->with(['error' => $e->getMessage()]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }
}
