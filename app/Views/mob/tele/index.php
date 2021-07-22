<?= view("mob/template/_head") ?>
<?= view("mob/template/_navigation") ?>

<div id="page-content" class="header-clear landing-light">
  <div id="page-content-scroll">

    <div class="decoration decoration-margins"></div>

    <div class="content">
      <div class="heading-text">
        <h4 class="animate-fade">Status Spam Telegram</h4>
        <div class="heading-line-1"></div>
        <i class="ion-android-star-outline color-red-dark"></i>
        <div class="heading-line-2"></div>
        <p class="animate-fade">
          Ini adalah halaman untuk mengubah status spam pesan ga penting dari bot telegram.
        </p>

        <div class="onoffswitch-1 animate-fade">
          <input type="checkbox" name="onoffswitch-1" class="onoffswitch-checkbox-1" id="changeStatus"
            <?= ($setting[0]['statuss'] != 1 ?: "checked=\"\"") ?>>
          <label class="onoffswitch-label-1" for="changeStatus"></label>
        </div>

        <script>
          $('#changeStatus').click(function () {
            if ($(this).is(':checked')) {
              alert("checked")
            } else {
              alert("unchecked")
            }
          });
        </script>

      </div>
    </div>

  </div>
</div>

<?= view("mob/template/_footer") ?>