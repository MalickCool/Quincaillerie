<?php
/**
 * Created by PhpStorm.
 * User: Malick Coulibaly
 * Date: 04/03/2020
 * Time: 12:33
 */
?>
		<footer class="main-footer">
			<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
			All rights reserved.
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 3.0.3-pre
			</div>
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->

		<!-- VueJs -->
		<script src="<?= base_url("assets/plugins/vuejs/vue.min.js") ?>"></script>
		<!-- jQuery -->
		<script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?= base_url("assets/plugins/jquery-ui/jquery-ui.min.js") ?>"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
		<!-- Select2 -->
		<script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>
		<!-- ChartJS -->
		<script src="<?= base_url("assets/plugins/chart.js/Chart.min.js") ?>"></script>
		<!-- Sparkline -->
		<script src="<?= base_url("assets/plugins/sparklines/sparkline.js") ?>"></script>
		<!-- JQVMap -->
		<script src="<?= base_url("assets/plugins/jqvmap/jquery.vmap.min.js") ?>"></script>
		<script src="<?= base_url("assets/plugins/jqvmap/maps/jquery.vmap.usa.js") ?>"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?= base_url("assets/plugins/jquery-knob/jquery.knob.min.js") ?>"></script>
		<!-- daterangepicker -->
		<script src="<?= base_url("assets/plugins/moment/moment.min.js") ?>"></script>
		<script src="<?= base_url("assets/plugins/daterangepicker/daterangepicker.js") ?>"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?= base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") ?>"></script>
		<!-- DataTables -->
		<script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.js") ?>"></script>
		<script src="<?= base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js") ?>"></script>
		<!--Axios JavaScript -->
		<script type="text/javascript" src="<?= base_url("assets/plugins/axios/axios.min.js") ?>"></script>
		<!-- Summernote -->
		<script src="<?= base_url("assets/plugins/summernote/summernote-bs4.min.js") ?>"></script>
		<!-- overlayScrollbars -->
		<script src="<?= base_url("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") ?>"></script>
		<!-- AdminLTE App -->
		<script src="<?= base_url("assets/dist/js/adminlte.js") ?>"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="<?= base_url("assets/dist/js/pages/dashboard.js") ?>"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?= base_url("assets/dist/js/demo.js") ?>"></script>
		<script src="<?= base_url("assets/dist/js/currency.js") ?>"></script>

		<script>
			$(function () {
				$('.datatableset').DataTable({
					"paging": false,
					"lengthChange": false,
					"searching": true,
					"ordering": true,
					"info": false,
					"autoWidth": false,
				});
			});

            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $(document).on("wheel", "input[type=number]", function (e) {
                $(this).blur();
            });
		</script>

		<?php
			if(isset($script)){
				$this->load->view("templates/scripts/".$script);
			}
		?>


		<?php
			if(isset($script2)){
				$this->load->view("templates/scripts/".$script2);
			}
		?>

		<style>
			/* Chrome, Safari, Edge, Opera */
			input::-webkit-outer-spin-button,
			input::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}

			/* Firefox */
			input[type=number] {
				-moz-appearance: textfield;
			}
		</style>
	</body>
</html>
