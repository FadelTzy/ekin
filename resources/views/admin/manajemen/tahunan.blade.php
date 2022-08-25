@extends('admin.ds_index')

@section('cssc')
<link href="{{asset('minton/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    ​ td.details-control {
        background: url('{{asset("img/open.png")}}') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('{{asset("img/close.png")}}') no-repeat center center;
    }
</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Manajemen Periode Tahunan Pegawai</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Periode</a></li>
    </ol>
</div>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h4 class="header-title">Manajemen Periode Tahunan Pegawai</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">


                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <!-- tes -->
                <div id="tabelpos" class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive" id="periode" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>

                                <th>Tahun</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Aksi</th>



                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>
<div id="con-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">

            <div>
                <form id="add_p" method="POST" action="#">
                    @csrf
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Set Tahun</label>
                                            <div class="input-group">
                                                <input id="awal" required autocomplete="off" name="awal" class="form-control" data-provide="datepicker" placeholder="Year" data-date-format="dd-m-yyyy">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm  btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="rem_s" class="btn btn-sm btn-success waves-effect waves-light">
                            <span id="spin" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="textb">Save</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



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
    var sinkron;
    var tabel;
    let url = window.location.origin;

    function upd(id) {
        $("#updatemodal").modal('show');
        $("#idupd").val(id.id);
        $("#updnama").val(id.nama_periode);
        $("#updawal").val(id.awal);
        $("#updakhir").val(id.akhir);
        console.log(id);
    }
    $("#upd_up").on('submit', function(e) {
        e.preventDefault();
        id = $("#idupd").val();
        let data = $(this).serialize();
        $("#rem_s2").attr('disabled', 'true');
        $("#textb2").html('Simpan...')
        $("#spin2").addClass('spinner-border ');
        $.ajax({
            url: url + '/admin/dm/periodes/' + id,
            data: data,
            type: "PUT",
            success: function(e) {
                console.log(e);
                tabel.ajax.reload();
                $("#rem_s2").removeAttr('disabled');
                $("#textb2").html('Simpan');
                $("#spin2").removeClass('spinner-border ');
                $("#upd_up")[0].reset();


            }
        })
    })

    function set(id) {
        console.log(id);
        let conf = confirm('klik oke untuk melanjutkan');
        if (conf) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('m_pegawai.set')}}",
                data: {
                    tahun: id
                },
                type: "POST",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }



    $(document).ready(function(e) {
        tabel = $("#periode").DataTable({

            "columnDefs": [{
                    "targets": [0],
                    "width": "5%"
                },
                {
                    "targets": [1],
                    "width": "10%"
                },
                {
                    "targets": [2],
                    "width": "50%"
                }, {
                    "targets": [3],
                    "width": "10%"
                }, {
                    "targets": [4],
                    "width": "10%"
                }
            ],
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('m_pegawai.index2')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'

                },
                {
                    name: 'tahun',
                    data: 'tahun'
                },

                {
                    name: 'status',
                    data: 'status'
                },

                {
                    name: 'total',
                    data: 'total'
                },
                {
                    name: 'aksi',
                    data: 'aksi'
                },






            ]
        });




    });
    $('#awal').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });

    function del(id) {
        let kon = confirm('klik oke untuk melanjutkan');
        if (kon) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route("m_pegawai.delete2")}}',
                data: {
                    id: id
                },
                type: "POST",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }
</script>

@endpush