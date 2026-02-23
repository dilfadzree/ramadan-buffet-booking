# 🌙 Ramadan Buffet Booking System

A full-stack Laravel booking system for managing Ramadan buffet reservations with real-time capacity tracking, interactive booking widgets, online payment integration, and a staff management dashboard.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2+
- **Frontend:** Blade, Tailwind CSS (CDN), Alpine.js
- **Database:** MySQL 8.x
- **Payment Gateways:** SenangPay, ToyyibPay

## Features

### Public Landing Page
- Animated hero section with booking call-to-action
- Pricing cards (Adults RM 89 / Children RM 45 / OKU RM 45)
- Interactive booking widget with real-time availability checking
- AJAX-powered calendar showing available dates

### Customer Booking Flow
1. Visit the landing page and scroll to the booking section
2. Select a date from the calendar — slots with remaining capacity are highlighted
3. Enter number of adults, children, OKU (disabled) guests, and baby chairs needed
4. Fill in contact details (name, phone, email)
5. Submit the booking — redirected to payment gateway selection
6. Choose **SenangPay** or **ToyyibPay** to complete payment
7. After successful payment — receive a booking confirmation with reference number

### Payment Gateway Integration
- **SenangPay** — FPX and Credit/Debit Card payments via SenangPay Open API
- **ToyyibPay** — FPX and Credit/Debit Card payments via ToyyibPay Bill API
- Automatic booking confirmation upon successful payment
- Server-to-server callback for reliable payment status updates
- Configurable sandbox/production modes for both gateways

### Staff Dashboard (`/staff`)
- **Dashboard** — Overview with today's bookings, monthly stats, total pax, and capacity utilization
- **Booking Management** (`/staff/bookings`) — Search, filter by date/status, sort columns, paginate, create manual bookings, edit, cancel, and export to CSV
- **Capacity Management** (`/staff/capacity`) — Set max capacity per day (single date or date range), visual calendar grid with color-coded utilization (green = available, yellow = nearly full, red = full)

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.x
- Laragon (recommended) or any local PHP development environment

### Setup

```bash
# Clone the repository
git clone https://github.com/dilfadzree/ramadan-buffet-booking.git
cd ramadan-buffet-booking

# Install dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate
```

### Database Configuration

Edit `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ramadan_buffet
DB_USERNAME=root
DB_PASSWORD=
```

Then create the database and run migrations:

```bash
# Create the database (via MySQL CLI or HeidiSQL)
mysql -u root -e "CREATE DATABASE IF NOT EXISTS ramadan_buffet;"

# Run migrations and seed data
php artisan migrate
php artisan db:seed
```

The seeder creates:
- **Staff account** for dashboard access
- **Daily capacities** for Ramadan 2026 (Feb 17 – Mar 18) with default 100 pax/day

### Payment Gateway Configuration

#### SenangPay

1. Register at [SenangPay](https://www.senangpay.my/) and get your credentials
2. Add to `.env`:

```env
SENANGPAY_MERCHANT_ID=your_merchant_id
SENANGPAY_SECRET_KEY=your_secret_key
SENANGPAY_SANDBOX=true
```

3. In your SenangPay dashboard, set:
   - **Return URL:** `https://yourdomain.com/payment/senangpay/return`
   - **Callback URL:** `https://yourdomain.com/payment/senangpay/callback`

#### ToyyibPay

1. Register at [ToyyibPay](https://toyyibpay.com/) and create a Category
2. Add to `.env`:

```env
TOYYIBPAY_SECRET_KEY=your_user_secret_key
TOYYIBPAY_CATEGORY_CODE=your_category_code
TOYYIBPAY_SANDBOX=true
```

3. In your ToyyibPay dashboard, set:
   - **Return URL:** `https://yourdomain.com/payment/toyyibpay/return`
   - **Callback URL:** `https://yourdomain.com/payment/toyyibpay/callback`

#### Buffet Pricing

Prices can be configured in `.env`:

```env
BUFFET_PRICE_ADULT=89
BUFFET_PRICE_CHILD=45
BUFFET_PRICE_OKU=45
```

> **Note:** Set `SENANGPAY_SANDBOX=true` / `TOYYIBPAY_SANDBOX=true` for testing. Change to `false` for production.

### Run the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` (or your configured Laragon URL).

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Staff | `staff@ramadanbuffet.com` | `password` |
| Customer | `customer@example.com` | `password` |

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/check-availability?date=YYYY-MM-DD&pax=N` | Check if a date can accommodate N pax |
| GET | `/api/available-dates?year=YYYY&month=MM` | Get available dates for a month |

## Project Structure

```
app/
├── Events/
│   └── BookingCreated.php           # Booking created event
├── Http/Controllers/
│   ├── AuthController.php           # Login/logout
│   ├── BookingController.php        # Public booking + API
│   ├── LandingPageController.php    # Landing page
│   ├── PaymentController.php        # Payment gateway handling
│   └── Staff/
│       ├── DashboardController.php  # Staff dashboard
│       ├── BookingController.php    # CRUD bookings
│       └── CapacityController.php   # Capacity management
├── Listeners/
│   └── SendConfirmationEmail.php    # Email on booking
├── Models/
│   ├── Booking.php                  # Booking model with scopes
│   ├── DailyCapacity.php            # Capacity model
│   └── User.php                     # User with roles
├── Services/
│   ├── AvailabilityService.php      # Real-time availability checks
│   ├── BookingService.php           # Booking business logic
│   ├── CapacityService.php          # Capacity management logic
│   ├── SenangPayService.php         # SenangPay integration
│   └── ToyyibPayService.php         # ToyyibPay integration
resources/views/
├── landing.blade.php                # Public landing page
├── booking/
│   └── confirmation.blade.php       # Booking confirmation
├── payment/
│   ├── checkout.blade.php           # Payment gateway selection
│   ├── failed.blade.php             # Payment failed page
│   └── not-configured.blade.php     # Gateway not configured
├── layouts/
│   ├── app.blade.php                # Public layout (dark theme)
│   └── staff.blade.php              # Staff dashboard layout
├── staff/
│   ├── dashboard.blade.php          # Staff overview
│   ├── bookings/                    # Booking CRUD views
│   └── capacity/                    # Capacity management
```

## License

Open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
