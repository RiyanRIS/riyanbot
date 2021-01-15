<?= view('home/template/head') ?>

<?= view('home/template/nav') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?= breadcump($title,$breadcump) ?>

  <!-- Main content -->
  <section class="content container-fluid">

  <div class="row">
    <div class="col-xs-12">
      <a href="<?= site_url("home/pengguna/tambah") ?>" class="btn btn-primary mb-3"><i class="fa fa-plus-square"></i> Tambah Pengguna</a>
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table datatable table-hovered table-bordered">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>NRA</th>
                  <th>NAMA</th>
                  <th>EMAIL</th>
                  <th style="min-width:90px">LAST LOGIN</th>
                  <th>ROLE</th>
                  <th>PHOTO</th>
                  <th style="min-width:260px">#</th>
                </tr>
              </thead>
              <tbody>
              <?php $no=1; foreach ($users as $user):?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $user->nra ?></td>
                  <td><?= $user->first_name." ".$user->last_name ?></td>
                  <td><?= $user->email ?></td>
                  <td><?= date("H:i:s", $user->last_login) ?> <br> <?= date("d F Y", $user->last_login) ?></td>
                  <td>
                    <?php foreach ($user->groups as $group): ?>
                      <span class="label label-info"><?= $group->name ?></span>
                    <?php endforeach?>
                  </td>
                  <td><img width="48px" src="<?= toUrl(@$user->photo,'users') ?>" alt=""></td>
                  <td><a href="<?= site_url('home/pengguna/ubah/'.$user->id) ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Ubah</a>
                  <?php if($user->active == 1){ ?>
                    <a onclick="confirmation(event)" href="<?= site_url('home/pengguna/nonaktifkan/'.$user->id) ?>" class="btn btn-success"><i class="fa fa-minus-square"></i> Nonaktifkan</a>
                  <?php }else{ ?>
                    <a onclick="confirmation(event)" href="<?= site_url('home/pengguna/aktifkan/'.$user->id) ?>" class="btn btn-default"><i class="fa fa-check-square"></i> Aktifkan</a>
                  <?php } ?>
                  <a onclick="confirmation(event)" href="<?= site_url('home/pengguna/hapus/'.$user->id) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>
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