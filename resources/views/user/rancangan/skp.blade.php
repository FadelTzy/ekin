@extends('user.index')

@section('cssc')
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

    .sorting,
    .sorting_asc,
    .sorting_desc {
        background: none;
    }

    tr.shown td.details-control {
        background: url('{{asset("img/close.png")}}') no-repeat center center;
    }

    td {
        text-align: center;
    }
</style>
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatable-rowgroup/css/rowGroup.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('body')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Rencana SKP</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rencana SKP</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if($jab != "kosong")
        @if(!Session::has('period'))
        <div class="row">
            <div class="col-12">
                <div class=" alert alert-danger ">
                    <h4 class="page-title">Periode Belum Diset</h4>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                @if($jab->status_target == 0)
                <div class="d-flex justify-content-between alert alert-danger ">
                    <h4 class="page-title">Anda Belum Menyusun Target Semester {{$period->nama_periode}} </h4><button type="button" onclick="keanu()" class="btn btn-sm btn-success"> <i class="mdi mdi-plus mr-1"></i> Target SKP</button>
                </div>
                @elseif($jab->status_target == 1)
                <div class=" alert alert-success ">
                    <h4 class="page-title">Target Semester Telah Disetujui {{$period->nama_periode}}</h4>
                </div>
                @elseif($jab->status_target == 2)
                <div class="alert alert-warning d-flex justify-content-between">
                    <h4 class="page-title">Target Semester Di Tolak, Silahkan Menyusun Ulang {{$period->nama_periode}} </h4>
                    <div>

                        <button class="btn btn-soft-warning" type="button" data-toggle="modal" data-target="#standard-modal"><i class="mdi mdi-alert"></i></button>
                        <button type="button" onclick="keanu()" class="btn  btn-warning"> Edit Target </button>
                    </div>
                </div>
                @elseif($jab->status_target == 3)
                <div class=" alert alert-primary ">
                    <h4 class="page-title">Menunggu Persetujuan Target Semester, Silahkan Menghubungi Atasan</h4>
                </div>
                @endif
            </div>
        </div>
        <div class="row">

            <div class="col-xl-12">
                <div class="card">


                    <div class="card-body">
                        <div class="row pb-3">
                            <div class="col-lg-6">

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="btn-label"><i class="fas fa-angle-down"></i></span>
                                        Cetak Rencana
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" target="_blank" href="{{route('cetak.rskp')}}">Rencana SKP</a>
                                        <a class="dropdown-item" target="_blank" href="{{route('cetak.rskpl')}}">Rencana SKP Lengkap</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-end">
                                <button id="rk" type="button" class="btn btn-sm btn-primary mb-2 mr-1">Rincian Kegiatan</button>
                                <button type="button" class="btn btn-sm btn-success mb-2 mr-1" @if($jab->status_target == 1)disabled @endif
                                    onclick="keanu()" > <i class="mdi mdi-plus mr-1"></i> Target SKP</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered wrap w-100 table-sm" id="pengajuan">
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
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        @endif
        @else
        <div class="row">
            <div class="col-12">
                <div class=" alert alert-danger ">
                    <h4 class="page-title">Tugas Jabatan Anda Untuk {{$period->nama_periode}} Tidak Terdaftar</h4>
                </div>
            </div>
        </div>
        @endif

    </div> <!-- container -->


</div> <!-- content -->
<div class="modal loader fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h6>Keterangan Penolakan</h6>
                <p>{{$jab->ket ?? '-'}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('js')
<script src="{{asset('minton/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script>
    var tabel;
    let url = window.location.origin;

    function keanu(param) {
        window.location.href = "{{route('kinerja-utama.create')}}";
    }


    console.log(tabel);

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

    function adakah(e) {
        if (e) {
            return e;
        }
        return 0;
    }

    function groupBy(element, key) {
        return element.reduce((value, x) => {
            (value[x[key]] = value[x[key]] || []).push(x);
            return value;
        }, {});
    };

    function dataloop(d) {
        var arrs = '';
        console.log(d);

        Object.keys(d['indexes2']).forEach(key => {
            $no = 1;
            if (key == '1') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Januari</td> </tr>'
            }
            if (key == '2') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Februari</td> </tr>'
            }
            if (key == '3') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Maret</td> </tr>'
            }
            if (key == '4') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan April</td> </tr>'
            }
            if (key == '5') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Mei</td> </tr>'
            }
            if (key == '6') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Juni</td> </tr>'
            }
            if (key == '7') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Juli</td> </tr>'
            }
            if (key == '8') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Agustus</td> </tr>'
            }
            if (key == '9') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan September</td> </tr>'
            }
            if (key == '10') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Oktober</td> </tr>'
            }
            if (key == '11') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan November</td> </tr>'
            }
            if (key == '12') {
                arrs = arrs + '<tr> <td class="text-left" colspan="5">Bulan Desember</td> </tr>'
            }
            d['indexes2'][key].forEach(el => {
                arrs = arrs + '<tr >' +
                    '<td class="text-left" colspan="5">' + '<span>Status : <span/>' + badge(d[el]["status"]) + '</td>' +

                    '</tr>' +
                    '<tr class="' + checktheme(d[el]["status"]) + '">' +
                    '<td  colspan="1"  class="text-center">' + $no++ + '</td>' +

                    '<td  colspan="2"  class="text-left">' + d[el]["kegiatan"] + '</td>' +

                    '<td>' + d[el]["tkuantitas"] + ' ' + d[el]["satuan"] + '</td>' +
                    '<td>' + '1' + '</td>' +



                    '</tr>';
            })
        });



        // console.log(groupBy(d, 'bulan'));
        d['indexes'].forEach(element => {

        });

        return arrs;
    }

    $(document).ready(function() {
        tabel = $("#pengajuan").DataTable({
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },
                {
                    orderable: false,
                    targets: 3,
                    width: "10%",

                },

                {
                    orderable: false,
                    targets: 4,
                    width: "5%",

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
            rowGroup: {
                startRender: null,
                endRender: function(rows, group) {
                    console.log('tes');
                    return $('<tr class="table-info"/>')
                        .append('<td class="text-left" colspan="3">Realisasi ' + '</td>')
                        .append('<td>' + rows.data()[0]['totalkuanr'] + '</td>')
                        .append('<td>' + rows.data()[0]['statusbulan'] + '</td>');
                },
                dataSrc: 0
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('skp.index')}}",
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
        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            console.log(message);
        };

        $('#pengajuan tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = tabel.row(tr);
            if ($(tr).hasClass('ada')) {
                $(tr).removeClass('ada');

                $(tr.next().nextUntil('[role="row"]')).remove();
            } else {
                $(tr).addClass('ada');

                $(tr.next()).after(dataloop(row.data()));
                console.log($(tr.next()));
            }

        });


    });
</script>
<script src="{{asset('minton/assets/libs/datatable-rowgroup/js/dataTables.rowGroup.min.js')}}"></script>

@endpush