@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatable-rowgroup/css/rowGroup.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<style>
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
@endsection

@section('body')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            @if(!Session::has('period'))

            <div class="col-12">

                <div class=" float-right">
                    <div class="text-danger pt-2">
                        Session Belum Di Set
                    </div>
                </div>

            </div>

            @endif

            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Pengajuan Realisasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pengajuan</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if(Session::get('id_periode')=="null")
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Tugas Jabatan Anda Untuk {{$datap->nama_periode}} <i>Tidak Terdaftar</i></h4>
                        <h6 class="page-body">Silahkan Melakukan Pengajuan Tugas Jabatan Ke Operator</h6>
                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>
        @else
        @if(Session::get('id_status') == 3 || Session::get('id_status') == 2)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Belum Dapat Mengajukan Realisasi Bulanan Sebelum Atasan Menyetujui Rancangan Target Semester</h4>
                        <h6 class="page-body">Silahkan Menghubungi Atasan Untuk Melakukan Persetujuan Rancangan Target Semester</h6>

                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>
        @elseif(Session::get('id_status') == 0)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Belum Menyusun Rancangan Target Semester {{$datap->nama_periode}}</h4>
                    </div>
                    <div>
                        <i class="fa fa-3x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>

        @else


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="btn-label"><i class="fas fa-angle-down"></i></span>
                                        Cetak Realisasi SKP
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" target="_blank" href="{{route('cetak.relskp')}}">Realisasi SKP</a>
                                        <a class="dropdown-item" target="_blank" href="{{route('cetak.relskpl')}}">Realisasi SKP Lengkap</a>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-8 d-flex justify-content-end">
                                <div class="text-sm-right">
                                    <button id="rk" type="button" class="btn btn-sm btn-primary mb-2 mr-1">Rincian Kegiatan</button>
                                </div>

                                <div class="text-sm-right">

                                    <button type="button" onclick="ajukan()" class="btn btn-success btn-sm mb-2"> <i class="mdi mdi-plus-circle mr-1"></i>Ajukan</button>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered wrap w-100 table-sm" id="pengajuan">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th rowspan="2"></th>
                                        <th rowspan="2"></th>

                                        <th rowspan="2">Tugas Jabatan</th>

                                        <th colspan="4">Target</th>
                                        <th colspan="4">Realisasi</th>

                                        <th rowspan="2">Penghitungan</th>
                                        <th rowspan="2">Nilai Mutu</th>


                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Mutu</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Biaya</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Mutu</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Biaya</th>
                                    </tr>

                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->
        @endif
        @endif

    </div>






</div> <!-- container -->

<div class="modal fade" data-backdrop="static" id="modal-pr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pengajuan Realisasi</h4>
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
                                    <label for="inputEmail4">Kegiatan Tugas Jabatan</label>
                                    <textarea class="form-control" required id="kegiatan" readonly placeholder="Tugas" cols="20" rows="5"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1">Aktifitas</label>
                                    <textarea class="form-control" required readonly id="aktivitas" placeholder="Kegiatan" cols="20" rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="satuan">Target</label>
                                    <div class="input-group">
                                        <input type="text" readonly class="form-control" id="targetkuantitas" placeholder="Laporan">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="skuan"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="satuan">Realisasi</label>
                                    <div class="input-group">
                                        <input min="1" type="number" class="form-control" required name="realisasikualitas" id="realisasikualitas" placeholder="Realisasi Target">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="rkuan"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="keterangan">Kualitas Realisasi</label>
                                    <div class="input-group">
                                        <input min="60" max="100" type="number" class="form-control" required name="rkualitas" id="rkualitas" required placeholder="Pengajuan Nilai (100)">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">*</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="keterangan">Keterangan Hasil Pekerjaan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan Hasil Pekerjaan" cols="20" rows="5"></textarea>
                                </div>
                            </div>

                            <button type="submit" id="btnsf" class="btn btn-primary">
                                <span id="btnsf1" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                <span id="btnsf2">Simpan</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>
