# Day 1 — Topik Umum & Poin Penting (Migrasi CI → Laravel)

Dokumen ringkas ini merangkum topik umum dan poin-poin penting untuk sesi Day 1. Letakkan materi demo terperinci terpisah bila diperlukan.

## 1) Struktur & Filosofi Laravel

- Konvensi > konfigurasi: struktur direktori yang jelas (`app/`, `routes/`, `config/`, `resources/`, `database/`).
- Alur request modern: route → controller → service (opsional) → model → view.
- MVC dengan pemisahan concern yang tegas; dorong testability dan maintainability.

## 2) Perbedaan Filosofi: CodeIgniter 4 vs Laravel

- Arsitektur: CI fleksibel/minimalis vs Laravel berkonvensi kuat/ekosistem lengkap.
- Dependency Injection: CI cenderung manual vs Laravel via Service Container (IoC, auto-resolution).
- Database Layer: CI Query Builder vs Laravel Eloquent (Active Record) + Schema Builder.
- Tooling: ekosistem Laravel (Artisan, Horizon, Scout, etc.) mempersingkat pengembangan.

## 3) Blade Templating

- Layout & section (`@extends`, `@section`, `@yield`) untuk DRY views.
- Komponen & partial (`<x-...>`, `@include`) untuk reusable UI.
- Keamanan: auto-escaping, directive umum (`@if`, `@foreach`, `@csrf`).

## 4) Eloquent ORM & Query Builder

- Model sebagai representasi tabel; konvensi penamaan & timestamps.
- Relasi: `hasOne`, `hasMany`, `belongsTo`, `belongsToMany`; eager loading (`with`).
- Query umum: filter, sort, paginate; Query Scopes untuk reusable constraints.
- Data lifecycle: migration, seeder, factory untuk konsistensi antar environment.

## 5) Environment Management

- `.env` per environment (local/staging/production) + `config()` sebagai antarmuka.
- Keamanan & performa: `APP_DEBUG=false` di production; gunakan `config:cache` untuk optimasi.
- Simpan secrets di environment, bukan di repo.

## 6) Service Container & DI

- Constructor injection untuk ketergantungan; mudah di-mock saat testing.
- Binding interface → implementasi di provider; pilih lifecycle (singleton/bind) sesuai kebutuhan.
- Kurangi coupling, tingkatkan reusability.

## 7) PHP Standards Recommendations (PSR)

- PSR-4: autoloading berbasis namespace/folder.
- PSR-12: coding style konsisten (indentasi, spasi, kurung, naming).
- PSR-7: standar HTTP message (berguna terutama di API dan interoperabilitas).

## 8) Best Practices

- Service layer untuk logika bisnis; controller tetap tipis.
- Validasi via Form Request; gunakan Resource/DTO untuk serialisasi respon.
- Gunakan type hinting, strict types (bila sesuai), dan dokumentasi yang cukup.
- Error handling & logging terpusat; hindari konfigurasi hard-coded (gunakan env).
