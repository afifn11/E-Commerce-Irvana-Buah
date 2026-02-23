# Irvana Buah — Fresh Fruit E-Commerce Platform

A full-stack e-commerce web application for a fresh fruit store, built with Laravel 12. Features a customer-facing storefront and a complete admin dashboard for managing products, orders, and users.

> **Type:** Personal / Portfolio Project  
> **Stack:** Laravel 12, Bootstrap 5, Tailwind CSS, MySQL  
> **Status:** Completed

---

## Preview

| Customer Storefront | Admin Dashboard |
|---|---|
| Homepage, shop, product detail, cart, checkout | Dashboard stats, product/order/user management |

---

## Features

### Customer Storefront
- **Homepage** — Hero banner, featured products, best sellers, and active discounts
- **Shop** — Full product listing with category filter, price filter, sorting, and real-time search
- **Product Detail** — Complete product info, stock availability, discount pricing, and add to cart
- **Shopping Cart** — AJAX-powered quantity updates and item removal without page reload
- **Checkout** — Order form with multiple payment options (Bank Transfer, Digital Wallet, COD)
- **Order Confirmation** — Post-checkout summary page with order details
- **Authentication** — Register, login, and password reset via Laravel Breeze
- **Customer Dashboard** — View order history and manage personal profile

### Admin Panel
- **Dashboard** — Real-time statistics: total products, categories, orders, and revenue
- **Product Management** — Full CRUD with image upload or external image URL support
- **Category Management** — Organize products by fruit category
- **Order Management** — View all orders, update order status, and track fulfillment
- **User Management** — Manage accounts and assign roles (admin / user)

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | Bootstrap 5, Tailwind CSS, Vanilla JS |
| Database | MySQL (default), MySQL-compatible |
| Auth | Laravel Breeze |
| Libraries | AOS, Swiper.js |
| Build Tool | Vite + NPM |

---

## Getting Started

### Requirements
- PHP >= 8.2
- Composer
- Node.js & NPM

### Installation

```bash
# Clone the repository
git clone https://github.com/afifn11/irvana-buah.git
cd irvana-buah

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed        # Optional: seed sample data

# Storage & assets
php artisan storage:link
npm run build

# Start development server
php artisan serve
```

Application runs at `http://localhost:8000`

---

## Default Credentials

Available after running `php artisan db:seed`:

| Role | Email | Password |
|---|---|---|
| Admin | admin@irvanabuah.com | 12345678 |
| User | user@irvanabuah.com | password |

---

## Database Configuration

**SQLite** is configured by default and requires no additional setup.

To switch to **MySQL**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=irvana_buah
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## Project Structure

```
irvana-buah/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php          # Public storefront pages
│   │   ├── CartController.php          # Cart operations (AJAX)
│   │   ├── CheckoutController.php      # Order processing
│   │   ├── CustomerOrderController.php # Customer order history
│   │   ├── CustomerProfileController.php
│   │   ├── ProductWebController.php    # Admin: product CRUD
│   │   ├── CategoryController.php      # Admin: category CRUD
│   │   ├── OrderController.php         # Admin: order management
│   │   ├── UserController.php          # Admin: user management
│   │   └── DashboardController.php     # Admin: dashboard stats
│   └── Models/
│       ├── Product.php     # Accessors for pricing, stock, ratings
│       ├── Category.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Cart.php
│       └── User.php
├── resources/views/
│   ├── home.blade.php
│   ├── home/
│   │   ├── app.blade.php               # Main frontend layout
│   │   ├── allproducts.blade.php
│   │   ├── detail.blade.php
│   │   ├── cart.blade.php
│   │   ├── checkout.blade.php
│   │   ├── order-success.blade.php
│   │   ├── about.blade.php
│   │   ├── contact.blade.php
│   │   └── partials/
│   │       ├── header.blade.php
│   │       └── footer.blade.php
│   ├── dashboard.blade.php
│   ├── products/
│   ├── categories/
│   ├── orders/
│   └── users/
└── routes/web.php
```

---

## Key Technical Highlights

- **AJAX cart operations** — add, update, and remove items without page reload
- **Role-based access control** — middleware-protected admin routes separate from customer routes
- **Automatic stock management** — stock decrements on checkout and restores on cancellation
- **Order number generation** — formatted as `IB-YYYYMMDD-XXXXXX`
- **Real-time product search** — AJAX-based search with instant results
- **Discount system** — percentage-based discounts with automatic effective price calculation via model accessors
- **CSRF protection** on all forms and AJAX requests
- **SQL injection protection** via Laravel Eloquent ORM

---

## Production Deployment

```bash
# Set production environment
APP_ENV=production
APP_DEBUG=false

# Cache optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Build production assets
npm run build

# Set file permissions
chmod -R 755 storage bootstrap/cache
```

---

## License

This project is intended for educational and portfolio purposes.