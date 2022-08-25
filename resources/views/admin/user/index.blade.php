@extends('admin.ds_index')

@section('cssc')
<style>

</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Tabel Admin</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Manajemen Admin</a></li>
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
                        <h4 class="header-title">Manajemen Admin</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">

                            <button class="btn btn-success btn-sm waves-effect waves-light mb-2" data-toggle="modal" data-target="#con-edit-modal"><i class="mdi mdi-plus mr-1"></i> <b>Admin</b></button>
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Tanggal Aktif</th>
                                <th>Level</th>
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
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputtext1">Username</label>
                                            <input type="text" class="form-control" id="exampleInputtext1" aria-describedby="textHelp" name="username" placeholder="Input User Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputtext2">Nama</label>
                                            <input type="text" class="form-control" id="exampleInputtext2" aria-describedby="textHelp" name="name" placeholder="Input Nama">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword2">Password</label>
                                            <input type="password" name="repass" class="form-control" id="exampleInputPassword2" placeholder="Ketik Ulang Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adminrole" id="adminrole1" value="option1">
                                                <label class="form-check-label" for="1">
                                                    Super Admin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adminrole" id="adminrole2" checked value="2">
                                                <label class="form-check-label" for="adminrole2">
                                                    Admin </label>
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
                <form id="upd_up" action="#">
                    <input type="hidden" name="id" id="idadmin">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputtext1u">Username</label>
                                            <input type="text" class="form-control" id="exampleInputtext1u" aria-describedby="textHelp" name="username" placeholder="Input User Nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputtext2u">Nama</label>
                                            <input type="text" class="form-control" id="exampleInputtext2u" aria-describedby="textHelp" name="name" placeholder="Input Nama">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1u">Password</label>
                                            <input type="password" name="pass" class="form-control" id="exampleInputPassword1u" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword2u">Password</label>
                                            <input type="password" name="repass" class="form-control" id="exampleInputPassword2u" placeholder="Ketik Ulang Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adminrole" id="adminrole1u" value="option1">
                                                <label class="form-check-label" for="1">
                                                    Super Admin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="adminrole" id="adminrole2u" checked value="2">
                                                <label class="form-check-label" for="adminrole2">
                                                    Admin </label>
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

<script>
    var sinkron;
    var tabel;
    let url = window.location.origin;

    function upd(id) {
        $("#updatemodal").modal('show');
        $("#idadmin").val(id.id);
        $("#exampleInputtext1u").val(id.username);
        $("#exampleInputtext2u").val(id.name);
        if (id.level == '1') {
            $('#adminrole1u').prop('checked', true);

        } else {
            $('#adminrole2u').prop('checked', true);

        }
        console.log(id);
    }
    $("#upd_up").on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        $("#rem_s2").attr('disabled', 'true');
        $("#textb2").html('Simpan...')
        $("#spin2").addClass('spinner-border ');
        $.ajax({
            url: url + '/admin/user/',
            data: data,
            type: "PUT",
            success: function(e) {
                $("#toastr-three").trigger("click");

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
            "columnDefs": [{
                    "targets": [3],
                    "orderable": false,
                    "width": "20%"
                },
                {
                    "targets": [0],
                    "width": "1%"
                },
                {
                    "targets": [1],
                    "width": "20%"
                }, {
                    "targets": [2],
                    "width": "20%"
                },
            ],
            order: [
                [0, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('admin.user')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'

                },

                {
                    name: 'name',
                    data: 'name'
                },

                {
                    name: 'username',
                    data: 'username'
                },
                {
                    name: 'gabung',
                    data: 'gabung'
                },
                {
                    name: 'status',
                    data: 'status'
                },
                {
                    name: 'aksi',
                    data: 'aksi'
                },





            ]
        });
        $("#add_p").on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            console.log(data);
            $("#rem_s").attr('disabled', 'true');
            $("#textb").html('Simpan...')
            $("#spin").addClass('spinner-border ');
            $.ajax({
                url: "{{route('admin.simpan')}}",
                data: data,
                type: "POST",
                success: function(e) {
                    $("#toastr-three").trigger("click");

                    console.log(e);
                    tabel.ajax.reload();
                    $("#rem_s").removeAttr('disabled');
                    $("#textb").html('Simpan');
                    $("#spin").removeClass('spinner-border ');
                    $("#add_p")[0].reset();


                }
            })
        })



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
                url: url + '/admin/user/hapus/' + id,
                type: "DELETE",
                success: function(e) {
                    $("#delete-success").trigger("click");

                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }
</script>

@endpush