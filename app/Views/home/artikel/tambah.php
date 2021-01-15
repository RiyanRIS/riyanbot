<?= view('home/template/head') ?>
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url('adminlte') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
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
                    <label for="exampleInputEmail1"><?= ucwords($judul['placeholder']) ?></label>
                    <?php echo form_input($judul);?>
                </div>
                <div class="form-group col-xs-6">
                    <label for="exampleInputEmail1"><?= ucwords($kategori[0]) ?></label>
                    <?php echo form_dropdown($kategori[0],$kategori[1],$kategori[2],$kategori[3]);?>
                </div>
              </div>
            </div>
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Content
                <small>Tulis artikel disini</small>
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                <textarea class="textarea" name="konten" placeholder="Tulis artikel disini"
                          style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  <div class="row">
                  <div class="form-group pt-3 col-xs-6">
                    <label for="exampleInputEmail1"><?= ucwords($gambar['placeholder']) ?></label>
                    <?php echo form_upload($gambar) ?>
                    <p class="help-block"><?= ucfirst($gambar['keterangan']) ?></p>
                  </div>
                  <div class="form-group pt-3 col-xs-6">
                    <label for="exampleInputEmail1"><?= ucwords($tags[4]) ?></label>
                    <?php echo form_multiselect($tags[0],$tags[1],$tags[2],$tags[3]) ?>
                  </div>
                </div>
            </div>
            <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
            <a href="#" class="btn btn-info"><i class="fa fa-eye"></i> Preview</a>
            <a href="<?= site_url('home/artikel') ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
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
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('adminlte') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url('adminlte') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5();
    $('.select2').select2({
      tags : true
    });
  })
</script>

</body>
</html>