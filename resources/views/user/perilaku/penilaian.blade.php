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
                    <h4 class="page-title">Penilaian Perilaku Kerja</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Penilaian Perilaku Kerja</a></li>

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
                            <table id="staf" class="table table-hover table-sm">
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Formulir Penilaian Perilaku Kinerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            {!!$form!!}
        </div>
    </div>
</div><!-- /.modal -->
<div class="modal fade" id="check" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.2);" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Preview Penilaian Kinerja</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div id="posisinya" class="modal-body">



            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="integrasi" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.2);" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content w-100">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Preview Integrasi Hasil Penilaian Kinerja PNS {{Session::get('tahon')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div id="integrasimodal" class="modal-body">


            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="bp" tabindex="-1" role="dialog" style="background: rgba(0, 0, 0, 0.2);" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
<div id="kriteria" class="modal fade shadow-lg" tabindex="-1" role="dialog" style="background: 
    rgba(0,0,0,0.2);" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Kriteria Penilaian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="w-25 text-center" scope="col">Kriteria Nilai</th>
                            <th class="w-75 text-center" scope="col">Keterangan</th>

                        </tr>
                    </thead>
                    <tbody class="tdk">
                        <tr>
                            <th scope="row">91 - 100</th>
                            <td>Hasil kerja sempurna, dan pelayanan di atas tidak ada kesalahan, tidak ada revisi, standar yang ditentukan dan lain-lain.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">76 - 90 </th>
                            <td>Hasil kerja mempunyai 1 (satu) atau 2 (dua) kesalahan kecil, tidak ada kesalahan besar, revisi, dan pelayanan sesuai standar yang telah ditentukan dan lain-lain.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">61 - 75 </th>
                            <td>Hasil kerja mempunyai 3 (tiga) atau 4 (empat) kesalahan kecil, dan tidak ada kesalahan besar, revisi, dan pelayanan cukup memenuhi standar yang ditentukan dan lain-lain.

                            </td>
                        </tr>
                        <tr>
                            <th scope="row">51 - 60 </th>
                            <td>Hasil kerja mempunyai 5 (lima) kesalahan kecil dan ada kesalahan besar, revisi, dan pelayanan tidak cukup memenuhi standar yang ditentukan dan lain-lain.

                            </td>
                        </tr>
                        <tr>
                            <th scope="row">50 ke Bawah </th>
                            <td>Hasil kerja mempunyai lebih dari 5 (lima) kesalahan kecil dan ada kesalahan besar, kurang memuaskan, revisi, pelayanan di bawah standar yang ditentukan dan lain-lain.

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var tabel2;
    let url = window.location.origin;

    function integrasi(id) {
        console.log(id);
        $.ajax({
            url: "{{route('perilaku.integrasi')}}",
            type: 'get',
            data: {
                id: id,
            },
            success: function(e) {
                $("#toastr-three").trigger("click");
                tabel2.ajax.reload();
                $("#integrasimodal").html(e);
                console.log(e);

            }
        });
    }

    function integr(id) {
        console.log(id);
        data = confirm('Integrasi Nilai');
        if (data) {
            $.ajax({
                url: "{{route('perilaku.integrasinilai')}}",
                type: 'post',
                data: {
                    id: id,
                },
                success: function(e) {
                    $("#toastr-three").trigger("click");
                    tabel2.ajax.reload();
                    console.log(e);

                }
            });
        }
    }

    function reset(id) {
        data = confirm('apakah anda yakin?');
        if (data) {
            $.ajax({
                url: "{{route('perilaku.reset')}}",
                type: 'post',
                data: {
                    id: id,
                },
                success: function(e) {
                    $("#toastr-three").trigger("click");
                    tabel2.ajax.reload();

                }
            });
        }

    }

    function check(id, nilai) {
        $.ajax({
            url: "{{route('perilaku.check')}}",
            type: 'post',
            data: {
                data: id,
                nilai: nilai
            },
            success: function(e) {
                $("#posisinya").html(e);
                $("#toastr-three").trigger("click");
                tabel2.ajax.reload();

            }
        });

    }

    function nilai(id) {
        console.log(id);
        $("#orientasi").val(id['orientasi_pelayanan']);
        $("#komitmen").val(id['komitmen']);
        $("#inisiatif").val(id['inisiatif_kerja']);
        $("#kerja").val(id['kerjasama']);
        $("#kepemimpinan").val(id['kepemimpinan']);
        $("#integritas").val(id['integritas']);
        $("#disiplin").val(id['disiplin']);
        tabel2.ajax.reload();
        $("#idp").val(id['id']);
    }


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




    $(document).ready(function() {
        $("#btnsms1").on('click', function(e) {
            $("#sms1").trigger('submit');
        })
        $("#sms1").on('submit', function(e) {
            e.preventDefault();
            var datapen = $(this).serialize();
            console.log(datapen);

            $.ajax({
                url: "{{route('perilaku.sms1')}}",
                type: 'post',
                data: datapen,
                success: function(e) {
                    console.log(e);
                    if (e == 'success') {
                        $("#toastr-three").trigger("click");
                        tabel2.ajax.reload();
                    }
                }
            });


        })

    });


    tabel2 = $("#staf").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{route('perilaku-kerja.index')}}"
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