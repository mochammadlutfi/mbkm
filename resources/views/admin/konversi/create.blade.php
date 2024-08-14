<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
        <form method="POST" action="{{ route('admin.konversi.store') }}">
            @csrf
            <div class="block block-rounded">
                <div class="block-header">
                    <div class="block-title">Tambah Konversi</div>
                    <div class="block-options">
                    </div>
                </div>
                <div class="block-content p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <x-select-field name="user_program_id" id="user_program_id" placeholder="Pilih" label="No Pendaftaran" :options="$daftar"/>
                        </div>
                        <div class="col-md-6">
                            <x-input-field type="text" name="tgl" label="Tanggal" id="tgl"/>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-vcenter" id="tableKonversi">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">
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
                                <td>
                                    Aksi
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="row-0">
                                <td>
                                    1
                                </td>
                                <td>
                                    <select class="form-control mitra_matkul" name="lines[0][mitra_matkul_id]">
                                        <option value="">Pilih</option>
                                        @foreach ($matkul as $m)
                                            <option value="{{ $m->id}}" data-sks="{{ $m->sks}}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <span class="showMitraSKS">0</span>
                                </td>
                                <td>
                                    <input type="text" name="lines[0][mitra_nilai]" class="form-control"/>
                                </td>
                                <td>
                                    <select class="form-control matkul" name="lines[0][matkul_id]">
                                        <option value="">Pilih</option>
                                        @foreach ($matkul as $m)
                                            <option value="{{ $m->id}}" data-sks="{{ $m->sks}}">{{ $m->nama }}</option>
                                        @endforeach
                                    </select> 
                                </td>
                                <td>
                                    <span class="showSKS">0</span>
                                </td>
                                <td>
                                    <input type="text" name="lines[0][nilai]" class="form-control"/>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger btn_delete">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-body">
                                <td colspan="2">Total SKS yang diperkenankan</td>
                                <td>
                                    <span class="totalMitraSKS">0</span>
                                </td>
                                <td></td>
                                <td>Total SKS yang disertakan</td>
                                <td>
                                    <span class="totalSKS">0</span>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <button type="button" class="btn btn-primary w-100" onclick="addRow()">
                                        Tambah
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        $('#field-user_id').select2();

        let idx = 1;
        var table = $("#tableKonversi");
        $(document).on('change', '.mitra_matkul', function() {
                var val = $(this).val();
                var sks = $(this).find(':selected').attr('data-sks') ?? 0;
                var tr = $(this).closest('tr');
                tr.find('.showMitraSKS').html(sks);
            });

        $(document).on('change', '.matkul', function() {
            var val = $(this).val();
            var sks = $(this).find(':selected').attr('data-sks') ?? 0;
            var tr = $(this).closest('tr');
            tr.find('.showSKS').html(sks);
        });

        
        function addRow(){

            var row = `
                <tr class="row-${idx}">
                    <td>${idx+1}</td>
                    <td>
                        <select class="form-control mitra_matkul" name="lines[${idx}][mitra_matkul_id]">
                            <option value="">Pilih</option>
                            @foreach ($matkul as $m)
                                <option value="{{ $m->id}}" data-sks="{{ $m->sks}}">{{ $m->nama }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td>
                        <span class="showMitraSKS">0</span>
                    </td>
                    <td>
                        <input type="text" name="lines[${idx}][mitra_nilai]" class="form-control"/>
                    </td>
                    <td>
                        <select class="form-control matkul" name="lines[${idx}][matkul_id]">
                            <option value="">Pilih</option>
                            @foreach ($matkul as $m)
                                <option value="{{ $m->id}}" data-sks="{{ $m->sks}}">{{ $m->nama }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td>
                        <span class="showSKS">0</span>
                    </td>
                    <td>
                        <input type="text" name="lines[${idx}][nilai]" class="form-control"/>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger btn_delete">
                            Hapus
                        </button>
                    </td>
                </tr>`;

            table.find("tbody").append(row);
            idx +=1;
            }
            
        $(document).on('click', '.btn_delete', function() {
            $(this).closest('tr').remove();
            idx -=1;
        });

        $("#field-tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate : new Date(),
            minDate: "today"
        });

        function formatRupiah(angka, prefix){
            var number_string = angka.toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
    </script>
    @endpush
</x-app-layout>

