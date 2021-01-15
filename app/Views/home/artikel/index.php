<?= view('home/template/head') ?>

<?= view('home/template/nav') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?= breadcump($title,$breadcump) ?>

  <!-- Main content -->
  <section class="content container-fluid">

  <div class="row">
    <div class="col-xs-12">
      <a href="<?= site_url("home/artikel/tambah") ?>" class="btn btn-primary mb-3"><i class="fa fa-plus-square"></i> Tambah Artikel</a>
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table datatable table-hovered table-bordered">
              <thead>
                <tr>
                  <th>NO</th>
                  <th style="min-width:160px;width:161px;max-width:162px">JUDUL ARTIKEL</th>
                  <th>PENULIS</th>
                  <th>SAMPUL</th>
                  <th style="min-width:80px;">STATUS</th>
                  <th style="min-width:200px;width:211px;max-width:212px">#</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($artikel as $key):?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $key['judul'] ?> <br> 
                  <small><b>Kategori: </b><?= $key['namakategori'] ?></small></td>
                  <td><?= ucfirst($key['namapenulis']) ?> <br> 
                  <small><b>Ditulis pada : </b><?= date('d F Y',strtotime($key['create_at'])) ?></small></td>
                  <td><img src="<?= toUrl($key['gambar'],'artikel') ?>" width="64px" alt=""></td>
                  <td>
                  <?php if($ingroup){ ?>
                      <div class="btn-group">
                        <button type="button" class="btn btn-info"><?= ucfirst($key['status']) ?></button>
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="<?= site_url('home/artikel/publish/'.$key['id']) ?>">Publish</a></li>
                          <li><a href="<?= site_url('home/artikel/unpublish/'.$key['id']) ?>">Unpublish</a></li>
                        </ul>
                      </div> 
                      <?php if($key['status']=='publish'){ ?>
                        <br><small><b>Diposting pada : </b> <?= date('d F Y',strtotime($key['publish_at'])) ?></small>
                      <?php } ?>
                      <?php if($key['update_at']!=null){ ?>
                        <br> <small><b>Terahir diupdate pada : </b> <?= date('d F Y',strtotime($key['update_at'])) ?></small>
                      <?php } ?>
                  <?php }else{ ?>
                    <button type="button" onclick="alert('Harap menunggu admin atau editor untuk menyunting tulisan anda')" class="btn btn-info"><?= ucfirst($key['status']) ?></button>
                  <?php } ?>
                  </td>
                  
                  <td>
                  <a href="https://ukmik.org/blog/<?= $key['slug'] ?>" target="_blank" class="btn btn-default"><i class="fa fa-eye"></i> Lihat</a>
                  <a href="<?= site_url('home/artikel/ubah/'.$key['id']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                  <a onclick="confirmation(event)" href="<?= site_url('home/artikel/hapus/'.$key['id']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>
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