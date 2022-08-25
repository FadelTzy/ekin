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
<h4 class="page-title">Monitoring Log Harian</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Monitoring</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Log Harian</a></li>
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
                                <th>Rencana SKP</th>
                                <th>Log Harian</th>
                                <th>Rencana SKP</th>
                                <th>Log Harian</th>
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
<div class="modal fade" id="lihatlog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Log Harian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-centered " style="width: 100%;" id="items" style="border-collapse: collapse; border-spacing: 0;">
                        <thead>

                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Tanggal Input</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Output</th>
                            </tr>
                        </thead>
                        <tbody id="bodylog">

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@push('js')
<script>
    function log(id) {
        console.log(id);
        var arrs = '';
        no = 1;
        $("#lihatlog").modal('show');
        id.forEach(element => {
            arrs = arrs +
                '<tr >' +

                '<td>' + no++ + '</td>' +
                '<td>' + element.tanggal + '</td>' +
                '<td>' + element.created_at + '</td>' +
                '<td>' + element.ket + '</td>' +
                '<td>' + element.kuantitas + ' ' + element.satuan + '</td>' +


                '</tr>';
        });
        $("#bodylog").html(arrs);
    }


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
                url: "{{route('log.monitoring')}}",
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



    })
</script>
@endpush