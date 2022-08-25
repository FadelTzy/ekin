@extends('user.index')

@section('cssc')
    <link href="{{ asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('minton/assets/libs/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <style>
        td.details-control {
            background: url('{{ asset('img/open.png') }}') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('{{ asset('img/close.png') }}') no-repeat center center;
        }

    </style>
@endsection

@section('body')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box page-title-box-alt">
                        <h4 class="page-title">SKP {{ $period->nama_periode }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">SKP Periode</a></li>

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->



            <div class="row">

                <div class="col-xl-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 mb-2">
                                    <a type="button" href="{{ route('skp.index') }}"
                                        class="btn btn-sm btn-bordered-danger waves-effect waves-light"><i
                                            class="mdi mdi-arrow-left mr-1"></i> Kembali</a>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <button type="submit" id="tambahtupok" data-toggle="modal"
                                        data-target="#full-width-modal"
                                        class="btn btn-sm btn-bordered-primary waves-effect waves-light"><i
                                            class="mdi mdi-plus mr-1"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table  table-sm table-centered w-100 dt-responsive" id="semester"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>

                                            <th>Kinerja Utama</th>

                                            <th>Total Rencana Kerja</th>
                                            <th>Status</th>

                                            <th>Aksi</th>

                                        </tr>

                                    </thead class>

                                </table>
                            </div>
                        </div>

                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <!-- end row -->



        </div> <!-- container -->

    </div> <!-- content -->

    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Kinerja Utama</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form method="post" id="subtar" action="#">
                                @csrf
                                <div class="form-row">
                                    <input type="hidden" id="idtugas" name="idtugas">

                                    <div class="form-group col-md-12">
                                        <textarea class="form-control" name="kinerja" required id="kinerja" placeholder="Input kinerja" cols="20"
                                            rows="6"></textarea>
                                    </div>
                                    <span>
                                        <p><i>*Kinerja utama adalah rangkuman dari seluruh aktifitas rencana kinerja</i>
                                        </p>
                                    </span>
                                </div>

                                <button type="submit" id="btnsf" class="btn btn-primary">
                                    <span id="btnsf1" class="spinner-border-sm mr-1" role="status"
                                        aria-hidden="true"></span>
                                    <span id="btnsf2">Simpan</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="full-width-modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-full-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Target Kegiatan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <form method="post" id="subtare" action="#">
                                @csrf
                                <div class="form-row">
                                    <input type="hidden" id="idtugasu" name="idtugasu">
                                    <input type="hidden" id="idt" name="idu">
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4">Tugas Jabatan</label>
                                        <textarea class="form-control" name="kegiatanu" required id="kegiatanu" readonly placeholder="Tugas" cols="20"
                                            rows="5"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail1">Kegiatan</label>
                                        <textarea class="form-control" name="aktivitasu" required id="aktivitasu" placeholder="Kegiatan" cols="20"
                                            rows="2"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="kuantitas">Kuantitas</label>
                                        <input type="text" class="form-control" required name="kuantitasu" id="kuantitasu"
                                            placeholder="Kuantitas">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="satuan">Satuan</label>
                                        <input type="text" class="form-control" name="satuanu" id="satuanu"
                                            placeholder="Laporan">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputAddress">Bulan</label>
                                        <select name="bulanu" id="bulanu" class="form-control">
                                            <option disabled selected>Pilih Bulan</option>
                                            @foreach ($smst as $s)
                                                <option value="{{ $s->no }}">{{ $s->bulan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" name="keteranganu" required id="keteranganu" placeholder="Keterangan" cols="20"
                                            rows="5"></textarea>
                                    </div>
                                </div>

                                <button type="submit" id="btnsfu" class="btn btn-primary">
                                    <span id="btnsf1u" class="spinner-border-sm mr-1" role="status"
                                        aria-hidden="true"></span>
                                    <span id="btnsf2u">Simpan</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-centered " style="width: 100%;" id="item2"
                                    style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>

                                        <tr>

                                            <th style="width: 80%;" scope="col">Item</th>
                                            <th style="width: 20%;" scope="col">Copy</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <button style="display: none;" id="toastr-three"></button><button style="display: none;"
        id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;"
        id="delete-success"></button>
@endsection

@push('js')
    <script src="{{ asset('minton/assets/libs/summernote/summernote-bs4.min.js') }}"></script>

    <script>
        let url = window.location.origin;

        var tabel;
        $("#subtare").on('submit', function(e) {
            e.preventDefault();
            $("#btnsfu").attr('disabled', 'true');
            $("#btnsf2u").html('Simpan...')
            $("#btnsf1u").addClass('spinner-border ');
            id = $("#idt").val();
            let data = $(this).serialize();
            $.ajax({
                url: url + '/skp/rancangan/skp/' + id,
                data: data,
                type: 'PUT',
                success: function(e) {
                    $("#btnsfu").removeAttr('disabled');
                    $("#btnsf2u").html('Simpan');
                    $("#btnsf1u").removeClass('spinner-border ');
                    $("#toastr-three").trigger("click");

                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        })

        function editj(e) {
            e.preventDefault;
            console.log(e);
            $("#full-width-modal2").modal('show')
            $("#idt").val(e.id);
            $("#idtugasu").val(e.id_tup);
            $("#kegiatanu").val(e.tt);
            $("#aktivitasu").val(e.kegiatan);
            $("#keteranganu").summernote("code", e.ket);
            $("#bulanu option[value=" + e.bulan + "]").attr('selected', 'selected');
            $("#kuantitasu").val(e.tkuantitas);
            $("#satuanu").val(e.satuan);
            let tabel3 = $("#item2").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('skp.itemu') }}"
                },
                columnDefs: [{
                        orderable: false,
                        targets: 0,
                        width: "95%",
                    },
                    {
                        orderable: false,
                        targets: 1,
                        width: "5%",

                    },

                ],
                columns: [{
                        nama: 'uraian',
                        data: 'uraian'
                    }, {
                        nama: 'aksii',
                        data: 'aksii'
                    },

                ]
            });
        }

        function delj(e) {
            e.preventDefault;

            $data = confirm("klik oke untuk melanjutkan");
            if ($data == 1) {
                $('.loader').modal('show');
                let iddel = e;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url + '/skp/rancangan/skp/' + e,
                    type: 'DELETE',
                    success: function(e) {
                        if (e == 'suc') {
                            $("#delete-success").trigger("click");
                        } else if (e == 'err') {
                            $("#delete-wrong").trigger("click");
                        }

                        tabel.ajax.reload(function() {
                            $('.loader').modal('hide');
                        });
                    },
                    error: function(e) {
                        console.log(e);
                    }

                })
                console.log(iddel);
                tabel.ajax.reload();
            }

        }

        function copy(item, id) {
            $("#kegiatan").val(item);
            $("#aktivitas").val(item);
            $("#idtugas").val(id);
        }

        function copyu(item, id) {
            $("#kegiatanu").val(item);
            $("#aktivitasu").val(item);
            $("#idtugasu").val(id);
        }

        function format(d) {
            // `d` is the original data object for the row
            console.log(d);
            var el = document.createElement('html');
            el.innerHTML = d.ket;

            el.getElementsByTagName('a');
            return `<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
        <tr>
            <td>Aktivitas:</td>
            <td>${d.kegiatan}</td>
            </tr>
            <tr>
            <td>Keterangan:</td>
            <td class='ales'>${d.ket}</td>
            </tr>
            </table>`;
        }

        $(document).ready(function(e) {
            $('#keterangan').summernote({
                placeholder: 'Input Text',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
            $('#keteranganu').summernote({
                placeholder: 'Input Text',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                console.log(message);
            };
            tabel = $("#semester").DataTable({

                columnDefs: [{
                        orderable: false,
                        targets: 0,
                        width: "1%",
                    },

                    {
                        targets: 1,
                        width: "40%",
                        orderable: false,

                    }, {
                        orderable: false,
                        targets: 2,
                        width: "20%",

                    }, {
                        orderable: false,
                        targets: 3,
                        width: "5%",
                    },
                    {
                        orderable: false,
                        targets: 4,
                        width: "7%",

                    }
                ],

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kinerja-utama.create') }}",
                },
                columns: [{
                        nama: 'DT_RowIndex',
                        data: 'DT_RowIndex'
                    }, {
                        nama: 'rencana',
                        data: 'rencana'
                    }, {
                        nama: 'total',
                        data: 'total'
                    }, {
                        nama: 'kinerja',
                        data: 'kinerja'
                    },
                    {
                        nama: 'aksi',
                        data: 'aksi'
                    },


                ]
            });

        });

        $("#subtar").submit(function(e) {
            e.preventDefault();
            $("#btnsf").attr('disabled', 'true');
            $("#btnsf2").html('Simpan...')
            $("#btnsf1").addClass('spinner-border ');
            let data = $(this).serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('kinerja-utama.store') }}",
                data: data,
                type: 'post',
                success: function(e) {
                    $("#btnsf").removeAttr('disabled');
                    $("#btnsf2").html('Simpan');
                    $("#btnsf1").removeClass('spinner-border ');
                    $("#toastr-three").trigger("click");
                    // $("#kuantitas").val('');
                    // $("#kegiatan").val('');
                    // $("#kualitas").val('');
                    // $("#aktivitas").val('');
                    // $("#bulan").val('');
                    // $("#keterangan").val('');
                    // $("#satuan").val('');
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        });
    </script>
@endpush
