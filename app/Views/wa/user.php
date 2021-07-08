<?= view("wa/temp/head.php") ?>

<?= view("wa/temp/nav.php") ?>

<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5 class="mt-5" id="judul-form">Add User</h5>
        <div class="card small card-default">
            <div class="card-body">
                <form id="addUser" class="form-inline" method="POST" action="">
                <input type="hidden" name="id" id="userID" value="">
                    <div class="mb-3">
                      <label for="nama" class="form-label">Nama Lengkap</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap" required="true">
                    </div>
                    <div class="mb-3">
                      <label for="nohp" class="form-label">No. Handphone</label>
                      <input type="text" name="nohp" class="form-control" id="nohp" placeholder="628xxxxx" required="true">
                    </div>
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Jl. Kusuma Negara No. 35B Bantul Yogyakarta" required="true">
                    </div>
                    <button id="submitUser" type="button" class="btn btn-labeled btn-primary mb-2"><span class="btn-label"><i class="icon-add fa fa-spinner fa-spin"></i> Tambah</button>
                    <button id="btnTunggu" type="button" class="btn btn-labeled btn-primary mb-2"><span class="btn-label"><i class="icon-tunggu fa fa-spinner fa-spin"></i>&nbsp;</button>
                    <div id="updateUser">
                      <button id="btnUpdate" type="button" class="btn btn-primary mb-2"><i class="icon-upd fa fa-spinner fa-spin"></i> Ubah</button>
                      <button id="cancelUpdate" type="button" class="btn btn-danger mb-2">Batal</button>
                    </div>
                    
                </form>
            </div>
        </div>
      </div>
      <div class="col-md-8">  
        <div class="mt-5 lokasi-alert"></div>
        <h5 class="">User</h5>
        <table id="myTable" class="table small table-bordered">
          <tbody><tr>
                <th>Nama</th>
                <th>No. Handphone</th>
                <th>Alamat</th>
                <th width="180" class="text-center">Aksi</th>
            </tr>
            </tbody><tbody id="tbody"></tbody>
        </table>
      </div>
    </div>
  </div>
</main>

    <!-- Delete Model -->
    <form action="" method="POST" class="users-remove-record-model">
        <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" style="width:55%;">
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
      var isupdate = $('#updateUser');
      var btnSubmit = $("#submitUser");
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
            url: 'https://riyanfire.herokuapp.com/api/user/getall', 
            dataType: 'json'
        });

        request.done(function (response, textStatus, jqXHR){
          $.each(response, function (index, value) {
            if (value) {
              var nama = value.nama;
              var nohp = value.nohp;
              var alamat = value.alamat;
              if (value.nama === undefined) { nama = "-" }
              if (value.nohp === undefined) { nohp = "-" }
              if (value.alamat === undefined) { alamat = "-" }
              htmls.push('<tr>\
              <td>' + nama + '</td>\
              <td>' + nohp + '</td>\
              <td>' + alamat + '</td>\
              <td><button class="btn btn-warning updateData" data-id="' + value.id + '">Update</button>\
              <button data-bs-toggle="modal" data-bs-target="#remove-modal" class="btn btn-danger removeData" data-id="' + value.id + '">Delete</button></td>\
            </tr>');
            }
          });
          $('#tbody').html("");
          $('#tbody').html(htmls);
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
      $('#submitUser').on('click', function () {
        event.preventDefault();
        loadingg();
        iconadd.show();

        const values = $("#addUser").serializeArray();

        var nama = values[1].value;
        var nohp = values[2].value;
        var alamat = values[3].value;

        request = $.ajax({
            type: 'POST',
            url: "/wa/user/add",
            dataType: 'json',
            data: {
              nama: nama,
              nohp: nohp,
              alamat: alamat
            }
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          getTable();
          iconadd.hide();
          $("#addUser input").val("");
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
          $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id + '">');
      });

      // Aksi remove
      $('.deleteRecord').on('click', function () {
          loadingg();
          $("#addUser input").val("");
          icondel.show();

          var values = $(".users-remove-record-model").serializeArray();
          var id = values[0].value;

          request = $.ajax({
            type: 'POST',
            url: "/wa/user/del/"+id,
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
          
          $('body').find('.users-remove-record-model').find("input").remove();
      });

      // Bersihkan data remove
      $('.remove-data-from-delete-form').click(function () {
          $('body').find('.users-remove-record-model').find("input").remove();
      });

      // Update data
      $("body").on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        btnSubmit.hide();
        isupdate.hide();
        $("#btnTunggu").show();
        $("#addUser input").val("");
        $("#addUser input").attr("disabled", true);

        request = $.ajax({
            type: 'POST',
            url: "/wa/user/get/"+updateID,
            dataType: 'json',
            timeout: 5000
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          $("#btnTunggu").hide();
          isupdate.show();
          judulForm.html('Update User');
          $("#addUser input").attr("disabled", false);
          $("#userID").val(updateID);
          $("#nama").val(response.nama);
          $("#nohp").val(response.nohp);
          $("#alamat").val(response.alamat);
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            if(textStatus == "timeout"){
              $.notify("Waktu request habis, silahkan ulangi sekali lagi", "error");
            }else{
              $.notify("UserID "+updateID+" tidak ditemukan", "error");
            }
            $("#addUser input").val("");
            btnSubmit.show();
            $("#btnTunggu").hide();
            isupdate.hide();
            judulForm.html('Add User');
        });
      });

      // Aksi Update
      $('#btnUpdate').on('click', function () {
        event.preventDefault();
        loadingg();
        iconupd.show();

        const values = $("#addUser").serializeArray();

        var id = values[0].value;
        var nama = values[1].value;
        var nohp = values[2].value;
        var alamat = values[3].value;

        request = $.ajax({
            type: 'POST',
            url: "/wa/user/upd",
            dataType: 'json',
            data: {
              id: id,
              nama: nama,
              nohp: nohp,
              alamat: alamat
            }
        });

        request.done(function (response, textStatus, jqXHR){
          console.log(response)
          getTable();
          iconupd.hide();
          $("#addUser input").val("");
          btnSubmit.show();
          isupdate.hide();
          judulForm.html('Add User');
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
        $("#addUser input").val("");
        btnSubmit.show();
        isupdate.hide();
        judulForm.html('Add User');
      });

      iconadd.hide();
      iconupd.hide();
      icondel.hide();
      $("#btnTunggu").hide();
      loadingg();
      getTable();

    });
    </script>


  </body>
</html>
