@extends('admin.ds_index')

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
@endsection
@section('breadcrumb')
<h4 class="page-title">Tabel Jabatan</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Jabatan</a></li>
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
                        <h4 class="header-title">Data Pegawai Remun</h4>
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
                                <th>Jabatan</th>
                                <th>Jenis Kepegawaian</th>
                                <th>Status Remun</th>

                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

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
    $(document).ready(function(e) {

        let tabel = $("#products-datatable2").DataTable({
            order: [
                [0, 'asc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('jabatan.index')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'

                }, {
                    name: 'jabatan',
                    data: 'jabatan'
                },
                {
                    name: 'status_k',
                    data: 'status_k'
                },
                {
                    name: 'status_r',
                    data: 'status_r'
                },

            ]
        });
        sinkron = function() {

            $.ajax({
                url: '{{route("admin.sinkronjabatan")}}',
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
    })
</script>
@endpush