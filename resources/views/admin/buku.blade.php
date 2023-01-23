<x-rocker.template-rocker>
    @push('cssLayout')
        <link href="{{asset('template/rocker/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}"
              rel="stylesheet"/>
    @endpush
    <div class="page-content">
        <div class="row">
            <div class="col-12 col-lg-12">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Buku</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="{{route('adm.dashboard')}}"><i
                                            class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Data Buku</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="ms-auto">
                        <button type="button" class="btn btn-sm btn-primary px-2 py-2" data-id="$row->id"
                                data-bs-toggle="modal" data-bs-target="#modalTambah"><i
                                class='bx bx-add-to-queue mr-1'></i>Tambah Data
                        </button>
                    </div>
                </div>
                <!--end breadcrumb-->
                <h6 class="mb-0 text-uppercase">Master Data Buku</h6>
                <hr/>
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabelBuku" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Pengarang</th>
                                    <th class="text-center">Tahun Terbit</th>
                                    <th class="text-center">Dibuat</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->
    </div>
    <!-- Start: Modal Tambah -->
    <div id="modalTambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- // END .modal-header -->
                <form action="{{route('adm.book.add')}}" method="post">
                    @csrf
                    <div class="modal-body">

                        <!-- Start: Nama Buku -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label
                                    for="name" @class(["form-label","errorLabel",($errors->tambah->has('name'))? "text-danger":""]) >JUDUL
                                    BUKU<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       @class(["form-control","errorInput",($errors->tambah->has('name'))? "is-invalid":""]) id="name"
                                       value="{{old('name')}}">
                            </div>
                            <div class="col-lg-12">
                                @if($errors->tambah->has('name'))
                                    <div class="text-danger errorMessage">{{$errors->tambah->first('name')}}</div>
                                @endif
                            </div>
                        </div>
                        <!-- End: Nama Kategori  -->

                        <!-- Start: Nama Kategori -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label
                                    for="kategori_id" @class(["form-label","errorLabel",($errors->tambah->has('kategori_id'))? "text-danger":""]) >NAMA
                                    KATEGORI<span
                                        class="text-danger">*</span></label>
                                <select name="kategori_id"
                                        id="kategori_id" @class(["form-control","errorInput",($errors->tambah->has('kategori_id'))? "is-invalid":""])>
                                    <option value="">Pilih</option>
                                    @foreach($dataKategori as $kategori)
                                        <option value="{{$kategori->id}}" @if(old('kategori_id') == $kategori->id) selected @endif>{{$kategori->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->tambah->has('kategori_id'))
                                <div class="col-lg-12">
                                    <div class="text-danger errorMessage">{{$errors->tambah->first('kategori_id')}}</div>
                                </div>
                            @endif
                        </div>
                        <!-- End: Nama Kategori  -->

                        <!-- Start: Nama Author -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label
                                    for="author_id" @class(["form-label","errorLabel",($errors->tambah->has('author_id'))? "text-danger":""]) >NAMA
                                    PENGARANG<span
                                        class="text-danger">*</span></label>
                                <select name="author_id"
                                        id="author_id" @class(["form-control","errorInput",($errors->tambah->has('author_id'))? "is-invalid":""])>
                                    <option value="">Pilih</option>
                                    @foreach($dataAuthor as $author)
                                        <option value="{{$author->id}}" @if(old('author_id') == $author->id) selected @endif>{{$author->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->tambah->has('author_id'))
                                <div class="col-lg-12">
                                    <div class="text-danger errorMessage">{{$errors->tambah->first('author_id')}}</div>
                                </div>
                            @endif
                        </div>
                        <!-- End: Nama Author  -->

                        <!-- Start: Tahun Terbit -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label
                                    for="tahun" @class(["form-label","errorLabel",($errors->tambah->has('tahun'))? "text-danger":""]) >TAHUN
                                    TERBIT <span
                                        class="text-danger">*</span></label>
                                <select name="tahun"
                                        id="tahun" @class(["form-control","errorInput",($errors->tambah->has('tahun'))? "is-invalid":""])>
                                    <option value="">Pilih</option>
                                    @foreach($dataTahun as $tahun)
                                        <option value="{{$tahun}}"
                                                @if(date("Y",strtotime(now())) == $tahun || old('tahun') == $tahun) selected @endif>{{$tahun}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->tambah->has('tahun'))
                                <div class="col-lg-12">
                                    <div class="text-danger errorMessage">{{$errors->tambah->first('tahun')}}</div>
                                </div>
                            @endif
                        </div>
                        <!-- End: Tahun Terbit -->


                    </div>
                    <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div>
    <!-- End: Modal Tambah        -->

    <!-- Start: Modal Edit -->
    <div id="modalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- // END .modal-header -->
                <form action="{{route('adm.kategori.edit')}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="idKategori" class="form-control" id="idKategori"/>
                                @if($errors->edit->has('idKategori'))
                                    <div class="row">
                                        <div
                                            class="text-danger errorMessage">{{$errors->edit->first('idKategori')}}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Start: Nama Kategori -->
                        <div class="row">
                            <div class="col-lg-12">
                                <label
                                    for="editNama" @class(["form-label","errorLabel",($errors->edit->has('nama'))? "text-danger":""]) >NAMA
                                    KATEGORI<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama"
                                       @class(["form-control","errorInput",($errors->edit->has('nama'))? "is-invalid":""]) id="editNama"
                                       value="{{old('nama')}}">
                            </div>
                            <div class="col-lg-12">
                                @if($errors->edit->has('nama'))
                                    <div class="text-danger errorMessage">{{$errors->edit->first('nama')}}</div>
                                @endif
                            </div>
                        </div>
                        <!-- End: Nama Kategori  -->
                    </div>
                    <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div>
    <!-- End: Modal Edit        -->

    <!-- Start: Modal Hapus -->
    <div id="modalHapus" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-standard-title"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-standard-title">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> <!-- // END .modal-header -->
                <form action="{{route('adm.kategori.delete')}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="idKategori" class="form-control" id="idHapusKategori"/>
                                @if($errors->hapus->has('idKategori'))
                                    <div class="row">
                                        <div
                                            class="text-danger errorMessage">{{$errors->hapus->first('idKategori')}}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Start: Nama Kategori -->
                        <div class="row">
                            <div class="col-lg-12">
                                Apakah anda ingin menghapus data ini ?
                            </div>
                        </div>
                        <!-- End: Nama Kategori  -->
                    </div>
                    <!-- // END .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div> <!-- // END .modal-content -->
        </div> <!-- // END .modal-dialog -->
    </div>
    <!-- End: Modal Hapus -->

    @push('jsLayout')
        <script src="{{asset('template/rocker/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('template/rocker/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
        <!--notification js -->
        <script src="{{asset('template/rocker/assets/plugins/notifications/js/lobibox.min.js')}}"></script>
        <script src="{{asset('template/rocker/assets/plugins/notifications/js/notifications.min.js')}}"></script>
        <script
            src="{{asset('template/rocker/assets/plugins/notifications/js/notification-custom-script.js')}}"></script>
        <script>
            @if ($message = Session::get('success'))
            let pesan = '{!! $message !!}';
            notif_message('success', pesan);
            @endif

            @if ($message = Session::get('warning'))
            let pesanWarning = '{!! $message !!}';
            notif_message('warning', pesanWarning);
            @endif

            @error('error')
            let pesanError = '{!! $message !!}';
            notif_message('warning', pesanError);
            @enderror


            function openModal(modal) {
                modal.modal("show");
            }

            /** Saat tombol modal edit di click */
            $(document).on("click", ".open-edit", function () {
                let fid = $(this).data('id');
                let fnama = $(this).data('nama');
                $('#idKategori').val(fid);
                $('#editNama').val(fnama);
            });

            /** Saat tombol modal hapus di click */
            $(document).on("click", ".open-hapus", function () {
                let fid = $(this).data('id');
                $('#idHapusKategori').val(fid);
            });

            $(document).ready(function () {
                let base_url = '{{route('adm.book')}}';

                @if($errors->hasbag('tambah'))
                openModal($('#modalTambah'));
                @endif

                @if($errors->hasbag('edit'))
                openModal($('#modalEdit'));
                @endif

                @if($errors->hasbag('hapus'))
                openModal($('#modalHapus'));
                @endif

                $('.modal').on('hidden.bs.modal', function (e) {
                    e.preventDefault();
                    let pesanError = $('.errorMessage');
                    let errorInput = $('.errorInput');
                    let errorLabel = $('.errorLabel');
                    pesanError.html("");
                    errorInput.removeClass('is-invalid');
                    errorLabel.removeClass('text-danger');
                })

                $('#tabelBuku').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: 'GET',
                        url: base_url,
                        async: true,
                        dataType: 'json',
                        data: {tipe: 3},
                        dataSrc: function (json) {
                            return json.data;
                        }
                    },
                    columns: [
                        {
                            data: 'index',
                            class: 'text-center',
                            defaultContent: '',
                            orderable: false,
                            searchable: false,
                            width: '5%',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; //auto increment
                            }
                        },
                        {data: 'name', class: 'text-left'},
                        {data: 'kategori.name', class: 'text-left'},
                        {data: 'author.name', class: 'text-left'},
                        {data: 'tahun_terbit', class: 'text-left'},
                        {data: 'created_at', class: 'text-center'},
                        {data: 'action', class: 'text-center', width: '15%', orderable: false},
                    ],
                    "bDestroy": true
                });
            });

            function notif_message(type, message) {
                Lobibox.notify(type, {
                    pauseDelayOnHover: true,
                    size: 'mini',
                    icon: 'bx bx-check-circle',
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    msg: message
                });
            }
        </script>
    @endpush
</x-rocker.template-rocker>
