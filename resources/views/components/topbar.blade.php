<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <div class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link " href="{{route('user.skp')}}" id="topnav-dashboard" role="button">
                            <i class="ri-dashboard-line mr-1"></i> Dashboard </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-layout-line mr-1"></i> SKP <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <!-- <a href="{{route('user.r_perd')}}" class="dropdown-item">Rancangan SKP</a> -->
                            <a href="{{route('user.info')}}" class="dropdown-item">Informasi Pegawai</a>

                            <a href="{{route('skp.index')}}" class="dropdown-item">Rencana SKP</a>
                            <a href="{{route('pengajuan-realisasi.index')}}" class="dropdown-item">Pengajuan Realisasi</a>
                            <a href="{{route('adendum.index')}}" class="dropdown-item">Adendum</a>

                            <a href="{{route('pengajuan-realisasi.remun')}}" class="dropdown-item">Pengajuan Remunerasi</a>

                            <a href="{{route('pengajuan-realisasi.pengukuran')}}" class="dropdown-item">Pengukuran Realisasi</a>

                        </div>
                    </li>
                    @if( Auth::user()->statusJabFungsionalBKD == 'Tendik Struktural' || Auth::user()->id_jenis_pegawai == 1 )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-layout-line mr-1"></i> IKU <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <a href="layouts-vertical.html" class="dropdown-item">Informasi Pegawai</a>
                            <a href="layouts-detached.html" class="dropdown-item">IKU</a>
                            <a href="layouts-detached.html" class="dropdown-item">Pengajuan Realisasi</a>
                        </div>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-layout-line mr-1"></i> Penilaian Staf <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <a href="{{route('setuju.staf')}}" class="dropdown-item">Persetujuan Rencana</a>
                            <a href="{{route('penilaian-realisasi.index')}}" class="dropdown-item">Penilaian Realisasi </a>
                            <a href="{{route('perilaku-kerja.index')}}" class="dropdown-item">Penilaian Perilaku</a>
                            <a href="{{route('pengajuan-realisasi.setujutt')}}" class="dropdown-item">Persetujuan Nilai Tambahan</a>

                            <a href="{{route('adendum.persetujuan')}}" class="dropdown-item">Persetujuan Adendum</a>
                        </div>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link " href="{{route('logharian.index')}}" id="topnav-log" role="button">
                            <i class="ri-dashboard-line mr-1"></i> Log harian
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="{{ route('logout') }}" id="topnav-dashboard" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-dashboard-line mr-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>


                    </li>
                    </ul> <!-- end navbar-->


                </div> <!-- end .collapsed-->
            </div>
            <form action="{{route('user.set')}}" method="POST">
                @csrf
                @method('POST')
                <div class="collapse navbar-collapse d-flex justify-content-end">
                    <div class=" float-end pr-2">
                        <select name="_tahun" id="_tahun" class="custom-select custom-select-sm">
                            <option value="null" selected>Tahun</option>
                            @foreach($tahund as $p)
                            <option value='{{$p->tahun}}' @if(Session::has('tahon')) @if(session::get('tahon')==$p->tahun) selected
                                @endif @endif>{{$p->tahun}} </option>
                            @endforeach
                        </select>

                    </div>
                    <div class=" float-end pr-2">
                        <select name="id" id=optidd class="custom-select  custom-select-sm">
                            <option value="null" selected>Pilih Periode</option>
                            @foreach($period as $p)
                            <option value='{{$p->id}}' @if(Session::has('period')) @if(session::get('period')==$p->id) selected
                                @endif @endif>{{date('j M Y', strtotime($p->awal))  }} - {{ date('j M Y', strtotime($p->akhir)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-sm btn-success"> Set</button>

                </div>
            </form>

        </nav>

    </div> <!-- end container-fluid -->
</div> <!-- end topnav-->
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let urlt = window.location.origin;
        var el = document.getElementById("_tahun");
        el.addEventListener('change', function(e) {
            console.log(el.value)
            var http = new XMLHttpRequest(); // inisialisasi
            http.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(http.responseText);
                    var data = JSON.parse(http.responseText);
                    var opttahun = '<option selected disabled>  Periode  </option>';
                    data.forEach(element => {
                        opttahun = opttahun + '<option value="' + element.id + '">' +
                            element.status_bulan +
                            '</option>';
                    });
                    var optid = document.querySelector("#optidd").innerHTML = opttahun;

                    console.log(opttahun);
                }
            };
            http.open("GET", urlt + '/skp/setperiode/' + el.value); // tentukan server tujuan
            http.send(); // eksekusi
        })




    });
</script>