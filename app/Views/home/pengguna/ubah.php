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
                <div class="form-group col-xs-6">
                    <label for="exampleInputFile">Member of Group</label>
                    <?php if ($ionAuth->isAdmin()): ?>
                        <select name="groups" class="form-control">
                        <?php foreach ($groups as $group):?>
                            <?php
                            $gID = $group['id'];
                            $checked = null;
                            $item = null;
                            foreach($currentGroups as $grp) {
                                if ($gID == $grp->id) {
                                    $checked = ' selected="true"';
                                break;
                                }
                            }
                        ?>
                        <option value="<?= $group['id'] ?>" <?= $checked;?>><?= $group['name'] ?></option>
                        <?php endforeach?>

                    </select>
                    <?php endif ?>
                </div>
                <?php echo form_hidden('id', $user->id);?>
                <?php echo form_hidden('imglama', $user->photo);?>
              </div>
            </div>
            <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
            <a href="<?= site_url('home/pengguna') ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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