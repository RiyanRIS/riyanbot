<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      v1.0.2
    </div>
    <!-- Default to the left -->
    <strong>Copyright&copy; <?= date("Y") ?> <a href="https://ukmik.org">ukmik.org</a>.</strong> All rights reserved.
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="<?= base_url("adminlte") ?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url("adminlte") ?>/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url("adminlte") ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url("adminlte") ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url("adminlte") ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url("adminlte") ?>/dist/js/adminlte.min.js"></script>
<!-- NotifyJS -->
<script src="<?= base_url("assets") ?>/notify.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url("adminlte") ?>/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<!-- Slimscroll -->
<script src="<?= base_url("adminlte") ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url("adminlte") ?>/bower_components/fastclick/lib/fastclick.js"></script>

<script>
$(function () {
    $('.datatable').DataTable();
})
<?php if(session()->has('msg')){
    if(session()->get('msg')[0] == 1){ ?>
        $.notify("<?= session()->get('msg')[1] ?>", "success");
    <?php }elseif(session()->get('msg')[0] == 0){ ?>
        $.notify("<?= session()->get('msg')[1] ?>", "error");
    <?php }
} ?>
function confirmation(ev) {
ev.preventDefault();
var urlToRedirect = ev.currentTarget.getAttribute('href');
console.log(urlToRedirect); 
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
})
.then((result) => {
  if (result.isConfirmed) {
    window.location.href=urlToRedirect;
  } else {
    
  }
});
}

</script>