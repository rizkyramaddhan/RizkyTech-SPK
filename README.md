<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

======================== GAMBARAN APLIKASI =============================
Sistem RizkyTech ini bertujuan mendukung operasi PPIC: perencanaan produksi, perencanaan kebutuhan bahan (MRP), pengendalian persediaan, pembuatan Work Order (SPK kerja produksi), penjadwalan, pelacakan status produksi, quality control, dan modul keputusan (SPK) untuk prioritisasi produksi atau alokasi bahan mengunakan metode SAW.

Hasil Akhir : aplikasi web responsif di Laptop dan android, Keamanan yang Standarisasi, Mudah di maintenance dan Dokumentasi lengkap

======================== SUSUNAN TEKNIS ================================
Backend	: Laravel 12, Gunakan Service layer + Repository untuk pemisahan concern.
Frontend: CSS native, vanilla JS + progressive enhancement.
Auth	: Laravel Sanctum atau cookie-based HttpOnly session.
Database: MySQL, normalisasi sampai 3NF, index untuk query laporan & MRP.
DevOps	: CI GitHub untuk linting, testing, migration; staging & prod; env config via .env.
Security: CSRF, rate limiting, CSP, validation, role-based access control (RBAC).
Observability: Logging , error tracking , audits (who changed apa)

======================== MODUL & FITUR UTAMA ===========================
1. Authentication & RBAC
	Login, logout, reset password, 2FA (opsional).
	Roles: Admin, PPIC Planner, Production Supervisor, Warehouse, QC, 	Purchasing, Viewer.
	Permissions granular (manage BOM, create WO, approve PO, run MRP, 	view reports).
2. Master data
	Produk (VGA/CPU) — SKU, spec, lead time, cycle time.
	Bill of Materials (BOM) — hierarchical BOM (multi-level).
	Routing / Work Center (mesin, lead time per operation).
	Suppliers, Warehouse locations, Material items/raw materials.
	Unit of Measure, Safety Stock policy.
3. Inventory & Warehouse
	Stock by location, FIFO/LIFO setting, stock movements 		(in/out/transfer).
	Stock opname (cycle count), adjustment, stock reservation for 	work orders.
4. Procurement
	Purchase Requests → Purchase Orders → GRN (Goods Received Note) → 	AP invoice link (optional).
	Supplier lead time tracking, purchase history.
5. Production Planning (PPIC)
	Master Production Schedule (MPS).
	MRP run (calculate net requirements from BOM, stock, open PO, 	open WO).
	Generate suggested Purchase Orders & Work Orders.
	What-if simulation (run MRP dengan parameter berbeda).
6. Work Orders (SPK)
	Create / schedule / release / track WO.
	Assign work center, operator, estimated time, actual time, scrap.
	WO status dashboard (planned, released, in-progress, completed).
7. Quality Control (QC)
	QC inspection plans per product/operation, recording test 	results, pass/fail.
	Non-conformity report & corrective action link.
8. Decision Support (SPK)
	Modul pemilihan prioritas (mis. prioritas produksi saat stok 		bahan terbatas).
	Metode yang didukung: SAW, AHP, opsi fuzzy logic atau rules 	engine.
	UI: masukkan bobot/atribut → hitung → tampilkan ranking dan 	rekomendasi.
9. Reporting & Dashboards
	Dashboard KPI: OEE (opsional), production attainment, stock 		levels, overdue WO, supplier lead time variance.
	Laporan MRP, consumption, aging stock, procurement history, 		traceability.
	Export CSV / PDF.
10. Audit, Notifications & Integrasi
	Audit trail untuk perubahan krusial.
	Notifikasi via email / in-app (websocket optional).
	API endpoints untuk integrasi ERP/SCM atau MES.

======================== ARSITETKTUR DATABASE ===========================
1. users (id, name, email, password, role_id, active, created_at)
2. roles (id, name)
3. permissions (id, name); role_permission pivot
4. products (id, sku, name, description, type, lead_time_days, 5. cycle_time_minutes)
6. materials (id, sku, name, uom, safety_stock, lead_time_days)
7. boms (id, product_id, version, note)
8. bom_items (id, bom_id, material_id, qty)
9. work_centers (id, code, name, capacity, shifts)
10. mps (id, product_id, period_start, period_end, qty, status)
11. work_orders (id, wo_no, product_id, qty, planned_start, planned_end, 12. actual_start, actual_end, status, assigned_to)
13. po (id, po_no, supplier_id, status, expected_date)
14. po_items (po_id, material_id, qty, price)
15. stock_movements (id, ref_type, ref_id, material_id, qty, 16. location_from, location_to, type, created_by)
17. inventory (material_id, warehouse_id, qty_on_hand, reserved_qty)
18. mrp_runs (id, run_at, params_json, results_json)
19. decision_cases (id, name, inputs_json, method, result_json)

======================== FLOW PROSES  ===================================
1. Planner masukkan MPS (target produksi).
2. Jalankan MRP → sistem menghitung kebutuhan material    berdasarkan BOM, stock on-hand, open PO, safety stock.
3. Sistem mengeluarkan rekomendasi PO & WO.
4. PPIC review → approve PO / release WO.
5. Warehouse melakukan reservation dan picking material.
6. Production Supervisor menjalankan WO → update progress / actual times    / scrap.
7. QC inspeksi → hasil tersimpan.
8. Data kembali ke MRP & laporan KPI.

======================== METODE SPK  ====================================
Mengunakan SAW

======================== STRUKTUR PROJEK ================================
/app
  /Http
    /Controllers
    /Requests
  /Models
  /Services    <-- MRPService, DecisionService
  /Repositories
/resources
  /views  <-- Blade minimal templates
  /css
  /js
/routes
  web.php
  api.php
/database
  migrations
  seeders
/tests
  Feature
  Unit

======================== DOKUMENTASI ====================================
1. Dokumentasi (outline lengkap)
2. Overview & Goals
3. System Architecture (component diagram)
4. Data Model (ERD + tabel + kolom penting)
5. API Reference (endpoints, payload, response)
6. Frontend Structure & Style Guide (CSS variables, JS modules)
8. Deployment Guide (env, DB migration, seeding, oss dependencies)
9. Testing Guide (how to run tests, CI config)
10. User Manual (step-by-step: create MPS, run MRP, create WO, QC)
11. Admin Guide (role management, backups, monitoring)
12. Developer Notes (how to extend MRP/decision algorithms)
13. Change log & release notes

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
