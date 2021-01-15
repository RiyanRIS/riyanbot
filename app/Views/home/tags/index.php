<?= view('home/template/head') ?>

<?= view('home/template/nav') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?= breadcump($title,$breadcump) ?>

  <!-- Main content -->
  <section class="content container-fluid">

  <div class="row">
    <div class="col-xs-12">
      <a href="<?= site_url("home/tags/tambah") ?>" class="btn btn-primary mb-3"><i class="fa fa-plus-square"></i> Tambah Tags</a>
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table datatable table-hovered table-bordered">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>TAGS</th>
                  <th>SLUG</th>
                  <th style="min-width:160px;width:161px;max-width:162px">#</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($tags as $key):?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $key['tags'] ?></td>
                  <td><?= $key['slug'] ?></td>
                  <td><a href="<?= site_url('home/tags/ubah/'.$key['id']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                  <a onclick="confirmation(event)" href="<?= site_url('home/tags/hapus/'.$key['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>
                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= view('home/template/foot') ?>

<script>

</script>
</body>
</html>