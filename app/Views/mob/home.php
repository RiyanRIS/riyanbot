<?= view("mob/template/_head") ?>
<?= view("mob/template/_navigation") ?>

    <div id="page-content" class="landing-light">
      <div id="page-content-scroll">
        <div class="landing landing-2">
          <div class="landing-header landing-header-2">
            <h2 class="title animate-top"><?= (@$site_name ?: "RiyanRis") ?></h2>
            <em class="animate-top">Jadilah Dirimu Sendiri</em>
            <div class="socials">
              <a href="mailto:riyanrisky129@gmail.com" class="animate-left landing-icon icon-square bg-hover-blue-dark landing-icon-1"><i
                  class="ion-email"></i></a>
              <a href="https://twitter.com/kodokkayang" class="animate-fade landing-icon icon-square bg-hover-blue-light landing-icon-2"><i
                  class="ion-social-twitter"></i></a>
              <a href="https://github.com/riyanris" class="animate-right landing-icon icon-square bg-hover-orange-dark landing-icon-3"><i
                  class="ion-social-github"></i></a>
            </div>
            <div class="clear"></div>
          </div>
          <div class="landing-content landing-content-2">
            <a href="<?= site_url("mob/tele") ?>" class="animate-fade"><i class="ion-android-home"></i><em>Telegram</em></a>
            <a href="<?= site_url("mob/users") ?>" class="animate-fade"><i class="ion-gear-a"></i><em>Users</em></a>
            <a href="<?= site_url("mob/quotes") ?>" class="animate-fade"><i class="ion-ios-analytics"></i><em>Quotes</em></a>
          </div>
        </div>
      </div>
    </div>

  <?= view("mob/template/_footer") ?>
