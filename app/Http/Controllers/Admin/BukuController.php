<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\DateModified;
use App\Http\Traits\AdminTrait;
use App\Models\Author;
use App\Models\Buku;
use Exception;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BukuController extends Controller
{
    use AdminTrait;

    /** route:  admin.buku */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $buku = Buku::with('author', 'kategori')->orderBy('id', 'desc')->get();
            return DataTables::of($buku)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $id = base64_encode($row->id);
                    $btn = " <a href=\"#\" class=\"btn btn-outline-primary px-5 open-edit\" data-bs-toggle=\"modal\" data-id=\"$id\" data-nama=\"$row->name\"  data-tahun=\"$row->tahun_terbit\" data-kategori=\"$row->kategori_id\" data-author=\"$row->author_id\" data-bs-target=\"#modalEdit\"> Edit</a>";
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
            'dataKategori' => Kategori::orderBy('name')->get(),
            'dataAuthor' => Author::orderBy('name')->get(),
            'dataTahun' => DateModified::getTahun(),
        ));
    }


    /** route: adm.book.add */
    public function store(Request $request)
    {
        if ($request->routeIs('adm.*')) {
            $rules = [
                'kategori_id' => 'required|numeric',
                'author_id' => 'required|numeric',
                'tahun' => 'required|numeric',
                'name' => 'required|unique:bukus,name|max:255',
            ];
            $message = [
                'kategori_id.required' => "Silahkan pilih kategori terlebih dahulu!",
                'kategori_id.numeric' => "Silahkan pilih kategori terlebih dahulu!",
                'author_id.required' => "Silahkan pilih Pengarang terlebih dahulu!",
                'author_id.numeric' => "Silahkan pilih Pengarang terlebih dahulu!",
                'tahun.required' => "Silahkan pilih Tahun Penerbitan terlebih dahulu!",
                'tahun.numeric' => "Silahkan pilih Tahun Penerbitan terlebih dahulu!",
                'name.required' => "Judul buku harus diisi!",
                'name.unique' => "Judul buku sudah ada di dalam database!",
                'name.max' => "Panjang karakter maksimal adalah 255 karakter!",

            ];
            $request->validateWithBag('tambah', $rules, $message);
            DB::beginTransaction();
            try {
                $buku = new Buku();
                $buku->author_id = $request->author_id;
                $buku->kategori_id = $request->kategori_id;
                $buku->name = $request->name;
                $buku->tahun_terbit = $request->tahun;
                $buku->save();
                DB::commit();
                return redirect(route('adm.book'))->with(['success' => "Data berhasil ditambahkan!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.book'))->withErrors(['error' => "Ada error di system silahkan kontak administrator"]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }


    /** route: adm.book.edit */
    public function update(Request $request){
        if ($request->routeIs('adm.*')) {
            $rules = [
                'idBuku' => 'required|max:255',
                'kategori_id' => 'required|numeric',
                'author_id' => 'required|numeric',
                'tahun' => 'required|numeric',
                'name' =>
                    [
                        'required',
                        Rule::unique('bukus')->ignore(base64_decode($request->idBuku)),
                    ]

            ];
            $message = [
                'idBuku.required' => "ID tidak ditemukan, silahkan refresh halaman atau kontak administrator!",
                'idBuku.max' => "ID tidak ditemukan, silahkan refresh halaman atau kontak administrator!",
                'kategori_id.required' => "Silahkan pilih kategori terlebih dahulu!",
                'kategori_id.numeric' => "Silahkan pilih kategori terlebih dahulu!",
                'author_id.required' => "Silahkan pilih Pengarang terlebih dahulu!",
                'author_id.numeric' => "Silahkan pilih Pengarang terlebih dahulu!",
                'tahun.required' => "Silahkan pilih Tahun Penerbitan terlebih dahulu!",
                'tahun.numeric' => "Silahkan pilih Tahun Penerbitan terlebih dahulu!",
                'name.required' => "Judul buku harus diisi!",
                'name.unique' => "Judul buku sudah ada di dalam database!",
                'name.max' => "Panjang karakter maksimal adalah 255 karakter!",
            ];
            $request->validateWithBag('edit', $rules, $message);
            DB::beginTransaction();
            try {
                Buku::findOrFail(base64_decode($request->idBuku));
                Buku::where('id',base64_decode($request->idBuku))->update([
                    'kategori_id' => $request->kategori_id,
                    'author_id' => $request->author_id,
                    'tahun_terbit' => $request->tahun,
                    'name' => $request->name,
                ]);
                DB::commit();
                return redirect(route('adm.book'))->with(['success' => "Data berhasil diperbaharui!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.book'))->withErrors(['error' => "Ada error di system silahkan kontak administrator"]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }
}
