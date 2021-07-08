<?= view("wa/temp/head.php") ?>

<?= view("wa/temp/nav.php") ?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h5 class="mt-5" id="judul-form">Server Bot WhatsApp 🇮🇩</h5>
        </br></br> ❤️ <a target='_blank' href='https://github.com/open-wa/wa-automate-nodejs'>https://github.com/open-wa/wa-automate-nodejs</a></br>🤖 <a target='_blank' href='https://wa.me/16502390040'>https://wa.me/16502390040</a></br></br>
        <?php 
if($setting[0]['statuss'] == 1){
			echo form_open(site_url('wa/change-status'));
			echo form_hidden('statuss', '0');
			echo "\nStatus: 🟢Active... ";
			echo form_submit('submit', 'Nonaktifkan');
			echo form_close();
		}else{
			echo form_open(site_url('wa/change-status'));
			echo form_hidden('statuss', '1');
			echo "\nStatus: 🔴Deactive... ";
			echo form_submit('submit', 'Aktifkan');
			echo form_close();
		}
        ?>
        </br></br> Enjoy..😃
      </div>
    </div>
  </div>
</main>

<?= view("wa/temp/foot.php") ?>


  </body>
</html>
