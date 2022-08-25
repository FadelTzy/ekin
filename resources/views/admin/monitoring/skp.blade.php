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
<h4 class="page-title">Monitoring SKP</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Monitoring</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">SKP</a></li>
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
                        <h4 class="header-title">Monitoring SKP Pegawai</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                            function:
                            <code>$().DataTable();</code>.
                        </p>
                    </div>

                </div>
                <!-- end row -->
                <!-- tes -->
                <div id="tabelpos" class="table-responsive">
                    <table class="table table-centered w-100 dt-responsive" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">NIP</th>
                                <th rowspan="2">Tahun</th>
                                <th class="text-center" colspan="2">Periode I</th>
                                <th class="text-center" colspan="2">Periode II</th>

                            </tr>
                            <tr>
                                <th>Rencana</th>
                                <th>Persetujuan</th>
                                <th>Rencana</th>
                                <th>Persetujuan</th>
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
            "dom": "<'row'<'col-sm-6'<'row'<'pl-2 toolbar'><'col-sm-6'l>>><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            fnInitComplete: function() {

                let html = '<select id="ts" class="form-control form-control-sm">' +
                    '<option  value="none"> Tahun </option>' +
                    '<option  value="2022" > 2022 </option>' +
                    '<option selected value="2021" > 2021 </option>' +
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
                        tabel.column(8).search(id).draw()

                    }
                    console.log(id)
                });

            },
            "columnDefs": [{
                "targets": [8],
                "visible": false
            }],
            order: [
                [0, 'asc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('skp.monitoring')}}",
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'

                }, {
                    name: 'nama',
                    data: 'nama'
                },
                {
                    name: 'nip',
                    data: 'nip'
                },
                {
                    name: 'tahun',
                    data: 'tahun'
                },
                {
                    name: 'r1',
                    data: 'r1',
                },
                {
                    name: 'p1',
                    data: 'p1',
                },
                {
                    name: 'r2',
                    data: 'r2',
                },
                {
                    name: 'p2',
                    data: 'p2',
                },
                {
                    name: 'tahun',
                    data: 'tahun',
                },
            ]
        });
        tabel.column(8).search(2021).draw()

        sinkron = function() {

            $.ajax({
                url: '{{route("admin.sinkron")}}',
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