<x-landing-layout>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="py-5 text-center">
                    <h2 class="fw-bold mb-2">
                        Profil
                    </h2>
                </div>
                <div class="block block-rounded">
                    <div class="block-content p-3">
                        <form method="post" action="{{ route('profil.edit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input-field type="text" id="nim" name="nim" label="NIM" :required="true" value="{{ $data->nim }}"/>
                                    <x-input-field type="text" id="email" name="email" label="Alamat Email" :required="true"  value="{{ $data->email }}"/>
                                </div>
                                <div class="col-md-6">
                                    <x-input-field type="text" id="nama" name="nama" label="Nama Lengkap" :required="true" value="{{ $data->nama }}"/>
                                    <x-input-field type="text" id="hp" name="hp" label="No HP" :required="true" value="{{ $data->hp }}"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>