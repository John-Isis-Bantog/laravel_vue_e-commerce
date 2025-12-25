Laravel + Vue E-Commerce Application

A simple e-commerce web application built with Laravel, Vue, Inertia.js, Supabase Storage, and Stripe.
This project demonstrates a modern full-stack setup using Laravel as the backend API and Vue as the frontend, without traditional REST APIs.

🚀 Tech Stack
Backend

Laravel – Application backend, routing, validation, authorization

Laravel Breeze + Fortify – Authentication & authorization

Inertia.js – Server-driven SPA architecture

MySQL – Relational database

Stripe – Payment processing

Supabase Storage – Image/file storage (product images)

Frontend

Vue 3 (Composition API)

TypeScript

Tailwind CSS

Shadcn UI components

Inertia.js Vue adapter

✨ Features
Authentication & Roles

User authentication (login, register, email verification)

Role-based access control (admin / customer)

Secure route protection using middleware and policies

Admin Features

Admin dashboard with statistics

CRUD management for:

Products

Categories

Admin users

Product activation/deactivation

Image upload using Supabase Storage

Live search (Inertia-based, no page reloads)

Customer Features

Product listing (active products only)

Product details view

Add to cart functionality

Stripe checkout integration

Role-aware navigation and redirects

🧠 Architecture Highlights

No traditional AJAX / Axios

Uses Inertia.js for seamless page updates

Single source of truth

Server controls data, frontend renders state

Role-based redirects

Centralized logic using invokable controllers

Clean separation of concerns

Controllers handle logic

Vue handles presentation

Policies handle authorization

📁 Storage & Uploads

Product images are stored using Supabase Buckets

Laravel handles upload validation

Public URLs are stored in the database

Supports optional images (nullable uploads)

💳 Payments

Stripe integration for checkout

Secure server-side payment intent handling

Ready for expansion (orders, receipts, webhooks)

⚙️ Installation & Setup
Prerequisites

PHP 8.1+

Composer

Node.js & npm

MySQL

Stripe account

Supabase project

Steps

Clone the repository

Install backend dependencies

Install frontend dependencies

Configure environment variables

Run migrations

Build frontend assets

Start the development server

Detailed .env configuration is required for:

Database

Stripe keys

Supabase storage credentials

🧪 Development Notes

Uses Inertia’s form helpers for validation and error handling

Uses Laravel policies & middleware for authorization

TypeScript is enforced with ESLint for better code quality

CI checks ensure linting and build integrity

📌 Why This Project?

This project was built to:

Learn modern Laravel + Vue architecture

Understand role-based access control

Practice real-world file storage and payments

Demonstrate clean backend/frontend integration

Build something close to production patterns

🔮 Future Improvements

Order history

Inventory tracking

Stripe webhooks

Pagination & filtering

Unit and feature tests

Admin analytics charts

📜 License

This project is open-source and available for educational and portfolio purposes.
