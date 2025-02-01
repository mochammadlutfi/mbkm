<x-landing-layout>

    <div class="content content-full">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Sign In Form -->
                <div class="block block-rounded mt-4">
                    <div class="block-header border-bottom border-3">
                        <h3 class="block-title">Buat Akun</h3>
                    </div>
                    <div class="block-content">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input-field type="text" id="nim" name="nim" label="NIM" :required="true"/>
                                    <x-input-field type="text" id="email" name="email" label="Alamat Email" :required="true"/>
                                    <x-input-field type="password" id="password" name="password" label="Password" :required="true"/>
                                </div>
                                <div class="col-md-6">
                                    <x-input-field type="text" id="nama" name="nama" label="Nama Lengkap" :required="true"/>
                                    <x-input-field type="text" id="hp" name="hp" label="No HP" :required="true"/>
                                    <x-input-field type="password" id="password_conf" name="password_conf" label="Konfirmasi Password" :required="true"/>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-lg mb-2 btn-alt-primary fw-medium w-100">
                                    Register
                                </button>
                                <h4 class="fs-base text-center fw-medium">Sudah punya akun ?
                                    <a href="{{ route('login') }}">Masuk</a>
                                </h4>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign In Form -->
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#field-nim").on("input", function() {
                    var maxLength = $(this).attr("maxlength") || 8; // Ambil batasan dari atribut maxlength atau default 10 karakter
                    var nilai = $(this).val();

                    // Hapus karakter yang bukan angka
                    nilai = nilai.replace(/[^0-9]/g, "");

                    // Batasi panjang karakter
                    if (nilai.length > maxLength) {
                        nilai = nilai.substring(0, maxLength);
                    }

                    $(this).val(nilai);
                });
                $("#field-hp").on("input", function() {
                    var maxLength = $(this).attr("maxlength") || 13; // Ambil batasan dari atribut maxlength atau default 10 karakter
                    var nilai = $(this).val();

                    // Hapus karakter yang bukan angka
                    nilai = nilai.replace(/[^0-9]/g, "");

                    // Batasi panjang karakter
                    if (nilai.length > maxLength) {
                        nilai = nilai.substring(0, maxLength);
                    }

                    $(this).val(nilai);
                });
            });


        </script>
    @endpush
</x-landing-layout>