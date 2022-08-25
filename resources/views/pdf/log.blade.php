@extends('pdf.layouts')

@section('content')
<h3 class="" style="text-align: center;">LAPORAN HARIAN</h3>


<table class="table p table-bordered table-hover table-striped">

    <tbody>
        <tr class="">
            <th style="width: 20%;" class="p">Nama</th>
            <th class="p">{{Auth::user()->nama}}</th>
        </tr>
        <tr class="">
            <th class="p">NIP</th>
            <th class="p">{{Auth::user()->nip}}</th>
        </tr>
        <tr class="">
            <th class="p">Jabatan</th>
            <th class="p">{{Auth::user()->jabatan ?? $jabatan->jabatan}}</th>
        </tr>
        <tr class="">
            <th class="p">Unit Kerja</th>
            <th class="p"> {{Auth::user()->unit}} / Universitas Negeri Makassar</th>
        </tr>
    </tbody>
</table>
<br>
<table class="p">
    <tbody>
        <tr class="">
            <th style="width: 5%; text-align:center">NO</th>
            <th class="text-center" style="width: 12%; text-align:center">TANGGAL KERJA</th>
            <th class="text-center" style="width: 12%; text-align:center">TANGGAL INPUT
            <th class="text-center" style="width: 38%; text-align:center">KEGIATAN TUGAS JABATAN</th>
            <th class="text-center" style="width: 10%; text-align:center">OUTPUT</th>
            <th class="text-center" style="width: 38%; text-align:center">KETERANGAN</th>
        </tr>
        @php $no = 1 @endphp

        @foreach($log->getData()->data as $t)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$t->inputtgl}}</td>
            <td>{{$t->tanggal}}</td>
            <td>{{$t->kegiatan}}</td>
            <td>{{$t->output}}</td>
            <td>{{$t->ket}}</td>

        </tr>
        @endforeach
        <tr class="borderless">
            <td colspan="5"></td>
            <td>
                <p>Makassar, {{$tanggal}}</p>
                <p>Pegawai Yang Bersangkutan,</p>
                <br><br><br>
                <p><u> {{Auth::user()->nama}}</u></p>

                <p>NIP. {{Auth::user()->nip}}</p>

            </td>

        </tr>
    </tbody>
</table>
@endsection