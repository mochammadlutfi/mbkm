<x-app-layout>
    <div class="content">
        <div class="content-heading d-flex justify-content-between align-items-center">
            <span>Data Mata Kuliah</span>
            <div class="space-x-1">
                <button type="button" class="btn btn-sm btn-primary" onclick="create()">
                    <i class="fa fa-plus me-1"></i>
                    Tambah Mata Kuliah
                </button>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-content p-3">
                <table class="table table-bordered datatable w-100">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>SKS</th>
                            <th>Total Program</th>
                            <th width="160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                    <form id="myForm" method="POST" onsubmit="return false;" enctype="multipart/form-data">
                        <input type="hidden" id="field-id" value=""/>
                        <div class="block block-rounded shadow-none mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Mata Kuliah</h3>
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
                                <div class="mb-4">
                                    <label for="field-kode">Kode</label>
                                    <input type="text" class="form-control" id="field-kode" name="kode">
                                    <div class="invalid-feedback" id="error-kode">Invalid feedback</div>
                                </div>
                                <div class="mb-4">
                                    <label for="field-nama">Nama</label>
                                    <input type="text" class="form-control" id="field-nama" name="nama">
                                    <div class="invalid-feedback" id="error-nama">Invalid feedback</div>
                                </div>
                                <div class="mb-4">
                                    <label for="field-sks">SKS</label>
                                    <input type="number" class="form-control" id="field-sks" name="sks">
                                    <div class="invalid-feedback" id="error-sks">Invalid feedback</div>
                                </div>
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
    </div>
    
    @push('scripts')
        <script>
            $(function () {
                $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'r" +
                            "ow'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    ajax: "{{ route('admin.matkul.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        }, {
                            data: 'kode',
                            name: 'kode'
                        }, {
                            data: 'nama',
                            name: 'nama'
                        }, {
                            data: 'sks',
                            name: 'sks'
                        }, {
                            data: 'program_count',
                            name: 'program_count'
                        }, {
                            data : 'action',
                            name : 'action',
                        }
                    ]
                });
            });

            function create(){
                const form = document.getElementById('modal-form');
                var modalForm = bootstrap.Modal.getOrCreateInstance(form);
                modalForm.show();
            }

            function edit(id){
                $.ajax({
                    url: "/admin/matkul/"+id,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $('#field-id').val(response.id);
                        $('#field-nama').val(response.nama);
                        var el = document.getElementById('modal-form');
                        var myModal = bootstrap.Modal.getOrCreateInstance(el);
                        myModal.show();
                    },
                    error: function (error) {
                    }

                });
            }
            
            function updateStatus(id, status, booking_id){
                // console.log(status);
                $.ajax({
                    url: "/admin/matkul/"+id +"/status",
                    type: "POST",
                    data : {
                        booking_id : booking_id,
                        status : status,
                        _token : $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (response) {
                        // console.log(response);
                        location.reload();
                        var el = document.getElementById('modal-show');
                        $('.datatable').DataTable().ajax.reload();
                        // $("#detailPembayaran").html(response);
                        var myModal = bootstrap.Modal.getOrCreateInstance(el);
                        myModal.hide();
                    },
                    error: function (error) {
                    }
                });
            }
            
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
                            url: "/admin/matkul/"+ id +"/delete",
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
                                        window.location.replace("{{ route('admin.matkul.index') }}");
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

            
        $("#myForm").on("submit",function (e) {
            e.preventDefault();
            var fomr = $('form#myForm')[0];
            var formData = new FormData(fomr);
            let token   = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token);

            var id = $("#field-id").val();
            var url = (id != "") ? "/admin/matkul/"+id+"/update" : "/admin/matkul/store";

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.fail == false) {
                        $('.datatable').DataTable().ajax.reload();
                        const el = document.getElementById('modal-form');
                        var myModal = bootstrap.Modal.getOrCreateInstance(el);
                        myModal.hide();
                        fomr.reset();
                    } else {
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
        </script>
    @endpush

</x-app-layout>

