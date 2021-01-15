<?= view('home/template/head') ?>

<?= view('home/template/nav') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?= breadcump($title,$breadcump) ?>

  <!-- Main content -->
  <section class="content container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
        </div>
        <?= form_open_multipart(uri_string()) ?>
            <div class="box-body">
              <div class="row">
                  <div class="col-xs-3">
                    <img class="profile-user-img img-responsive img-circle" src="<?= toUrl(session()->get('user')->photo,'users') ?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?= session()->get('user')->first_name." ".session()->get('user')->last_name ?></h3>
                    <p class="text-muted text-center"><?= session()->get('group')[0]['description'] ?></p>
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        <b>NRA</b> <a class="pull-right"><?= session()->get('user')->nra ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Email</b> <a class="pull-right"><?= session()->get('user')->email ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>No. Handphone</b> <a class="pull-right"><?= session()->get('user')->phone ?></a>
                      </li>
                    </ul>
                  </div>
                  <div class="col-xs-9">
                  <div class="row">
                    <div class="col-xs-12">
                      <div id="infoMessage"><?php echo $message;?></div>
                    </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputEmail1"><?= ucwords($first_name['placeholder']) ?></label>
                      <?php echo form_input($first_name);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($last_name['placeholder']) ?></label>
                      <?php echo form_input($last_name);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($nra['placeholder']) ?></label>
                      <?php echo form_input($nra);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($email['placeholder']) ?></label>
                      <?php echo form_input($email);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($phone['placeholder']) ?></label>
                      <?php echo form_input($phone);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($password['placeholder']) ?></label> <small><?= ucwords($password['keterangan']) ?></small>
                      <?php echo form_input($password);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputPassword1"><?= ucwords($password_confirm['placeholder']) ?></label>
                      <?php echo form_input($password_confirm);?>
                  </div>
                  <div class="form-group col-xs-6">
                      <label for="exampleInputFile"><?= ucwords($photo['placeholder']) ?></label>
                      <?php echo form_upload($photo);?>
                      <p class="help-block"><?= ucwords($photo['keterangan']) ?></p>
                  </div>
                  <div class="form-group col-xs-6">
                    <label for="exampleInputPassword1"><?= ucwords($deskripsi['placeholder']) ?></label>
                    <?php echo form_textarea($deskripsi);?>
                </div>
                </div>
                </div>
                
                <?php echo form_hidden('id', $user->id);?>
                <?php echo form_hidden('imglama', $user->photo);?>
              </div>
            </div>
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
                <a href="<?= site_url('home/dashboard') ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
              </div>
            </div>
        <?= form_close() ?>
    </div>
  </div>
  <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= view('home/template/foot') ?>
</body>
</html>