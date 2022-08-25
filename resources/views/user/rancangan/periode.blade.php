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
</style>
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Formulir Rencana SKP</h4>
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

                        <table id="tahun" class="table table-striped table-sm">
                            <thead>

                                <tr class="text-center">
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Tahun</th>
                                    <th rowspan="2">Periode SKP</th>

                                    <th colspan="4">Target</th>
                                    <th rowspan="2">Status SKP</th>

                                </tr>
                                <tr class="text-center">
                                    <th scope="col">Semester I</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Semester II</th>
                                    <th scope="col">Status</th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
    </div> <!-- container -->
    <div id="info-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="">
                        <form id="tahunform" action="#" method="post">
                            @csrf
                            <h5 class="mt-1">Periode Awal</h5>
                            <div class="input-group">
                                <input type="text" id="awal" name="awal" class="form-control" data-provide="datepicker" data-date-format="dd-m-yyyy">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                            <h5 class="mt-3">Periode Akhir</h5>
                            <div class="input-group">
                                <input type="text" id="akhir" name="akhir" class="form-control" data-provide="datepicker" data-date-format="dd-m-yyyy">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                </div>
                            </div>
                            <div class="float-right">

                                <button type="submit" id="btnsf" class="btn btn-info mt-3">
                                    <span id="btnsf1" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                    <span id="btnsf2">Tambah</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div> <!-- content -->
<div class="modal loader fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('minton/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script>
    var tabel;
    let url = window.location.origin;
    $("#tahunform").on('submit', function(e) {
        $("#btnsf").attr('disabled', 'true');
        $("#btnsf2").html('Simpan...')
        $("#btnsf1").addClass('spinner-border ');
        e.preventDefault();
        console.log('hai');
        let data = $(this).serialize();
        console.log(data);
        $.ajax({
            url: "{{route('tahunperiode.store')}}",
            data: data,
            type: "POST",
            success: function(e) {
                console.log(e);
                $("#awal").val('');
                $("#akhir").val('');
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                tabel.ajax.reload();
                $("#btnsf1").removeClass('spinner-border ');
            }
        })

    });



    function deletej(id) {
        console.log(id);
        let d = confirm("Klik Oke Untuk Melanjutkan")
        if (d) {
            $('.loader').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/skp/rancangan/tahunperiode/' + id,
                type: 'DELETE',
                success: function(response) {
                    console.log(response);
                    if (response == 'success') {
                        $("#delete-success").trigger("click");

                        tabel.ajax.reload();
                        $('.loader').modal('hide');
                    } else {
                        $("#delete-wrong").trigger("click");

                    }

                }
            })
        }

    }
    tabel = $("#tahun").DataTable({
        "dom": "<'row'<'col-sm-6'<'row'<'pl-2 toolbar'><'col-sm-6'l>>><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        fnInitComplete: function() {
            $('div.toolbar').html('<button type="submit" id="tambahtupok" data-toggle="modal" data-target="#info-alert-modal" class="btn btn-bordered-primary waves-effect waves-light">Tambah</button>');

        },
        ajax: {
            url: "{{route('user.r_perd')}}",
        },
        columns: [{
                nama: 'DT_RowIndex',
                data: 'DT_RowIndex'
            },
            {
                nama: 'tahun',
                data: 'tahun'

            },
            {
                name: 'period',
                data: 'period'
            },
            {
                name: 'skp1',
                data: 'skp1'
            },
            {
                name: 'status',
                data: 'status'
            },
            {
                name: 'skp2',
                data: 'skp2'
            },
            {
                name: 'status',
                data: 'status'
            },
            {
                name: 'aksi',
                data: 'aksi'
            },




        ],
    });
</script>
@endpush