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
<h4 class="page-title">Tabel Periode</h4>
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
                        <h4 class="header-title">Manajemen Periode</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">

                            <button class="btn btn-success btn-sm waves-effect waves-light mb-2" data-toggle="modal" data-target="#con-edit-modal"><i class="mdi mdi-plus mr-1"></i> <b>Periode</b></button>
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
                                <th></th>
                                <th>Periode</th>
                                <th>Bulan</th>
                                <th>Aktif</th>
                                <th>Aksi</th>
                                <th>Aktivasi</th>
                                <th>sm</th>
                                <th>th</th>


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

<div id="updatemodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Periode</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="upd_up" method="POST" action="#">
                    @csrf
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-5" class="control-label">Nama Periode</label>

                                    <input type="text" name="nama" required placeholder="ex : Periode 2021 Semester Satu" id="updnama" class="form-control" value="">

                                </div>

                                <input type="hidden" id="idupd" name="id">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Awal Bulan</label>
                                            <div class="input-group">
                                                <input id="updawal" required autocomplete="off" name="awal" class="form-control" data-provide="datepicker" placeholder="dd-m-yyyy" data-date-format="dd-m-yyyy">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Akhir Bulan</label>
                                            <div class="input-group">
                                                <input id="updakhir" autocomplete="off" name="akhir" class="form-control" data-provide="datepicker" placeholder="dd-m-yyyy" data-date-format="dd-m-yyyy">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="field-1-edit" class="control-label">Semester</label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smsr" id="exampleRadios1" value="1" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Semester 1
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="smsr" id="exampleRadios2" value="2">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Semester 2
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="field-1-edit" class="control-label">Status Periode</label>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" checked name="status" class="custom-control-input" id="customSwitch1">
                                        <label id="labelsts" class="custom-control-label" for="customSwitch1">Aktif</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm  btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="rem_s2" class="btn btn-sm btn-success waves-effect waves-light">
                            <span id="spin2" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="textb2">Simpan</span>
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
                url: "{{route('periodes.set')}}",
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

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Periode Semester:</td>' +
            '<td>' + d.awal + ' <b> s/d </b> ' + d.akhir + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Semester:</td>' +
            '<td>' + d.semester + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>tahun:</td>' +
            '<td>' + d.tahun + '</td>' +
            '</tr>' +

            '</table>';
    }


    $(document).ready(function(e) {
        tabel = $("#periode").DataTable({
            "dom": "<'row'<'col-sm-6'<'row'<'pl-2 toolbar'><'col-sm-6'l>>><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            fnInitComplete: function() {
                let html = '<select id="ts" class="form-control form-control-sm">' +
                    '<option selected value="none"> Tahun </option>' +
                    '<option value="2022" > 2022 </option>' +
                    '<option value="2021" > 2021 </option>' +
                    '<option value="2020" > 2020 </option>' +
                    '<option value="2019"> 2019 </option>' +

                    '</select>';
                $('div.toolbar').html(html);
                $("#ts").change(function(e) {
                    e.preventDefault();
                    let id = $(this).val();

                    if (id == "none") {
                        tabel.columns(8).search('').draw()

                    } else {
                        tabel.columns(8).search(id).draw()

                    }
                    console.log(id)
                });

            },
            "columnDefs": [{
                    "targets": [4, 5, 6, 1],
                    "orderable": false,
                    "width": "5%"
                },
                {
                    "targets": [0],
                    "width": "5%"
                },
                {
                    "targets": [2],
                    "width": "30%"
                }, {
                    "targets": [3],
                    "width": "30%"
                }, {
                    "targets": [7, 8],
                    "visible": false
                }
            ],
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('periodes.index')}}",
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
                },
                {
                    name: 'nama_periode',
                    data: 'nama_periode'
                },

                {
                    name: 'status_bulan',
                    data: 'status_bulan'
                },

                {
                    name: 'status',
                    data: 'status'
                },
                {
                    name: 'aksi',
                    data: 'aksi'
                },
                {
                    name: 'set',
                    data: 'set'
                },
                {
                    name: 'semester',
                    data: 'semester'
                }, {
                    name: 'tahun',
                    data: 'tahun'
                },




            ]
        });
        $("#add_p").on('submit', function(e) {
            console.log('sd')
            e.preventDefault();
            let data = $(this).serialize();
            console.log(data);
            $("#rem_s").attr('disabled', 'true');
            $("#textb").html('Simpan...')
            $("#spin").addClass('spinner-border ');
            $.ajax({
                url: "{{route('periodes.store')}}",
                data: data,
                type: "POST",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                    $("#rem_s").removeAttr('disabled');
                    $("#textb").html('Simpan');
                    $("#spin").removeClass('spinner-border ');
                    $("#add_p")[0].reset();


                }
            })
        })
        $('#periode tbody').on('click', 'td.details-control', function() {
            console.log('as')
            var tr = $(this).closest('tr');
            var row = tabel.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
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
                url: url + '/admin/dm/periodes/' + id,
                type: "DELETE",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }
</script>

@endpush