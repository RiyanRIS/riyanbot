</head>

<body>
  <div id="page-transitions">
    <div class="page-preloader page-preloader-dark">
      <div class="spinner"></div>
    </div>

    <?php if(@$sub){ ?> 
    <div class="header header-light">
      <div class="menu-bar menu-bar-text">
        <a href="javascript:void()" onclick="goBack()" class="menu-bar-text-1"><i class="ion-ios-arrow-left"></i><em>Back</em></a>
        <a href="#" class="menu-bar-title"><?= (@$sub ?: "RiyanRis") ?></a>
      </div>
    </div>
      
    <?php } ?>
    