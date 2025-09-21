<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# E-Commerce Management System

A Laravel-based e-commerce management system that allows administrators to manage products and orders, and users to search products, place orders, make payments, and handle order updates.  

The system follows modern **clean architecture** principles: Thin Controllers, Fat Models, Service Layer for complex logic, Form Requests for validation, Resources for API responses, Traits for reusable logic, and Custom Exceptions for consistent error handling.

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Project Structure](#project-structure)
- [Key Components](#key-components)
- [API Endpoints](#api-endpoints)
- [Error Handling](#error-handling)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Features

### Admin
- Add, update, delete, and list products.  
- Update order status.  

### User
- Search products by name.  
- Create and manage orders.  
- Process payments.  
- View, cancel, or update orders.  
- Update product quantity in orders.  
- Remove products from orders.  

### Authentication
- Register & login with role-based tokens (admin/user).  
- Logout.  

### System
- Standardized API responses via `Resources` and `ApiResponse` Trait.  
- Validation via `Form Requests` with custom JSON error responses.  
- Business exceptions with unified JSON responses.  
- Database relationships: Products, Orders, OrderProducts, Categories, Users with roles.

---

## Requirements

- PHP >= 8.1  
- Laravel >= 10.x  
- Composer  
- MySQL (or any supported DB)  
- Laravel Sanctum (API authentication)  
- Spatie Laravel Permission (roles/permissions)  
- Storage for product images (public disk)

---
app/
├── Exceptions/ # Custom business exceptions
│ ├── BaseBusinessException.php
│ ├── QuantityExceededException.php
│ ├── OrderAlreadyPaidException.php
│ ├── InvalidPaymentAmountException.php
│ └── AuthenticationFailedException.php
├── Http/
│ ├── Controllers/ # Thin controllers
│ │ ├── Admin/
│ │ ├── Auth/
│ │ └── User/
│ ├── Requests/ # Validation requests
│ ├── Resources/ # API resources
│ ├── Traits/ # Reusable traits
├── Models/ # Fat models with business logic
├── Repository/ # Query repositories with BaseFilter
└── Services/ # Services for complex operations

## Key Components
- **Models (Fat Models):** contain business logic, relationships, stock/payment checks.  
- **Controllers (Thin):** delegate to services/models, return Resources.  
- **Services:** encapsulate complex logic (transactions, multi-model ops).  
- **Form Requests:** validation with standardized JSON error replies.  
- **Resources:** unified API output format.  
- **Traits:** reusable `ApiResponse` & `ApiValidationResponse`.  
- **Exceptions:** domain-specific (e.g., `QuantityExceededException`).  
- **Repositories:** extend `BaseFilter` to support dynamic filtering, search, sort, price range, relationships.
## Error Handling
- **Validation errors:** handled by Form Requests with JSON 400.  
- **Business errors:** handled via custom Exceptions with JSON responses.  
- **Global handler:** catches unhandled exceptions and formats JSON output
  


