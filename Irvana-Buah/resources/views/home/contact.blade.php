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

    <style>
    /* ── Contact info cards ─────────────────────────────────── */
    .ic-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 12px 20px;
        text-align: center;
        border: 1px solid #e2eaf6;
        box-shadow: 0 2px 12px rgba(10,77,184,.07);
        height: 100%;
        transition: transform .3s, box-shadow .3s;
    }
    .ic-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(10,77,184,.13); }

    .ic-icon {
        width: 58px; height: 58px;
        background: #eaf0fc;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
        transition: background .3s;
    }
    .ic-card:hover .ic-icon { background: #0a4db8; }
    .ic-icon i { font-size: 1.5rem; color: #0a4db8; transition: color .3s; }
    .ic-card:hover .ic-icon i { color: #fff; }

    .ic-card h4 {
        font-size: .78rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: #6b7a99; margin-bottom: 6px;
    }
    .ic-card p { font-size: .85rem; color: #333; margin: 0; line-height: 1.5; }
    .ic-card p a { color: #0a4db8; text-decoration: none; font-weight: 600; }
    .ic-card p a:hover { text-decoration: underline; }

    /* ── Form wrapper ───────────────────────────────────────── */
    .ct-form-wrap {
        background: #fff;
        border-radius: 20px;
        padding: 36px 36px 32px;
        box-shadow: 0 4px 24px rgba(10,77,184,.08);
        border: 1px solid #e8eef8;
    }
    @media (max-width: 575px) {
        .ct-form-wrap { padding: 22px 16px 24px; }
    }

    .ct-form-title {
        font-size: 1.4rem; font-weight: 700; color: #111;
        margin-bottom: 6px; display: flex; align-items: center; gap: 10px;
    }
    .ct-form-title i { color: #0a4db8; }

    .ct-label {
        font-size: .84rem; font-weight: 600; color: #374151;
        display: block; margin-bottom: 6px;
    }
    .ct-input {
        width: 100%; padding: 11px 14px;
        border: 1.5px solid #d1d9e8; border-radius: 10px;
        font-size: .9rem; color: #333; background: #fff;
        outline: none; display: block; transition: border-color .2s, box-shadow .2s;
        font-family: inherit;
    }
    .ct-input:focus {
        border-color: #0a4db8;
        box-shadow: 0 0 0 3px rgba(10,77,184,.12);
    }
    .ct-input::placeholder { color: #9ca3af; font-size: .87rem; }
    textarea.ct-input { resize: vertical; min-height: 140px; }

    .ct-submit {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 14px 24px;
        background: #0a4db8; color: #fff;
        border: none; border-radius: 12px;
        font-size: 1rem; font-weight: 700; cursor: pointer;
        transition: background .25s, transform .2s, box-shadow .25s;
        box-shadow: 0 4px 14px rgba(10,77,184,.3);
    }
    .ct-submit:hover {
        background: #083d96;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(10,77,184,.35);
    }
    .ct-submit:active { transform: translateY(0); }
    .ct-submit i { font-size: 1.1rem; }

    /* ── Right column ───────────────────────────────────────── */
    .ct-map iframe {
        width: 100%; height: 260px;
        border: 0; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.09);
        display: block;
    }

    .ct-quick-title {
        font-size: 1rem; font-weight: 700; color: #111; margin: 20px 0 12px;
    }
    .ct-quick-btn {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 18px; border-radius: 12px;
        text-decoration: none; font-weight: 600; font-size: .92rem;
        margin-bottom: 10px; border: 1.5px solid transparent;
        transition: all .25s;
    }
    .ct-quick-btn i.ct-icon-main { font-size: 1.25rem; flex-shrink: 0; }
    .ct-quick-btn span { flex: 1; }
    .ct-quick-btn i.ct-arrow { font-size: .9rem; opacity: .5; transition: transform .25s; }
    .ct-quick-btn:hover i.ct-arrow { transform: translateX(4px); opacity: 1; }

    .ct-quick-btn.wa {
        background: #e7f9ee; color: #1a7a3e; border-color: #b7eacc;
    }
    .ct-quick-btn.wa:hover { background: #25d366; color: #fff; border-color: #25d366; }
    .ct-quick-btn.em {
        background: #eaf0fc; color: #0a4db8; border-color: #c3d4f5;
    }
    .ct-quick-btn.em:hover { background: #0a4db8; color: #fff; border-color: #0a4db8; }

    /* ── Mobile tweaks ──────────────────────────────────────── */
    @media (max-width: 575px) {
        .ic-card { padding: 16px 8px 14px; border-radius: 12px; }
        .ic-icon  { width: 46px; height: 46px; border-radius: 10px; margin-bottom: 10px; }
        .ic-icon i { font-size: 1.2rem; }
        .ic-card h4 { font-size: .7rem; }
        .ic-card p  { font-size: .75rem; }
    }
    </style>

    <section id="contact" class="contact section">
      <div class="container" data-aos="fade-up">

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        {{-- ── Info cards ── --}}
        <div class="row g-3 mb-5" data-aos="fade-up" data-aos-delay="100">
          <div class="col-6 col-md-3">
            <div class="ic-card">
              <div class="ic-icon"><i class="bi bi-geo-alt-fill"></i></div>
              <h4>Lokasi</h4>
              <p>Jl. Buah Raya No. 88,<br>Jakarta Selatan 12760</p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="ic-card">
              <div class="ic-icon"><i class="bi bi-whatsapp"></i></div>
              <h4>WhatsApp</h4>
              <p><a href="https://wa.me/6281234567890">+62 812-3456-7890</a></p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="ic-card">
              <div class="ic-icon"><i class="bi bi-envelope-fill"></i></div>
              <h4>Email</h4>
              <p><a href="mailto:info@irvanabuah.com">info@irvanabuah.com</a></p>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="ic-card">
              <div class="ic-icon"><i class="bi bi-clock-fill"></i></div>
              <h4>Jam Buka</h4>
              <p>Sen–Sab 07.00–20.00<br>Minggu 08.00–17.00</p>
            </div>
          </div>
        </div>

        {{-- ── Form + Map ── --}}
        <div class="row g-4 align-items-start" data-aos="fade-up" data-aos-delay="150">

          {{-- Contact Form --}}
          <div class="col-lg-7">
            <div class="ct-form-wrap">
              <div class="ct-form-title">
                <i class="bi bi-chat-dots-fill"></i> Kirim Pesan
              </div>
              <p class="text-muted mb-4" style="font-size:.9rem;">
                Ada pertanyaan atau butuh bantuan? Kami siap membantu Anda.
              </p>

              <form action="{{ route('contact.send') }}" method="post">
                @csrf
                <div class="row g-3">
                  <div class="col-sm-6">
                    <label class="ct-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="ct-input @error('name') is-invalid @enderror"
                           value="{{ old('name', Auth::user()->name ?? '') }}"
                           placeholder="Nama lengkap Anda" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-sm-6">
                    <label class="ct-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="ct-input @error('email') is-invalid @enderror"
                           value="{{ old('email', Auth::user()->email ?? '') }}"
                           placeholder="email@anda.com" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-sm-6">
                    <label class="ct-label">Nomor Telepon</label>
                    <input type="tel" name="phone" class="ct-input"
                           value="{{ old('phone') }}" placeholder="+62 8xx-xxxx-xxxx">
                  </div>
                  <div class="col-sm-6">
                    <label class="ct-label">Subjek <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="ct-input @error('subject') is-invalid @enderror"
                           value="{{ old('subject') }}" placeholder="Topik pesan Anda" required>
                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-12">
                    <label class="ct-label">Pesan <span class="text-danger">*</span></label>
                    <textarea name="message" rows="6"
                              class="ct-input @error('message') is-invalid @enderror"
                              placeholder="Tuliskan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="col-12">
                    <button type="submit" class="ct-submit">
                      <i class="bi bi-send-fill"></i> Kirim Pesan
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          {{-- Map + Quick contact --}}
          <div class="col-lg-5">
            <div class="ct-map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322009!2d106.8195613!3d-6.194699!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f42a7a66df03%3A0xbde6ba04e33cb23a!2sJakarta%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>

            <p class="ct-quick-title">Hubungi Langsung</p>
            <a href="https://wa.me/6281234567890" class="ct-quick-btn wa" target="_blank">
              <i class="bi bi-whatsapp ct-icon-main"></i>
              <span>Chat via WhatsApp</span>
              <i class="bi bi-arrow-right ct-arrow"></i>
            </a>
            <a href="mailto:info@irvanabuah.com" class="ct-quick-btn em">
              <i class="bi bi-envelope-fill ct-icon-main"></i>
              <span>Kirim Email Langsung</span>
              <i class="bi bi-arrow-right ct-arrow"></i>
            </a>
          </div>

        </div>
      </div>
    </section>
</main>
@endsection
