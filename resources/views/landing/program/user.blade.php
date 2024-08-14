<x-landing-layout>
    <div class="content content-full">
        <div class="py-4 text-center">
            <h2 class="fw-bold mb-2">
                Program Saya
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="block block-rounded">
                    <div class="block-content p-4">
                        <table class="table table-bordered w-100 table-vcenter" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60px">No</th>
                                    <th class="text-center" width="60px">Nomor</th>
                                    <th width="200px">Tgl Daftar</th>
                                    <th width="300px">Program</th>
                                    <th class="text-center">Status</th>
                                    <th width="130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $d->kode }}</td>
                                    <td>{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d F Y H:i') }} WIB</td>
                                    <td>
                                        {{ $d->program->kategori->nama }}<br/>
                                        {{ $d->program->nama }}
                                    </td>
                                    <td>
                                        @if($d->status == 'pending')
                                            <span class="badge bg-warning px-3">Pending</span>
                                        @elseif($d->status == 'terima')
                                            <span class="badge bg-success px-3">Diterima</span>
                                        @elseif($d->status == 'tolak')
                                            <span class="badge bg-danger px-3">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary px-3">Batal</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.program.show', $d->id) }}" class="btn btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            $('#datatable').DataTable({
                dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        </script>
    @endpush
</x-landing-layout>