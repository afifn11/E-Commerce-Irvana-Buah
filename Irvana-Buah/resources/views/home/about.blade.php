@extends('home.app')

@section('title', 'Tentang Kami - Irvana Buah')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Tentang Irvana Buah</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Tentang Kami</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- About 2 Section -->
    <section id="about-2" class="about-2 section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <span class="section-badge"><i class="bi bi-info-circle"></i> About Us</span>
        <div class="row">
          <div class="col-lg-6">
            <h2 class="about-title">Menghadirkan Buah Segar Terbaik Langsung dari Kebun untuk Keluarga Anda</h2>
            <p class="about-description">Irvana Buah berdiri dengan satu misi sederhana: memastikan setiap keluarga Indonesia mendapatkan akses mudah terhadap buah-buahan segar berkualitas premium setiap harinya.</p>
          </div>
          <div class="col-lg-6">
            <p class="about-text">Kami bermitra langsung dengan petani buah terpercaya dari berbagai daerah di Indonesia, sehingga buah yang sampai di tangan Anda selalu dalam kondisi segar, tanpa perantara yang tidak perlu dan tanpa kompromi terhadap kualitas.</p>
            <p class="about-text">Sejak berdiri, Irvana Buah terus berkembang dengan menghadirkan berbagai pilihan buah lokal maupun impor pilihan, sistem pemesanan yang mudah, dan layanan pengiriman cepat yang menjaga kesegaran produk hingga ke depan pintu rumah Anda.</p>
          </div>
        </div>

        <div class="row features-boxes gy-4 mt-3">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-box">
              <div class="icon-box">
                <i class="bi bi-bullseye"></i>
              </div>
              <h3><a href="#" class="stretched-link">Misi Kami</a></h3>
              <p>Menyediakan buah segar berkualitas tinggi dengan harga yang terjangkau, mudah diakses oleh semua kalangan, dan dikirim langsung ke rumah Anda dengan cepat dan aman.</p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-box">
              <div class="icon-box">
                <i class="bi bi-person-check"></i>
              </div>
              <h3><a href="#" class="stretched-link">Komitmen Kami</a></h3>
              <p>Setiap produk yang kami jual melewati seleksi ketat dari tim quality control kami. Kami tidak menjual buah yang tidak layak konsumsi — jaminan kualitas adalah janji kami kepada pelanggan.</p>
            </div>
          </div>

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-box">
              <div class="icon-box">
                <i class="bi bi-clipboard-data"></i>
              </div>
              <h3><a href="#" class="stretched-link">Visi Kami</a></h3>
              <p>Menjadi platform belanja buah online terpercaya nomor satu di Indonesia yang menghubungkan petani lokal dengan konsumen secara langsung, adil, dan berkelanjutan.</p>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-12" data-aos="zoom-in" data-aos-delay="200">
            <div class="video-box">
              <img src="assets/img/about/about-wide-1.webp" class="img-fluid" alt="Video Thumbnail">
              <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About 2 Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="avatars d-flex align-items-center">
              <img src="assets/img/person/person-m-2.webp" alt="Avatar 1" class="rounded-circle" loading="lazy">
              <img src="assets/img/person/person-m-3.webp" alt="Avatar 2" class="rounded-circle" loading="lazy">
              <img src="assets/img/person/person-f-5.webp" alt="Avatar 3" class="rounded-circle" loading="lazy">
              <img src="assets/img/person/person-m-5.webp" alt="Avatar 4" class="rounded-circle" loading="lazy">
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row counters">
              <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <h2><span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1" class="purecounter"></span>+</h2>
                <p>Jenis Buah Tersedia</p>
              </div>

              <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <h2><span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>K+</h2>
                <p>Pelanggan Puas</p>
              </div>

              <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                <h2><span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>%</h2>
                <p>Jaminan Kesegaran</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Stats Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <div class="container">

        <div class="testimonial-masonry">

          <div class="testimonial-item" data-aos="fade-up">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Buahnya selalu segar dan tiba dalam kondisi sempurna. Sejak kenal Irvana Buah, saya tidak pernah lagi beli buah di tempat lain!</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-7.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Sari Dewi</h3>
                  <span class="position">Ibu Rumah Tangga, Jakarta Selatan</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Saya pesan untuk stok buah di kantor setiap minggu. Prosesnya mudah, pengirimannya tepat waktu, dan kualitasnya konsisten. Tim Irvana Buah sangat responsif ketika ada pertanyaan. Sangat direkomendasikan untuk pembelian dalam jumlah besar!</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-7.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Budi Santoso</h3>
                  <span class="position">Office Manager, Perusahaan Swasta</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Harga bersaing, pilihan buah banyak, dan pengiriman cepat. Aplikasinya juga mudah digunakan. Sudah jadi langganan tetap saya!</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-8.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Anisa Rahma</h3>
                  <span class="position">Mahasiswi, Depok</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Anggur dan mangga dari Irvana Buah kualitasnya jauh lebih baik dari yang saya temukan di supermarket. Rasanya manis dan segar, tidak mengecewakan.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-8.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Hendro Prasetyo</h3>
                  <span class="position">Chef Profesional, Tangerang</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Sebagai pemilik usaha katering, saya butuh pasokan buah yang stabil dan berkualitas. Irvana Buah benar-benar membantu bisnis saya. Mereka selalu siap memenuhi pesanan besar dengan kualitas yang tidak pernah turun. Partner terbaik untuk usaha makanan!</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-9.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Ratna Kusuma</h3>
                  <span class="position">Pemilik Usaha Katering, Bekasi</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="500">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Saya suka dengan promo diskon yang sering ada. Bisa hemat banyak tanpa mengorbankan kualitas buah. Pelayanan customer service-nya juga ramah dan cepat merespons.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-13.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Fajar Nugroho</h3>
                  <span class="position">Pelanggan Setia, Bogor</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Testimonials Section -->

  </main>
@endsection