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
                                    <th width="400px">Program</th>
                                    <th width="200px">Tgl Daftar</th>
                                    <th class="text-center">Status</th>
                                    <th width="130px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
                processing: true,
                serverSide: true,
                dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: "{{ route('user.program') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'program.nama', name: 'program.nama'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false
                    },
                ]
            });
        </script>
    @endpush
</x-landing-layout>