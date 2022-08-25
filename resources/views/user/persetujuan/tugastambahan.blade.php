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
                    <h4 class="page-title">Persetujuan Tugas Tambahan </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Persetujuan Tugas</a></li>

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
                                        <th scope="col">Tugas Tambahan</th>
                                        <th scope="col">Kreativitas</th>


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

                </div>
                <form action="" id="formnt">
                    @csrf
                    <input type="hidden" name="id" id="idft">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm  " style="width: 100%;" id="itemlog" style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                        <tr style="background-color: #2980b9; color: white">
                                            <td style="width: 35%;" colspan="2" class="col-md-4">Nilai Tambahan</td>
                                            <td style="width: 45%;">Keterangan</td>
                                            <td style="width: 5%;">Nilai</td>
                                            <td class="text-center" style="width: 10%;">Aksi</td>
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
                                            <td>&nbsp;</td>

                                        </tr>
                                        <tr>
                                            <td class="text-left">


                                            </td>

                                            <td colspan="2" class="text-left">
                                                <div id="ket_t"></div>
                                            </td>
                                            <td class="text-center">
                                                <div id="nilai_1" style="font-size: 18px;">0</div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="1" type="radio" name="tambahan" id="tambahan1">
                                                    <label class="form-check-label" for="tambahan1">
                                                        Setuju
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="2" type="radio" name="tambahan" id="tambahan2">
                                                    <label class="form-check-label" for="tambahan2">
                                                        Tolak
                                                    </label>
                                                </div>
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
                                            <td>&nbsp;</td>

                                        </tr>
                                        <tr>
                                            <td>


                                            </td>
                                            <td colspan="2" class="text-left">
                                                <div id="ket_k"></div>
                                            </td>
                                            <td class="text-center">
                                                <div id="nilai_2" style="font-size: 18px;">0</div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="1" type="radio" name="kreativitas" id="kreativitas1">
                                                    <label class="form-check-label" for="kreativitas1">
                                                        Setuju
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="2" type="radio" name="kreativitas" id="kreativitas2">
                                                    <label class="form-check-label" for="kreativitas2">
                                                        Tolak
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="float-right pl-2">

                                <button type="submit" id="btnsft" class="btn btn-primary">
                                    <span id="btnsf1t" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    <span id="btnsf2t">Simpan </span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#formnt").on('submit', function(e) {
        e.preventDefault();
        $("#btnsft").attr('disabled', 'true');
        $("#btnsf2t").html('Simpan...')
        $("#btnsf1t").addClass('spinner-border ');
        let data = $(this).serialize();
        $.ajax({
            url: "{{route('pengajuan-realisasi.simpannilai')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsft").removeAttr('disabled');
                $("#btnsf2t").html('Simpan');
                $("#btnsf1t").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");
                tabel2.ajax.reload();

                console.log(e);
            }
        })
    })

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
        $.ajax({
            url: "{{route('pengajuan-realisasi.lihatdata')}}",
            type: 'GET',
            data: {
                id: id
            },
            success: function(e) {
                $("#ket_t").html(e[0]['ket_nt']);
                $("#ket_k").html(e[0]['ket_nk']);
                $("#nilai_1").html(e[0]['nt']);
                $("#nilai_2").html(e[0]['nk']);
                $("#idft").val(e[0]['id_mn'])
                console.log(e);
            }
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
            url: "{{route('pengajuan-realisasi.setujutt')}}"
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
                nama: 'status',
                data: 'status'
            },
            {
                nama: 'status1',
                data: 'status1'
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