@extends('user.index')

@section('cssc')
<link href="{{asset('minton/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('minton/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('body')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Informasi Pegawai</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Informasi Pegawai</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if($jab == 'null')
        <div class="row">
            <div class="col-12">
                <div class=" alert alert-danger ">
                    <h4 class="page-title">Periode Jabatan Belum Diset</h4>
                </div>
            </div>
        </div>
        @else

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#home" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-inline-block">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-inline-block">Tupoksi Pegawai</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#periode" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-inline-block">Nilai Periode</span>
                                </a>
                            </li>
                            <li class="tahunan">
                                <a href="#tahun" data-toggle="tab" aria-expanded="false" onclick="integrasi()" class="nav-link ">
                                    <span class="d-inline-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-inline-block">Nilai Integrasi</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane  show active" id="home">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="card-title">Pegawai Yang Dinilai</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-3 ">
                                                <img src="{{Auth::user()->foto}}" alt="image" class="mx-auto img-fluid rounded" width="180" />
                                                <p class="mb-0">
                                            </div>
                                            <div class="col-lg-9">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Nama</b></td>
                                                            <td>{{Auth::user()->nama}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>NIP</b></td>
                                                            <td>{{Auth::user()->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Pangkat, Gol</b></td>
                                                            <td>{{Auth::user()->pangkat}}, {{Auth::user()->golongan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Jabatan</b></td>
                                                            <td>{{Auth::user()->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Unit Kerja</b></td>
                                                            <td> {{Auth::user()->unit}} / Universitas Negeri Makassar</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    @if($ap == NULL)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class=" alert alert-danger ">
                                                <h4 class="page-title">Pejabat Atasan Belum Diset</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="card-body">
                                        <h3 class="card-title">Pejabat Penilai</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-3 ">
                                                <img src="{{$ap->foto ?? 'none'}}" alt="image" class="mx-auto img-fluid rounded" width="180" />
                                                <p class="mb-0">
                                            </div>
                                            <div class="col-lg-9 ">
                                                <table class="table table-striped">

                                                    <tbody>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>{{$ap->nama }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>NIP</td>
                                                            <td>{{$ap->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pangkat, Gol</td>
                                                            <td>{{$ap->pangkat}}, {{$ap->golongan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>{{$ap->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td> {{$ap->unit}} / Universitas Negeri Makassar</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="card">
                                    @if($ppt == NULL)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class=" alert alert-danger ">
                                                <h4 class="page-title">Pejabat Atasan Belum Diset</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="card-body">
                                        <h3 class="card-title">Pejabat Penanda Tangan</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-3 ">
                                                <img src="{{$ppt->foto ?? 'none'}}" alt="image" class="mx-auto img-fluid rounded" width="180" />
                                                <p class="mb-0">
                                            </div>
                                            <div class="col-lg-9 ">
                                                <table class="table table-striped">

                                                    <tbody>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>{{$ppt->nama}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>NIP</td>
                                                            <td>{{$ppt->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pangkat, Gol</td>
                                                            <td>{{$ppt->pangkat}}, {{$ppt->golongan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>{{$ppt->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td> {{$ppt->unit}} / Universitas Negeri Makassar</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="card">
                                    @if($pa == NULL)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class=" alert alert-danger ">
                                                <h4 class="page-title">Pejabat Atasan Belum Diset</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="card-body">
                                        <h3 class="card-title">Atasan Pejabat Penanda Tangan</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-3 ">
                                                <img src="{{$pa->foto ?? 'none'}}" alt="image" class="mx-auto img-fluid rounded" width="180" />
                                                <p class="mb-0">
                                            </div>
                                            <div class="col-lg-9 ">
                                                <table class="table table-striped">

                                                    <tbody>
                                                        <tr>
                                                            <td>Nama</td>
                                                            <td>{{$pa->nama}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>NIP</td>
                                                            <td>{{$pa->nip}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pangkat, Gol</td>
                                                            <td>{{$pa->pangkat}}, {{$pa->golongan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jabatan</td>
                                                            <td>{{$pa->jabatan}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Unit Kerja</td>
                                                            <td> {{$pa->unit}} / Universitas Negeri Makassar</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane" id="profile">
                                <div class="row">

                                    <div class="col-xl-12">
                                        <div class="card">


                                            <div class="card-body">
                                                <div class="row 3pb-">
                                                    <div class="col-lg-6">
                                                        <h4 class="page-title"> {{$jabatan->kode}} - {{$jabatan->jabatan}}</h4>
                                                    </div>

                                                </div>
                                                <div class="row"></div>
                                                <table id="skp" class="table table-striped w-100 table-sm">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th scope="col">No</th>
                                                            <th scope="col">Tugas Jabatan</th>
                                                            <th scope="col">Hasil Kerja</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div> <!-- end card -->
                                    </div> <!-- end col -->
                                </div>
                            </div>
                            <div class="tab-pane" id="periode">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center" style="width: 50%;">ATASAN LANGSUNG</th>
                                                <th colspan="2" class="text-center">PNS YANG DINILAI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="min-width: 150px;">Nama</td>
                                                <td>{{$ap->nama}}</td>
                                                <td style="min-width: 150px;">Nama</td>
                                                <td>{{Auth::user()->nama}}</td>
                                            </tr>
                                            <tr>
                                                <td>NIP</td>
                                                <td>{{$ap->nip}}</td>
                                                <td>NIP</td>
                                                <td>{{Auth::user()->nip}}</td>
                                            </tr>
                                            <tr>
                                                <td>Pangkat/Gol.</td>
                                                <td>{{$ap->pangkat}}, {{$ap->golongan}}</td>
                                                <td>Pangkat/Gol.</td>
                                                <td>{{Auth::user()->pangkat}}, {{Auth::user()->golongan}}</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>{{$ap->jabatan}}</td>
                                                <td>Jabatan</td>
                                                <td>{{Auth::user()->jabatan}}</td>
                                            </tr>
                                            <tr>
                                                <td>Unit Kerja</td>
                                                <td>
                                                    {{$ap->unit}} / Universitas Negeri Makassar
                                                </td>
                                                <td>Unit Kerja</td>
                                                <td>
                                                    {{Auth::user()->unit}} / Universitas Negeri Makassar
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>
                                            <tr>
                                                <td colspan="1" style="width: 350px;">Tanggal Penilaian</td>
                                                <td colspan="1" class="text-center" style="width: 200px;">
                                                    @if($jab->perilaku != NULL)
                                                    {{ $jab->perilaku->created_at != NULL ?  date('d M Y',strtotime($jab->perilaku->created_at)) : 'Belum diset'}}
                                                    @else
                                                    'Belum Dinilai'
                                                    @endif
                                                </td>
                                                <td colspan="1"> </td>

                                            </tr>
                                            <tr>
                                                <td style="width: 350px;">1. SKP</td>
                                                <td style="width: 200px;" class="text-center">
                                                    {{$jab->nilai_skp}} x 60%
                                                </td>
                                                <td>{{number_format((float)($jab->nilai_skp * 0.6), 2, '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>2. Perilaku Kerja</td>
                                                <td class="text-center">
                                                    {{$jab->nilai_kerja}} x 40%
                                                </td>
                                                <td>{{number_format((float)($jab->nilai_kerja * 0.4), 2, '.')
                                                  }}</td>
                                            </tr>
                                            @if(Session::get('semester') == 1)
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Nilai Prestasi Kerja</strong>
                                                </td>
                                                <td><strong>{{number_format((float)($jab->nilai_skp * 0.6), 2, '.')+number_format((float)($jab->nilai_kerja * 0.4), 2, '.')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Nilai Konversi Periode {{Session::get('semester') == 1 ? 'Januari - Juni' : 'Juli - Desember' }}</strong>
                                                </td>
                                                <td><strong>{{$nk}}</strong></td>
                                            </tr>
                                            @else

                                            <tr>
                                                <td colspan="2">
                                                    <strong>Ide Baru</strong>
                                                </td>
                                                <td><strong>{{2}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Nilai Prestasi Kerja</strong>
                                                </td>
                                                <td><strong>{{number_format((float)($jab->nilai_skp * 0.6), 2, '.')+number_format((float)($jab->nilai_kerja * 0.4), 2, '.') + 2}}</strong></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <div class="alert alert-info flat" role="alert">
                                        <ul style="margin-left: -20px;">
                                            <li>Penghitungan nilai konversi menggunakan rumus yang tercantum dalam <a href="#" data-toggle="modal" data-target="#modal_se_menpan" style="text-decoration: underline;">SE MenPAN-RB No 03 Tahun 2021</a> (Bagian Lampiran Nomor 3-a).</li>
                                            <!-- <li>Nilai yang ditampilkan pada halaman ini diperbarui setiap hari, dan hasilnya akan terlihat pada hari berikutnya.</li> -->
                                            <li>Jika ada perubahan nilai PPKP, maka nilai konversi akan ter-<i>update</i> secara otomatis pada hari berikutnya.</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="tahun">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">ATASAN LANGSUNG</th>
                                            <th colspan="2" class="text-center">PNS YANG DINILAI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="min-width: 150px;">Nama</td>
                                            <td>{{$ap->nama}}</td>
                                            <td style="min-width: 150px;">Nama</td>
                                            <td>{{Auth::user()->nama}}</td>
                                        </tr>
                                        <tr>
                                            <td>NIP</td>
                                            <td>{{$ap->nip}}</td>
                                            <td>NIP</td>
                                            <td>{{Auth::user()->nip}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pangkat/Gol.</td>
                                            <td>{{$ap->pangkat}}, {{$ap->golongan}}</td>
                                            <td>Pangkat/Gol.</td>
                                            <td>{{Auth::user()->pangkat}}, {{Auth::user()->golongan}}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>{{$ap->jabatan}}</td>
                                            <td>Jabatan</td>
                                            <td>{{Auth::user()->jabatan}}</td>
                                        </tr>
                                        <tr>
                                            <td>Unit Kerja</td>
                                            <td>
                                                {{$ap->unit}} / Universitas Negeri Makassar
                                            </td>
                                            <td>Unit Kerja</td>
                                            <td>
                                                {{Auth::user()->unit}} / Universitas Negeri Makassar
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="1" class="text-center">Tanggal Integrasi Penilaian </th>
                                            <th colspan="3" class="">{{$integrasi->tanggalnilai ?? 'Belum diset'}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4" class="text-center" style="width: 100%;">INTEGRASI HASIL PENILAIAN KINERJA PNS TAHUN {{Session::get('tahon')}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">PERIODE</th>
                                            <th colspan="2" class="text-center">NILAI KINERJA PNS</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">Januari - Juni</th>
                                            <th colspan="2" class="text-center">{{$integrasi->status_1 ?? 'null'}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">Juli - Desember</th>
                                            <th colspan="2" class="text-center">{{$integrasi->status_2 ?? 'null'}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">Nilai Kinerja PNS Tahun {{Session::get('tahon')}} </th>
                                            <th colspan="2" class="text-center">{{$integrasi->nilai ?? 'null'}}</th>

                                        <tr>
                                            <th colspan="2" class="text-center" style="width: 50%;">Predikat </th>
                                            <th colspan="2" class="text-center">{{$integrasi->predikat ?? 'null'}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>
        <!-- end row -->
        @endif


    </div> <!-- container -->

</div> <!-- content -->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function integrasi() {
        $.ajax({
            url: "{{route('user.integrasi')}}",
            type: 'get',

            success: function(e) {

                console.log(e);
            }
        });
    }
    tabel = $("#skp").DataTable({

        ajax: {
            url: "{{route('user.info')}}",
        },
        processing: true,
        serverSide: true,
        columns: [{
                nama: 'DT_RowIndex',
                data: 'DT_RowIndex',
                width: "5%",
            },
            {
                nama: 'uraian',
                data: 'uraian',
                width: "20%",


            },
            {
                name: 'hasil',
                data: 'hasil',
                width: "20%",

            },




        ],
    });
</script>
@endpush