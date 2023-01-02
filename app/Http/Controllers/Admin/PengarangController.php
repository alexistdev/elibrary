<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\AdminTrait;
use App\Models\Author;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Exception;

class PengarangController extends Controller
{
    use AdminTrait;

    /** route:  admin.pengarang */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $author = Author::orderBy('id', 'desc')->get();
            return DataTables::of($author)
                ->addIndexColumn()
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('action', function ($row) {
                    $id = base64_encode($row->id);
                    $btn = " <a href=\"#\" class=\"btn btn-outline-primary px-5 open-edit\" data-bs-toggle=\"modal\" data-id=\"$id\" data-nama=\"$row->name\" data-bs-target=\"#modalEdit\"> Edit</a>";
                    $btn = $btn . " <a href=\"#\" class=\"btn btn-outline-danger px-5 hapus-modal\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#hapusModal\"> Delete</i></a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.author', array(
            'judul' => "Dashboard Guru | FavoriteIDN",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }

    /** route: adm.author.add */
    public function store(Request $request)
    {
        if ($request->routeIs('adm.*')) {
            $rules = [
                'nama' => 'required|unique:authors,name|max:255',
            ];
            $message = [
                'nama.required' => "Nama Pengarang harus diisi!",
                'nama.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'nama.unique' => "Nama Pengarang sudah ada di dalam database!",
            ];
            $request->validateWithBag('tambah', $rules, $message);
            DB::beginTransaction();
            try {
                $author = new Author();
                $author->name = $request->nama;
                $author->save();
                DB::commit();
                return redirect(route('adm.author'))->with(['success' => "Data berhasil ditambahkan!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.author'))->with(['error' => $e->getMessage()]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }

    /** route: adm.author.edit */
    public function update(Request $request)
    {
        if ($request->routeIs('adm.*')) {
            $rules = [
                'nama' => [
                    'required','max:255',
                    Rule::unique('authors','name')->ignore(base64_decode($request->idAuthor)),
                ],
                'idAuthor' => 'required|max:255',
            ];
            $message = [
                'nama.required' => "Nama Kategori harus diisi!",
                'nama.max' => "Panjang karakter maksimal adalah 255 karakter!",
                'nama.unique' => "Nama kategori sudah ada di dalam database!",
                'idAuthor.required' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
                'idAuthor.max' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
            ];
            $request->validateWithBag('edit', $rules, $message);
            DB::beginTransaction();
            try {
                Author::where('id',base64_decode($request->idAuthor))->update([
                    'name' => $request->nama,
                ]);
                DB::commit();
                return redirect(route('adm.author'))->with(['success' => "Data berhasil diperbaharui!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.author'))->with(['error' => $e->getMessage()]);
            }

        } else {
            return abort("404", "NOT FOUND");
        }

    }

    /** route: adm.author.delete */
    public function destroy(Request $request){
        if ($request->routeIs('adm.*')) {
            $rules = [
                'idAuthorDelete' => 'required|max:255',
            ];
            $message = [
                'idAuthorDelete.required' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
                'idAuthorDelete.max' => "ID tidak ditemukan silahkan ulangi kembali atau refresh halaman!",
            ];
            $request->validateWithBag('hapusAuthor', $rules, $message);
            DB::beginTransaction();
            try {
                $author = Author::findOrFail(base64_decode($request->idAuthorDelete));
                $author->delete();
                DB::commit();
                return redirect(route('adm.author'))->with(['warning' => "Data berhasil dihapus!"]);
            } catch (Exception $e) {
                DB::rollback();
                return redirect(route('adm.author'))->with(['error' => $e->getMessage()]);
            }
        } else {
            return abort("404", "NOT FOUND");
        }
    }
}
