@extends('admin.ds_index')

@section('cssc')
<link href="{{asset('minton/assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    .vh-100 {
        min-height: 50vh;

    }

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
@endsection
@section('breadcrumb')
<h4 class="page-title">Manajemen Pegawai</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Tabel Pegawai</a></li>
    </ol>
</div>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h4 class="header-title">Riwayat Posisi {{$datap->nama}} / {{$datap->nip}}</h4>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <a href="{{route('m_pegawai.index')}}" class="btn btn-danger btn-sm waves-effect waves-light">
                                    <b>
                                    </b> Kembali</a>
                                <a href="" data-toggle="modal" data-target="#con-edit-modal" class="btn btn-success btn-sm waves-effect waves-light">Tambah Posisi</a>

                            </div>
                            <div class="col-lg-6 float-right">
                                <a href="{{route('m_pegawai.show', $datap->id_peg)}}" class="btn btn-warning btn-sm waves-effect waves-light float-right">Reload Data</a>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->
                <!-- tes -->
                <div id="tabelpos" class="table-responsive vh-100">
                    <table class="table table-centered dt-responsive" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>No</th>
                                <th></th>
                                <th>Tugas Jabatan</th>
                                <th>Periode</th>
                                <th>Tahun</th>
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
                <h4 class="modal-title">Tambah Posisi Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="edit_jab" method="POST" action="#">
                    @csrf
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="{{$datap->id_peg}}">
                                <div class="form-group">
                                    <input type="text" name="nama" class="form-control" value="{{$datap->nama}}" readonly>

                                </div>
                                <div class="form-group">
                                    <input type="text" name="nip" class="form-control" value="{{$datap->nip}}" readonly>

                                </div>
                                <div class="form-group">
                                    <input type="text" name="nip" class="form-control" value="{{$datap->jabatan}}" readonly>

                                </div>
                                <div class="form-group mb-1">
                                    <label>Tugas Jabatan</label> <br />
                                    <select required name="jab" id="selectize-select">
                                        <option data-display="Select">Pilih Jabatan</option>
                                        @foreach($tugas as $j)
                                        <option value="{{$j->id}}">{{$j->kode}} - {{$j->jabatan}}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group mb-1">
                                    <label>Periode</label> <br />
                                    <select required name="periode" id="selectize-select">
                                        <option data-display="Select">Pilih Periode</option>
                                        @foreach($period as $u)
                                        <option value="{{$u->tahun}}">
                                            {{$u->tahun}}
                                        </option>

                                        @endforeach

                                    </select>
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm  btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="rem_s" class="btn btn-sm btn-success waves-effect waves-light">
                            <span id="spin" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="textb">Simpan</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Set Pejabat Penilai { {{$datap->nama}} / {{$datap->nip}} }</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <div id="tabelpos2" class="table-responsive p-2 ">
                    <table class="table table-centered dt-responsive" id="products-datatable3" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>Nama</th>
                                <th>NIP</th>

                                <th>Unit Kerja</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>


                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="modal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Set Pejabat Penanda Tangan { {{$datap->nama}} / {{$datap->nip}} }</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <div id="tabelpos2" class="table-responsive p-2 ">
                    <table class="table table-centered dt-responsive" id="products-datatable4" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>Nama</th>
                                <th>NIP</th>

                                <th>Unit Kerja</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>


                            </tr>
                        </thead>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="modal4" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Set Atasan Pejabat Penanda Tangan { {{$datap->nama}} / {{$datap->nip}} }</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <div id="tabelpos2" class="table-responsive p-2 ">
                    <table class="table table-centered dt-responsive" id="products-datatable5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>

                                <th>Nama</th>
                                <th>NIP</th>

                                <th>Unit Kerja</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>


                            </tr>
                        </thead>

                    </table>
                </div>

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
    var selects;
    //del

    function simpanpp(p, c, k) {
        console.log(p + ' ' + c + ' ' + k);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('m_pegawai.post')}}",
            data: {
                idm: p,
                idp: c,
                idk: k
            },
            type: "POST",
            success: function(e) {
                if (e == 'success') {
                    $("#modal2").modal('hide');
                    $("#modal3").modal('hide');
                    $("#modal4").modal('hide');

                    tabel.ajax.reload();
                }
                console.log(e);
            }
        })

    }

    function pp(id) {
        console.log(id);
        $("#modal2").modal('show');
        if ($.fn.DataTable.isDataTable("#products-datatable3")) {
            $('#products-datatable3').DataTable().clear().destroy();
        }
        $("#products-datatable3").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('m_pegawai.get')}}",
                data: {
                    id: id,
                    kon: 1
                }
            },
            columns: [{
                    name: 'nama',
                    data: 'nama'
                },
                {
                    name: 'nip',
                    data: 'nip'
                },

                {
                    name: 'unit',
                    data: 'unit'
                },
                {
                    name: 'jabatan',
                    data: 'jabatan'
                },

                {
                    name: 'aksi',
                    data: 'aksi',
                },
            ]
        });

    }

    function ppt(id) {

        $("#modal3").modal('show');
        if ($.fn.DataTable.isDataTable("#products-datatable4")) {
            $('#products-datatable4').DataTable().clear().destroy();
        }
        $("#products-datatable4").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('m_pegawai.get')}}",
                data: {
                    id: id,
                    kon: 2
                }
            },
            columns: [{
                    name: 'nama',
                    data: 'nama'
                },
                {
                    name: 'nip',
                    data: 'nip'
                },
                {
                    name: 'unit',
                    data: 'unit'
                },
                {
                    name: 'jabatan',
                    data: 'jabatan'
                },

                {
                    name: 'aksi',
                    data: 'aksi',
                },
            ]
        });


    }

    function appt(id) {
        $("#modal4").modal('show');
        if ($.fn.DataTable.isDataTable("#products-datatable5")) {
            $('#products-datatable5').DataTable().clear().destroy();
        }

        $("#products-datatable5").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('m_pegawai.get')}}",
                data: {
                    id: id,
                    kon: 3
                }
            },
            columns: [{
                    name: 'nama',
                    data: 'nama'
                },
                {
                    name: 'nip',
                    data: 'nip'
                },
                {
                    name: 'unit',
                    data: 'unit'
                },
                {
                    name: 'jabatan',
                    data: 'jabatan'
                },

                {
                    name: 'aksi',
                    data: 'aksi',
                },
            ]
        });

    }

    function del(id) {
        console.log(id);
        let kon = confirm('klik oke untusk melanjutkan');
        if (kon) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/admin/manajemen/m_pegawai/' + id,
                type: "DELETE",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }

    function checkst(id) {
        if (id == 1) {
            return '<span class="badge badge-success">Periode Aktif</span>';
        } else {
            return '<span class="badge badge-danger">Periode Tidak Aktif</span>';

        }
    }

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Status:</td>' +
            '<td>' + checkst(d.status) + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pejabat Penilai:</td>' +
            '<td>' + d.pejabat + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Pejabat Penanda Tangan:</td>' +
            '<td>' + d.ppt + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Atasan Pejabat Penanda Tangan:</td>' +
            '<td>' + d.appt + '</td>' +
            '</tr>' +
            '</table>';
    }
    $(document).ready(function(e) {

        $("#customSwitch1").on('change', function(e) {
            console.log($(this).is(':checked'));
            if ($(this).is(':checked')) {
                $("#labelsts").html('Aktif');
            } else {
                $("#labelsts").html('Tidak Aktif');

            }
        })
        $("#edit_jab").on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            console.log(data);
            $("#rem_s").attr('disabled', 'true');
            $("#textb").html('Simpan...')
            $("#spin").addClass('spinner-border ');
            $.ajax({
                url: "{{route('m_pegawai.store')}}",
                data: data,
                type: "POST",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                    $("#rem_s").removeAttr('disabled');
                    $("#textb").html('Simpan');
                    $("#spin").removeClass('spinner-border ');
                    $("#edit_jab")[0].reset();
                    selects[1].selectize.clear()
                    selects[2].selectize.clear()

                }
            })
        })



        tabel = $("#products-datatable2").DataTable({
            "dom": "<'row'<'col-sm-6'<'row'<'pl-2 toolbar'><'col-sm-6'>>><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            fnInitComplete: function() {
                tahun = '<?php echo json_encode($period) ?>';
                datatahun = JSON.parse(tahun);
                console.log(JSON.parse(tahun)[0].tahun);
                let html = '<select id="ts" class="form-control form-control-sm">' +
                    '<option selected value="none"> Tahun </option>';
                datatahun.forEach(element => {
                    html += '<option value="' + element.tahun + '" > ' + element.tahun + ' </option>';

                });



                html += '</select>';
                $('div.toolbar').html(html);
                $("#ts").change(function(e) {
                    e.preventDefault();
                    let id = $(this).val();

                    if (id == "none") {
                        tabel.columns(4).search('').draw()

                    } else {
                        tabel.columns(4).search(id).draw()

                    }
                    console.log(id)
                });

            },
            "columnDefs": [{
                "width": "10%",
                "targets": 5
            }],
            order: [
                [0, 'asc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('m_pegawai.show', $datap->id_peg)}}",
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
                    name: 'tugas_j',
                    data: 'tugas_j',
                },
                {
                    name: 'periode',
                    data: 'periode',
                },
                {
                    name: 'tahun',
                    data: 'tahun',
                },
                {
                    name: 'Aksi',
                    data: 'Aksi',
                },

            ]
        });
        $('#products-datatable2 tbody').on('click', 'td.details-control', function() {
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
    $(function() {
        selects = $("select").selectize(options);
    })
</script>
<script src="{{asset('minton/assets/libs/mohithg-switchery/switchery.min.js')}}"></script>

<script src="{{asset('minton/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
<script src="{{asset('minton/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

@endpush