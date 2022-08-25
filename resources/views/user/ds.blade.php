@extends('user.index')

@section('cssc')
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
                    <h4 class="page-title">Selamat Datang Di Aplikasi E-Kinerja Universitas Negeri Makassar</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>

                        </div>

                        <h4 class="header-title mt-0">Periode {{$periode[0]->nama_periode}}</h4>

                        <div class="mt-3">
                            <div class="media">
                                <div dir="ltr">
                                    <input data-plugin="knob" data-width="70" data-height="70" data-fgColor="#4ad0e6 " data-bgColor="#03F9FF" value="{{$periode['totalss1'] ?? 0}}" data-skin="tron" data-angleOffset="{{$periode['totals1'] ?? 0}}" data-readOnly=true data-thickness=".20" />
                                </div>
                                <div class="media-body text-right align-self-center">
                                    <h3 class="mt-0 mb-1">Rencana SKP {{$periode['totals1'] ?? 0}} </h3>
                                    <p class="text-muted mb-0">Status : {{$periode['statusps1'] ?? 'Tidak Terdaftar'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-xl-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal"></i>
                            </a>

                        </div>

                        <h4 class="header-title mt-0">Periode {{$periode[1]->nama_periode}}</h4>
                        <div class="mt-3">
                            <div class="media">
                                <div dir="ltr">
                                    <input data-plugin="knob" data-width="64" data-height="64" data-fgColor="#4ad0e6" data-bgColor="#03F9FF" value="{{$periode['totalss2'] ?? 0}}" data-skin="tron" data-angleOffset="{{$periode['totals2'] ?? 0}}" data-readOnly=true data-thickness=".20" />
                                </div>
                                <div class="media-body text-right align-self-center">
                                    <h3 class="mt-0 mb-1">Rencana SKP {{$periode['totals2'] ?? 0}} </h3>
                                    <p class="text-muted mb-0">Status : {{$periode['statusps2']?? 'Tidak Terdaftar'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->




        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box page-title-box-alt">
                    <h4 class="page-title">Silahkan pilih menu pintasan dibawah ini</h4>

                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/informasi')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class="fas fa-user fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Data Pegawai</h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/rancangan/skp')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class="far fa-calendar-alt fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Rencana SKP </h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/pengajuan-realisasi')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class=" far fa-calendar-check fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Realisasi SKP</h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/logharian')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class="far fa-edit fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Log Harian </h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/pengajuan-remunerasi')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class="fas fa-pen-alt fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Remunerasi SKP</h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>
            <div class="col-md-2 col-xl-2 col-sm-6">
                <div class="card product-box">
                    <a href="{{url('skp/pengukuran-realisasi')}}">
                        <div class="product-img text-center">
                            <div class="px-3 pt-3 pb-2">
                                <i class="fas fa-pen-alt fa-5x"></i>
                            </div>
                        </div>

                        <div class="product-info text-center">

                            <div>
                                <h5 class="font-16 mt-0 mb-1 pb-2 text-dark">Pengukuran SKP</h5>

                            </div>

                        </div> <!-- end product info-->
                    </a>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Progres Penilaian Bulanan SKP</h4>

                        <div id="cardCollpase2" class="collapse pt-3 show" dir="ltr">
                            <div id="chartsd" class="apex-charts" data-colors="#02a8b5,#3b82da"></div>
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->


        </div>





    </div> <!-- container -->

</div> <!-- content -->
@endsection

@push('js')
<!-- Third Party js-->
<script src="{{asset('minton/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
<script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
<script src="https://apexcharts.com/samples/assets/ohlc.js"></script>

<!-- init js -->
<script>
    tahun = "{{session::get('tahon') }}";
    var bulan = '{!! json_encode($bulan) !!}';
    console.log(JSON.parse(bulan));
    var options = {
        series: [{
                name: "2021",
                data: JSON.parse(bulan)
            },

        ],
        chart: {
            height: 350,
            type: 'line',
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            },
            toolbar: {
                show: false
            }
        },
        colors: ['#77B6EA', '#545454'],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Tahun ' + tahun,
            align: 'left'
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            title: {
                text: 'Bulan'
            }
        },
        yaxis: {
            title: {
                text: 'Nilai'
            },
            min: 5,
            max: 100
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartsd"), options);
    chart.render();
</script>
<script src="{{asset('minton/assets/js/pages/apexcharts.init.js')}}"></script>
@endpush