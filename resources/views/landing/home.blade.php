<x-landing-layout>
    <div class="content content-full">
        
    <div class="row g-6 w-100 py-7 overflow-hidden">
        <div class="col-md-5 order-md-last py-4 d-md-flex align-items-md-center justify-content-md-end">
          <img class="img-fluid" src="/images/kampus_merdeka.png" alt="Hero Promo">
        </div>
        <div class="col-md-7 py-4 d-flex align-items-center">
          <div class="text-center text-md-start">
            <h1 class="fw-bold fs-2 mb-3">
                Merdeka Belajar Kampus Merdeka
            </h1>
            <p class="text-muted fw-medium mb-4">
                Kampus Merdeka merupakan bagian dari kebijakan Merdeka Belajar oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia yang memberikan kesempaatan bagi mahasiswa/i untuk mengasah kemampuan sesuai bakat dan minat dengan terjun langsung ke dunia kerja sebagai persiapan karier masa depan.
            </p>
            <a class="btn btn-alt-primary py-3 px-4" href="{{ route('program.index')}}">
              <i class="fa fa-arrow-right opacity-50 me-1"></i> Cari Program
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="position-relative bg-body-light">
        <div class="position-absolute top-0 end-0 bottom-0 start-0 bg-white skew-y-1"></div>
        <div class="position-relative">
            <div class="content content-full">
                <div class="pt-5 pb-5">
                    <div class="pb-4 position-relative">
                        <h2 class="fw-bold mb-2 text-center">
                            Program <span class="text-primary">Terbaru</span>
                        </h2>
                        <p class="fw-medium text-muted text-center">
                            Informasi penyelenggaraan Merdeka Belajar bagi seluruh mahasiswa Universitas Komputer Indonesia
                          </p>
                    </div>
                    <div class="row g-3 py-2">
                        @foreach ($program as $t)
                        <div class="col-md-4">
                            <x-card-program :data="$t" />
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="{{ route('program.index')}}" class="btn btn-primary">Lihat Program Lainnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
    <link rel="stylesheet" href="/js/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="/js/plugins/slick-carousel/slick.css">
    <link rel="stylesheet" href="/js/plugins/slick-carousel/slick-theme.css">
    <style>
        /**
        * Simple fade transition,
        */
        .slider-wrapper{
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .slider-wrapper img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mfp-fade.mfp-bg {
            opacity: 0;
            -webkit-transition: all 0.15s ease-out;
            -moz-transition: all 0.15s ease-out;
            transition: all 0.15s ease-out;
        }
        .mfp-fade.mfp-bg.mfp-ready {
            opacity: 0.8;
        }
        .mfp-fade.mfp-bg.mfp-removing {
            opacity: 0;
        }

        .mfp-fade.mfp-wrap .mfp-content {
            opacity: 0;
            -webkit-transition: all 0.15s ease-out;
            -moz-transition: all 0.15s ease-out;
            transition: all 0.15s ease-out;
        }
        .mfp-fade.mfp-wrap.mfp-ready .mfp-content {
            opacity: 1;
        }
        .mfp-fade.mfp-wrap.mfp-removing .mfp-content {
            opacity: 0;
        }

        </style>
    @endpush
    @push('scripts')
        <script src="/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
        <script src="/js/plugins/slick-carousel/slick.min.js"></script>
        <script>
            $('.js-gallery').addClass('js-gallery-enabled').magnificPopup({
                delegate: 'a.img-lightbox',
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
            $('.yt-gallery').magnificPopup({
                delegate: 'a.yt-lightbox',
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                gallery: {
                    enabled: true
                }
            });

            $('.js-slider:not(.js-slider-enabled)').each((index, element) => {
            let el = $(element);

            // Add .js-slider-enabled class to tag it as activated and init it
            el.addClass('js-slider-enabled').slick({
                arrows: el.data('arrows') || false,
                dots: el.data('dots') || false,
                slidesToShow: el.data('slides-to-show') || 1,
                centerMode: el.data('center-mode') || false,
                autoplay: el.data('autoplay') || false,
                autoplaySpeed: el.data('autoplay-speed') || 3000,
                infinite: typeof el.data('infinite') === 'undefined' ? true : el.data('infinite')
            });
            });
        </script>
    @endpush
</x-landing-layout>