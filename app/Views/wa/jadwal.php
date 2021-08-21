<?= view("wa/temp/head.php") ?>

<?= view("wa/temp/nav.php") ?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <div class="row">
    <div class="col-md-4">
      <h5 class="mt-5" id="judul-form">Add Jadwal</h5>
        <div class="card small card-default">
            <div class="card-body">
                <form id="addQuote" class="form-inline" method="POST" action="">
                  <input type="hidden" name="id" id="quoteID" value="">
                  <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea name="pesan" id="pesan" cols="10" rows="5" placeholder="Masukkan Pesan Text" class="form-control" required="true"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="tujuan" class="form-label">Tujuan</label>
                    <textarea name="tujuan" id="tujuan" cols="10" rows="5" placeholder="0896xxxx" class="form-control" required="true"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Tanggal Kirim" required="true">
                  </div>
                  <div class="mb-3">
                    <label for="jam" class="form-label">Jam</label>
                    <input type="time" name="jam" class="form-control" id="jam" placeholder="Waktu Kirim" required="true">
                  </div>
                  <button id="submitQuote" type="button" class="btn btn-labeled btn-primary mb-2"><span class="btn-label"><i class="icon-add fa fa-spinner fa-spin"></i> Tambah</button>
                  <button id="btnTunggu" type="button" class="btn btn-labeled btn-primary mb-2"><span class="btn-label"><i class="icon-tunggu fa fa-spinner fa-spin"></i>&nbsp;</button>
                  <div id="isupdate">
                    <button id="btnUpdate" type="button" class="btn btn-primary mb-2"><i class="icon-upd fa fa-spinner fa-spin"></i> Ubah</button>
                    <button id="cancelUpdate" type="button" class="btn btn-danger mb-2">Batal</button>
                  </div>
                </form>
            </div>
        </div>
      </div>
      <div class="col-md-8">  
        <div class="mt-5 lokasi-alert"></div>
        <h5 class="">Quote</h5>
        <table id="myTable" class="table small table-bordered" style="width:100%">
          <thead><tr>
                <th>No</th>
                <th>Pesan</th>
                <th>Tujuan</th>
                <th>Jadwal</th>
                <th>Status</th>
                <th width="150" class="text-center">Aksi</th>
            </tr>
            </thead><tbody id="tbody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- Delete Model -->
<form action="" method="POST" class="quotes-remove-record-model">
  <div id="remove-modal" data-bs-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                  <button type="button" class="btn-close remove-data-from-delete-form" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>Do you want to delete this record?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary remove-data-from-delete-form" data-bs-dismiss="modal">Batal</button>
                  <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord"><i class="icon-del fa fa-spinner fa-spin"></i> Hapus
                  </button>
              </div>
          </div>
      </div>
  </div>
</form>

<?= view("wa/temp/foot.php") ?>

