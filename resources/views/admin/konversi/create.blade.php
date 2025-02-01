<x-app-layout>
    @push('styles')
    @endpush

    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Tambah Konversi</span>
            <div class="space-x-1">
            </div>
        </div>
        <form method="POST" action="{{ route('admin.konversi.store') }}">
            @csrf
            <div class="block block-rounded">
                <div class="block-content p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <x-select-field name="user_id" id="user_id" placeholder="Pilih" label="Mahasiswa" :options="$mahasiswa"/>
                        </div>
                        <div class="col-md-4">
                            <x-select-field id="user_program_id" label="No Pendaftaran" placeholder="Pilih" name="user_program_id" :options="[]" disabled/>
                        </div>
                        <div class="col-md-4">
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
                                    <select class="form-control mitra_matkul" required name="lines[0][mitra_matkul_id]">
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
                                    <input type="text" name="lines[0][mitra_nilai]" class="form-control mitra_nilai"/>
                                </td>
                                <td>
                                    <select class="form-control matkul required" name="lines[0][matkul_id]">
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
                                    <input type="text" name="lines[0][nilai]" class="form-control nilai" required/>
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
        var konversiHuruf = {
            "A+": "A", "A-": "A", "AB": "A", "A": "A",
            "B+": "B", "B-": "B", "BC": "B", "B": "B",
            "C+": "C", "C-": "C", "CD": "C", "C": "C",
            "D+": "D", "D-": "D", "D": "D",
            "E+": "E", "E-": "E", "E": "E",
            "F": "F"
        };

        function konversiAngka(nilai) {
            if (nilai >= 85 && nilai <= 100) return "A";
            if (nilai >= 70 && nilai < 85) return "B";
            if (nilai >= 56 && nilai < 70) return "C";
            if (nilai >= 40 && nilai < 56) return "D";
            if (nilai >= 0 && nilai < 40) return "E";
            return nilai;
        }

        $(document).on("input", "input.mitra_nilai", function() {
            var nilaiMitra = $(this).val().toUpperCase().trim(); 

             // **Batasan input: hanya A-E, F, +, - dan maksimal 2 karakter**
            if (!/^(A\+?|A-|AB|B\+?|B-|BC|C\+?|C-|CD|D\+?|D-|D|E\+?|E-|E|F|\d{1,3})?$/.test(nilaiMitra)) {
                Swal.fire({
                    icon: "error",
                    title: "Input tidak valid!",
                    text: "Hanya boleh A-E, F, +, -, atau angka 0-100.",
                    confirmButtonText: "OK"
                });
                $(this).val(""); // Kosongkan input
                return;
            }

            // **Jika panjang lebih dari 2 karakter, hapus karakter terakhir**
            if (nilaiMitra.length > 2 && isNaN(nilaiMitra)) {
                $(this).val(nilaiMitra.substring(0, 2));
                return;
            }

            var nilaiKonversi = null;

            if ($.isNumeric(nilaiMitra)) { // Jika input adalah angka
                nilaiKonversi = konversiAngka(parseInt(nilaiMitra));
            } else if (konversiHuruf[nilaiMitra]) { // Jika input adalah huruf dalam daftar
                nilaiKonversi = konversiHuruf[nilaiMitra];
            }

            // Jika nilai tidak valid, kosongkan input dan tampilkan SweetAlert
            if (nilaiKonversi === null) {
                Swal.fire({
                    icon: "error",
                    title: "Nilai tidak valid!",
                    text: "Silakan masukkan nilai sesuai daftar konversi.",
                    confirmButtonText: "OK"
                });
                $(this).val(""); // Kosongkan input
                return;
            }
            var parentRow = $(this).closest("tr");
            parentRow.find("input.nilai").val(nilaiKonversi);
        });

        $('#field-user_id').select2();
        $('#field-user_program_id').select2({
            ajax: {
                url: "{{ route('admin.register.select') }}",
                type: 'POST',
                dataType: 'JSON',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term,
                        user_id : $('#field-user_id').val()
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#field-user_id").on("change", function(e){
            e.preventDefault();
            var id = $(this).val();
            $("#field-user_program_id").trigger('clear');
            if(id){
                $("#field-user_program_id").prop("disabled", false);
            }else{
                $("#field-user_program_id").prop( "disabled", true );
            }
        });
        
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
                        <select class="form-control mitra_matkul" required name="lines[${idx}][mitra_matkul_id]">
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
                        <input type="text" name="lines[${idx}][mitra_nilai]" class="form-control mitra_nilai"/>
                    </td>
                    <td>
                        <select class="form-control matkul" required name="lines[${idx}][matkul_id]">
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
                        <input type="text" name="lines[${idx}][nilai]" required class="form-control nilai"/>
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

