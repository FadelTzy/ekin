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
        @if($id_mn->adendum == 1 || $id_mn->adendum == 2)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Belum Dapat Mengajukan Realisasi Bulanan Sebelum Atasan Menyetujui Adendum Anda</h4>
                        <h6 class="page-body">Silahkan Menghubungi Atasan Untuk Melakukan Persetujuan Rancangan Target Baru</h6>

                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
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

                                <button id="rk" type="button" class="btn btn-sm btn-primary mb-2 mr-1">Rincian Kegiatan</button>

                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right">

                                    <button type="button" data-toggle="modal" data-target="#lihatlog" class="btn btn-success btn-sm mb-2"> <i class="mdi mdi-plus-circle mr-1"></i>Isi Nilai Tambahan</button>
                                    <button type="button" class="btn btn-success btn-sm mb-2"> <i class="mdi mdi-plus-circle mr-1"></i>Realisasi Bulanan</button>
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

                                        <th colspan="2">Target</th>
                                        <th rowspan="2">Nilai Mutu</th>


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
                <!-- end row -->
            </div>
        </div>
        @endif


        <!-- end row -->
        @endif
        @endif

    </div>






</div> <!-- container -->

<div class="modal fade" id="modal-pr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <input min="60" max="100" type="number" class="form-control" required name="rkualitas" id="rkualitas" value="100" required placeholder="Pengajuan Nilai (100)">
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
<div class="modal fade" id="lihatlog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pengajuan Tugas Tambahan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="formtt" action="" method="post">
                <input type="hidden" name="id" value="{{$id_mn->id ??'null'}}">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm  " style="width: 100%;" id="itemlog" style="border-collapse: collapse; border-spacing: 0;">
                            <thead>
                                <tr style="background-color: #2980b9; color: white">
                                    <td style="width: 45%;" colspan="2" class="col-md-4">Nilai Tambahan</td>
                                    <td style="width: 50%;">Keterangan</td>
                                    <td style="width: 5%;">Nilai</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-left" style="background-color: #ecf0f1">
                                    <td class="text-left" style="width: 20px;">1</td>
                                    <td>
                                        <div class="pull-left">
                                            Tugas Tambahan </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-left">
                                        @foreach($tambah as $t)
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{$t->nilai}}" type="radio" name="ntambahan" id="ntambahan{{$t->id}}">
                                            <label class="form-check-label" for="ntambahan{{$t->id}}">
                                                {{$t->tugas}}
                                            </label>
                                        </div>
                                        @endforeach

                                    </td>

                                    <td>
                                        <textarea name="ket_1" style="width: 100%;" id="" name="desktt" cols="30" rows="10"></textarea>

                                    </td>
                                    <td class="text-center">
                                        <div id="nilai_1" style="font-size: 18px;">0</div>
                                    </td>
                                </tr>
                                <tr style="background-color: #ecf0f1">
                                    <td class="text-left" style="width: 20px;">2</td>
                                    <td>
                                        <div class="pull-left">
                                            Kreativitas </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-left">
                                        @foreach($kreatif as $t)
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{$t->nilai}}" type="radio" name="nkreativitas" id="nkreativitas{{$t->id}}">
                                            <label class="form-check-label" for="nkreativitas{{$t->id}}">
                                                {{$t->tugas}}
                                            </label>
                                        </div>
                                        @endforeach

                                    </td>
                                    <td>
                                        <textarea name="ket_2" style="width: 100%;" id="" name="desktk" cols="30" rows="10"></textarea>
                                    </td>
                                    <td class="text-center">
                                        <div id="nilai_2" style="font-size: 18px;">0</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnsft" class="btn btn-primary">
                        <span id="btnsf1t" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                        <span id="btnsf2t">Simpan Nilai Tambahan</span>
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@push('js')
<script>
    var tabel;
    var url = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('input[name=ntambahan]').change(function() {
        var value = $('input[name=ntambahan]:checked').val();
        $("#nilai_1").html(value);
    });
    $('input[name=nkreativitas]').change(function() {
        var value = $('input[name=nkreativitas]:checked').val();
        $("#nilai_2").html(value);
    });
    $("#rk").on('click', function() {
        $(".details-control").trigger('click');
    })
    $("#formtt").on('submit', function(e) {
        e.preventDefault();
        $("#btnsft").attr('disabled', 'true');
        $("#btnsf2t").html('Simpan...')
        $("#btnsf1t").addClass('spinner-border ');
        let data = $(this).serialize();
        $.ajax({
            url: "{{route('pengajuan-realisasi.nilaitambah')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsft").removeAttr('disabled');
                $("#btnsf2t").html('Simpan');
                $("#btnsf1t").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");

                console.log(e);
            }
        })

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
                $("#realisasikualitas").val(e.tkuantitas);

                $("#rkualitas").val(100);

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

        $.ajax({
            url: "{{route('pengajuan-realisasi.store')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                $("#btnsf1").removeClass('spinner-border ');
                $("#realisasikualitas").val('');
                $("#rkualitas").val('');
                $("#keterangan").val('');
                console.log(e);
                if (e == 'gagal') {
                    alert('Anda Belum Bisa Mengajukan Realisasi, Isi Log Harian Terlebih Dahulu');
                } else {
                    tabel.ajax.reload();
                    $("#toastr-three").trigger("click");

                }

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

    function dataloop(d) {
        var arrs = '';
        console.log(d);
        d['indexes'].forEach(element => {
            arrs = arrs + '<tr >' +
                '<td class="text-left" colspan="3"><b>' + 'Bulan ' + bulans(d[element]["bulan"]) + '</b></td>' +
                '<td class="text-right" colspan="3">' + '<b>Status : <b/>' + badge(d[element]["status"]) + '</td>' +

                '</tr>' +
                '<tr class="' + checktheme(d[element]["status"]) + '">' +

                '<td  colspan="3" rowspan="2" class="text-left">' + d[element]["kegiatan"] + '</td>' +

                '<td>' + '<p><b>Target</b></p>' + d[element]["tkuantitas"] + ' ' + d[element]["satuan"] + '</td>' +
                '<td>' + '1' + '</td>' +
                '<td>' + adakah(d[element]["nilai_atasan"]) + '</td>' +
                '</tr>' +
                '<tr class="' + checktheme(d[element]["status"]) + '">' +

                '<td>' + '<p><b>Realisasi</b></p>' + d[element]["rkuantitas"] + ' ' + d[element]["satuan"] + '</td>' +
                '<td>' + checkbul(d[element]["status"]) + '</td>' +
                '<td>' + '<button data-toggle="modal" data-target="#modal-pr" onclick="realisasi(' + d[element]["id"] + ')" href="javascript:void(0);" class="btn btn-sm btn-primary mb-2"><i class="fa fa-edit"></i></button>' + '</td>' +


                '</tr>';
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
                    orderable: false,
                    targets: 5,
                    width: "5%",

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
                    return $('<tr class="table-info"/>')
                        .append('<td class="text-left" colspan="3">Realisasi ' + '</td>')
                        .append('<td>' + rows.data()[0]['totalkuanr'] + '</td>')
                        .append('<td>' + rows.data()[0]['statusbulan'] + '</td>').append('<td />');
                },
                dataSrc: 0
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('pengajuan-realisasi.index')}}",
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
                    nama: 'totalcapai',
                    data: 'totalcapai'
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