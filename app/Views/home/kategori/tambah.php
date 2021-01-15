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
        <?= form_open(uri_string()) ?>
            <div class="box-body">
              <div class="row">
                  <div class="col-xs-12">
                    <div id="infoMessage"><?php echo $message;?></div>
                  </div>
                <div class="form-group col-xs-6">
                    <label for="exampleInputEmail1"><?= ucwords($kategori['placeholder']) ?></label>
                    <?php echo form_input($kategori);?>
                </div>
              </div>
            </div>
            <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
            <a href="<?= site_url('home/kategori') ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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