@extends('home.app')

@section('title', 'Kontak Kami - Irvana Buah')

@section('content')
<main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Kontak Kami</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="current">Kontak</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="contact" class="contact section">
      <div class="container" data-aos="fade-up">

        @if(session('success'))
          <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif

        <div class="row gy-5 gx-lg-5">
          <div class="col-lg-4">
            <div class="info-wrapper">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Lokasi Kami</h3>
                  <p>Jl. Buah Raya No. 88, Jakarta Selatan, DKI Jakarta 12760</p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Telepon / WhatsApp</h3>
                  <p><a href="https://wa.me/6281234567890" class="text-decoration-none">+62 812-3456-7890</a></p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p><a href="mailto:info@irvanabuah.com" class="text-decoration-none">info@irvanabuah.com</a></p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                <i class="bi bi-clock flex-shrink-0"></i>
                <div>
                  <h3>Jam Operasional</h3>
                  <p>Senin - Sabtu: 07.00 - 20.00<br>Minggu: 08.00 - 17.00</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-8">
            <form action="{{ route('contact.send') }}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              @csrf
              <div class="row gy-4">
                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Nama Anda <span class="text-danger">*</span></label>
                  <input type="text" name="name" id="name-field" class="form-control @error('name') is-invalid @enderror" 
                         value="{{ old('name', Auth::user()->name ?? '') }}" required>
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" 
                         name="email" id="email-field" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="phone-field" class="pb-2">Nomor Telepon</label>
                  <input type="tel" class="form-control" name="phone" id="phone-field" value="{{ old('phone') }}" placeholder="+62 8xx-xxxx-xxxx">
                </div>
                <div class="col-md-6">
                  <label for="subject-field" class="pb-2">Subjek <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                         name="subject" id="subject-field" value="{{ old('subject') }}" required>
                  @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                  <label for="message-field" class="pb-2">Pesan <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('message') is-invalid @enderror" 
                            name="message" rows="10" id="message-field" required>{{ old('message') }}</textarea>
                  @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary px-5">
                    <i class="bi bi-send me-2"></i>Kirim Pesan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</main>
@endsection
