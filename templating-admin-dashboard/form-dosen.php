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
					<div class="card card-info card-outline mb-4">
						<div class="card-header">
							<div class="card-title">Custom Validation</div>
						</div>
						<form class="needs-validation" novalidate>
							<div class="card-body">
								<div class="row g-3">
									<div class="col-12">
										<label for="validationCustom01" class="form-label">First name</label>
										<input
											type="text"
											class="form-control"
											id="validationCustom01"
											value="Mark"
											required />
										<div class="valid-feedback">Looks good!</div>
									</div>
									<div class="col-12">
										<label for="validationCustom03" class="form-label">City</label>
										<input
											type="text"
											class="form-control"
											id="validationCustom03"
											required />
										<div class="invalid-feedback">Please provide a valid city.</div>
									</div>
									<div class="col-12">
										<label for="validationCustom04" class="form-label">State</label>
										<select class="form-select" id="validationCustom04" required>
											<option selected disabled value="">Choose&hellip;</option>
											<option>California</option>
											<option>Washington</option>
											<option>Tennessee</option>
										</select>
										<div class="invalid-feedback">Please select a valid state.</div>
									</div>
									<div class="col-12">
										<label for="validationCustom05" class="form-label">Zip</label>
										<input
											type="text"
											class="form-control"
											id="validationCustom05"
											required />
										<div class="invalid-feedback">Please provide a valid zip.</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button class="btn btn-info" type="submit">Submit form</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include('footer.php') ?>