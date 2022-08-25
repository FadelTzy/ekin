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
</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Tabel Relasi</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Pegawai</a></li>
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
                        <h4 class="header-title">Data Pegawai</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">

                            <button onclick="sinkron()" class="btn btn-success mb-2"><i class="mdi mdi-reload mr-1"></i> Sinkronisasi</button>

                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <!-- tes -->
                <div id="tabelpos" class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Pejabat Penilai Langsung</th>
                                <th>Penilai Pejabat</th>
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
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="edit_jab" method="POST" action="#">
                    @csrf
                    <input type="hidden" id="idposte" name="id" value="">
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label>Atasan Penilai</label> <br />
                                    <select required name="ap" id="selectize-select">
                                        <option data-display="Select">Pilih Atasan</option>
                                        @foreach($data as $j)
                                        <option value="{{$j->id_peg}}">{{$j->nama}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-2">
                                    <label>Penilai Atasan</label> <br />
                                    <select required name="pa" id="selectize-select2">
                                        <option data-display="Select">Pilih Penilai Atasan</option>
                                        @foreach($data as $j)
                                        <option value="{{$j->id_peg}}">{{$j->nama}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="jab_e" class="btn btn-success waves-effect waves-light">
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
    var tabel;
    var sinkron;
    $(function() {
        $("select").selectize(options);
    })

    function updatej(id) {
        let url = window.location.origin;
        console.log(url)
        let data = {
            id: id
        };
        $("#con-edit-modal").modal('show');
        $("#idposte").val(id);
        console.log(id);

    }

    $(document).ready(function(e) {

        let tabel = $("#products-datatable2").DataTable({
            order: [
                [0, 'asc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('info.index')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'

                }, {
                    name: 'nama',
                    data: 'nama'
                },
                {
                    name: 'atasan',
                    data: 'atasan',

                },
                {
                    name: 'ppa',
                    data: 'ppa',

                },
                {
                    name: 'aksi',
                    data: 'aksi',
                },


            ]
        });

        sinkron = function() {

            $.ajax({
                url: '{{route("admin.relasi")}}',
                type: 'get',
                beforeSend: function() {
                    $('.loader').modal('show');

                },
                success: function(e) {
                    if (e == 'success') {
                        $("#toastr-three").trigger("click");

                    } else {
                        $("#delete-wrong").trigger("click");

                    }
                    tabel.ajax.reload();
                    $('.loader').modal('hide');

                }
            })
        }
        $("#edit_jab").submit(function(e) {
            var id = $("#idposte").val();
            e.preventDefault();
            $("#itemerr").html('');
            var data = $(this).serialize();
            console.log(data);
            $("#jab_e").attr('disabled', 'true');
            $("#texte").html('Simpan...')
            $("#spine").addClass('spinner-border ');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('info.update')}}",
                type: 'POST',
                data: data,
                success: function(e) {
                    tabel.ajax.reload();

                    console.log(e)

                },

            }).done(function() {
                $("#jab_e").removeAttr('disabled');
                $("#texte").html('Simpan');
                $("#spine").removeClass('spinner-border ');
            })

        })
    })
</script>
<script src="{{asset('minton/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>

@endpush