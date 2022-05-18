						<!-- Footer -->
						<footer class="navbar bg-dark text-light mt-auto">
							<div class="container">
								<div class="copyright text-center mx-auto">
									<span>Copyright © Mitra Keluarga <?= date('Y'); ?></span>
									<input type="hidden" id="baseUrl" value="<?php echo base_url(); ?>">
									<input type="hidden" id="lokasiID" value="<?= $this->session->userdata('lokasi_id'); ?>">
									<input type="hidden" id="lokasiID" value="<?= $this->session->userdata('ora_session'); ?>">
								</div>
							</div>
						</footer>
						<!-- End of Footer -->

					</div>
					<!-- End of Main Content -->
				</div>
				<!-- End of Content -->
			</div>
			<!-- End Of Wrapper -->

		<!-- Js jquery -->	
		<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
		<!-- Js popper -->
		<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
		<!-- Js moment -->
		<script src="<?php echo base_url('assets/js/moment.js'); ?>"></script>

		<!-- Jquery UI -->
		<script src="<?php echo base_url('assets/vendor/jquery-ui-1.13.0/jquery-ui.min.js'); ?>"></script>
		<!-- Jquery Validation -->
		<script src="<?php echo base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
		<!-- datetimepicker jquery -->
		<script src="<?php echo base_url('assets/vendor/date-time-picker/build/js/bootstrap-datetimepicker.min.js'); ?>"></script>
		<!-- masked input jquery -->
		<script src="<?php echo base_url('assets/vendor/masked-input/jquery-maskedinput.min.js'); ?>"></script>
		<!-- tinysort jquery -->
		<script src="<?php echo base_url('assets/vendor/tinysort-3.2.5/tinysort.min.js'); ?>"></script>
		<!-- dropzone jquery -->
		<script src="<?php echo base_url('assets/vendor/dropzone/js/dropzone.min.js'); ?>"></script>
		<!-- Js Util -->
		<script src="<?php echo base_url('assets/bootstrap-4.6.1/js/dist/util.js'); ?>"></script>
		<!-- Js bootstrap -->
		<script src="<?php echo base_url('assets/bootstrap-4.6.1/dist/js/bootstrap.bundle.min.js'); ?>"></script>
		<!-- main.js -->
		<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/all.js?v=202205190002'); ?>"></script>

	</body>

</html>