<x-app-layout>

    <div class="content">
        <div class="row">
            <!-- Row #1 -->
            <div class="col-6 col-xl-4">
                <a
                    class="block block-rounded block-link-rotate text-end"
                    href="{{ route('admin.user.index') }}">
                    <div
                        class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                        <div class="d-none d-sm-block">
                            <i class="fa fa-users fa-2x opacity-25"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-3 fw-semibold">{{ $ovr['user']}}</div>
                            <div class="fs-sm fw-semibold text-uppercase text-muted">Peserta</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-4">
                <a
                    class="block block-rounded block-link-rotate text-end"
                    href="{{ route('admin.program.index') }}">
                    <div
                        class="block-content block-content-full d-sm-flex justify-content-between align-items-center">
                        <div class="d-none d-sm-block">
                            <i class="fa fa-book fa-2x opacity-25"></i>
                        </div>
                        <div class="text-end">
                            <div class="fs-3 fw-semibold">{{ $ovr['program'] }}</div>
                            <div class="fs-sm fw-semibold text-uppercase text-muted">Program</div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>
        
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="400px">Judul</th>
                            <th width="230px">Tgl Mulai</th>
                            <th width="230px">Tgl Selesai</th>
                            <th>Peserta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berlangsung as $d)
                        <tr class="bg-success">
                            <td>{{ $d->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->tgl_mulai)->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->tgl_selesai)->translatedFormat('d F Y') }}</td>
                            <td>{{ $d->user_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            
            $(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: false,
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        </script>
    @endpush
</x-app-layout>