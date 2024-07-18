<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>Login Admin - Persona Public Speaking</title>

        <meta name="description" content="Persona Public Speaking">
        <meta name="robots" content="noindex, nofollow">
        <!-- Stylesheets -->
        <link rel="stylesheet" id="css-main" href="/css/codebase.min.css">
        @vite(['resources/sass/main.scss', 'resources/js/codebase/app.js',
        'resources/js/app.js'])
    </head>

    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('/images/bg-page.png');">
                    <div class="row mx-0 justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-5">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <!-- END Header -->
                                <div class="text-center">
                                    <img src="/images/logo-white.png" class="w-75">
                                </div>
                                <div class="block block-rounded mt-md-5">
                                    <div class="block-content">
                                        <h1 class="h4 fw-bold mt-0 mb-4">Masuk</h1>
                                        <form method="POST" action="{{ route('admin.login') }}">
                                            @csrf
                                            <x-input-field type="text" id="username" name="username" label="Username"/>
                                            <x-input-field type="password" id="password" name="password" label="Password"/>
                                            <div class="mb-4">
                                            <button type="submit" class="btn btn-lg btn-primary fw-medium w-100">
                                                Login
                                            </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Sign Up Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
    </body>
</html>