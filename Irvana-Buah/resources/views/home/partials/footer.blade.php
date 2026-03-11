<footer id="footer" class="footer">
    <div class="footer-main">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="footer-widget footer-about">
              <a href="{{ route('home') }}" class="logo">
                <span class="sitename">Irvana Buah</span>
              </a>
              <p>Irvana Buah menyediakan buah-buahan segar berkualitas premium langsung dari kebun pilihan. Nikmati kesegaran dan nutrisi terbaik untuk hidup yang lebih sehat.</p>
              <div class="footer-contact mt-4">
                <div class="contact-item">
                  <i class="bi bi-geo-alt"></i>
                  <span>Jl. Buah Raya No. 88, Jakarta Selatan</span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-telephone"></i>
                  <span>+62 812-3456-7890</span>
                </div>
                <div class="contact-item">
                  <i class="bi bi-envelope"></i>
                  <span>info@irvanabuah.com</span>
                </div>
              </div>
              {{-- Social icons inline for mobile (desktop still uses the widget below) --}}
              <div class="social-links-inline d-lg-none mt-3">
                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Belanja</h4>
              <ul class="footer-links">
                <li><a href="{{ route('products') }}">Semua Produk</a></li>
                <li><a href="{{ route('best-sellers') }}">Best Seller</a></li>
                <li><a href="{{ route('discount.products') }}">Produk Diskon</a></li>
                <li><a href="{{ route('products') }}?sort=newest">Produk Terbaru</a></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Bantuan</h4>
              <ul class="footer-links">
                <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>
                <li><a href="{{ route('cart.index') }}">Keranjang Belanja</a></li>
                <li><a href="{{ route('cart.checkout') }}">Checkout</a></li>
                @auth
                  <li><a href="{{ route('customer.orders') }}">Status Pesanan</a></li>
                  <li><a href="{{ route('customer.profile') }}">Profil Saya</a></li>
                @else
                  <li><a href="{{ route('login') }}">Masuk / Daftar</a></li>
                @endauth
              </ul>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Perusahaan</h4>
              <ul class="footer-links">
                <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                <li><a href="{{ route('contact') }}">Kontak</a></li>
                <li><a href="{{ route('about') }}">Cara Pemesanan</a></li>
                <li><a href="{{ route('about') }}">Kebijakan Pengiriman</a></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="footer-widget">
              <h4>Jam Operasional</h4>
              <p>Kami siap melayani pesanan Anda setiap hari</p>
              <ul class="footer-links">
                <li><span><i class="bi bi-clock me-1"></i> Senin - Sabtu: 07.00 - 20.00</span></li>
                <li><span><i class="bi bi-clock me-1"></i> Minggu: 08.00 - 17.00</span></li>
              </ul>
              <div class="social-links mt-4">
                <h5>Ikuti Kami</h5>
                <div class="social-icons">
                  <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                  <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                  <a href="#" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                  <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                  <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <div class="payment-methods d-flex align-items-center justify-content-center">
          <span>Kami Menerima:</span>
          <div class="payment-icons">
            <i class="bi bi-credit-card" aria-label="Kartu Kredit"></i>
            <i class="bi bi-bank" aria-label="Transfer Bank"></i>
            <i class="bi bi-cash" aria-label="COD / Tunai"></i>
            <i class="bi bi-phone" aria-label="Dompet Digital"></i>
          </div>
        </div>

        <div class="legal-links">
          <a href="#">Syarat & Ketentuan</a>
          <a href="#">Kebijakan Privasi</a>
          <a href="{{ route('contact') }}">Hubungi Kami</a>
        </div>

        <div class="copyright text-center">
          <p>© <span>{{ date('Y') }}</span> <strong class="sitename">Irvana Buah</strong>. All Rights Reserved.</p>
        </div>

      </div>
    </div>
  </footer>

@include('home.partials.cart-handler')
@include('home.partials.wishlist-handler')
@include('home.partials.chatbot')
@include('home.partials.whatsapp-widget')
@include('home.partials.search-autocomplete')

{{-- ═══ BOTTOM NAVIGATION BAR — mobile only ═══ --}}
<nav class="bottom-nav d-md-none" id="bottomNav">
  <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
    <i class="bi bi-house"></i>
    <span>Home</span>
  </a>
  <a href="{{ route('products') }}" class="bottom-nav-item {{ request()->routeIs('products*') || request()->routeIs('discount*') || request()->routeIs('best*') ? 'active' : '' }}">
    <i class="bi bi-grid"></i>
    <span>Toko</span>
  </a>
  @auth
  <a href="{{ route('wishlist.index') }}" class="bottom-nav-item {{ request()->routeIs('wishlist*') ? 'active' : '' }}">
    <i class="bi bi-heart"></i>
    <span>Wishlist</span>
    @php $wlMobile = \App\Models\Wishlist::where('user_id', Auth::id())->count(); @endphp
    @if($wlMobile > 0)<span class="bn-badge">{{ $wlMobile }}</span>@endif
  </a>
  @else
  <a href="{{ route('login') }}" class="bottom-nav-item">
    <i class="bi bi-heart"></i>
    <span>Wishlist</span>
  </a>
  @endauth
  <a href="{{ route('cart.index') }}" class="bottom-nav-item {{ request()->routeIs('cart*') ? 'active' : '' }}">
    <i class="bi bi-cart3"></i>
    <span>Keranjang</span>
    @auth
      @php $cartMobile = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity'); @endphp
      @if($cartMobile > 0)<span class="bn-badge">{{ $cartMobile }}</span>@endif
    @endauth
  </a>
  @auth
  <a href="{{ route('customer.profile') }}" class="bottom-nav-item {{ request()->routeIs('customer.profile') ? 'active' : '' }}">
    <i class="bi bi-person"></i>
    <span>Akun</span>
  </a>
  @else
  <a href="{{ route('login') }}" class="bottom-nav-item">
    <i class="bi bi-person"></i>
    <span>Masuk</span>
  </a>
  @endauth
</nav>

<script>
// Footer accordion — mobile only
(function() {
  function initFooterAccordion() {
    if (window.innerWidth >= 768) return;
    document.querySelectorAll('.footer-widget:not(.footer-about) h4').forEach(h4 => {
      if (h4.dataset.accInited) return;
      h4.dataset.accInited = '1';
      h4.addEventListener('click', function() {
        const isOpen = this.classList.contains('open');
        // Close all
        document.querySelectorAll('.footer-widget:not(.footer-about) h4').forEach(el => el.classList.remove('open'));
        // Toggle current
        if (!isOpen) this.classList.add('open');
      });
    });
  }
  document.addEventListener('DOMContentLoaded', initFooterAccordion);
  window.addEventListener('resize', initFooterAccordion);
})();
</script>