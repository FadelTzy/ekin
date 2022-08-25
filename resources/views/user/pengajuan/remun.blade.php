@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title">Pengajuan Remunerasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Remunerasi</a></li>

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
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary mb-2"><i class="mdi mdi-plus-circle mr-1"></i> Cetak Realisasi</a>


                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right">
                                    <form action="" id="nilairem" name="remun">
                                        @csrf
                                        <input type="hidden" id="nilai" name="nilai">
                                        <button type="submit" class="btn btn-success btn-sm mb-2"> <i class="mdi mdi-plus-circle mr-1"></i>Ajukan Nilai</button>
                                    </form>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered wrap w-100 table-sm" id="pengajuan">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th rowspan="2"></th>

                                        <th rowspan="2">Tugas Jabatan</th>

                                        <th colspan="2">Kuantitas</th>
                                        <th rowspan="2">Kualitas</th>
                                        <th rowspan="2">Nilai Capaian</th>


                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Target</th>
                                        <th scope="col">Realisasi</th>
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


<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

@endsection

@push('js')
<script>
    var tabel;
    var url = window.location.origin;

    $("#rk").on('click', function() {
        $(".details-control").trigger('click');
    })

    $("#nilairem").on('submit', function(e) {
        e.preventDefault();
        data = $(this).serializeArray();
        console.log(data);
        $.ajax({
            url: '{{route("pengajuan-realisasi.ajuremun")}}',
            type: 'POST',
            data: data,
            success: function(e) {

                if (e == 'success') {
                    $("#toastr-three").trigger("click");

                }

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
                $("#skuan").html(e.satuan);
                $("#rkuan").html(e.satuan);
                $("#idtugas").val(id);
                $("#realisasikualitas").attr("max", e.tkuantitas);

                console.log(e)
            }
        })
    }



    function bulans(d) {
        let day;
        switch (d) {
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




    function dataloop(d) {
        var arrs = '';
        console.log(d);
        d['indexes'].forEach(element => {
            arrs = arrs + '<tr >' +
                '<td class="text-left" colspan="3"><b>' + 'Bulan ' + bulans(d[element]["bulan"]) + '</b></td>' +
                '<td class="text-right" colspan="3">' + '<b>Status : <b/>' + badge(d[element]["status"]) + '</td>' +

                '</tr>' +
                '<tr class="' + checktheme(d[element]["status"]) + '">' +

                '<td colspan="2">' + '<b> T </b>' + '</td>' +
                '<td rowspan="2" class="text-left">' + d[element]["kegiatan"] + '</td>' +

                '<td>' + d[element]["tkuantitas"] + '</td>' +
                '<td>' + '1' + '</td>' +
                '<td>' + d[element]["nilai_capaian"] + '</td>' +
                '</tr>' +
                '<tr class="' + checktheme(d[element]["status"]) + '">' +
                '<td colspan="2">' + '<b> R </b>' + '</td>' +

                '<td>' + d[element]["rkuantitas"] + '</td>' +
                '<td>' + checkbul(d[element]["status"]) + '</td>' +
                '<td>' + '<button data-toggle="modal" data-target="#modal-pr" onclick="realisasi(' + d[element]["id"] + ')" href="javascript:void(0);" class="btn btn-sm btn-primary mb-2"><i class="fa fa-edit"></i></button>' + '</td>' +


                '</tr>';
        });

        return arrs;
    }


    $(document).ready(function() {
        tabel = $("#pengajuan").DataTable({
            fnInitComplete: function(e) {
                total = tabel.column(5).data().reduce(function(a, b) {
                    return a + b
                });
                $("#nilai").val((total / tabel.data().count()).toFixed(2));
                row = '<tr>' +
                    '<td colspan="5"> <b> Rata - Rata Nilai </b></td>' +
                    '<td colspan="1">' + (total / tabel.data().count()).toFixed(2) + ' </td>' +
                    '</tr>';
                $('table tr:last').after(row);
                console.log($('table tr:last'));


            },
            "searching": false,
            "lengthChange": false,

            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },

                {
                    targets: 1,
                    width: "40%",
                    orderable: false,
                    className: "text-left"

                }, {
                    orderable: false,
                    targets: 2,
                    width: "10%",

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
                    targets: 5,
                    width: "5%",

                },

            ],

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('pengajuan-realisasi.remun')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'
                },
                {
                    nama: 'tugas',
                    data: 'tugas'
                }, {
                    nama: 'totalkuan',
                    data: 'totalkuan'
                }, {
                    nama: 'totalkuanr',
                    data: 'totalkuanr'
                },
                {
                    nama: 'totalkual',
                    data: 'totalkual'
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




    });
</script>
@endpush