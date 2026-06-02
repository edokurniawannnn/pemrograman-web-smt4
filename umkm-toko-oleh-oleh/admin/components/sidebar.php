<?php $halaman = basename($_SERVER['PHP_SELF']); ?>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo">
		<a href="index.php" class="app-brand-link">
			<span class="app-brand-logo demo">
				<svg width="25" viewBox="0 0 24 24" fill="none" stroke="#696cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
					<line x1="3" y1="6" x2="21" y2="6"></line>
					<path d="M16 10a4 4 0 0 1-8 0"></path>
				</svg>
			</span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2">Oleh-Oleh</span>
		</a>

		<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		<li class="menu-item <?= ($halaman == 'index.php') ? 'active' : '' ?>">
			<a href="index.php" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Analytics">Dashboard</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">Manajemen Toko</span>
		</li>

		<li class="menu-item <?= in_array($halaman, ['produk.php', 'tambah_produk.php', 'edit_produk.php', 'detail_produk.php']) ? 'active' : '' ?>">
			<a href="produk.php" class="menu-link">
				<i class="menu-icon tf-icons bx bx-box"></i>
				<div data-i18n="Produk">Data Produk</div>
			</a>
		</li>

		<li class="menu-item <?= ($halaman == 'kategori_produk.php') ? 'active' : '' ?>">
			<a href="kategori_produk.php" class="menu-link">
				<i class="menu-icon tf-icons bx bx-collection"></i>
				<div data-i18n="Kategori">Kategori Produk</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">Sistem</span>
		</li>

		<li class="menu-item <?= ($halaman == 'user.php') ? 'active' : '' ?>">
			<a href="user.php" class="menu-link">
				<i class="menu-icon tf-icons bx bx-user"></i>
				<div data-i18n="Produk">Data User</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">Transaksi</span>
		</li>

		<li class="menu-item <?= ($halaman == 'data_pesanan.php') ? 'active' : '' ?>">
			<a href="data_pesanan.php" class="menu-link">
				<i class="menu-icon tf-icons bx bx-cart"></i>
				<div data-i18n="Pesanan">Data Pesanan</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase"><span class="menu-header-text">Sistem</span></li>

		<li class="menu-item">
			<a href="../index.php" class="menu-link" target="_blank">
				<i class="menu-icon tf-icons bx bx-store"></i>
				<div data-i18n="Toko">Lihat Website</div>
			</a>
		</li>

		<li class="menu-item mt-3">
			<a href="../logout.php" class="menu-link bg-label-danger">
				<i class="menu-icon tf-icons bx bx-power-off text-danger"></i>
				<div data-i18n="Logout" class="text-danger fw-bold">Keluar</div>
			</a>
		</li>
	</ul>
</aside>