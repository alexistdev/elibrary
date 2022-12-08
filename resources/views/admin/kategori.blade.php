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
                    <div class="breadcrumb-title pe-3">Kategori</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="{{route('adm.dashboard')}}"><i
                                            class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Data Kategori</li>
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
                <h6 class="mb-0 text-uppercase">Master Data Kategori</h6>
                <hr/>
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabelKategori" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Dibuat</th>
                                    <th>Action</th>
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
                <form action="{{route('adm.kategori.add')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <!-- Start: Nama Kategori -->
                        <div class="row">
                            <div class="col-lg-12">
                                <label
                                    for="nama" @class(["form-label","errorLabel",($errors->hasbag('tambah'))? "text-danger":""]) >NAMA
                                    KATEGORI<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama"
                                       @class(["form-control","errorInput",($errors->hasbag('tambah'))? "is-invalid":""]) id="nama"
                                       value="{{old('nama')}}">
                            </div>
                            <div class="col-lg-12">

                                <div class="text-danger errorMessage">{{ $errors->tambah->first() }}</div>

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
    <!-- End: Modal Tambah        -->

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
                notif_message('success',pesan);
            @endif

            function openModal(modal) {
                modal.modal("show");
            }

            $(document).ready(function () {
                let base_url = '{{route('adm.kategori')}}';

                @if($errors->hasbag('tambah'))
                openModal($('#modalTambah'));
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

                $('#tabelKategori').DataTable({
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
                        {data: 'created_at', class: 'text-center'},
                        {data: 'action', class: 'text-center', width: '15%', orderable: false},
                    ],
                    "bDestroy": true
                });
            });

            function notif_message(type,message) {
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
