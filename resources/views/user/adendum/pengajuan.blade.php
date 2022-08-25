@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatable-rowgroup/css/rowGroup.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    td.details-control {
        background: url('{{asset("img/open.png")}}') no-repeat center center;
        cursor: pointer;
    }

    .sorting,
    .sorting_asc,
    .sorting_desc {
        background: none;
    }

    tr.shown td.details-control {
        background: url('{{asset("img/close.png")}}') no-repeat center center;
    }

    td {
        text-align: center;
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
                    <h4 class="page-title">Formulir Pengajuan Adendum</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Adendum</a></li>

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
        @if(Session::get('id_status') == 3 || Session::get('id_status') == 2)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Tidak Dapat Mengajukan Adendum Sebelum Atasan Menyetujui Rancangan Target Semester</h4>
                        <h6 class="page-body">Silahkan Menghubungi Atasan Untuk Melakukan Persetujuan Rancangan Target Semester</h6>

                    </div>
                    <div>
                        <i class="fa fa-4x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>
        @elseif(Session::get('id_status') == 0)
        <div class="row">

            <div class="col-12">
                <div class="alert alert-danger d-flex justify-content-between" role="alert">
                    <div>
                        <h4 class="page-title">Anda Belum Menyusun Rancangan Target Semester {{$datap->nama_periode}}</h4>
                        {{Session::get('id_status')}}

                    </div>
                    <div>
                        <i class="fa fa-3x fa-exclamation-triangle  mr-2"></i>
                    </div>

                </div>

            </div>
        </div>

        @else
        {!!$alert!!}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">

                                <button id="rk" type="button" class="btn btn-sm btn-primary mb-2 mr-1">Rincian Kegiatan</button>

                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered wrap w-100 table-sm" id="pengajuan">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th rowspan="2"></th>
                                        <th rowspan="2"></th>
                                        <th rowspan="2">Tugas Jabatan</th>
                                        <th colspan="2">Target</th>
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2">Aksi</th>


                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Bulan</th>
                                    </tr>

                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end row -->
        @endif
        @endif

    </div>






</div> <!-- container -->
<div class="modal fade" data-backdrop="static" id="modal-ub" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Pengubahan Target SKP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form method="post" id="subtare" action="#">
                            @csrf
                            <div class="form-row">
                                <input type="hidden" id="idtugasu" name="idtugas">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Tugas Jabatan</label>
                                    <textarea class="form-control" name="kegiatan" required id="kegiatanu" readonly placeholder="Tugas" cols="20" rows="5"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail1">Kegiatan</label>
                                    <textarea class="form-control" name="aktivitas" required id="aktivitasu" placeholder="Kegiatan" cols="20" rows="2"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kuantitas">Kuantitas</label>
                                    <input type="text" class="form-control" required name="kuantitas" id="kuantitasu" placeholder="Kuantitas">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control" name="satuan" id="satuanu" placeholder="Laporan">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputAddress">Bulan</label>
                                    <select name="bulan" id="bulanu" class="form-control">
                                        <option disabled selected>Pilih Bulan</option>
                                        @foreach($smst as $s)
                                        <option value="{{$s->no}}">{{$s->bulan}}</option>

                                        @endforeach



                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" required id="keteranganu" placeholder="Keterangan" cols="20" rows="5"></textarea>
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
<div class="modal fade" data-backdrop="static" id="modal-pr" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Penambahan Target SKP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form method="post" id="subtar" action="#">
                            @csrf
                            <div class="form-row">
                                <input type="hidden" id="idtugas" name="idtugas">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Tugas Jabatan</label>
                                    <textarea class="form-control" name="kegiatan" required id="kegiatan" readonly placeholder="Tugas" cols="20" rows="5"></textarea>
                                </div>
                                <div class="form-group  col-md-12">

                                    <label for="inputEmail1">Kegiatan</label>
                                    <textarea class="form-control" name="aktivitas" required id="aktivitas" placeholder="Kegiatan" cols="20" rows="2"></textarea>

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
                                    <label for="inputAddress">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control">
                                        <option disabled selected>Pilih Bulan</option>
                                        @foreach($smst as $s)
                                        <option value="{{$s->no}}">{{$s->bulan}}</option>

                                        @endforeach



                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" required id="keterangan" placeholder="Keterangan" cols="20" rows="5"></textarea>
                                </div>
                            </div>

                            <button type="submit" id="btnsf" class="btn btn-primary">
                                <span id="btnsf1" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                <span id="btnsf2">Simpan</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>
<div id="pa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h6>Keterangan Penolakan</h6>
                <p>{{$data->ket_adendum ?? '-'}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@push('js')
<script>
    var tabel;
    var url = window.location.origin;

    $("#rk").on('click', function() {
        $(".details-control").trigger('click');
    })

    function tambah(id) {
        $("#kegiatan").val(id.uraian);
        $("#idtugas").val(id.id);
        $("#aktivitas").val(id.uraian);
        console.log(id);
    }

    function edit(e) {
        $("#kegiatanu").val(e.ur);
        $("#idtugasu").val(e.id);
        $("#aktivitasu").val(e.kegiatan);
        $("#bulanu option[value=" + e.bulan + "]").attr('selected', 'selected');

        $("#kuantitasu").val(e.tkuantitas);
        $("#satuanu").val(e.satuan);
        $("#keteranganu").val(e.ket);
    }

    function hapus(id) {
        let kon = confirm('klik oke untuk melanjutkan');
        if (kon) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/skp/adendum/' + id,
                type: "DELETE",
                success: function(e) {
                    console.log(e);
                    tabel.ajax.reload();
                }
            })
        }
    }

    function realisasi(id) {
        $("#realisasikualitas").val('');
        $("#rkualitas").val('');
        $("#keterangan").val('');
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/skp/pengajuan-realisasi/' + id,
            type: 'get',
            success: function(e) {
                $("#kegiatan").val(e.tugasjabatan);
                $("#aktivitas").val(e.kegiatan);
                $("#targetkuantitas").val(e.tkuantitas);
                $("#skuan").html(e.satuan);
                $("#rkuan").html(e.satuan);
                $("#idtugas").val(id);
                $("#realisasikualitas").attr("max", e.tkuantitas);

                console.log(e)
            }
        })
    }
    $("#subtare").submit(function(e) {
        let id = $("#idtugasu").val();
        e.preventDefault();
        $("#btnsf2").attr('disabled', 'true');
        $("#btnsf22").html('Simpan...')
        $("#btnsf12").addClass('spinner-border ');
        let data = $(this).serialize();
        console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/skp/adendum/' + id,
            data: data,
            type: 'PUT',
            success: function(e) {
                $("#btnsf2").removeAttr('disabled');
                $("#btnsf22").html('Simpan');
                $("#btnsf12").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");

                console.log(e);
                tabel.ajax.reload();
            }
        })
    });
    $("#subtar").submit(function(e) {
        e.preventDefault();
        $("#btnsf").attr('disabled', 'true');
        $("#btnsf2").html('Simpan...')
        $("#btnsf1").addClass('spinner-border ');
        let data = $(this).serialize();
        console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('adendum.store')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                $("#btnsf1").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");

                console.log(e);
                tabel.ajax.reload();
            }
        })
    });

    function bulans(d) {
        let day;
        switch (d) {
            case "1":
                day = "Januari";
                break;
            case "2":
                day = "Februari";
                break;
            case "3":
                day = "Maret";
                break;
            case "4":
                day = "April";
                break;
            case "5":
                day = "Mei";
                break;
            case "6":
                day = "Juni";
                break;
            case "7":
                day = "Juli";
                break;
            case "8":
                day = "Agustus";
                break;
            case "9":
                day = "September";
                break;
            case "10":
                day = "Oktober";
                break;
            case "12":
                day = "Desember";
                break;
            case "11":
                day = "November";
                break;
        }
        return day;
    }

    function badge(id) {
        if (id == 0) {
            return '<h4 class="badge badge-warning"> Belum Melakukan Pengajuan</h4>'
        } else if (id == 1) {
            return '<h4 class="badge badge-info"> Menunggu Penilaian Atasan</h4>'
        } else {
            return '<h4 class="badge badge-success">Telah Dinilai</h4>'
        }
    }

    function checkbul(id) {
        if (id == 2 || id == 1) {
            return '1'
        } else {
            return '0';
        }
    }

    function checktheme(id) {
        if (id == 0 || id == 1) {
            return 'table-info'
        } else {
            return 'table-success'
        }
    }

    function adakah(e, uraian) {
        e['ur'] = uraian;
        data = JSON.stringify(e);
        if (e['status'] == 1 || e['status'] == 2) {
            return 'Telah Realisasi';
        }
        $btn = `<button onclick='hapus(${e['id']})' href='javascript:void(0);' class='btn mr-1 btn-sm btn-danger mb-2'><i class='fa fa-trash'></i></button>`;
        $btn += "<button onclick='edit(" + data + ")'  data-toggle='modal' data-target='#modal-ub' href='javascript:void(0);' class='btn btn-sm btn-info mb-2'><i class='fa fa-edit'></i></button>";
        return $btn;
    }

    function adendum(id) {
        if (id) {
            if (id == 1) {
                return 'Dihapus';
            } else if (id == 2) {
                return 'Diubah';
            } else if (id == 3) {
                return 'Ditambah';
            }
        }
        return '';
    }

    function dataloop(d) {
        var arrs = '';
        d['targets'].forEach(element => {
            arrs = arrs + '<tr class="' + checktheme(element["status"]) + '">';

            if (element['status_adendum'] == '2') {
                arrs = arrs + '<td class="text-left" colspan="2"><b>' + bulans(element["adendum"]["bulan"]) + '</b></td>' +
                    '<td class="text-left" colspan="1"><b>' + element["adendum"]["kegiatan"] + '</b></td>' +
                    '<td class="text-center" colspan="1"><b>' + element["adendum"]["kuantitas"] + ' ' + element["adendum"]["satuan"] + '</b></td>';
            } else {
                arrs = arrs + '<td class="text-left" colspan="2"><b>' + bulans(element["bulan"]) + '</b></td>' +
                    '<td class="text-left" colspan="1"><b>' + element["kegiatan"] + '</b></td>' +
                    '<td class="text-center" colspan="1"><b>' + element["tkuantitas"] + ' ' + element["satuan"] + '</b></td>';
            }


            arrs = arrs + '<td class="text-center" colspan="1"><b>' + '1' + '</b></td>' +
                '<td class="text-center" colspan="1"><b>' + adendum(element['status_adendum']) + '</b></td>' +
                '<td class="text-center" colspan="1"><b>' + adakah(element, d['uraian']) + '</b></td>' +

                '</tr>';
        });

        return arrs;
    }


    $(document).ready(function() {
        tabel = $("#pengajuan").DataTable({
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },
                {
                    orderable: false,
                    targets: 3,
                    width: "15%",

                },

                {
                    orderable: false,
                    targets: 4,
                    width: "5%",

                },
                {
                    orderable: false,
                    targets: 2,
                    width: "40%",
                    className: "text-left"

                },
                {
                    orderable: false,
                    targets: 5,
                    width: "5%",

                },
                {
                    orderable: false,
                    targets: 6,
                    width: "10%",

                },

                {
                    targets: 1,
                    width: "1%",
                    orderable: false,

                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('adendum.index')}}",
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
                }, {
                    nama: 'uraian',
                    data: 'uraian'
                }, {
                    nama: 'kuantitas',
                    data: 'kuantitas'
                }, {
                    nama: 'bulan',
                    data: 'bulan'
                },
                {
                    nama: 'id_jab',
                    data: 'null',
                    "defaultContent": ''


                },
                {
                    nama: 'aksi',
                    data: 'aksi'
                },


            ]
        });
        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            console.log(message);
        };

        $('#pengajuan tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = tabel.row(tr);

            if ($(tr).hasClass('ada')) {
                $(tr).removeClass('ada');

                $(tr.nextUntil('[role="row"]')).remove();
            } else {
                $(tr).addClass('ada');

                $(tr).after(dataloop(row.data()));
                console.log($(tr.next()));
            }
        });


    });
</script>
@endpush