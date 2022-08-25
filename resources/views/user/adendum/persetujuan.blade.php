@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatable-rowgroup/css/rowGroup.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .bd-example-modal-lg .modal-dialog {
        display: table;
        position: relative;
        margin: 0 auto;
        top: calc(50% - 24px);
    }

    .bd-example-modal-lg .modal-dialog .modal-content {
        background-color: transparent;
        border: none;
    }

    td.details-control {
        background: url('{{asset("img/open.png")}}') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('{{asset("img/close.png")}}') no-repeat center center;
    }
</style>
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Persetujuan Adendum SKP Pegawai</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Penilaian Staf</a></li>

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
                        <div class="table-responsive">
                            <table id="staf" class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NIP</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Periode</th>
                                        <th scope="col">Status</th>

                                        <th scope="col">Aksi</th>

                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>






    </div> <!-- container -->

</div> <!-- content -->
<div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Adendum SKP Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="float-left" id="btnpegawai">

                        </div>

                    </div>
                    <div class="col-lg-6 d-flex justify-content-end">
                        <div class="float-right pr-2" id="btntolak">

                        </div>
                        <div class="float-right" id="btnconfirm">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered wrap w-100 table-sm" id="rencanaskp">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th rowspan="2"></th>
                                        <th rowspan="2"></th>

                                        <th rowspan="2">Tugas Jabatan</th>

                                        <th colspan="2">Target (Rencana)</th>
                                        <th colspan="2">Target (Adendum)</th>
                                        <th rowspan="2">Status</th>


                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Bulan</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Bulan</th>
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

<div class="modal fade" id="penolakan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Keterangan Penolakan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="formpenolakan" action="">
                @csrf
                <input type="hidden" name="id" id="idpen">
                <div class="modal-body">
                    <div class="form-group no-margin">
                        <textarea class="form-control" rows="5" name="ket" id="field-7" placeholder="Keterangan Penolakan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="sbt" type="submit" class="btn btn-sm btn-info waves-effect waves-light">Kirim</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="datapegawai" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.2);" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Biodata Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row" id="infopegawai"></div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

@endsection
@push('js')

