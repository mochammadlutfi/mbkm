<x-landing-layout>

    <div class="content content-full">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <!-- Sign In Form -->
                <div class="block block-rounded mt-4">
                    <div class="block-content">
                        <h3 class="fs-lg mb-lg-4 text-center">Masuk</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <x-input-field type="text" id="nim" name="nim" label="NIM" :required="true"/>
                            <x-input-field type="password" id="password" name="password" label="Password" :required="true"/>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-lg mb-2 btn-alt-primary fw-medium w-100">
                                    Masuk
                                </button>
                                <h4 class="fs-base text-center fw-medium">Belum punya akun ?
                                    <a href="{{ route('register') }}">Daftar</a>
                                </h4>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign In Form -->
            </div>
        </div>
    </div>
</x-landing-layout>