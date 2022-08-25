@extends('pdf.layouts')

@section('content')
<h2 class="" style="text-align: center;">Sasaran Kinerja Pegawai</h2>

<p>{{$periode}}</p>

<table class="table table-bordered table-hover table-striped">
    <thead>

    </thead>
    <tbody>
        <tr class="bgrow">
            <th style="width: 5%; text-align:center">No</th>
            <th colspan=" 2" class="text-center" style="width: 50%; text-align:center">I. PEJABAT PENILAI</th>
            <th style="width: 5%; text-align:center">No</th>
            <th colspan="4" class="text-center" style="width: 45%;  text-align:center">II. PNS YANG DINILAI</th>
        </tr>
        <tr>
            <td>1</td>
            <td style="min-width: 150px;">Nama</td>
            <td>{{$ap->nama}}</td>
            <td>1</td>
            <td colspan=" 2" style="min-width: 150px;">Nama</td>
            <td colspan=" 2">{{Auth::user()->nama}}</td>
        </tr>
        <tr>
            <td>2</td>

            <td>NIP</td>
            <td>{{$ap->nip}}</td>
            <td>2</td>

            <td colspan=" 2">NIP</td>

            <td colspan=" 2">{{Auth::user()->nip}}</td>

        </tr>
        <tr>
            <td>3</td>

            <td>Pangkat/Gol.</td>
            <td>{{$ap->pangkat}}, {{$ap->golongan}}</td>
            <td>3</td>

            <td colspan=" 2">Pangkat/Gol.</td>

            <td colspan=" 2">{{Auth::user()->pangkat}}, {{Auth::user()->golongan}}</td>

        </tr>
        <tr>
            <td>4</td>

            <td>Jabatan</td>
            <td>{{$ap->jabatan}}</td>
            <td>4</td>

            <td colspan=" 2">Jabatan</td>

            <td colspan=" 2">{{Auth::user()->jabatan ?? $jabatan->jabatan}}</td>

        </tr>
        <tr>
            <td>5</td>

            <td>Unit Kerja</td>
            <td>
                {{$ap->unit}} / Universitas Negeri Makassar
            </td>
            <td>5</td>

            <td colspan=" 2">Unit Kerja</td>

            <td colspan=" 2">
                {{Auth::user()->unit}} / Universitas Negeri Makassar
            </td>

        </tr>
        <tr class="bgrow">
            <th rowspan="2" style="width: 5%; text-align:center">No</th>
            <th colspan=" 2" rowspan="2" class="text-center" style="width: 45%; text-align:center">III. KEGIATAN TUGAS JABATAN</th>
            <th rowspan="2" style="width: 5%; text-align:center">AK</th>
            <th colspan="4" style="width: 40%; text-align:center">TARGET</th>

        </tr>
        <tr class="bgrow">
            <th style="width: 10%;" class=" tc">Kuantitas</th>
            <th style="width: 10%;" class=" tc">Kualitas</th>
            <th style="width: 10%;" class=" tc">Waktu</th>
            <th style="width: 10%;" class=" tc">Biaya</th>
        </tr>
        @php $no = 1 @endphp
        @foreach($target->getData()->data as $t)
        <tr>
            <td>{{$no++}}</td>
            <td colspan="2">{{$t->tugas}}</td>
            <td class="tc">0</td>
            <td class="tc">{{$t->totalkuan}}</td>
            <td class="tc">100</td>
            <td class="tc">{{$t->waktu}} Bulan</td>
            <td class="tc">Rp. 0</td>
        </tr>
        @endforeach
        <tr class="borderless">
            <td colspan="5">
                <p>Pejabat Penilai,</p>
                <br><br><br>
                <p><u> {{$ap->nama}}</u></p>

                <p>NIP. {{$ap->nip}}</p>

            </td>
            <td colspan="3">
                <p>Makassar, {{$tanggal}}</p>
                <p>PNS Yang Dinilai,</p>
                <br><br><br>
                <p><u> {{Auth::user()->nama}}</u></p>

                <p>NIP. {{Auth::user()->nip}}</p>
            </td>
        </tr>
    </tbody>
</table>
@endsection