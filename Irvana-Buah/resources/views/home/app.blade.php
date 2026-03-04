<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Irvana Buah - Toko Buah Segar Online')</title>
  <meta name="description" content="@yield('meta_description', 'Irvana Buah - Toko buah segar berkualitas premium. Pesan online, pengiriman cepat ke seluruh kota.')">
  <meta name="keywords"    content="@yield('meta_keywords',     'buah segar, toko buah online, buah premium, irvana buah')">
  <meta name="robots"      content="index, follow">
  <link rel="canonical"    href="{{ url()->current() }}">

  {{-- Open Graph (WhatsApp / Facebook share preview) --}}
  <meta property="og:type"        content="@yield('og_type', 'website')">
  <meta property="og:url"         content="{{ url()->current() }}">
  <meta property="og:title"       content="@yield('og_title', config('app.name', 'Irvana Buah') . ' - Toko Buah Segar Online')">
  <meta property="og:description" content="@yield('og_description', 'Irvana Buah - Toko buah segar berkualitas premium. Pesan online, pengiriman cepat ke seluruh kota.')">
  <meta property="og:image"       content="@yield('og_image', asset('assets/img/og-default.webp'))">
  <meta property="og:site_name"   content="Irvana Buah">
  <meta property="og:locale"      content="id_ID">

  {{-- Twitter Card --}}
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="@yield('og_title', 'Irvana Buah')">
  <meta name="twitter:description" content="@yield('og_description', 'Toko buah segar berkualitas premium.')">
  <meta name="twitter:image"       content="@yield('og_image', asset('assets/img/og-default.webp'))">

  @stack('seo')
  {{-- Site-level Organization schema --}}
  <script type="application/ld+json">
  { "@context": "https://schema.org", "@type": "Organization", "name": "Irvana Buah", "url": "{{ config('app.url') }}", "logo": "{{ asset('assets/img/logo.png') }}", "sameAs": [] }
  </script>

  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/drift-zoom/drift-basic.css') }}" rel="stylesheet">

  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body class="@yield('body_class', 'index-page')">

  @include('home.partials.header')

  @yield('content')

  @include('home.partials.footer')

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/drift-zoom/Drift.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

  <script src="{{ asset('assets/js/main.js') }}"></script>
  @yield('scripts')

</body>

</html>