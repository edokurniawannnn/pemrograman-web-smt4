<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCenterTitle">
					<i class="bx bx-error-circle text-danger me-2"></i>Konfirmasi Hapus Data
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p class="fs-6">Apakah Anda yakin ingin menghapus produk <strong id="teksNamaProduk" class="text-danger"></strong> beserta fotonya?</p>
				<div class="alert alert-warning mb-0" role="alert">
					<h6 class="alert-heading fw-bold mb-1">Peringatan!</h6>
					<span>Tindakan ini bersifat permanen dan tidak dapat dibatalkan.</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
					Batal
				</button>
				<a href="#" id="tombolEksekusiHapus" class="btn btn-danger">Ya, Hapus Data!</a>
			</div>
		</div>
	</div>
</div>
</div>

<div class="layout-overlay layout-menu-toggle"></div>
</div>
<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/dashboards-analytics.js"></script>

<script>
	// Logika untuk UI Dropdown Kategori
	document.querySelectorAll('.item-kategori').forEach(item => {
		item.addEventListener('click', function() {
			const idKategori = this.getAttribute('data-id');
			const namaKategori = this.innerText;

			document.getElementById('id_category_hidden').value = idKategori;

			document.getElementById('teksKategoriTerpilih').innerText = namaKategori;

			const btnDropdown = document.getElementById('btnKategoriDropdown');
			btnDropdown.classList.remove('btn-outline-primary');
			btnDropdown.classList.add('btn-primary');
		});
	});
</script>

<script>
	var modalHapus = document.getElementById('modalKonfirmasiHapus');
	modalHapus.addEventListener('show.bs.modal', function(event) {

		var button = event.relatedTarget;

		var idProduk = button.getAttribute('data-id');
		var namaProduk = button.getAttribute('data-nama');

		modalHapus.querySelector('#teksNamaProduk').textContent = namaProduk;

		modalHapus.querySelector('#tombolEksekusiHapus').href = 'action/action_hapus_produk.php?id=' + idProduk;
	});
</script>
</body>

</html>