<x-landing-layout>
    <div class="content">
        <div class="py-5 text-center">
            <h1 class="fw-bold">Ubah Password</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-content p-3">
                        <form method="POST" action="{{ route('profil.password') }}">
                            @csrf                                   
                            <x-input-field type="password" id="password" name="password" label="Password" :required="true"/>

                            <button type="submit" class="btn btn-primary fw-medium">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>