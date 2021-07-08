<?= view("wa/temp/head.php") ?>

<?= view("wa/temp/nav.php") ?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5 class="mt-5" id="judul-form">Add Quote</h5>
        <div class="card small card-default">
            <div class="card-body">
                <form id="addQuote" class="form-inline" method="POST" action="">
                  <input type="hidden" name="id" id="quoteID" value="">
                  <div class="mb-3">
                    <label for="quote" class="form-label">Quote</label>
                    <textarea name="quote" id="quote" cols="10" rows="5" placeholder="Masukkan Quote" class="form-control" required="true"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="from" class="form-label">From</label>
                    <input type="text" name="from" class="form-control" id="from" placeholder="Asal Quote" required="true">
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
                <th>Quote</th>
                <th>From</th>
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
        $('#tbody').html("<tr class=\"loading\"><td colspan=\"4\">Tunggu....</td></tr>");
      }

      function getTable(){
        var htmls = [];

        request = $.ajax({
            type: 'GET', 
            url: 'https://riyanfire.herokuapp.com/api/quote/getall', 
            dataType: 'json'
        });

        request.done(function (response, textStatus, jqXHR){
          $.each(response, function (index, value) {
            if (value) {
              var quote = value.quote;
              var from = value.from;
              if (value.quote === undefined) { quote = "-" }
              if (value.from === undefined) { from = "-" }
              htmls.push('<tr>\
              <td>' + quote + '</td>\
              <td>' + from + '</td>\
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
        loadingg();
        iconadd.show();

        const values = $("#addQuote").serializeArray();

        var quote = values[1].value;
        var from = values[2].value;

        request = $.ajax({
            type: 'POST',
            url: "/wa/quote/add",
            dataType: 'json',
            data: {
              quote: quote,
              from: from,
            }
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          getTable();
          iconadd.hide();
          $("#addQuote input").val("");
          $("#addQuote textarea").val("");
          $.notify("Data Berhasil Disimpan...", "success");
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
          loadingg();
          $("#addQuote input").val("");
          $("#addQuote textarea").val("");
          icondel.show();

          var values = $(".quotes-remove-record-model").serializeArray();
          var id = values[0].value;

          request = $.ajax({
            type: 'POST',
            url: "/wa/quote/del/"+id,
            dataType: 'json',
          });

          request.done(function (response, textStatus, jqXHR){
            console.log(response)
            getTable();
            $("#remove-modal").modal('hide');
            icondel.hide();
            $.notify("Data Berhasil Dihapus...", "success");
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
            url: "/wa/quote/get/"+updateID,
            dataType: 'json',
            timeout: 5000
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          $("#btnTunggu").hide();
          isupdate.show();
          judulForm.html('Update quote');
          $("#addQuote input").attr("disabled", false);
          $("#addQuote textarea").attr("disabled", false);
          $("#quoteID").val(updateID);
          $("#quote").val(response.quote);
          $("#from").val(response.from);
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
            judulForm.html('Add quote');
        });
      });

      // Aksi Update
      $('#btnUpdate').on('click', function () {
        event.preventDefault();
        loadingg();
        iconupd.show();

        const values = $("#addQuote").serializeArray();

        var id = values[0].value;
        var quote = values[1].value;
        var from = values[2].value;

        request = $.ajax({
            type: 'POST',
            url: "/wa/quote/upd",
            dataType: 'json',
            data: {
              id: id,
              quote: quote,
              from: from
            }
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          getTable();
          iconupd.hide();
          $("#addQuote input").val("");
          $("#addQuote textarea").val("");
          btnSubmit.show();
          isupdate.hide();
          judulForm.html('Add quote');
          $.notify("Data Berhasil Diubah...", "success");
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
        judulForm.html('Add quote');
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
