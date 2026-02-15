# ShopCart Project

## About

ShopCart is a e-commerce shopping cart application built with Laravel and Herd. It manages products, shopping carts, orders, and customer interactions with customers and admins.

## Features

- **Product Management**: Browse and search available products
- **Shopping Cart**: Add, update, and manage items in the cart
- **Checkout System**: Checkout process for customers
- **Order Management**: Track and manage customer orders
- **Admin Dashboard**: Admin panel for managing products and viewing orders
- **User Authentication**: Secure user registration and login

## Installation

1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install JavaScript dependencies: `npm install`
4. Copy `.env.example` to `.env` and configure your database
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Build frontend assets: `npm run build`

## Usage

- Start the development server: `php artisan serve`
- Build frontend assets: `npm run dev`
- Run tests: `php artisan test`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Use your .env credentials in DBeaver to create a connection and tables:

Step 1: Create DBeaver Connection

Open DBeaver → Database → New Database Connection → PostgreSQL → Next
Fill in:
Host: 127.0.0.1
Port: 5432
Database: shopping_project
Username: YOUR_USERNAME
Password: YOUR_PASSWORD
Click "Test Connection" → Finish
Step 2: Create Tables in DBeaver

Right-click your connection → SQL Editor → New SQL Script
Paste this SQL:

CREATE TABLE products (
id SERIAL PRIMARY KEY,
sku VARCHAR(100) UNIQUE NOT NULL,
name VARCHAR(255) NOT NULL,
description TEXT,
price DECIMAL(10,2) NOT NULL,
image VARCHAR(255),
material VARCHAR(100),
length VARCHAR(100),
gemstone VARCHAR(100),
clasp_type VARCHAR(100),
style VARCHAR(100),
deleted BOOLEAN DEFAULT false,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
id SERIAL PRIMARY KEY,
email VARCHAR(255) UNIQUE NOT NULL,
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL,
phone_number VARCHAR(20),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carts (
cart_id SERIAL PRIMARY KEY,
isinorder BOOLEAN DEFAULT false,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart_items (
id SERIAL PRIMARY KEY,
cart_id INT NOT NULL REFERENCES carts(cart_id) ON DELETE CASCADE,
sku VARCHAR(100) NOT NULL REFERENCES products(sku),
quantity INT DEFAULT 1 CHECK (quantity > 0),
price DECIMAL(10,2) NOT NULL,
deleted BOOLEAN DEFAULT false,
isinorder BOOLEAN DEFAULT false,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
order_id SERIAL PRIMARY KEY,
cart_id INT REFERENCES carts(cart_id),
email VARCHAR(255) NOT NULL REFERENCES customers(email),
street_number VARCHAR(100),
street_name VARCHAR(255),
apt_number VARCHAR(100),
city VARCHAR(100),
state VARCHAR(100),
zip VARCHAR(10),
shipping_method VARCHAR(100),
total_cost DECIMAL(10,2) NOT NULL,
total_quantity INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
id SERIAL PRIMARY KEY,
order_id INT NOT NULL REFERENCES orders(order_id) ON DELETE CASCADE,
email VARCHAR(255),
sku VARCHAR(100) REFERENCES products(sku),
quantity INT NOT NULL CHECK (quantity > 0),
price DECIMAL(10,2) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
