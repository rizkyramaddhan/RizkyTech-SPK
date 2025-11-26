{{-- resources/views/ppic/dashboard.blade.php --}}
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard PPIC</title>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
</head>

<body>
    <header class="topbar">
        <div class="container">
            <h1 class="brand">PPIC Dashboard</h1>
            <div class="meta">
                <span class="user">Halo, Admin</span>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="panel search-panel">
            <input id="search" type="search" placeholder="Cari produk / SKU..." aria-label="Cari produk">
        </section>

        <section class="panel summary-panel" aria-labelledby="summaryTitle">
            <h2 id="summaryTitle">Ringkasan</h2>
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="card-title">Total Produk</div>
                    <div class="card-value">{{ count($products) }}</div>
                </div>
                <div class="summary-card">
                    <div class="card-title">Produk Low Stock</div>
                    <div class="card-value" id="lowStockCount">--</div>
                </div>
                <div class="summary-card">
                    <div class="card-title">Total Stock</div>
                    <div class="card-value" id="totalStock">--</div>
                </div>
            </div>
        </section>

        <section class="panel list-panel" aria-labelledby="productListTitle">
            <h2 id="productListTitle">Product List</h2>

            {{-- MOBILE: cards --}}
            <div class="card-list" id="cardList">
                @foreach ($products as $p)
                    <article class="product-card" data-sku="{{ $p['sku'] }}"
                        data-name="{{ strtolower($p['name']) }}">
                        <header class="pcard-head">
                            <div class="pcard-title">
                                <div class="sku">{{ $p['sku'] }}</div>
                                <div class="name">{{ $p['name'] }}</div>
                            </div>
                            <div class="pcard-stock">
                                <div class="stock">{{ $p['stock'] }}</div>
                                <div class="stock-label">stok</div>
                            </div>
                        </header>

                        <div class="pcard-body">
                            <div class="bom-preview">
                                <strong>BOM:</strong>
                                <ul>
                                    @foreach ($p['bom'] as $i => $b)
                                        <li>{{ $b['part'] }} <span class="qty">×{{ $b['qty'] }}</span></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="pcard-actions">
                                <button class="btn small toggle-bom" aria-expanded="false">Toggle BOM</button>
                                <button class="btn small details" data-id="{{ $p['id'] }}">Detail</button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- DESKTOP: table (hidden on small screens) --}}
            <div class="table-wrap">
                <table class="product-table" id="productTable">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Produk</th>
                            <th>Stock</th>
                            <th>Min Stock</th>
                            <th>BOM (preview)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            <tr>
                                <td>{{ $p['sku'] }}</td>
                                <td>{{ $p['name'] }}</td>
                                <td>{{ $p['stock'] }}</td>
                                <td>{{ $p['min_stock'] ?? '-' }}</td>
                                <td>
                                    @foreach ($p['bom'] as $b)
                                        <span class="bom-chip">{{ $b['part'] }}×{{ $b['qty'] }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <script>
        // Minimal JS untuk toggle BOM & search
        document.addEventListener('DOMContentLoaded', function() {
            const products = @json($products);
            const cardList = document.getElementById('cardList');
            const lowStockCountEl = document.getElementById('lowStockCount');
            const totalStockEl = document.getElementById('totalStock');
            const searchInput = document.getElementById('search');

            // compute summary
            let totalStock = products.reduce((s, p) => s + (p.stock || 0), 0);
            let lowStockCount = products.filter(p => (p.min_stock ?? 0) && p.stock <= p.min_stock).length;
            totalStockEl.textContent = totalStock;
            lowStockCountEl.textContent = lowStockCount;

            // toggle bom details (for card view)
            document.querySelectorAll('.toggle-bom').forEach(btn => {
                btn.addEventListener('click', () => {
                    const article = btn.closest('.product-card');
                    const expanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', String(!expanded));
                    article.classList.toggle('bom-hidden');
                });
            });

            // simple search filter
            searchInput.addEventListener('input', (e) => {
                const q = e.target.value.trim().toLowerCase();
                document.querySelectorAll('.product-card').forEach(card => {
                    const name = card.dataset.name;
                    const sku = card.dataset.sku.toLowerCase();
                    const visible = !q || name.includes(q) || sku.includes(q);
                    card.style.display = visible ? '' : 'none';
                });

                // also filter table rows if visible
                document.querySelectorAll('#productTable tbody tr').forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = (!q || rowText.includes(q)) ? '' : 'none';
                });
            });
        });
    </script>
</body>

</html>
