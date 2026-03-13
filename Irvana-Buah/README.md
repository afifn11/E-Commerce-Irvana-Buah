# Irvana Buah — Fresh Fruit E-Commerce Platform

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)
![Railway](https://img.shields.io/badge/Deployed_on-Railway-0B0D0E?style=for-the-badge&logo=railway&logoColor=white)

**A full-stack e-commerce web application for a fresh fruit store, built with Laravel 12.**

[Live Demo](https://irvana-buah.up.railway.app) · [Admin Demo](#demo-credentials)

</div>

---

## Overview

Irvana Buah is a production-deployed e-commerce platform built from the ground up with Laravel 12. It features a modern, responsive customer storefront and a complete admin dashboard — covering everything from product & order management to payment integration, loyalty points, and an AI-powered chatbot.

This project was developed as a personal portfolio project to demonstrate real-world full-stack web development skills, including third-party API integration, service layer architecture, and cloud deployment.

---

## Screenshots

### 🏠 Homepage
![Homepage](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/homepage-irvana-buah.png)

### 🛒 Product Catalog & Shopping
| Halaman Produk | Keranjang | Checkout |
|---|---|---|
| ![Produk](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/halaman-produk-irvana-buah.png) | ![Keranjang](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/halaman-keranjang-irvana-buah.png) | ![Checkout](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/halaman-checkout-irvana-buah.png) |

### 🛠️ Admin Dashboard
![Admin](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/admin-irvana-buah.png)

### 📱 Mobile View
![Mobile](https://raw.githubusercontent.com/afifn11/E-Commerce-Irvana-Buah/401e11dc342d23b1e04ffc6f2289a2057a2aa43a/Irvana-Buah/docs/images/mobile-view.png)

---

## Features

### 🛍️ Customer Storefront
- **Homepage** — Hero banner, featured products, best sellers carousel, and active promotions
- **Product Catalog** — Filter by category, price range, and sort options with real-time AJAX search + autocomplete
- **Product Detail** — Full product info, stock status, discount pricing, customer reviews & ratings
- **Shopping Cart** — AJAX-powered add, update quantity, and remove without page reload
- **Checkout** — Multi-step order form with coupon code redemption and loyalty points redemption
- **Payment Gateway** — Midtrans integration supporting Credit Card, GoPay, OVO, QRIS, and Bank Transfer
- **Order Tracking** — Real-time order status updates with email notifications via Brevo SMTP
- **Customer Account** — Order history, profile management, wishlist, loyalty points balance
- **Loyalty Points System** — Earn points on every purchase, redeem as discount on checkout
- **Wishlist** — Save products for later, persisted per user
- **Product Reviews** — Star rating and review submission after verified purchase
- **Coupon System** — Admin-generated coupon codes with percentage/fixed discount and usage limits

### 🔐 Authentication & Security
- **Email & Password** — Laravel Breeze with email verification
- **Google OAuth** — One-click sign-in via Laravel Socialite
- **Role-based Access Control** — Middleware-protected routes (admin vs customer)
- **CSRF Protection** — On all forms and AJAX requests
- **SQL Injection Prevention** — Laravel Eloquent ORM throughout

### 🤖 AI Chatbot
- **Gemini API Integration** — Conversational chatbot powered by Google Gemini 2.5 Flash
- Context-aware responses about products, orders, shipping, and store policies
- Quick-reply chips for common questions

### 🛠️ Admin Dashboard
- **Dashboard Analytics** — Total revenue, orders, products, users with period comparison
- **Product Management** — Full CRUD with image upload or external URL support, stock tracking
- **Category Management** — Organize products by category
- **Order Management** — View all orders, update status (Pending → Processing → Shipped → Delivered), trigger email notifications
- **User Management** — Manage accounts, assign roles
- **Coupon Management** — Create and manage discount coupons with usage tracking
- **Review Moderation** — View and manage customer reviews

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Laravel 12 (PHP 8.2+) |
| Frontend Styling | Tailwind CSS 3, Bootstrap 5 |
| Frontend Reactivity | Alpine.js 3 |
| HTTP Client | Axios |
| Database | MySQL 8 |
| Authentication | Laravel Breeze + Laravel Socialite (Google OAuth) |
| Payment Gateway | Midtrans |
| Email | Brevo SMTP (Transactional Email) |
| AI Chatbot | Google Gemini 2.5 Flash API |
| Build Tool | Vite 6 |
| Deployment | Railway (PaaS) |
| Version Control | Git + GitHub |

---

## Architecture Highlights

```
app/
├── Http/Controllers/
│   ├── Admin/                  # Admin panel controllers (CRUD, dashboard)
│   ├── Auth/                   # Auth + Google OAuth (SocialAuthController)
│   ├── Customer/               # Customer-specific views (orders, payment)
│   ├── CartController.php      # AJAX cart operations
│   ├── CheckoutController.php  # Order placement flow
│   ├── ChatbotController.php   # Gemini API proxy
│   └── HomeController.php      # Public storefront pages
├── Services/                   # Business logic layer
│   ├── CartService.php
│   ├── CheckoutService.php     # Order creation, stock management
│   ├── PointsService.php       # Loyalty points calculation
│   ├── ProductService.php
│   ├── DashboardService.php    # Analytics aggregation
│   └── ImageUploadService.php
├── Models/
│   ├── Product.php             # Accessors: effective_price, discount_percentage
│   ├── Order.php               # Order number generation (IB-YYYYMMDD-XXXXXX)
│   ├── Coupon.php
│   ├── UserPoints.php
│   └── Wishlist.php
└── Enums/
    └── PaymentMethod.php
```

**Key design decisions:**
- **Service Layer** — Business logic extracted from controllers into dedicated service classes for maintainability and testability
- **Model Accessors** — Price calculations (discount, effective price) handled via Eloquent accessors to keep views clean
- **AJAX-first** — Cart, wishlist, and search use AJAX for seamless UX without full page reloads
- **Enum Usage** — `PaymentMethod` enum for type-safe payment method handling (PHP 8.1+)

---

## Getting Started

### Requirements
- PHP >= 8.2
- Composer
- Node.js >= 18 & NPM
- MySQL 8

### Installation

```bash
# Clone the repository
git clone https://github.com/afifn11/E-Commerce-Irvana-Buah.git
cd E-Commerce-Irvana-Buah/Irvana-Buah

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your database in .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=irvana_buah
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders
php artisan migrate
php artisan db:seed

# Link storage and build assets
php artisan storage:link
npm run build

# Start development server
php artisan serve
```

App runs at `http://localhost:8000`

### Environment Variables

Key variables to configure in `.env`:

```env
# App
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=irvana_buah

# Google OAuth
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Midtrans Payment
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Email (Brevo SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=your_brevo_username
MAIL_PASSWORD=your_brevo_password
MAIL_FROM_ADDRESS=your@email.com
MAIL_SCHEME=tls

# AI Chatbot
GEMINI_API_KEY=your_gemini_api_key
```

---

## Demo Credentials

Available after running `php artisan db:seed`:

| Role | Email | Password |
|---|---|---|
| Admin | admin@irvanabuah.com | admin123 |
| Customer | test@example.com | user123 |

**Live Demo:** [https://irvana-buah.up.railway.app](https://irvana-buah.up.railway.app)

---

## Deployment

This project is deployed on **Railway** using Nixpacks (auto-detected build). The deployment pipeline:

1. **Build** — Nixpacks installs PHP 8.3, Composer, Node 20; runs `composer install`, `npm ci`, `npm run build`, and caches Laravel config/routes/views
2. **Deploy** — Container starts with `php artisan storage:link && php artisan serve`
3. **Database** — Railway-hosted MySQL with internal networking

For self-hosting on a VPS:
```bash
APP_ENV=production
APP_DEBUG=false

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

npm run build
chmod -R 755 storage bootstrap/cache
```

---

## License

This project is open-source for educational and portfolio purposes.  
Feel free to use it as a reference — a ⭐ star is appreciated!

---

<div align="center">
Built with ❤️ by <a href="https://github.com/afifn11">Muhammad Afif Naufal</a>
</div>