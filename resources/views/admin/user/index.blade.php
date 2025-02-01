<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Data Mahasiswa</span>
            <div class="space-x-1">
                <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Mahasiswa
                </a>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Email</th>
                            <th width="60px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
        class="modal"
        id="modal-form"
        aria-labelledby="modal-form"
        style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formData" method="POST" onsubmit="return false;">
                    <input type="hidden" id="field-id" value=""/>
                    <div class="block block-rounded shadow-none mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Ubah Password</h3>
                            <div class="block-options">
                                <button
                                    type="button"
                                    class="btn-block-option"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <x-input-field type="password" id="password" name="password" label="Password Baru" isAjax/>
                            <x-input-field type="password" id="password_confirmation" name="password_confirmation" label="Konfirmasi Password" isAjax/>
                        </div>
                        <div
                            class="block-content block-content-full block-content-sm text-end border-top">
                            <button type="button" class="btn btn-alt-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-alt-primary" id="btn-simpan">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    dom : "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    ajax: "{{ route('admin.user.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'hp', name: 'hp'},
                        {data: 'email', name: 'email'},
                        {data: 'created_at', name: 'created_at'},
                        {
                            data: 'action', 
                            name: 'action', 
                            orderable: true, 
                            searchable: true
                        },
                    ]
                });

                $("#formData").on("submit",function (e) {
                    e.preventDefault();
                    var fomr = $('form#formData')[0];
                    var formData = new FormData(fomr);
                    let token   = $("meta[name='csrf-token']").attr("content");
                    formData.append('_token', token);

                    $("#modal-form .block").addClass('block-mode-loading');

                    let id = $('#field-id').val();

                    $.ajax({
                        url: `/admin/mahasiswa/${id}/password`,
                        type: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        complete : function(e){
                            $("#modal-form .block").removeClass('block-mode-loading');
                        },
                        success: function (response) {
                            if (response.fail == false) {
                                var myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-form'));
                                myModal.hide();
                            } else {
                                $(this).find('input').removeClass('is-invalid');
                                for (control in response.errors) {
                                    $('#field-' + control).addClass('is-invalid');
                                    $('#error-' + control).html(response.errors[control]);
                                }
                            }
                        },
                        error: function (error) {
                        }
                    });

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
        
        function openModal(id){
            $('#field-id').val(id);
            $('#field-password').val('');
            $('#field-password_confirmation').val('');
            var modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-form'),{
                backdrop : 'static',
                keyboard : false
            });
            modalForm.show();
        }
        </script>
    @endpush

</x-app-layout>

