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
                                <li class="breadcrumb-item active" aria-current="page">Data Stock Buku</li>
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
                <h6 class="mb-0 text-uppercase">Master Data Stock</h6>
                <hr/>
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabelStock" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Judul Buku</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Ditambahkan</th>
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
                                        <option value="{{$kategori->id}}"
                                                @if(old('kategori_id') == $kategori->id) selected @endif>{{$kategori->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->tambah->has('kategori_id'))
                                <div class="col-lg-12">
                                    <div
                                        class="text-danger errorMessage">{{$errors->tambah->first('kategori_id')}}</div>
                                </div>
                            @endif
                        </div>
                        <!-- End: Nama Kategori  -->

                        <!-- Start: Judul Buku -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <label
                                    for="buku_id" @class(["form-label","errorLabel",($errors->tambah->has('buku_id'))? "text-danger":""]) >JUDUL
                                    BUKU<span
                                        class="text-danger">*</span></label>
                                <select name="buku_id" class="form-control" id="buku_id"></select>
                            </div>
                            @if($errors->tambah->has('author_id'))
                                <div class="col-lg-12">
                                    <div class="text-danger errorMessage">{{$errors->tambah->first('buku_id')}}</div>
                                </div>
                            @endif
                        </div>
                        <!-- End: Judul Buku -->

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
    <!-- End: Modal Tambah    -->


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
                let fauthor = $(this).data('author');
                let fkategori = $(this).data('kategori');
                let ftahun = $(this).data('tahun');
                $('#idBuku').val(fid);
                $('#editName').val(fnama);
                $('#editkategori_id').val(fkategori);
                $('#editauthor_id').val(fauthor);
                $('#edittahun').val(ftahun);
            });

            /** Saat tombol modal hapus di click */
            $(document).on("click", ".open-hapus", function () {
                let fid = $(this).data('id');
                $('#idhapusbuku').val(fid);
            });

            /** Ajax untuk get data buku berdasarkan kategori */
            function getDataBuku(kategori_id){
                let urlAjax = '{{route('admin.ajax.get-buku-bykategori')}}';
                let optionBuku = $('#buku_id');
                // Empty the dropdown
                optionBuku.find('option').remove().end();
                $.ajax({
                    url: urlAjax,
                    type: 'get',
                    dataType: 'json',
                    data: {kategori_id: kategori_id},
                    success: function(response){
                        let len = 0;
                        if(response != null){
                            len = response.length;
                        }
                        if(len > 0){
                            // Read data and create <option >
                            for(let i=0; i<len; i++){

                                let id = response[i].id;
                                let name = response[i].name;

                                let option = "<option value='"+id+"'>"+name+"</option>";

                                optionBuku.append(option);
                            }
                        }

                    }
                });
            }

            $(document).ready(function () {

                $('#kategori_id').change(function() {

                    // kategori id
                    let id = $(this).val();
                    getDataBuku(id);
                });

                let base_url = '{{route('adm.stock')}}';

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

                $('#tabelStock').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: 'GET',
                        url: base_url,
                        async: true,
                        dataType: 'json',
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
                        {data: 'code', class: 'text-left'},
                        {data: 'code', class: 'text-left'},
                        {data: 'code', class: 'text-left'},

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
