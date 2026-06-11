<?php include('header.php');
include('navbar.php');
include('sidebar.php');
?>

<main class="app-main">
	<?php include('app-content-header.php') ?>
	<div class="app-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card mb-4">
						<div class="card-header">
							<h3 class="card-title">Data Mahasiswa</h3>

							<div class="card-tools">
								<ul class="pagination pagination-sm float-end">
									<li class="page-item">
										<a class="page-link" href="#">&laquo;</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">1</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">2</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">3</a>
									</li>
									<li class="page-item">
										<a class="page-link" href="#">&raquo;</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body p-0">
							<table class="table">
								<thead>
									<tr class="text-center">
										<th>No</th>
										<th>Nama Mahasiswa</th>
										<th>NPM Mahasiswa</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr class="text-center">
										<td>1.</td>
										<td>Rudy Pancjoro</td>
										<td>2409182940</td>
										<td>
											<a href="" class="btn btn-primary btn-sm">Lihat Data</a>
											<a href="" class="btn btn-warning btn-sm">Edit Data</a>
											<a href="" class="btn btn-danger btn-sm">Hapus Data</a>
										</td>
									</tr>
									<tr class="text-center">
										<td>1.</td>
										<td>Rudy Pancjoro</td>
										<td>2409182940</td>
										<td>
											<a href="" class="btn btn-primary btn-sm">Lihat Data</a>
											<a href="" class="btn btn-warning btn-sm">Edit Data</a>
											<a href="" class="btn btn-danger btn-sm">Hapus Data</a>
										</td>
									</tr>
									<tr class="text-center">
										<td>1.</td>
										<td>Rudy Pancjoro</td>
										<td>2409182940</td>
										<td>
											<a href="" class="btn btn-primary btn-sm">Lihat Data</a>
											<a href="" class="btn btn-warning btn-sm">Edit Data</a>
											<a href="" class="btn btn-danger btn-sm">Hapus Data</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include('footer.php') ?>