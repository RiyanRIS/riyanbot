</head>
<body class="d-flex flex-column h-100">

<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="javascript:void(0)">Whatsapp API</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link <?= nav("home", @$nav) ?>" href="<?= site_url('wa') ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= nav("quote", @$nav) ?>" href="<?= site_url('wa/quote') ?>">Quote</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= nav("user", @$nav) ?>" href="<?= site_url('wa/user') ?>">User</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>