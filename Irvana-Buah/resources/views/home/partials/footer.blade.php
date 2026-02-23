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
                  <li><a href="{{ route('orders.index') }}">Status Pesanan</a></li>
                  <li><a href="{{ route('profile.edit') }}">Profil Saya</a></li>
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
