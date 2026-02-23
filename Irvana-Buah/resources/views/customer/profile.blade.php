@extends('home.app')
@section('title', 'Profil Saya - Irvana Buah')

@section('content')
<main class="main">
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Profil Saya</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li class="current">Profil Saya</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="section py-5">
    <div class="container" data-aos="fade-up">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
          <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="row g-4">
        {{-- Sidebar --}}
        <div class="col-lg-3">
          <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-3">
            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle" style="width:80px;height:80px">
              <i class="bi bi-person-circle fs-1 text-success"></i>
            </div>
            <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
            <p class="text-muted small mb-0">{{ $user->email }}</p>
          </div>
          <div class="list-group shadow-sm rounded-4 overflow-hidden border-0">
            <a href="#profile" data-bs-toggle="tab" class="list-group-item list-group-item-action active border-0 py-3">
              <i class="bi bi-person me-2"></i>Informasi Akun
            </a>
            <a href="#password" data-bs-toggle="tab" class="list-group-item list-group-item-action border-0 py-3">
              <i class="bi bi-lock me-2"></i>Ubah Password
            </a>
            <a href="{{ route('customer.orders') }}" class="list-group-item list-group-item-action border-0 py-3">
              <i class="bi bi-bag me-2"></i>Pesanan Saya
            </a>
          </div>
        </div>

        {{-- Content --}}
        <div class="col-lg-9">
          <div class="tab-content">
            {{-- Profile tab --}}
            <div class="tab-pane fade show active" id="profile">
              <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom px-4 py-3">
                  <h6 class="fw-bold mb-0"><i class="bi bi-person me-2" style="color:var(--accent-color)"></i>Informasi Akun</h6>
                </div>
                <div class="card-body p-4">
                  <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" disabled>
                        <div class="form-text">Email tidak dapat diubah.</div>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">No. Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone ?? '') }}" placeholder="08xx-xxxx-xxxx">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">Bergabung Sejak</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->created_at->format('d F Y') }}" disabled>
                      </div>
                      <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-success px-4 rounded-pill">
                          <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            {{-- Password tab --}}
            <div class="tab-pane fade" id="password">
              <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom px-4 py-3">
                  <h6 class="fw-bold mb-0"><i class="bi bi-lock me-2" style="color:var(--accent-color)"></i>Ubah Password</h6>
                </div>
                <div class="card-body p-4">
                  <form method="POST" action="{{ route('customer.profile.password') }}">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                      <div class="col-12">
                        <label class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                      </div>
                      <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-success px-4 rounded-pill">
                          <i class="bi bi-lock-fill me-2"></i>Ubah Password
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</main>
@endsection