<script>
    $(document).ready(function(){
      var isupdate = $('#isupdate');
      var btnSubmit = $("#submitQuote");
      var btnUpdate = $("#btnUpdate");
      var btnCancel = $("#cancelUpdate");
      var judulForm = $("#judul-form");
      var iconadd = $(".icon-add");
      var iconupd = $(".icon-upd");
      var icondel = $(".icon-del");

      function loadingg(){ 
        $('#tbody').html("<tr class=\"loading\"><td colspan=\"5\">Tunggu....</td></tr>");
      }

      function getTable(){
        var htmls = [];

        request = $.ajax({
            type: 'GET', 
            url: '<?= site_url("jadwal/getall") ?>', 
            dataType: 'json'
        });

        request.done(function (response, textStatus, jqXHR){
          let no = 1
          $.each(response, function (index, value) {
            if (value) {
              var pesan = value.pesan;
              var tujuan = value.tujuan;
              var jadwal = value.tanggal + " " + value.jam;
              var status = value.status;
              htmls.push('<tr>\
              <td>' + (no++) + '</td>\
              <td>' + pesan + '</td>\
              <td>' + tujuan + '</td>\
              <td>' + jadwal + '</td>\
              <td>' + status + '</td>\
              <td><button class="btn btn-warning updateData" data-id="' + value.id + '">Update</button>\
              <button data-bs-toggle="modal" data-bs-target="#remove-modal" class="btn btn-danger removeData" data-id="' + value.id + '">Delete</button></td>\
            </tr>');
            }
          });
          $('#tbody').html("");
          $('#tbody').html(htmls);
          $('#myTable').DataTable();
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            if(errorThrown == 'Not Found'){
              $('#tbody').html("<tr><td colspan=\"4\">Data Kosong...</td></tr>");
            }
        });

      }

      // Aksi Add
      $('#submitQuote').on('click', function () {
        event.preventDefault();
        iconadd.show();

        const values = $("#addQuote").serializeArray();

        var pesan = values[1].value;
        var tujuan = values[2].value;
        var tanggal = values[3].value;
        var jam = values[4].value;

        request = $.ajax({
            type: 'POST',
            url: "<?= site_url("jadwal/add") ?>",
            dataType: 'json',
            data: {
              pesan: pesan,
              tujuan: tujuan,
              tanggal: tanggal,
              jam: jam,
            }
        });

        request.done(function (response, textStatus, jqXHR){
          if(response[0] == true){
            $.notify("Data Berhasil Disimpan...", "success");
            $("#addQuote input").val("");
            $("#addQuote textarea").val("");
            getTable();
          }else{
            $.notify(response[1], "error");
          }
          iconadd.hide();
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            $.notify("Data gagal disimpan", "error");
        });

      });

      // Remove Data
      $("body").on('click', '.removeData', function () {
          var id = $(this).attr('data-id');
          $('body').find('.quotes-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
      });

      // Aksi remove
      $('.deleteRecord').on('click', function () {
          $("#addQuote input").val("");
          $("#addQuote textarea").val("");
          icondel.show();

          var values = $(".quotes-remove-record-model").serializeArray();
          var id = values[0].value;

          request = $.ajax({
            type: 'POST',
            url: "<?= site_url("jadwal/del/") ?>"+id,
            dataType: 'json',
          });

          request.done(function (response, textStatus, jqXHR){
            if(response[0] == true){
              $.notify("Data Berhasil Dihapus...", "success");
            }else{
              $.notify(response[1], "error");
            }
            $("#remove-modal").modal('hide');
            getTable();
            icondel.hide();
          });

          request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
              $.notify("Data gagal dihapus", "error");
          }); 
          
          $('body').find('.quotes-remove-record-model').find("input").remove();
      });

      // Bersihkan data remove
      $('.remove-data-from-delete-form').click(function () {
          $('body').find('.quotes-remove-record-model').find("input").remove();
      });

      // Update data
      $("body").on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        btnSubmit.hide();
        isupdate.hide();
        $("#btnTunggu").show();
        $("#addQuote input").val("");
        $("#addQuote textarea").val("");
        $("#addQuote input").attr("disabled", true);
        $("#addQuote textarea").attr("disabled", true);

        request = $.ajax({
            type: 'POST',
            url: "<?= site_url("jadwal/getbyid/") ?>"+updateID,
            dataType: 'json',
            timeout: 5000
        });

        request.done(function (response, textStatus, jqXHR){
          $("#btnTunggu").hide();
          isupdate.show();
          judulForm.html('Update jadwal');
          $("#addQuote input").attr("disabled", false);
          $("#addQuote textarea").attr("disabled", false);
          $("#quoteID").val(updateID);
          $("#pesan").val(response.pesan);
          $("#tujuan").val(response.tujuan);
          $("#tanggal").val(response.tanggal);
          $("#jam").val(response.jam);
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            if(textStatus == "timeout"){
              $.notify("Waktu request habis, silahkan ulangi sekali lagi", "error");
            }else{
              $.notify("quoteID "+updateID+" tidak ditemukan", "error");
            }
            $("#addQuote input").val("");
            $("#addQuote textarea").val("");
            
            btnSubmit.show();
            $("#btnTunggu").hide();
            isupdate.hide();
            judulForm.html('Add jadwal');
        });
      });

      // Aksi Update
      $('#btnUpdate').on('click', function () {
        event.preventDefault();
        iconupd.show();

        const values = $("#addQuote").serializeArray();

        var id = values[0].value;
        var pesan = values[1].value;
        var tujuan = values[2].value;
        var tanggal = values[3].value;
        var jam = values[4].value;

        request = $.ajax({
            type: 'POST',
            url: "<?= site_url("jadwal/update") ?>",
            dataType: 'json',
            data: {
              id: id,
              pesan: pesan,
              tujuan: tujuan,
              tanggal: tanggal,
              jam: jam,
            }
        });

        request.done(function (response, textStatus, jqXHR){
          if(response[0] == true){
            $("#addQuote input").val("");
            $("#addQuote textarea").val("");
            btnSubmit.show();
            isupdate.hide();
            judulForm.html('Add quote');
            $.notify("Data Berhasil Diubah...", "success");
            getTable();
          }else{
            $.notify(response[1], "error");
          }
          iconupd.hide();
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            $.notify("Data gagal disimpan", "error");
        });

      });

      // Batal update
      btnCancel.on('click', function (){
        $("#addQuote input").val("");
        $("#addQuote textarea").val("");
        btnSubmit.show();
        isupdate.hide();
        judulForm.html('Add jadwal');
      });

      iconadd.hide();
      iconupd.hide();
      icondel.hide();
      isupdate.hide();
      $("#btnTunggu").hide();
      loadingg();
      getTable();

    });
    </script>

  </body>
</html>
