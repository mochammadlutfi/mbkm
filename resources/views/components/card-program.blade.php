@props([
    'data' => null
])
<a class="block block-bordered block-rounded" href="{{ route('program.show', $data->slug) }}">
    <div class="block-content p-3">
        <h2 class="fs-4 fw-bold mb-1">
            {{ $data->nama }}
        </h2>
        <h3 class="fs-base fw-semibold mb-2">
            {{ $data->mitra }}
        </h3>
        <div class="text-muted fs-sm">
            <i class="fa fa-map-pin opacity-50 me-1"></i>
            {{ $data->lokasi }}
        </div>
    </div>
    <div class="block-content p-3 border-top border-3 flex-grow-0">
        <div class="text-muted fs-sm fw-semibold mb-2">
            <i class="fa fa-fw fa-calendar-alt opacity-50 me-1"></i>
            Pendaftaran : <x-format-date :mulai="$data->tgl_mulai_daftar" :selesai="$data->tgl_selesai_daftar"/>
        </div>
        <div class="text-muted fs-sm fw-semibold mb-2">
            <i class="fa fa-fw fa-calendar-alt opacity-50 me-1"></i>
            Pelaksanaan : <x-format-date :mulai="$data->tgl_mulai" :selesai="$data->tgl_selesai"/>
        </div>
    </div>
</a>