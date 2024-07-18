<x-landing-layout>
    <div class="content content-full">
        <div class="py-3 text-center">
            <h2 class="fw-bold mb-2">
                Daftar Program
            </h2>
            <p class="text-muted fw-medium mb-4">
                Informasi penyelenggaraan Merdeka Belajar bagi seluruh mahasiswa Universitas Komputer Indonesia
            </p>
        </div>
        <form action="{{ route('program.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <x-select-field id="skema" placeholder="Pilih" name="skema" :options="[
                        ['label' => 'Onsite', 'value' => 'Onsite'],
                        ['label' => 'Remote', 'value' => 'Remote'],
                        ['label' => 'Terkadang Remote, Terkadang Onsite', 'value' => 'Terkadang Remote, Terkadang Onsite'],
                    ]" label="Skema Program" value="{{ request('skema')}}"/>
                </div>
                <div class="col-md-3">
                    <x-select-field id="jenis" placeholder="Pilih" name="jenis" value="{{ request('jenis')}}" :options="$kategori" label="Jenis"/>
                </div>
                <div class="col-md-3">
                    <x-input-field type="text" id="q" name="q" label="Nama / Lokasi Program" value="{{ request('q')}}"/>
                </div>
                <div class="col-md-3 pt-md-1">
                    <button type="submit" class="btn btn-primary mt-4 w-100">Filter</button>
                </div>
            </div>
        </form>
        <div class="row g-2 py-2">
            @foreach ($data as $d)
                <div class="col-md-4">
                    <x-card-program :data="$d" />
                </div>
            @endforeach
        </div>
    </div>
</x-landing-layout>