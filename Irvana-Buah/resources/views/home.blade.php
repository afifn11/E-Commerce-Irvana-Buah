@extends('home.app')

@section('title', 'eStore - Home')

@section('content')

    <section class="ecommerce-hero-1 hero section" id="hero">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
            <div class="content">
              <span class="promo-badge">Segar Setiap Hari</span>
              <h1>Buah <span>Segar</span> Berkualitas Terbaik Untuk Keluarga</h1>
              <p>Irvana Buah menyediakan buah-buahan segar berkualitas premium langsung dari kebun pilihan. Nikmati kesegaran dan nutrisi terbaik untuk hidup yang lebih sehat.</p>
              <div class="hero-cta">
                <a href="{{ route('products.index') }}" class="btn btn-shop">Belanja Sekarang <i class="bi bi-arrow-right"></i></a>
                {{-- If 'fresh_only' is a filter for the products.index page --}}
                <a href="{{ route('products.index', ['fresh_only' => 1]) }}" class="btn btn-collection">Buah Segar Hari Ini</a>
              </div>
              <div class="hero-features">
                <div class="feature-item">
                  <i class="bi bi-truck"></i>
                  <span>Pengiriman Cepat</span>
                </div>
                <div class="feature-item">
                  <i class="bi bi-shield-check"></i>
                  <span>Jaminan Segar</span>
                </div>
                <div class="feature-item">
                  <i class="bi bi-award"></i>
                  <span>Kualitas Premium</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 image-col" data-aos="fade-left" data-aos-delay="200">
            <div class="hero-image">
              <img src="{{ asset('assets/img/fruits/mixed-fruits-main.webp') }}" alt="Buah Segar Irvana" class="main-product" loading="lazy">
              <div class="floating-product product-1" data-aos="fade-up" data-aos-delay="300">
                <img src="{{ asset('assets/img/fruits/apple-fresh.webp') }}" alt="Apel Segar">
                <div class="product-info">
                  <h4>Apel Fuji</h4>
                  <span class="price">Rp 35.000/kg</span>
                </div>
              </div>
              <div class="floating-product product-2" data-aos="fade-up" data-aos-delay="400">
                <img src="{{ asset('assets/img/fruits/orange-fresh.webp') }}" alt="Jeruk Segar">
                <div class="product-info">
                  <h4>Jeruk Manis</h4>
                  <span class="price">Rp 28.000/kg</span>
                </div>
              </div>
              <div class="discount-badge" data-aos="zoom-in" data-aos-delay="500">
                <span class="percent">25%</span>
                <span class="text">OFF</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features-section py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="feature-card text-center">
              <div class="feature-icon">
                <i class="bi bi-leaf"></i>
              </div>
              <h5>100% Organik</h5>
              <p>Buah-buahan organik tanpa pestisida berbahaya</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="feature-card text-center">
              <div class="feature-icon">
                <i class="bi bi-clock"></i>
              </div>
              <h5>Selalu Segar</h5>
              <p>Dipetik langsung dari kebun untuk kesegaran maksimal</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="feature-card text-center">
              <div class="feature-icon">
                <i class="bi bi-truck"></i>
              </div>
              <h5>Pengiriman Cepat</h5>
              <p>Dikirim dalam 24 jam untuk menjaga kesegaran</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="feature-card text-center">
              <div class="feature-icon">
                <i class="bi bi-heart"></i>
              </div>
              <h5>Untuk Kesehatan</h5>
              <p>Kaya nutrisi dan vitamin untuk hidup sehat</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section id="info-cards" class="info-cards section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 justify-content-center">
          <div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-truck"></i>
              </div>
              <h3>Free Shipping</h3>
              <p>Nulla sit morbi vestibulum eros duis amet, consectetur vitae lacus. Ut quis tempor felis sed nunc viverra.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-piggy-bank"></i>
              </div>
              <h3>Money Back Guarantee</h3>
              <p>Nullam gravida felis ac nunc tincidunt, sed malesuada justo pulvinar. Vestibulum nec diam vitae eros.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-percent"></i>
              </div>
              <h3>Discount Offers</h3>
              <p>Nulla ipsum nisi vel adipiscing amet, dignissim consectetur ornare. Vestibulum quis posuere elit auctor.</p>
            </div>
          </div><div class="col-12 col-sm-6 col-lg-3" data-aos="fade-up" data-aos-delay="500">
            <div class="info-card text-center">
              <div class="icon-box">
                <i class="bi bi-headset"></i>
              </div>
              <h3>24/7 Support</h3>
              <p>Ipsum dolor amet sit consectetur adipiscing, nullam vitae euismod tempor nunc felis vestibulum ornare.</p>
            </div>
          </div></div>

      </div>

    </section><section id="category-cards" class="category-cards section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="category-slider swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "autoplay": {
                "delay": 5000,
                "disableOnInteraction": false
              },
              "grabCursor": true,
              "speed": 600,
              "slidesPerView": "auto",
              "spaceBetween": 20,
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 15
                },
                "576": {
                  "slidesPerView": 3,
                  "spaceBetween": 15
                },
                "768": {
                  "slidesPerView": 4,
                  "spaceBetween": 20
                },
                "992": {
                  "slidesPerView": 5,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 6,
                  "spaceBetween": 20
                }
              }
            }
          </script>

          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-1.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Vestibulum ante</h3>
                <p class="category-count">4 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-6.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Maecenas nec</h3>
                <p class="category-count">8 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-9.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Aenean tellus</h3>
                <p class="category-count">4 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-f-1.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Donec quam</h3>
                <p class="category-count">12 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-10.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Phasellus leo</h3>
                <p class="category-count">4 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="600">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-m-1.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Quisque rutrum</h3>
                <p class="category-count">2 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="700">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-10.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Etiam ultricies</h3>
                <p class="category-count">4 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="category-card" data-aos="fade-up" data-aos-delay="800">
                <div class="category-image">
                  <img src="{{ asset('assets/img/product/product-2.webp') }}" alt="Category" class="img-fluid">
                </div>
                <h3 class="category-title">Fusce fermentum</h3>
                <p class="category-count">4 Products</p>
                <a href="{{ url('/category') }}" class="stretched-link"></a>
              </div>
            </div>
          </div>

          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>

      </div>

    </section><section id="best-sellers" class="best-sellers section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Best Sellers</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-1.webp') }}" class="img-fluid default-image" alt="Product" loading="lazy">
                <img src="{{ asset('assets/img/product/product-1-variant.webp') }}" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                <div class="product-tags">
                  <span class="badge bg-accent">New</span>
                </div>
                <div class="product-actions">
                  <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                  <button class="btn-quickview" type="button" aria-label="Quick view">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>
              <div class="product-info">
                <h3 class="product-title"><a href="{{ url('/product-details') }}">Lorem ipsum dolor sit amet</a></h3>
                <div class="product-price">
                  <span class="current-price">$89.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <span class="rating-count">(42)</span>
                </div>
                <button class="btn btn-add-to-cart">
                  <i class="bi bi-bag-plus me-2"></i>Add to Cart
                </button>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-4.webp') }}" class="img-fluid default-image" alt="Product" loading="lazy">
                <img src="{{ asset('assets/img/product/product-4-variant.webp') }}" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                <div class="product-tags">
                  <span class="badge bg-sale">Sale</span>
                </div>
                <div class="product-actions">
                  <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                  <button class="btn-quickview" type="button" aria-label="Quick view">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>
              <div class="product-info">
                <h3 class="product-title"><a href="{{ url('/product-details') }}">Consectetur adipiscing elit</a></h3>
                <div class="product-price">
                  <span class="current-price">$64.99</span>
                  <span class="original-price">$79.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <span class="rating-count">(28)</span>
                </div>
                <button class="btn btn-add-to-cart">
                  <i class="bi bi-bag-plus me-2"></i>Add to Cart
                </button>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-7.webp') }}" class="img-fluid default-image" alt="Product" loading="lazy">
                <img src="{{ asset('assets/img/product/product-7-variant.webp') }}" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                <div class="product-actions">
                  <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                  <button class="btn-quickview" type="button" aria-label="Quick view">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>
              <div class="product-info">
                <h3 class="product-title"><a href="{{ url('/product-details') }}">Sed do eiusmod tempor incididunt</a></h3>
                <div class="product-price">
                  <span class="current-price">$119.00</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span class="rating-count">(56)</span>
                </div>
                <button class="btn btn-add-to-cart">
                  <i class="bi bi-bag-plus me-2"></i>Add to Cart
                </button>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-12.webp') }}" class="img-fluid default-image" alt="Product" loading="lazy">
                <img src="{{ asset('assets/img/product/product-12-variant.webp') }}" class="img-fluid hover-image" alt="Product hover" loading="lazy">
                <div class="product-tags">
                  <span class="badge bg-sold-out">Sold Out</span>
                </div>
                <div class="product-actions">
                  <button class="btn-wishlist" type="button" aria-label="Add to wishlist">
                    <i class="bi bi-heart"></i>
                  </button>
                  <button class="btn-quickview" type="button" aria-label="Quick view">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
              </div>
              <div class="product-info">
                <h3 class="product-title"><a href="{{ url('/product-details') }}">Ut labore et dolore magna aliqua</a></h3>
                <div class="product-price">
                  <span class="current-price">$75.50</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <i class="bi bi-star"></i>
                  <span class="rating-count">(15)</span>
                </div>
                <button class="btn btn-add-to-cart btn-disabled" disabled="">
                  <i class="bi bi-bag-plus me-2"></i>Sold Out
                </button>
              </div>
            </div>
          </div></div>

      </div>

    </section><section id="product-list" class="product-list section">

      <div class="container isotope-layout" data-aos="fade-up" data-aos-delay="100" data-default-filter="*" data-layout="masonry" data-sort="original-order">

        <div class="row">
          <div class="col-12">
            <div class="product-filters isotope-filters mb-5 d-flex justify-content-center" data-aos="fade-up">
              <ul class="d-flex flex-wrap gap-2 list-unstyled">
                <li class="filter-active" data-filter="*">All</li>
                <li data-filter=".filter-clothing">Clothing</li>
                <li data-filter=".filter-accessories">Accessories</li>
                <li data-filter=".filter-electronics">Electronics</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row product-container isotope-container" data-aos="fade-up" data-aos-delay="200">

          <div class="col-md-6 col-lg-3 product-item isotope-item filter-clothing">
            <div class="product-card">
              <div class="product-image">
                <span class="badge">Sale</span>
                <img src="{{ asset('assets/img/product/product-11.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-11-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Lorem ipsum dolor sit amet</a></h5>
                <div class="product-price">
                  <span class="current-price">$89.99</span>
                  <span class="old-price">$129.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <span>(24)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-electronics">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-9.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-9-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Consectetur adipiscing elit</a></h5>
                <div class="product-price">
                  <span class="current-price">$249.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <span>(18)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-accessories">
            <div class="product-card">
              <div class="product-image">
                <span class="badge">New</span>
                <img src="{{ asset('assets/img/product/product-3.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-3-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Sed do eiusmod tempor</a></h5>
                <div class="product-price">
                  <span class="current-price">$59.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <i class="bi bi-star"></i>
                  <span>(7)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-clothing">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-4.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-4-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Incididunt ut labore et dolore</a></h5>
                <div class="product-price">
                  <span class="current-price">$79.99</span>
                  <span class="old-price">$99.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span>(32)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-electronics">
            <div class="product-card">
              <div class="product-image">
                <span class="badge">Sale</span>
                <img src="{{ asset('assets/img/product/product-5.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-5-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Magna aliqua ut enim ad minim</a></h5>
                <div class="product-price">
                  <span class="current-price">$199.99</span>
                  <span class="old-price">$249.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <i class="bi bi-star"></i>
                  <span>(15)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-accessories">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-6.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-6-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Veniam quis nostrud exercitation</a></h5>
                <div class="product-price">
                  <span class="current-price">$45.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star"></i>
                  <span>(21)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-clothing">
            <div class="product-card">
              <div class="product-image">
                <span class="badge">New</span>
                <img src="{{ asset('assets/img/product/product-7.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-7-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Ullamco laboris nisi ut aliquip</a></h5>
                <div class="product-price">
                  <span class="current-price">$69.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-half"></i>
                  <i class="bi bi-star"></i>
                  <span>(11)</span>
                </div>
              </div>
            </div>
          </div><div class="col-md-6 col-lg-3 product-item isotope-item filter-electronics">
            <div class="product-card">
              <div class="product-image">
                <img src="{{ asset('assets/img/product/product-8.webp') }}" alt="Product" class="img-fluid main-img">
                <img src="{{ asset('assets/img/product/product-8-variant.webp') }}" alt="Product Hover" class="img-fluid hover-img">
                <div class="product-overlay">
                  <a href="{{ url('/cart') }}" class="btn-cart"><i class="bi bi-cart-plus"></i> Add to Cart</a>
                  <div class="product-actions">
                    <a href="#" class="action-btn"><i class="bi bi-heart"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-eye"></i></a>
                    <a href="#" class="action-btn"><i class="bi bi-arrow-left-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="product-info">
                <h5 class="product-title"><a href="{{ url('/product-details') }}">Ex ea commodo consequat</a></h5>
                <div class="product-price">
                  <span class="current-price">$159.99</span>
                </div>
                <div class="product-rating">
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <i class="bi bi-star-fill"></i>
                  <span>(29)</span>
                </div>
              </div>
            </div>
          </div></div>

        <div class="text-center mt-5" data-aos="fade-up">
          <a href="#" class="view-all-btn">View All Products <i class="bi bi-arrow-right"></i></a>
        </div>

      </div>

    </section>
@endsection