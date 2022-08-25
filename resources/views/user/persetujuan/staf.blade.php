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
                    <h4 class="page-title">Persetujuan Rencana SKP Pegawai</h4>
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
                <h4 class="modal-title" id="myLargeModalLabel">Target SKP Pegawai</h4>
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

                                        <th colspan="2">Target</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Bulan</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="float-right pl-2" id="btntolak">


                        </div>
                        <div class="float-right" id="btnconfirm">


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
<div class="modal loader fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
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
        if (check) {
            $.ajax({
                url: "{{route('p_setuju.staf')}}",
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

    function lihat1(id) {
        $("#bs-example-modal-lg").modal('show');
        console.log(id);
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
                    console.log(d);
                    d['indexes'].forEach(element => {
                        console.log(element);
                        arrs = arrs + '<tr >' +
                            '<td class="text-left" colspan="3"><b>' + 'Bulan ' + bulans(d[element]["bulan"]) + '</b></td>' +
                            '<td class="text-right" colspan="2">' + '<b>Status : <b/>' + badge(d[element]["status"]) + '</td>' +

                            '</tr>' +
                            '<tr class="' + checktheme(d[element]["status"]) + '">' +

                            '<td  colspan="3"  class="text-left">' + d[element]["kegiatan"] + '</td>' +

                            '<td class="text-center">' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</td>' +
                            '<td class="text-center">' + '1' + '</td>' +



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
                    width: "10%",
                    className: "text-center"
                },

                {
                    orderable: false,
                    targets: 4,
                    width: "5%",
                    className: "text-center"
                },
                {
                    orderable: false,
                    targets: 2,
                    width: "40%",
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
                url: "{{route('p_lihat.staf')}}",
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



            ]
        });
        $.ajax({
            url: "{{route('p_lihat.akun')}}",
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




    function lihat2(id) {
        $("#bs-example-modal-lg").modal('show');


        $.ajax({
            url: "{{route('p_lihat2.staf')}}",
            type: 'GET',
            data: {
                id: id
            },
            success: function(e) {
                $("#pppegawai").html(e['pp']);
                $("#bodytabel").html(e['skp']);
                $("#btnconfirm").html(e['btn']);
                $("#btntolak").html(e['btnt']);
                console.log(e['skp']);
                if (e == 'success') {
                    tabel2.ajax.reload();
                }
            }
        });

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
                url: "{{route('p_tolak.staf')}}",
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
            url: "{{route('setuju.staf')}}"
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