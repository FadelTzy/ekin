@extends('admin.ds_index')

@section('cssc')
<link href="{{asset('minton/assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />

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
</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Tabel Tupoksi Pegawai</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Tupoksi</a></li>
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
                        <h4 class="header-title">Manajemen Jabatan & Tupoksi</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">

                            <button class="btn btn-success btn-sm waves-effect waves-light mb-2" id="con-open" data-toggle="modal" data-target="#con-close-modal"><i class="mdi mdi-plus-circle mr-1"></i> Tambah Data</button>

                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <!-- tes -->
                <div id="tabelpos" class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive" id="tupoksi" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>No</th>
                                <th></th>
                                <th>Kode Jabatan</th>
                                <th>Jabatan</th>
                                <th>Tupoksi</th>
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
<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Jabatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="tambah_jab" method="POST" action="#">
                    @csrf
                    <div class="modal-body py-2 px-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <div class="form-group">
                                        <label for="kode" class="control-label">Kode Jabatan</label>

                                        <input type="text" name="kode" required placeholder="E.101" id="kode" class="form-control" value="">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <div class="form-group">
                                        <label for="jabatan" class="control-label">Jabatan</label>

                                        <input type="text" name="jabatan" required placeholder="Analis" id="jabatan" class="form-control">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div id="" class="form-group">
                                    <div class="form-group">
                                        <label for="field-1-edit" class="control-label">Status Jabatan</label>

                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" checked name="status" class="custom-control-input" id="customSwitch1">
                                            <label id="labelsts" class="custom-control-label" for="customSwitch1">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="rem_s" class="btn btn-success waves-effect waves-light">
                            <span id="spin" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="textb">Simpan</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="con-lihat-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tupoksi <span id="tupokjab"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <div class="modal-body p">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <div id="data-tupok">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div id="con-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Unit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="edit_jab" method="POST" action="#">
                    @csrf
                    <input type="hidden" id="idposte" value="">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1-edit" class="control-label">Unit</label>
                                    <input type="text" name="Unit-e" class="form-control vk" id="field-1-edit" value="{{old('Unit')}}" placeholder="Fakultas Teknik">
                                    <div class="text-danger" id="unit-e"></div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="rem_se" class="btn btn-success waves-effect waves-light">
                            <span id="spine" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="texte">Simpan</span>
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
<script>
    // var i = 1;
    // $('#add').click(function() {
    //     i++;
    //     $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Input Tupoksi" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    // });

    // $(document).on('click', '.btn_remove', function() {
    //     var button_id = $(this).attr("id");
    //     $('#row' + button_id + '').remove();
    // });
    $(function() {
        $("select").selectize(options);
    })
    var tabel;
    let url = window.location.origin;

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

            '<tr>' +
            '<td>status:</td>' +
            '<td>' + d.statusbtn + '</td>' +
            '</tr>' +


            '</table>';
    }

    $(document).ready(function(e) {
        tabel = $("#tupoksi").DataTable({
            "columnDefs": [{
                    "targets": [1],
                    "orderable": false,
                    "width": "1%"
                },
                {
                    "targets": [4, 5],
                    "orderable": false,
                    "width": "10%"
                },
                {
                    "targets": [0],
                    "width": "5%"
                },
                {
                    "targets": [2],
                    "width": "30%"
                },
            ],
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('jabatans.index')}}",
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
                    name: 'kode',
                    data: 'kode'
                },
                {
                    name: 'jabatan',
                    data: 'jabatan'
                },

                {
                    name: 'tupoks',
                    data: 'tupoks'
                },
                {
                    name: 'aksi',
                    data: 'aksi'
                },



            ]
        });
        $('#tupoksi tbody').on('click', 'td.details-control', function() {
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


    function lihatt(id) {
        let url = window.location.origin;
        $("#con-lihat-modal").modal('show');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/admin/dm/showtupok/' + id,
            type: "get",
            success: function(response) {
                console.log(response);
                $("#data-tupok").html(response);
                $("#tupokjab").html($("#jabtupok").html());

            }
        })
    }
    $("#con-open").on('click', function() {

        $("#errr").html('');

    })

    function tambaht(id) {

        $("#con-tambaht-modal").modal('show');

        console.log(id)
    }

    function deletej(id) {

        let d = confirm("Klik Oke Untuk Melanjutkan")
        if (d) {
            $('.loader').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/admin/dm/jabatans/' + id,
                type: 'DELETE',

                success: function(response) {
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
    $("#tambah_jab").submit(function(e) {

        e.preventDefault();


        var data = $(this).serialize();
        console.log(data);
        $("#rem_s").attr('disabled', 'true');
        $("#textb").html('Simpan...')
        $("#spin").addClass('spinner-border ');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('jabatans.store')}}",
            type: "POST",
            data: data,

            success: function(response) {
                console.log(response);
                $("#rem_s").removeAttr('disabled');
                $("#textb").html('Simpan');
                $("#spin").removeClass('spinner-border ');
                if (response.error != null) {
                    $("#toastr-one").trigger("click");
                    $("#errr").html('<label class="text-danger"><i>*Field Belum Diset</i></label> <br />');
                    console.log(response);
                }
                if (response.success) {
                    $("#statuserr,#kstatuserr").html('');
                    $("#toastr-three").trigger("click");
                    $("#errr").html('');
                    console.log('success');
                    $(".vk").val('');
                    tabel.ajax.reload();
                }

            },
            error: function(response) {
                console.log(response);
                $("#rem_s").removeAttr('disabled');
                $("#textb").html('Simpan');
                $("#spin").removeClass('spinner-border ');
                $("#toastr-one").trigger("click");

            },
        });

    });
</script>
<script src="{{asset('minton/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

@endpush