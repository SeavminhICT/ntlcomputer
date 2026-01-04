# Computer Store QR-Code Online Menu / Catalog System

Laravel 12 + MySQL system that lets customers scan a QR code and browse computer products online, while admins manage inventory, pricing, and specs.

## Key Features

- Public catalog (mobile-first) with search, category filters, and product detail pages
- Admin panel with login, dashboard, product & category management
- Multiple product image uploads
- QR code generator for the catalog URL
- RESTful APIs (public catalog + secured admin)

## Tech Stack

- Backend: Laravel 12 (PHP 8.2+)
- Database: MySQL
- Frontend: Blade, Bootstrap 5, HTML/CSS/JS
- QR Code: simplesoftwareio/simple-qrcode
- API Auth: Laravel Sanctum

## Database Design

Tables + key fields:

- users: name, email, password, role
- categories: name, status
- products: category_id, product_code, brand, model, cpu, ram, storage, gpu, display, color, condition, warranty, country, price, stock, description, status
- product_images: product_id, image_path

## Setup (Local)

1) Install dependencies
```bash
composer install
npm install
```

2) Environment
```bash
cp .env.example .env
php artisan key:generate
```

3) Configure `.env`
```
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=computer_store
DB_USERNAME=root
DB_PASSWORD=secret

STORE_NAME="NTL Computer Store"
STORE_LOGO="/images/logo.png"
STORE_CATALOG_URL="http://127.0.0.1:8000/catalog"
```

4) Install Sanctum + QR Code package
```bash
composer require laravel/sanctum simplesoftwareio/simple-qrcode
php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"
php artisan migrate
```

5) Storage link (for product images and QR codes)
```bash
php artisan storage:link
```

6) Seed sample data
```bash
php artisan db:seed
```

7) Run the app
```bash
php artisan serve
```

## Admin Login

Seeded admin account:
- Email: `admin@computerstore.test`
- Password: `password`

Admin panel: `http://127.0.0.1:8000/admin`

## Customer Catalog

Public catalog URL: `http://127.0.0.1:8000/catalog`

## REST API

Public catalog:
- `GET /api/catalog/categories`
- `GET /api/catalog/products?category=ID&q=search`
- `GET /api/catalog/products/{id}`

Admin auth (Sanctum):
- `POST /api/admin/login` → `{ email, password }` returns bearer token
- `POST /api/admin/logout`

Admin resources (Bearer token required):
- `GET /api/admin/categories`
- `POST /api/admin/categories`
- `PUT /api/admin/categories/{id}`
- `DELETE /api/admin/categories/{id}`
- `GET /api/admin/products`
- `POST /api/admin/products`
- `GET /api/admin/products/{id}`
- `PUT /api/admin/products/{id}`
- `DELETE /api/admin/products/{id}`
- `DELETE /api/admin/products/{product}/images/{image}`

## QR Code Flow

1) Admin visits `/admin/qr`
2) System generates `storage/app/public/qr/catalog-qr.svg`
3) Admin downloads PNG and prints it

## Deployment Guide (Production)

1) Server requirements: PHP 8.2+, MySQL 8, Composer, Node.js
2) Configure `.env` with production DB + `APP_URL`
3) Install dependencies:
```bash
composer install --optimize-autoloader --no-dev
npm install && npm run build
```
4) Run migrations + seed:
```bash
php artisan migrate --force
php artisan db:seed --force
```
5) Link storage:
```bash
php artisan storage:link
```
6) Set permissions for `storage/` and `bootstrap/cache/`
7) Configure your web server (Nginx/Apache) to point to `public/`

## Notes

- Update store name/logo in `config/store.php` or `.env`.
- Add product images via Admin → Products.
- QR code is generated as SVG (no Imagick needed); delete the file to force refresh.