<script>
    var tabel2;
    let url = window.location.origin;

    function setuju(id, ids) {
        console.log(id);
        let check = confirm('Klik Ya Untuk Melanjutkan');
        console.log(id);
        if (check) {
            $.ajax({
                url: "{{route('adendum.setuju')}}",
                type: 'GET',
                data: {
                    id: id,
                    ids: ids
                },
                success: function(e) {
                    console.log(e);
                    if (e == 'success') {
                        tabel2.ajax.reload();
                        $("#toastr-three").trigger("click");


                    }
                }
            });
        }

    }

    function pegawai(e) {
        $("#datapegawai").modal('show');
        $.ajax({
            url: "{{route('p_lihat.pegawai')}}",
            type: 'GET',
            data: {
                id: e
            },
            success: function(e) {

                $("#infopegawai").html(e['pp']);


                console.log(e);

            }
        });
    }

    function adakah(e, uraian) {
        e['ur'] = uraian;
        data = JSON.stringify(e);
        if (e['status'] == 1 || e['status'] == 2) {
            return 'Telah Realisasi';
        }
        $btn = `<button onclick='hapus(${e['id']})' href='javascript:void(0);' class='btn mr-1 btn-sm btn-danger mb-2'><i class='fa fa-trash'></i></button>`;
        $btn += "<button onclick='edit(" + data + ")'  data-toggle='modal' data-target='#modal-ub' href='javascript:void(0);' class='btn btn-sm btn-info mb-2'><i class='fa fa-edit'></i></button>";
        return $btn;
    }

    function adendum(id) {
        if (id) {
            if (id == 1) {
                return 'Dihapus';
            } else if (id == 2) {
                return 'Diubah';
            } else if (id == 3) {
                return 'Ditambah';
            }
        }
        return '';
    }

    function lihat1(id) {
        $("#bs-example-modal-lg").modal('show');
        if ($.fn.DataTable.isDataTable("#rencanaskp")) {
            $('#rencanaskp').DataTable().clear().destroy();
        }
        tabel = $("#rencanaskp").DataTable({
            "lengthChange": false,
            "bPaginate": false, //hide pagination
            "bInfo": false, // hide showing entries
            "bFilter": false, //hide Search bar

            fnInitComplete: function() {
                function dataloop(d) {
                    var arrs = '';
                    d['indexes'].forEach(element => {
                        arrs = arrs + '<tr class="' + checktheme(d[element]["status"]) + '">';

                        if (d[element]['status_adendum'] == '2') {
                            arrs = arrs + '<td class="text-left" colspan="2"><b>' + bulans(d[element]["adendum"]["bulan"]) + '</b></td>' +
                                '<td class="text-left" colspan="1"><b>' + d[element]["adendum"]["kegiatan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + '1' + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + d[element]["adendum"]["kuantitas"] + ' ' + d[element]["adendum"]["satuan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + '1' + '</b></td>';

                        } else if (d[element]['status_adendum'] == '1') {
                            arrs = arrs + '<td class="text-left" colspan="2"><b>' + bulans(d[element]["bulan"]) + '</b></td>' +
                                '<td class="text-left" colspan="1"><b>' + d[element]["kegiatan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + '1' + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + ' -' + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + ' -' + '</b></td>';


                        } else if (d[element]['status_adendum'] == '3') {
                            arrs = arrs + '<td class="text-left" colspan="2"><b>' + bulans(d[element]["bulan"]) + '</b></td>' +
                                '<td class="text-left" colspan="1"><b>' + d[element]["kegiatan"] + '</b></td>' +

                                '<td class="text-center" colspan="1"><b>' + ' -' + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + ' -' + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</b></td>' +
                                '<td class="text-center" colspan="1"><b>' + '1' + '</b></td>';
                        }


                        arrs = arrs +
                            '<td class="text-center" colspan="1"><b>' + adendum(d[element]['status_adendum']) + '</b></td>' +

                            '</tr>';
                    });

                    return arrs;
                }
                $('#rencanaskp tbody').on('click', 'td.details-control', function() {
                    console.log('sd');
                    var tr = $(this).closest('tr');
                    var row = tabel.row(tr);
                    if ($(tr).hasClass('ada')) {
                        $(tr).removeClass('ada');

                        $(tr.nextUntil('[role="row"]')).remove();
                    } else {
                        $(tr).addClass('ada');

                        $(tr).after(dataloop(row.data()));
                        console.log($(tr.next()));
                    }

                });
            },
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },
                {
                    orderable: false,
                    targets: 3,
                    width: "12%",
                    className: "text-center"
                },

                {
                    orderable: false,
                    targets: 4,
                    width: "3%",
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: 5,
                    width: "12%",
                    className: "text-center"
                },

                {
                    orderable: false,
                    targets: 6,
                    width: "3%",
                    className: "text-center"
                },

                {
                    orderable: false,
                    targets: 7,
                    width: "5%",
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: 2,
                    width: "50%",
                    className: "text-left"

                },


                {
                    targets: 1,
                    width: "1%",
                    orderable: false,

                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('adendum.lihat')}}",
                data: {
                    id: id
                },
                "complete": function(xhr, responseText) {
                    console.log(xhr);
                    console.log(responseText); //*** responseJSON: Array[0]
                }
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'
                },
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                }, {
                    nama: 'tugas',
                    data: 'tugas'
                }, {
                    nama: 'totalkuan',
                    data: 'totalkuan'
                }, {
                    nama: 'waktu',
                    data: 'waktu'
                },
                {
                    nama: 'totalkuana',
                    data: 'totalkuana'
                }, {
                    nama: 'waktua',
                    data: 'waktua'
                }, {
                    nama: 'indexes',
                    data: ({
                        indexes
                    }) => indexes.length
                },
            ]
        });
        $.ajax({
            url: "{{route('adendum.akun')}}",
            type: 'GET',
            data: {
                id: id
            },
            success: function(e) {

                $("#btnconfirm").html(e['btn']);
                $("#btntolak").html(e['btnt']);
                $("#btnpegawai").html(e['info']);

                console.log(e);
                if (e == 'success') {
                    tabel2.ajax.reload();

                }
            }
        });

    }

    function bulans(d) {
        let day;
        switch (d) {
            case "1":
                day = "Januari";
                break;
            case "2":
                day = "Februari";
                break;
            case "3":
                day = "Maret";
                break;
            case "4":
                day = "April";
                break;
            case "5":
                day = "Mei";
                break;
            case "6":
                day = "Juni";
                break;
            case "7":
                day = "Juli";
                break;
            case "8":
                day = "Agustus";
                break;
            case "9":
                day = "September";
                break;
            case "10":
                day = "Oktober";
                break;
            case "12":
                day = "Desember";
                break;
            case "11":
                day = "November";
                break;
        }
        return day;
    }

    function badge(id) {
        if (id == 0) {
            return '<h4 class="badge badge-warning"> Belum Melakukan Pengajuan</h4>'
        } else if (id == 1) {
            return '<h4 class="badge badge-info"> Menunggu Penilaian Atasan</h4>'
        } else {
            return '<h4 class="badge badge-success">Telah Dinilai</h4>'
        }
    }

    function checkbul(id) {
        if (id == 2 || id == 1) {
            return '1'
        } else {
            return '0';
        }
    }

    function checktheme(id) {
        if (id == 0 || id == 1) {
            return 'table-info'
        } else {
            return 'table-success'
        }
    }
    $(document).ready(function() {
        $("#sbt").on('click', function(e) {
            $("#formpenolakan").trigger('submit');
        })
        $("#formpenolakan").on('submit', function(e) {
            e.preventDefault();
            var datapen = $(this).serialize();
            console.log(datapen);
            $.ajax({
                url: "{{route('adendum.tolak')}}",
                type: 'GET',
                data: datapen,
                success: function(e) {
                    console.log(e);
                    if (e == 'success') {
                        tabel2.ajax.reload();
                        $("#toastr-three").trigger("click");

                    }
                }
            });

        })
    });


    function tolak(id, ids) {
        $("#penolakan").modal('show');
        $("#idpen").val(id);
        console.log(id);
        console.log(ids);
        // let check = confirm('Klik Ya Untuk Melanjutkan');
        if (check) {

        }

    }


    tabel2 = $("#staf").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('adendum.persetujuan')}}"
        },
        columnDefs: [{
                orderable: false,
                targets: 0,
                width: "5%",
            },
            {
                orderable: false,
                targets: 1,
                width: "10%",
            },
            {
                orderable: false,
                targets: 6,
                width: "10%",

            },

        ],
        columns: [{
                nama: 'DT_RowIndex',
                data: 'DT_RowIndex'
            }, {
                nama: 'nip',
                data: 'nip'
            },
            {
                nama: 'nama',
                data: 'nama'
            },
            {
                nama: 'jabatan',
                data: 'jabatan'
            },
            {
                nama: 'period',
                data: 'period'
            }, {
                nama: 'status',
                data: 'status'
            },

            {
                nama: 'aksi',
                data: 'aksi'
            },
        ]
    });
</script>
<script src="{{asset('minton/assets/libs/datatable-rowgroup/js/dataTables.rowGroup.min.js')}}"></script>

@endpush