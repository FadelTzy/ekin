@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />
<style>
    .tzey {
        width: 100%;
        height: 100%;
        object-fit: cover;
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

@section('body')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            @if(!Session::has('period'))

            <div class="col-12">

                <div class=" float-right">
                    <div class="text-danger pt-2">
                        Session Belum Di Set
                    </div>
                </div>

            </div>

            @endif

            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Log Harian</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Log Harian</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @if(Session::get('id_periode')=="null")
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Tugas Jabatan Anda Untuk {{$datap->nama_periode}} <i>Tidak Terdaftar</i></h4>
                        <h6 class="page-body">Silahkan Melakukan Pengajuan Tugas Jabatan Ke Operator</h6>
                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>
        @else
        @if(Session::get('id_status') == 0 || Session::get('id_status') == 2)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Belum Dapat Menyusun Log Harian Sebelum Atasan Menyetujui Rancangan Target Semester</h4>
                        <h6 class="page-body">Silahkan Menghubungi Atasan Untuk Melakukan Persetujuan Rancangan Target Semester</h6>

                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>
        @elseif(Session::get('id_status') == 3)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Belum Menyusun Rancangan Target Semester {{$datap->nama_periode}}</h4>
                    </div>
                    <div>
                        <i class="fa fa-3x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>

        @else
        <div class="row mb-2">

            <div class="col-sm-8">
                <div class="float-sm-left">
                    <form class="form-inline">
                        <div class="form-group mr-2">
                            <label for="membersearch-input" class="sr-only">Search</label>
                            <input type="search" class="form-control" id="membersearch-input" placeholder="Search...">
                        </div>
                        <button type="button" class="btn btn-success btn-sm mb-2 mb-sm-0"><i class="mdi mdi-cog"></i></button>
                    </form>

                </div>
            </div><!-- end col-->
            <div class="col-sm-4">
                <div class="float-sm-right ">
                    <a target="_blank" href="{{route('cetak.log')}}" class="btn btn-warning btn-sm mb-2"><i class="mdi mdi-plus-circle "></i> Cetak Log</a>
                </div>
                <div class="float-sm-right pr-2">
                    <button data-toggle="modal" data-target="#bs-example-modal-lg" class="btn btn-success btn-sm mb-2"><i class="mdi mdi-plus-circle mr-2"></i> Tambah Log</button>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
            @foreach($smst as $s)
            <div class="col-xl-3 col-sm-4">
                <div class="text-center card">
                    <div class="card-body">

                        <div class="dropdown float-right">
                            <a class="text-body dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical font-20"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <button onclick="lihat('{{ $s->no }}');" type="button" class="dropdown-item">Lihat</button>
                                <a class="dropdown-item" target="_blank" href="{{route('cetak.logb',['a'=> $s->no])}}"> Cetak Log</a>
                                <a class="dropdown-item" href="#" onclick="redirect('{{$s->no}}')"> Hapus Log</a>
                            </div>

                        </div>
                        <div class="avatar-xl mx-auto mt-1">
                            <div class="avatar-title bg-light rounded-circle">
                                <i class="mdi mdi-calendar-range h1 m-0 text-body"></i>
                            </div>
                        </div>
                        <p class="text-muted mt-3 mb-1">Log Harian </p>
                        <h4 class=""><a href="" class="text-dark">{{$s->bulan}}</a></h4>

                        <ul class="social-list list-inline mt-4 mb-2">
                            <li class="list-inline-item">
                                @if($s->nilai != 0)
                                <p class="text-success">{{$s->nilai}} Log Harian</p>
                                @else
                                <p>Belum Ada Log Harian</p>
                                @endif
                            </li>

                        </ul>

                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
            @endforeach
        </div>
        <!-- end row -->
        @endif
        @endif

    </div>






</div> <!-- container -->

<div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Log Harian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <form method="post" id="subtar" enctype="multipart/form-data" action="#">
                            @csrf
                            <div class="form-row">
                                <input type="hidden" id="idtugas" name="idtugas">
                                <div class="form-group col-md-6">
                                    <label for="field-4" class="control-label">Tanggal</label>
                                    <div class="input-group">
                                        <input id="awal" required autocomplete="off" name="awal" class="form-control" @if(Session::get('semester')==1) data-date-end-date="30-06-2021" data-date-start-date="01-01-2021" @else data-date-end-date="31-12-2021" data-date-start-date="01-07-2021" @endif data-provide="datepicker" placeholder="dd-m-yyyy" data-date-format="dd-m-yyyy">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="field-4" class="control-label">Foto Kegiatan</label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="gambar" id="customFile">
                                        <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1">Kegiatan</label>
                                    <textarea class="form-control" name="aktivitas" readonly required id="aktivitas" placeholder="Kegiatan" cols="20" rows="4"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="text" class="form-control" required name="kuantitas" id="kuantitas" placeholder="Kuantitas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Laporan">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="keterangan">Log Harian</label>
                                    <textarea class="form-control" name="keterangan" required id="keterangan" placeholder="Log Harian" cols="20" rows="5"></textarea>
                                </div>
                            </div>

                            <button type="submit" id="btnsf" class="btn btn-primary">
                                <span id="btnsf1" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                <span id="btnsf2">Simpan</span>
                            </button>
                        </form>
                    </div>
                    <div class="col-6">
                        <div class="text-center table-responsive">
                            <table class="table table-striped table-sm table-centered " style="width: 100%;" id="itemm" style="border-collapse: collapse; border-spacing: 0;">
                                <thead>

                                    <tr class="text-left">
                                        <th style="width: 10%;" scope="col">No</th>
                                        <th style="width: 5%;" scope="col"></th>
                                        <th style="width: 75%;" scope="col">Item</th>
                                        <th style="width: 10%;" scope="col">Copy</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyt"></tbody>


                            </table>
                            <h5 id="apasih">Lakukan Pemilihan Tanggal Kegiatan Pada Field Tanggal</h5>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Output</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="lihatgambar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Foto Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">

                        <img class="tzey" alt="">
                    </div>
                    <div class="col-md-6">
                        <label for="">Keterangan</label>
                        <p id="ketnya"></p>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" style="background: rgba(0, 0, 0, 0.2);" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit Log Harian</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form method="post" id="editar" enctype="multipart/form-data" action="#">
                            @csrf
                            <input type="hidden" name="id" id="idid">
                            <div class="form-row">
                                <input type="hidden" id="idtugas" name="idtugas">
                                <div class="form-group col-md-6">
                                    <label for="field-4" class="control-label">Tanggal</label>
                                    <div class="input-group">
                                        <input id="awale" required autocomplete="off" name="awal" class="form-control" data-provide="datepicker" placeholder="dd-m-yyyy" data-date-format="dd-m-yyyy">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ri-calendar-event-fill"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="field-4" class="control-label">Foto Kegiatan</label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="gambar" id="customFilee">
                                        <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1">Kegiatan</label>
                                    <textarea class="form-control" name="aktivitas" readonly required id="aktivitase" placeholder="Kegiatan" cols="20" rows="4"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="text" class="form-control" required name="kuantitas" id="kuantitase" placeholder="Kuantitas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuane" placeholder="Laporan">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="keterangan">Log Harian</label>
                                    <textarea class="form-control" name="keterangan" required id="keterangane" placeholder="Log Harian" cols="20" rows="5"></textarea>
                                </div>
                            </div>

                            <button type="submit" id="btnsf2" class="btn btn-primary">
                                <span id="btnsf12" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                <span id="btnsf22">Simpan</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

@endsection

@push('js')
<script src="{{asset('minton/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    var tabel2;
    var url = window.location.origin;

    function lg(img) {
        console.log(img);
        $("#lihatgambar").modal('show');
        $('.tzey').attr("src", url + '/image/log/' + img.gambar);
        $("#ketnya").html(img.ket);
        console.log(url + '/image/log/' + img.gambar);
    }

    function editj(id) {
        console.log(id);
        $("#editmodal").modal('show');
        $("#awale").val(id.tanggal);
        $("#aktivitase").val(id.target.kegiatan);
        $("#kuantitase").val(id.kuantitas);
        $("#satuane").val(id.satuan);
        $("#keterangane").val(id.ket);
        $("#idid").val(id.id);

        console.log(id);
    }

    function lihat(id) {
        $("#lihatlog").modal('show');

        console.log(id);
        if ($.fn.DataTable.isDataTable('#items')) {
            $("#items").DataTable().destroy();

        }
        tabel2 = $("#items").DataTable({
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },
                {
                    orderable: false,
                    targets: 3,
                    width: "35%",

                },
                {
                    orderable: false,
                    targets: 2,
                    width: "5%",

                },
                {
                    orderable: false,
                    targets: 4,
                    width: "10%",

                },
                {
                    orderable: false,
                    targets: 5,
                    width: "10%",

                },

                {
                    targets: 1,
                    width: "5%",

                }
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('logharian.item')}}",
                data: {
                    id: id,
                }
            },
            columns: [{
                    nama: 'DT_RowIndex',
                    data: 'DT_RowIndex'
                },
                {
                    name: 'tanggal',
                    data: 'tanggal'
                }, {
                    name: 'inputtgl',
                    data: 'inputtgl'
                }, {
                    name: 'kegiatan',
                    data: 'kegiatan'
                },
                {
                    name: 'output',
                    data: 'output'
                },

                {
                    name: 'aksi',
                    data: 'aksi'
                },

            ]
        });
    }

    function delj(id) {

        $data = confirm("klik oke untuk melanjutkan");
        if ($data == 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/skp/logharian/' + id,
                type: 'DELETE',
                success: function(e) {
                    if (e == 'success') {
                        $("#delete-success").trigger("click");
                    } else if (e == 'err') {
                        $("#delete-wrong").trigger("click");
                    }

                    tabel2.ajax.reload();
                }

            })
        }
    }

    function check(id) {
        console.log(id);

    }



    function copy(item, id) {
        $("#aktivitas").val(item);
        $("#idtugas").val(id);
        console.log(item);
    }
    $("#subtar").submit(function(e) {
        e.preventDefault();
        $("#btnsf").attr('disabled', 'true');
        $("#btnsf2").html('Simpan...')
        $("#btnsf1").addClass('spinner-border ');

        let data = new FormData(this);
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('logharian.store')}}",
            data: data,
            type: 'post',
            processData: false,
            contentType: false,
            success: function(e) {
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                $("#btnsf1").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");
                $("#kuantitas").val('');
                $("#kegiatan").val('');
                $("#awal").val('');
                $("#aktivitas").val('');
                $("#bulan").val('');
                $("#keterangan").val('');
                $("#satuan").val('');
                console.log(e);
            }
        })
    });
    $("#editar").submit(function(e) {
        e.preventDefault();
        $("#btnsf2").attr('disabled', 'true');
        $("#btnsf22").html('Simpan...')
        $("#btnsf12").addClass('spinner-border ');

        let data = new FormData(this);
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('logharian.store2')}}",
            data: data,
            type: 'post',
            processData: false,
            contentType: false,
            success: function(e) {
                $("#btnsf2").removeAttr('disabled');
                $("#btnsf22").html('Simpan');
                $("#btnsf12").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");
                tabel2.ajax.reload();
                console.log(e);
            }
        })
    });
    $("#awal").on('change', function() {
        let date = $(this).val();
        $("#apasih").html('');

        console.log(date);
        if ($.fn.DataTable.isDataTable("#itemm")) {
            $('#itemm').DataTable().clear().destroy();
        }
        tabel = $("#itemm").DataTable({

            "columnDefs": [{
                "width": "70%",
                "targets": 2
            }],
            order: [
                [0, 'asc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('logharian.getitem')}}",
                data: {
                    date: date
                },
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
                    name: 'kegiatan',
                    data: 'kegiatan',
                    className: 'text-left'
                },
                {
                    name: 'Aksi',
                    data: 'Aksi',
                },

            ]
        });

    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $(".custom-file-label").html(fileName) // Inside find search element where the name should display (by Id Or Class)
    });

    $('#itemm tbody').on('click', 'td.details-control', function() {
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

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr class="text-left">' +
            '<td>Kegiatan:</td>' +
            '<td>' + d.tupoksi + '</td>' +
            '</tr>' +
            '<tr  class="text-left">' +
            '<td>Keterangan:</td>' +
            '<td>' + d.ket + '</td>' +
            '</tr>' +
            '<tr  class="text-left">' +
            '<td>Kuantitas:</td>' +
            '<td>' + d.tkuantitas + ' ' + d.satuan + '</td>' +

            '</tr>' +

            '</table>';
    }

    function redirect(a) {
        if (confirm('Apakah Anda Yakin Menghapus Log Bulan ' + a + ' ?')) {
            window.location.href = url + '/skp/hapuslogbulan/' + a;
        }
        return false;
    }
</script>
@if(Session::has('msg'))


<script>
    alert('{{Session::get("msg")}}');
</script>
@endif
@endpush