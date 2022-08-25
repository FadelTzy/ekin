@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>
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
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">SKP Periode {{$tahun->tahun}} - @php if(Request::segment(5) == 1 ){
                        echo 'semester 1'; } else { echo 'semester 2';}@endphp </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">SKP Periode</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->



        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  table-sm table-centered w-100 dt-responsive" id="semester" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2">#</th>
                                        <th rowspan="2"></th>

                                        <th rowspan="2">Kegiatan</th>

                                        <th colspan="3">Target</th>

                                    </tr>
                                    <tr class="text-center">
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Kualitas</th>
                                        <th scope="col">Bulan</th>
                                        <th scope="col">Aksi</th>

                                    </tr>
                                </thead class>

                            </table>
                        </div>
                    </div>

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>
        <!-- end row -->



    </div> <!-- container -->

</div> <!-- content -->
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Target Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <form method="post" id="subtar" action="#">
                            @csrf
                            <div class="form-row">
                                <input type="hidden" name="idperiode" value="{{ Request::segment(4) }}">
                                <input type="hidden" name="idsemester" value="{{ Request::segment(5) }}">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">Kegiatan</label>
                                    <textarea class="form-control" name="kegiatan" required id="kegiatan" readonly placeholder="Kegiatan" cols="20" rows="5"></textarea>
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
                                    <select name="bulan" class="form-control">
                                        <option disabled selected>Pilih Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>


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
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-centered " style="width: 100%;" id="item" style="border-collapse: collapse; border-spacing: 0;">
                                <thead>

                                    <tr>

                                        <th scope="col">Item</th>
                                        <th scope="col">Copy</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

@endsection

@push('js')

<script>
    let url = window.location.origin;

    var tabel;

    function editj(e) {
        e.preventDefault;
        $("#full-width-modal").modal('show')
    }

    function delj(e) {
        e.preventDefault;

        $data = confirm("klik oke untuk melanjutkan");
        if ($data == 1) {
            $('.loader').modal('show');
            let iddel = e;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url + '/skp/rancangan/skpmanajemen/' + e,
                type: 'DELETE',
                data: {
                    data: iddel
                },

                success: function(e) {
                    if (e == 'suc') {
                        $("#delete-success").trigger("click");
                    } else if (e == 'err') {
                        $("#delete-wrong").trigger("click");
                    }

                    tabel.ajax.reload(function() {
                        $('.loader').modal('hide');
                    });
                },
                error: function(e) {
                    console.log(e);
                }

            })
            console.log(iddel);
            tabel.ajax.reload();
        }

    }

    function copy(item) {
        $("#kegiatan").val(item);
    }

    function format(d) {
        // `d` is the original data object for the row
        console.log(d);
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

            '<tr>' +
            '<td>Keterangan:</td>' +
            '<td>' + d.ket + '</td>' +
            '</tr>' +

            '</table>';
    }
    $(document).ready(function(e) {
        console.log('s');
        let id = '{{ Request::segment(4) }}';
        let ids = '{{ Request::segment(5) }}';

        let tabel2 = $("#item").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('user.item')}}"
            },
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "95%",
                },
                {
                    orderable: false,
                    targets: 1,
                    width: "5%",

                },

            ],
            columns: [{
                    nama: 'item',
                    data: 'item'
                }, {
                    nama: 'aksii',
                    data: 'aksii'
                },

            ]
        });
        tabel = $("#semester").DataTable({
            "dom": "<'row'<'col-sm-6'<'row'<'pl-2 toolbar'><'col-sm-6'l>>><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            fnInitComplete: function() {
                $('div.toolbar').html('<button type="submit" id="tambahtupok" data-toggle="modal" data-target="#full-width-modal" class="btn btn-bordered-primary waves-effect waves-light">Tambah</button>');

            },
            columnDefs: [{
                    orderable: false,
                    targets: 0,
                    width: "1%",
                },
                {
                    orderable: false,
                    targets: 3,
                    width: "5%",

                },
                {
                    orderable: false,
                    targets: 2,
                    width: "40%",

                },
                {
                    orderable: false,
                    targets: 4,
                    width: "7%",

                },
                {
                    orderable: false,
                    targets: 5,
                    width: "10%",

                },
                {
                    orderable: false,
                    targets: 6,
                    width: "10%",

                },
                {
                    targets: 1,
                    width: "5%",
                    orderable: false,

                }
            ],
            order: [
                [1, 'desc']
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: url + '/skp/rancangan/tahunan/' + id + '/' + ids,
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
                    nama: 'item',
                    data: 'item'
                }, {
                    nama: 'tkuan',
                    data: 'tkuan'
                }, {
                    nama: 'tkualitas',
                    data: 'tkualitas'
                }, {
                    nama: 'bulan',
                    data: 'bulan'
                },
                {
                    nama: 'aksi',
                    data: 'aksi'
                },


            ]
        });
        $('#semester tbody').on('click', 'td.details-control', function() {
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

    $("#subtar").submit(function(e) {
        e.preventDefault();
        $("#btnsf").attr('disabled', 'true');
        $("#btnsf2").html('Simpan...')
        $("#btnsf1").addClass('spinner-border ');
        let data = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('user.inserttupok')}}",
            data: data,
            type: 'post',
            success: function(e) {
                $("#btnsf").removeAttr('disabled');
                $("#btnsf2").html('Simpan');
                $("#btnsf1").removeClass('spinner-border ');
                $("#toastr-three").trigger("click");
                $("#kuantitas").val('');
                $("#kegiatan").val('');
                $("#kualitas").val('');
                $("#biaya").val('');
                $("#waktu").val('');
                $("#satuan").val('');
                console.log(e);
                tabel.ajax.reload();
            }
        })
    });
</script>
@endpush