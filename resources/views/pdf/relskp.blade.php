<!DOCTYPE html>
<html lang="en">

<head>




    <style>
        .tc {
            text-align: center;
            padding: 0;
        }

        html {
            margin-top: 10px;
            margin-bottom: 10px;
            margin-left: 10px;
            margin-right: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid black;
            text-align: left;
            padding: 0px;
        }


        tr.borderless td {
            border: 0;
        }

        tr.bgrow {
            background-color: #dddddd;
            font-size: 12px;
        }
    </style>
    <!-- icons -->
</head>

<body>

    <h3 class="" style="text-align: center;">PENILAIAN CAPAIAN SASARAN KERJA <br>PEGAWAI NEGERI SIPIL</h3>

    <p>{{$periode}}</p>

    <table class="table table-bordered table-hover table-striped">
        <thead>

        </thead>
        <tbody>

            <tr class="bgrow">
                <th rowspan="2" style="width: 2%; text-align:center">No</th>
                <th rowspan="2" class="text-center" style="width: 28%; text-align:center">I. KEGIATAN TUGAS JABATAN</th>
                <th rowspan="2" style="width: 4%; text-align:center">AK</th>
                <th colspan="4" style="width: 20%; text-align:center">TARGET</th>
                <th rowspan="2" style="width: 4%; text-align:center">AK</th>
                <th colspan="4" style="width: 20%; text-align:center">REALISASI</th>
                <th rowspan="2" style="width: 10%; text-align:center">PENGHITUNGAN</th>
                <th rowspan="2" style="width: 7%; text-align:center">NILAI CAPAIAN SKP</th>

            </tr>
            <tr class="bgrow">
                <th style="width: 5%;" class=" tc">Kuan</th>
                <th style="width: 5%;" class=" tc">Kual</th>
                <th style="width: 5%;" class=" tc">Waktu</th>
                <th style="width: 5%;" class=" tc">Biaya</th>
                <th style="width: 5%;" class=" tc">Kuan</th>
                <th style="width: 5%;" class=" tc">Kual</th>
                <th style="width: 5%;" class=" tc">Waktu</th>
                <th style="width: 5%;" class=" tc">Biaya</th>
            </tr>
            @php $no = 1; $nilaitotal=0; @endphp
            @foreach($realisasi->getData()->data as $t)
            <tr>
                <td class="tc">{{$no++}}</td>
                <td>{{$t->tugas}}</td>
                <td class="tc">0</td>
                <td class="tc">{{$t->totalkuan}}</td>
                <td class="tc">100</td>
                <td class="tc">{{$t->waktu}} Bulan</td>
                <td class="tc">Rp. 0</td>
                <td class="tc">0</td>
                <td class="tc">{{$t->totalkuanr}}</td>
                <td class="tc">{{$t->totalcapai}}</td>
                <td class="tc">{{$t->statusbulan}} Bulan</td>
                <td class="tc">Rp. 0</td>
                <td class="tc">{{$t->hbk}}</td>
                <td class="tc">{{ number_format((float)($t->hbk / 3), 2, '.', '') }}</td>
                @php $nilaitotal += number_format((float)($t->hbk / 3), 2, '.', '') @endphp
            </tr>
            @endforeach
            <tr>
                <td></td>
                <th colspan="13" class="text-center" style="text-align:left"> II. TUGAS TAMBAHAN & KREATIVITAS</th>
            </tr>
            <tr>
                <td class="tc">1</td>
                <td>(tugas tambahan)</td>
                <td colspan="10">{{$tugast ?? ''}}</td>
                <td class="tc"></td>
                <td class="tc">{{$nilait ?? ''}}</td>

            </tr>
            <tr>
                <td class="tc">1</td>
                <td>(kreativitas)</td>
                <td colspan="10">{{$kreatif ?? ''}}</td>
                <td class="tc"></td>
                <td class="tc">{{$nilaik ?? ''}}</td>

            </tr>
            <tr>
                <th class="tc" colspan="13">NILAI CAPAIAN SKP</th>

                <th class="tc">{{($nilaitotal/ ($no-1)) + ($nilaik ?? 0 ) + ($nilait ??0 )}}</th>

            </tr>
            <tr class="borderless">
                <td colspan="10"></td>
                <td colspan="4">
                    <p>Makassar, {{$tanggal}}</p>
                    <p>Pejabat Penilai,</p>
                    <br><br><br>
                    <p><u> {{$ap->nama}}</u></p>

                    <p>NIP. {{$ap->nip}}</p>

                </td>

            </tr>
        </tbody>
    </table>





    <!-- App js -->

</body>

</html>