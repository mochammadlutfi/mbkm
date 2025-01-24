<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Detail Pendaftaran</span>
            <div class="space-x-1">
                @if($data->status == 'pending')
                <button type="button" class="btn btn-sm btn-primary" onclick="updateStatus('terima')">
                    Terima
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="updateStatus('tolak')">
                    Tolak
                </button>
                @endif
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-4">
                <div class="row">
                    <div class="col-md-6">
                        <x-field-read label="Kode Pendaftaran" value="{{ $data->kode }}"/>
                        <x-field-read label="Program" value="{{ $data->program->nama }}"/>
                        <x-field-read label="Tanggal" value="{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}"/>
                        <x-field-read label="Status">

                            <x-slot name="value">
                                @if($data->status == 'pending')
                                    <span class="badge bg-warning px-3">Pending</span>
                                @elseif($data->status == 'terima')
                                    <span class="badge bg-success px-3">Diterima</span>
                                @elseif($data->status == 'tolak')
                                    <span class="badge bg-danger px-3">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary px-3">Batal</span>
                                @endif
                            </x-slot>
                        </x-field-read>
                    </div>
                    <div class="col-md-6">
                        <x-field-read label="File CV">
                            <x-slot name="value">
                                <a href="{{ $data->cv }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat CV
                                </a>
                            </x-slot>
                        </x-field-read>
                        <x-field-read label="File KTP">
                            <x-slot name="value">
                                <a href="{{ $data->ktp }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat KTP
                                </a>
                            </x-slot>
                        </x-field-read>
                        <x-field-read label="File Transkrip Nilai">
                            <x-slot name="value">
                                <a href="{{ $data->transkrip }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat Transkrip Nilai
                                </a>
                            </x-slot>
                        </x-field-read>
                        <x-field-read label="File Asuransi">
                            <x-slot name="value">
                                <a href="{{ $data->asuransi }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat Asuransi
                                </a>
                            </x-slot>
                        </x-field-read>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <script>
        function updateStatus(sa){
            alert(sa);
        }
        function updateStatus(status){
            var content ='';
            if(status == 'terima'){
                var content = 'Terima pendaftaran?';
            }else{
                var content = 'Tolak pendaftaran?';
            }
            Swal.fire({
                icon : false,
                text: content,
                toast : true,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: `Tidak`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.register.status', $data->id) }}",
                        type: "POST",
                        data : {
                            status : status,
                            _token : $("meta[name='csrf-token']").attr("content"),
                        },
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                            location.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        }
                    });
                }
            })
        }
        // function updateStatus(status){
        //     var content ='';
        //     if(status == 'terima'){
        //         var content = 'Terima pendaftaran?';
        //     }else{
        //         var content = 'Tolak pendaftaran?';
        //     }

        //     $.confirm({
        //         title: 'Konfirmasi Pendaftaran!',
        //         content: content,
        //         buttons: {
        //             cancel: {
        //                 text: 'Tidak',
        //                 btnClass: 'btn-red',
        //             },
        //             confirm: {
        //                 text: 'Ya',
        //                 btnClass: 'btn-primary',
        //                 action : function () {
        //                     $.ajax({
        //                         url: "{{ route('admin.register.status', $data->id) }}",
        //                         type: "POST",
        //                         data : {
        //                             status : status,
        //                             _token : $("meta[name='csrf-token']").attr("content"),
        //                         },
        //                         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //                         success: function(data) {
        //                             location.reload();
        //                         },
        //                         error: function(jqXHR, textStatus, errorThrown) {
        //                         }
        //                     });
        //                 }
        //             },
        //         }
        //     });
        // }
        $(function () {
    });
    </script>
    @endpush

</x-app-layout>

