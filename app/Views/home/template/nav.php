</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>B</b>LOG</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BLOG</b>UKMIK</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?= count($notif) ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?= count($notif) ?> notifications</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <?php foreach ($notif as $key) { ?>
                    <li><!-- start notification -->
                    <a href="<?= site_url('home/n/'.$key['id']) ?>">
                      <i class="fa fa-users text-aqua"></i> <?= ucwords($key['pesan']) ?>
                    </a>
                  </li>
                  <?php } ?>
                  <!-- end notification -->
                </ul>
              </li>
              <!-- <li class="footer"><a href="#">View all</a></li> -->
            </ul>
          </li>

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="<?= toUrl(session()->get('user')->photo,'users') ?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?= session()->get('user')->first_name." ".session()->get('user')->last_name ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="<?= toUrl(session()->get('user')->photo,'users') ?>" class="img-circle" alt="User Image">

                <p>
                  <?= session()->get('user')->first_name." ".session()->get('user')->last_name ?>
                  <small><?= session()->get('group')[0]['description'] ?></small>
                </p>
              </li>
              <!-- Menu Body -->
           
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= site_url('home/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?= site_url("auth/logout") ?>" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= toUrl(session()->get('user')->photo,'users') ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= session()->get('user')->first_name." ".session()->get('user')->last_name ?></p>
          <!-- Status -->
          <a href="javascript:void()"><i class="fa fa-circle text-success"></i> <?= session()->get('group')[0]['description'] ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN MENU</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="<?= nav(1,$nav) ?>"><a href="<?= site_url("home/dashboard") ?>"><i class="fa fa-link"></i> <span>Dashboard</span></a></li>
        <li class="<?= nav(3,$nav) ?>"><a href="<?= site_url("home/artikel") ?>"><i class="fa fa-book"></i> <span>Artikel</span></a></li>
        <li class="<?= nav(5,$nav) ?>"><a href="<?= site_url("home/komentar") ?>"><i class="fa fa-commenting"></i> <span>Komentar</span></a></li>
        <?php if (session()->get('group')[0]['id'] == 1 || session()->get('group')[0]['id'] == 3){ ?>
        <li class="treeview <?= nav(2,$nav) ?> <?= nav1(2,$nav) ?>">
          <a href="#"><i class="fa fa-link"></i> <span>Master Data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            
            <li class="<?= nav(2,@$navv) ?>"><a href="<?= site_url("home/kategori") ?>">Kategori</a></li>
            <li class="<?= nav(3,@$navv) ?>"><a href="<?= site_url("home/tags") ?>">Tags</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if (session()->get('group')[0]['id'] == 1){ ?>
            <li class="<?= nav(4,@$nav) ?>"><a href="<?= site_url("home/pengguna") ?>"><i class="fa fa-users"></i> <span>Pengguna</span></a></li>
        <?php } ?>
        <li><a href="<?= site_url("auth/logout") ?>"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>