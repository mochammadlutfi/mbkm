<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Detail Konversi</span>
            <div class="space-x-1">
                <a href="{{ route('admin.konversi.pdf', $data->id)}}" class="btn btn-primary btn-sm ">
                    Download PDF
                </a>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <div class="row">
                    <div class="col-md-6">
                        <x-field-read label="Kode Pendaftaran" value="{{ $data->daftar->kode }}"/>
                        <x-field-read label="Nama Mahasiswa" value="{{ $data->daftar->user->nama }}"/>
                        <x-field-read label="Program" value="{{ $data->daftar->program->nama }}"/>
                        <x-field-read label="Tanggal" value="{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}"/>

                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <table class="table table-bordered table-vcenter" id="tableKonversi">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">
                                Matakuliah yang diampu di Prodi Mitra dan Nilai dari Prodi Mitra
                            </th>
                            <th colspan="4" class="text-center">
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
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
    </script>
    @endpush

</x-app-layout>

