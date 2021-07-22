<?= view("mob/template/_head") ?>
<?= view("mob/template/_navigation") ?>

<div id="page-content" class="header-clear landing-light">
  <div id="page-content-scroll">

    <div class="decoration decoration-margins"></div>

    <div class="content">
      <a href="#" class="button button-ghost button-teal"><i class="ion ion-android-add"></i> Quote</a>

      <div class="input-icon">
        <input type="text" class="input-text-line input-green-line" id="cari" name="cari" placeholder="Pencarian...">
        <i class="ion-search"></i>
      </div>

      <div class="page-userlist">
        <?php foreach ($quotes as $key ) { ?>
          
        <div class="user-list-2">
          <strong class="animate-left"><?= $key->from ?></strong>
          <em class="animate-fade animate-delay-100"><?= $key->quote ?></em>
          <a href="#" class="bg-red-dark animate-right animate-delay-150"><i class="ion-trash-b"></i></a>
          <a href="#" class="bg-blue-dark animate-right"><i class="ion-edit"></i></a>
        </div>

        <?php } ?>
      </div>

    </div>
  </div>
</div>

  <?= view("mob/template/_footer") ?>