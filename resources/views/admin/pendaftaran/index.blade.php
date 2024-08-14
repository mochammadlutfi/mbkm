<x-app-layout>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <div class="block-title">Data Pendaftaran</div>
                <div class="block-options">
                    
                </div>
            </div>
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>No Pendaftaran</th>
                            <th>Tgl Daftar</th>
                            <th>Mahasiswa</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th width="60px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $d->kode }}</td>
                            <td>{{ \Carbon\Carbon::parse($d->created_at)->translatedFormat('d F Y H:i') }} WIB</td>
                            <td>
                                {{ $d->user->nim }}<br>
                                {{ $d->user->nama }}
                            </td>
                            <td>
                                {{ $d->program->kategori->nama }}<br/>
                                {{ $d->program->nama }}
                            </td>
                            <td>{{ $d->status }}</td>
                            <td>
                                <a href="{{ route('admin.register.show', $d->id) }}">
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
    
    @push('scripts')
        <script>
            $(function () {
                $('.datatable').DataTable({
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            });
        function hapus(id){
            Swal.fire({
                icon : 'warning',
                text: 'Hapus Data?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: `Tidak, Jangan!`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/pelanggan/"+ id +"/delete",
                        type: "DELETE",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                            if(data.fail == false){
                                Swal.fire({
                                    toast : true,
                                    title: "Berhasil",
                                    text: "Data Berhasil Dihapus!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'success',
                                    position : 'top-end'
                                }).then((result) => {
                                    window.location.replace("{{ route('admin.user.index') }}");
                                });
                            }else{
                                Swal.fire({
                                    toast : true,
                                    title: "Gagal",
                                    text: "Data Gagal Dihapus!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'error',
                                    position : 'top-end'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    toast : true,
                                    title: "Gagal",
                                    text: "Terjadi Kesalahan Di Server!",
                                    timer: 1500,
                                    showConfirmButton: false,
                                    icon: 'error',
                                    position : 'top-end'
                                });
                        }
                    });
                }
            })
        }
        </script>
    @endpush

</x-app-layout>

