  <?= view('home/template/head') ?>
<!-- Date Picker -->
<link rel="stylesheet" href="<?= base_url('adminlte') ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> 
<?= view('home/template/nav') ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?= breadcump($title,$breadcump) ?>

    <!-- Main content -->
    <section class="content container-fluid">

    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $totalartikel ?></h3>

              <p>Total Artikel</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?= site_url('home/artikel') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $totalusers ?></h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
              
            </div>
            <a href="<?= site_url('home/users') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $totalkomen ?></h3>

              <p>Total Comment</p>
            </div>
            <div class="icon">
            <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?= site_url('home/komentar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>6505</h3>

              <p>Total Visitors</p>
            </div>
            <div class="icon">
            <i class="ion ion-stats-bars"></i>
              
            </div>
            <a href="javascript:void(0)" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-8">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class=""><a href="#revenue-chart" data-toggle="tab" aria-expanded="false">Notifikasi</a></li>
              <li class="active"><a href="#sales-chart" data-toggle="tab" aria-expanded="true">Log Sistem</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Aktivitas</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane" id="revenue-chart">
              <div class="table-responsive">
                <table class="table datatabeln no-margin">
                  <thead>
                  <tr>
                    <th>TIME</th>
                    <th>PESAN</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($allnotif as $key){?>
                  <tr>
                    <td><?= date('Y-m-d H:i:s', strtotime($key['create_at'])) ?></td>
                    <td><?= $key['pesan'] ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="box-footer clearfix">
                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
              </div>
              </div>

              <div class="chart tab-pane active" id="sales-chart">
              <div class="table-responsive">
                <table class="table datatabeln no-margin">
                  <thead>
                  <tr>
                    <th>TIME</th>
                    <th>USERS</th>
                    <th>TABEL</th>
                    <th>AKTIVITAS</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($log as $key){?>
                  <tr>
                    <td><?= date('Y-m-d H:i:s', strtotime($key['time'])) ?></td>
                    <td><?= $key['first_name'] ?></td>
                    <td><?= $key['nama_tabel'] ?></td>
                    <td><?= $key['keterangan'] ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="box-footer clearfix">
                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All</a>
              </div>
              </div>
              </div>
          </div>
          </div>
          <div class="col-lg-4">
          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title">Calendar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.row -->

    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?= view('home/template/foot') ?>
<!-- datepicker -->
<script src="<?= base_url('adminlte') ?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('#calendar').datepicker("setDate", new Date());
    $('.datatabeln').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    })
  </script>
</body>
</html>