<x-landing-layout>
    <div class="content content-full">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="block block-bordered rounded">
                    <div class="block-content p-3 border-4 border-bottom">
                        <h1 class="fs-2 fw-bold mb-2">{{ $data->nama }}</h1>
                        <h3 class="fs-sm fw-medium mb-3">{{ $data->mitra }}</h3>
                        <p class="text-muted fs-sm"> <i class="fa fa-map-pin me-2"></i>
                            {{ $data->lokasi }} ({{ $data->skema }})</p>
                        
                        <div class="d-flex mb-3">
                            <div class="d-flex me-4">
                                <div class="me-2">
                                    <i class="fa fa-2x fa-calendar-alt"></i>
                                </div>
                                <div class="fs-sm">
                                    <div class="fw-medium">Tanggal Pendaftaran</div>
                                    <div class="text-muted">
                                        <x-format-date :mulai="$data->tgl_mulai_daftar" :selesai="$data->tgl_selesai_daftar" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="me-2">
                                    <i class="fa fa-2x fa-calendar-alt"></i>
                                </div>
                                <div class="fs-sm">
                                    <div class="fw-medium">Tanggal Pelaksanaan</div>
                                    <div class="text-muted">
                                        <x-format-date :mulai="$data->tgl_mulai" :selesai="$data->tgl_selesai" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->guard('web')->check())
                            @if ($register)
                            <button class="btn btn-secondary" disabled>
                                Sudah Mendaftar
                            </button>
                            @else
                            <form action="{{ route('program.register') }}" method="POST">
                                @csrf
                                <input type="hidden" name="program_id" value="{{ $data->id }}"/>
                                <button class="btn btn-primary">
                                    Daftar Sekarang
                                </button>
                            </form>
                            @endif
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Daftar Sekarang
                        </a>
                        @endif
                    </div>
                    <div class="block-content p-3">
                        {!! $data->deskripsi !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="fs-3 fw-bold mb-3">Program Lainnya</h2>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" integrity="sha512-lteuRD+aUENrZPTXWFRPTBcDDxIGWe5uu0apPEn+3ZKYDwDaEErIK9rvR0QzUGmUQ55KFE2RqGTVoZsKctGMVw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            $('#clock').countdown('2020/10/10 12:34:56')
                .on('update.countdown', function(event) {
                var format = '%H:%M:%S';
                if(event.offset.totalDays > 0) {
                    format = '%-d day%!d ' + format;
                }
                if(event.offset.weeks > 0) {
                    format = '%-w week%!w ' + format;
                }
                $(this).html(event.strftime(format));
                })
                .on('finish.countdown', function(event) {
                $(this).html('This offer has expired!')
                    .parent().addClass('disabled');

                });
        </script>
    @endpush
</x-landing-layout>