@endsection

@push('js')
<script>
    var tabel;
    var url = window.location.origin;

    $("#rk").on('click', function() {
        $(".details-control").trigger('click');
    })

    function realisasi(id) {
        $("#realisasikualitas").val('');
        $("#rkualitas").val('');
        $("#keterangan").val('');
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/skp/pengajuan-realisasi/' + id,
            type: 'get',
            success: function(e) {
                $("#kegiatan").val(e.tugasjabatan);
                $("#aktivitas").val(e.kegiatan);
                $("#targetkuantitas").val(e.tkuantitas);
                $("#skuan").html(e.satuan);
                $("#rkuan").html(e.satuan);
                $("#idtugas").val(id);
                $("#realisasikualitas").attr("max", e.tkuantitas);

                console.log(e)
            }
        })
    }

    $("#subtar").submit(function(e) {
        e.preventDefault();
        $("#btnsf").attr('disabled', 'true');
        $("#btnsf2").html('Simpan...')
        $("#btnsf1").addClass('spinner-border ');
        let data = $(this).serialize();
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('pengajuan-realisasi.store')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                $("#btnsf1").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");
                $("#realisasikualitas").val('');
                $("#rkualitas").val('');
                $("#keterangan").val('');
                console.log(e);
                tabel.ajax.reload();
            }
        })
    });

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

    function checkstatus(e) {
        if (e == 2) {
            return 1
        }
        return 0;
    }

    function dataloop(d) {
        var arrs = '';
        console.log(d);
        d['indexes'].forEach(element => {
            arrs = arrs +
                '<tr class="' + checktheme(d[element]["status"]) + '">' +

                '<td  colspan="3" class="text-left">' + 'Bulan ' + bulans(d[element]["bulan"]) + '</td>' +

                '<td>' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</td>' +
                '<td>' + '100' + '</td>' +
                '<td>' + '1' + '</td>' +
                '<td>' + 'Rp. 0' + '</td>' +
                '<td>' + d[element]["rkuantitas"] + ' ' + d[element]["satuan"] + '</td>' +

                '<td>' + d[element]["nilai_atasan"] + '</td>' +
                '<td>' + checkstatus(d[element]["status"]) + '</td>' +
                '<td>' + 'Rp. 0' + '</td>' +
                '<td>' + '' + '</td>' +
                '<td>' + '' + '</td>' +

                '</tr>';
        });

        return arrs;
    }

    function ajukan() {
        data = $("#nilaiskp").html();
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('pengajuan-realisasi.storeukuran')}}",
            data: {
                id: data
            },
            type: 'post',
            success: function(e) {

                $("#toastr-three").trigger("click");

                console.log(e);
            }
        })

    }

    $(document).ready(function() {

        tabel = $("#pengajuan").DataTable({
            fnInitComplete: function(e) {
                total = tabel.column(12).data().reduce(function(a, b) {
                    return Number(a) + Number(b);
                });
                console.log('sad');
                id = tabel.data()[0][0]['id_ped'];

                function getData(id, callback) {
                    $.ajax({
                        url: "{{route('pengajuan-realisasi.lihatdata')}}",
                        data: {
                            id: id
                        },
                        type: 'get',
                        success: callback
                    })
                }

                datas = getData(id, function(e) {
                    console.log(e);
                    if (e.length != 0) {
                        $("#kett").html(e[0]['ket_nt'])
                        $("#ketk").html(e[0]['ket_nk'])
                        $("#nilaik").html(e[0]['nk'])
                        $("#nilait").html(e[0]['nt'])
                        nk = e[0]['nk'] ?? 0;
                        nt = e[0]['nt'] ?? 0;
                        totalt = +nk + +nt
                        kett = e[0]['ket_nt'] ?? '';
                        ketk = e[0]['ket_nk'] ?? '';
                    } else {
                        $("#kett").html('')
                        $("#ketk").html('')
                        $("#nilaik").html('')
                        $("#nilait").html('')
                        nk = 0;
                        nt = 0;
                        totalt = +nk + +nt
                        kett = '';
                        ketk = '';
                    }


                    totaln = +((total / tabel.data().count()).toFixed(2)) + +totalt;
                    console.log(totalt);
                    $("#nilai").val(totaln);
                    row = '<tr>' +
                        '<td class="text-left" colspan="13"> <b> Tugas Tambahan & Kreatifitas </b></td>' +

                        '</tr>';
                    row += '<tr>' +
                        '<td colspan="3"> <b> Tugas Tambahan </b></td>' +
                        '<td class="text-left" id="kett" colspan="9"> <b> ' + kett + ' </b></td>' +

                        '<td id="nilait" colspan="1">' + nt + ' </td>' +
                        '</tr>';
                    row += '<tr>' +
                        '<td colspan="3"> <b> Kreativitas </b></td>' +
                        '<td class="text-left" id="ketk" colspan="9"> <b> ' + ketk + ' </b></td>' +

                        '<td id="nilaik" colspan="1">' + nk + '</td>' +
                        '</tr>';
                    row += '<tr>' +
                        '<td colspan="12"> <b> Nilai Capaian SKP </b></td>' +
                        '<td id="nilaiskp" colspan="1">' + totaln + ' </td>' +
                        '</tr>';
                    $('table tr:last').after(row);

                });




            },
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },

                {
                    targets: 1,
                    width: "1%",
                    orderable: false,

                },
                {
                    orderable: false,
                    targets: 2,
                    width: "25%",
                    className: "text-left"

                },
                {
                    orderable: false,
                    targets: 3,
                    width: "4%",

                },

                {
                    orderable: false,
                    targets: 4,
                    width: "1%",

                },
                {
                    orderable: false,
                    targets: 5,
                    width: "5%",

                },

                {
                    orderable: false,
                    targets: 6,
                    width: "5%",

                },
                {
                    orderable: false,
                    targets: 7,
                    width: "4%",

                },

                {
                    orderable: false,
                    targets: 8,
                    width: "1%",

                },
                {
                    orderable: false,
                    targets: 9,
                    width: "5%",

                },

                {
                    orderable: false,
                    targets: 10,
                    width: "5%",

                },

                {
                    orderable: false,
                    targets: 11,
                    width: "3%",

                },
                {
                    orderable: false,
                    targets: 12,
                    width: "3%",

                },


            ],
            "pageLength": 50,

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('pengajuan-realisasi.pengukuran')}}",
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
                    "orderable": false,
                    "data": null,
                    "defaultContent": '100'
                },
                {
                    nama: 'waktu',
                    data: 'waktu'
                }, {
                    "orderable": false,
                    "data": null,
                    "defaultContent": 'Rp. 0'
                },
                {
                    nama: 'totalkuanr',
                    data: 'totalkuanr'
                },
                {
                    nama: 'totalcapai',
                    data: 'totalcapai'
                }, {
                    nama: 'statusbulan',
                    data: 'statusbulan'
                },
                {
                    "orderable": false,
                    "data": null,
                    "defaultContent": 'Rp. 0'
                }, {
                    nama: 'hbk',
                    data: 'hbk'
                },
                {
                    nama: 'hbk',
                    data: ({
                        hbk
                    }) => parseFloat(Number(hbk) / 3).toFixed(2)
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

                $(tr.nextUntil('[role="row"]')).remove();
            } else {
                $(tr).addClass('ada');

                $(tr).after(dataloop(row.data()));
                console.log($(tr.next()));
            }

        });


    });
</script>
<script src="{{asset('minton/assets/libs/datatable-rowgroup/js/dataTables.rowGroup.min.js')}}"></script>
@endpush