<?= view('home/template/head') ?>

<?= view('home/template/nav') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?= breadcump($title,$breadcump) ?>

  <!-- Main content -->
  <section class="content container-fluid">

  <div class="row">
    <div class="col-xs-12">
      <!-- <a href="<?= site_url("home/artikel/tambah") ?>" class="btn btn-primary mb-3"><i class="fa fa-plus-square"></i> Tambah Artikel</a> -->
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table datatable table-hovered table-bordered">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>WAKTU</th>
                  <th style="min-width:160px;width:161px;max-width:162px">JUDUL ARTIKEL</th>
                  <th>NAMA</th>
                  <th style="min-width:80px;">KOMENTAR</th>
                  <th style="min-width:200px;width:211px;max-width:212px">#</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($komentar as $key):?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= date('F d Y H:i', strtotime($key['create_at'])) ?></td>
                  <td><a href="https://ukmik.org/blog/<?= $key['slug'] ?>"><?= $key['judul'] ?></a></td>
                  <td><?= ucfirst($key['nama']) ?><br> <b> <?= $key['email'] ?></b> </td>
                  <td><?= $key['komentar'] ?></td>
                  
                  <td>
                  <a href="<?= site_url('home/komentar/balas/') ?>" class="btn btn-warning"><i class="fa fa-forward"></i> Balas</a>
                  <a onclick="confirmation(event)" href="<?= site_url('home/komentar/hapus/'.$key['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>
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