<html>

<head>
    <title>Konversi Nilai {{ $data->daftar->kode }}</title>

    <link rel="stylesheet" href="/css/bootstrap.css">
    <style>

        #header {
            width: 100%;
            background-color: #dff6ff;
        }

        #header tr td {
            padding: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table id="header">
            <tr>
                <td width="40%" class="text-center">
                    <img src="/images/logo2.png" width="300px;">
                    <h3 style="font-size: 16pt;">UNIVERSITAS KOMPUTER INDONESIA</h3>
                </td>
                <td width="60%">
                    <h1 style="text-align:left;margin-bottom: 5px;font-size:16pt;font-weight: bold;">PROGRAM STUDI</h1>
                    <h1 style="margin-bottom: 5px;font-size:20pt;font-weight: bold;">SISTEM INFORMASI</h1>
                </td>
            </tr>
        </table>
        <span style="border:1px solid black; padding;20pt">
            FORM KONVERSI NILAI PROGRAM MBKM 
        </span>

        <p>Lampiran 1 - Form Konversi Nilai Program MBKM (PMM2)</p>
        <br/>
        <br/>
        <br/>
        <p>Ketua Program Studi Sistem Informasi dan PIC Program MBKM PMM 2, telah melaksanakan koordinasi dan verifikasi
            atas penyetaraan (konversi) nilai Program MBKM ke nilai Mata Kuliah Program Studi sesuai dengan KRS
            mahasiswa pelaksana MBKM sebagai berikut:
        </p>
        <br/>
        <table width="100%">
            <tr>
                <td width="40%">Nama </td>
                <td width="2%">:</td>
                <td>{{ $data->daftar->user->nama }}</td>
            </tr>
            <tr>
                <td>NIM </td>
                <td>:</td>
                <td>{{ $data->daftar->user->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi </td>
                <td>:</td>
                <td>Sistem Informasi</td>
            </tr>
            <tr>
                <td>Nama Program Studi / PT Mitra</td>
                <td>:</td>
                <td>{{ $data->daftar->program->mitra }}</td>
            </tr>
        </table>
        <br/>
        <p>
            Menetapkan bahwa mahasiswa tersebut berhak mendapatkan mendapatkan penyetaraan nilai mata kuliah dengan
            rincian mata kuliah, sebagai berikut
        </p>
        <br/>

        <table class="table table-bordered table-vcenter" id="tableKonversi">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">
                        Matakuliah yang diampu di Prodi Mitra dan Nilai dari Prodi Mitra
                    </th>
                    <th colspan="3" class="text-center">
                        Matakuliah di KRS dan Transkrip Hasil Konversi 
                    </th>
                </tr>
                <tr>
                    <td width="90px">
                        No
                    </td>
                    <td width="250px">
                        Mata Kuliah 
                    </td>
                    <td width="80px">SKS</td>
                    <td width="100px">
                        Nilai 
                    </td>
                    <td width="250px">
                        Mata Kuliah 
                    </td>
                    <td width="80px">SKS</td>
                    <td width="100px">
                        Nilai 
                    </td>
                </tr>
            </thead>
            <tbody>
                @php
                    $sks_mitra = 0;
                    $sks = 0;
                @endphp
                @foreach ($data->detail as $line)
                <tr class="row-0">
                    <td>{{ $loop->index+1 }}</td>
                    <td>
                        {{ $line->mitra_matkul->nama }}
                    </td>
                    <td>
                        {{ $line->mitra_matkul->sks }}
                    </td>
                    <td>
                        {{ $line->mitra_nilai}}
                    </td>
                    <td>
                        {{ $line->matkul->nama }}
                    </td>
                    <td>
                        {{ $line->matkul->sks }}
                    </td>
                    <td>
                        {{ $line->nilai }}
                    </td>
                </tr>
                @php
                    $sks_mitra += $line->mitra_matkul->sks;
                    $sks = $line->matkul->sks;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-body">
                    <td colspan="2">Total SKS yang diperkenankan</td>
                    <td>
                        <span class="totalMitraSKS">{{ $sks_mitra }}</span>
                    </td>
                    <td></td>
                    <td>Total SKS yang disertakan</td>
                    <td>
                        <span class="totalSKS">{{ $sks}}</span>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <br/>
        <p>*) Berupa Huruf Mutu (A,B,C,D,E)</p>
        {{-- <hr/> --}}
        <br/>
        <br/>
        <table width="100%" class="text-center">
            <tr>
                <td colspan="2">
                    Bandung, {{\Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}<br/>
                    Menyetujui,
                </td>
            </tr>
            <tr>
                <td>PIC Program MBKM</td>
                <td>Ketua Program Studi Sistem Informasi</td>
            </tr>
            <tr>
                <td>
                    <br/>
                    <br/>
                    <br/>
                </td>
                <td>
                    <br/>
                    <br/>
                    <br/>
                </td>
            </tr>
            <tr>
                <td>

                </td>
            </tr>
        </table>
    </div>

</body>

</html>