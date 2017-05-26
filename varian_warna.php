<?php include 'session_login.php';

  
  
  include 'header.php';
  include 'navbar.php';
  include 'sanitasi.php';
  include 'db.php';

  $query = $db->query("SELECT * FROM varian_warna");
  
  ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">
<!-- Modal tambah data -->


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Warna </h4>
      </div>
      <div class="modal-body">
<form role="form">

          <div class="form-group">
          <label> Nama Warna </label><br>
          <input type="text" name="varian_warna" id="varian_warna" class="form-control" autocomplete="off" required="" >
          </div>

   
   
            <button type="Tambah" id="submit_tambah" class="btn btn-success"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
</form>
        
        <div class="alert alert-success" style="display:none">
        <strong>Berhasil!</strong> Data berhasil Di Tambah
        </div>
  </div>
        <div class ="modal-footer">
        <button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
  </div>

  </div>
</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Varian Warna</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Varian Warna </label>
     <input type="text" id="data_varian_warna" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Varian Warna</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Varian Warna:</label>
     <input type="text" class="form-control" id="varian_warna_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-primary">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<h3><b>DATA WARNA</b></h3><hr>

<?php
include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT warna_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND warna_tambah = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> WARNA</button>';

}
?>
<br><br>


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
    <thead> 
      
      <th style="background-color: #4CAF50; color: white"> Nama Warna </th>
      <th style="background-color: #4CAF50; color: white"> Hapus </th>
      <th style="background-color: #4CAF50; color: white"> Edit </th>   
      
    </thead>
    
    <tbody>
    <?php

    // menyimpan data sementara yang ada pada $query
  while ($data = mysqli_fetch_array($query))
  {
        //menampilkan data
      echo "<tr>
      
      <td>". $data['varian_warna'] ."</td>";


$pilih_akses_otoritas = $db->query("SELECT warna_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND warna_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td><button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-varian_warna='". $data['varian_warna'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

$pilih_akses_otoritas = $db->query("SELECT warna_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND warna_edit = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td> <button class='btn btn-info btn-edit' data-varian_warna='". $data['varian_warna'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
      echo "</tr>";
    
  }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
    </tbody>

  </table>
</span>
</div>

</div>


<script type="text/javascript">
  
  $(function () {
  $("#tableuser").dataTable({ordering :false });
  });

</script>


<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
    $("#submit_tambah").click(function(){
    var nama = $("#varian_warna").val();
    console.log(nama)
    if (nama == ""){
      alert("Nama Harus Diisi");
    }
    
    else {
    
    $.post('proses_tambah_varian_warna.php',{nama:$("#varian_warna").val()},function(data){

    if (data != '') {
    $("#varian_warna").val('');

    $(".alert").show('fast');
    $("#table_baru").load('tabel-varian_warna.php');
    
    setTimeout(tutupalert, 2000);
    $(".modal").modal("hide");
    }
    
    
    });                   
                  }

    function tutupmodal() {
    
    }   
    
    });

// end fungsi tambah data


  
//fungsi hapus data 
    $(".btn-hapus").click(function(){
    var nama = $(this).attr("data-varian_warna");
    var id = $(this).attr("data-id");
    $("#data_varian_warna").val(nama);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });


    $("#btn_jadi_hapus").click(function(){
    
    var id = $("#id_hapus").val();

    $.post("hapus_varian_warna.php",{id:id},function(data){

    if (data != "") {
    $("#table_baru").load('tabel-varian_warna.php');
    $("#modal_hapus").modal('hide');
    
    }

    
    });
    
    });
// end fungsi hapus data

//fungsi edit data 
    $(".btn-edit").click(function(){
    
    $("#modal_edit").modal('show');
    var nama = $(this).attr("data-varian_warna"); 
    var id  = $(this).attr("data-id");
    $("#varian_warna_edit").val(nama);
    $("#id_edit").val(id);
    
    
    });
    
    $("#submit_edit").click(function(){
    var nama = $("#varian_warna_edit").val();
    var id = $("#id_edit").val();

    if (nama == ""){
      alert("Nama Harus Diisi");
    }
    else {

          $.post("update_varian_warna.php",{id:id,nama:nama},function(data){
    if (data != '') {
    $(".alert").show('fast');
    $("#table_baru").load('tabel-varian_warna.php');
    
    setTimeout(tutupalert, 2000);
    $(".modal").modal("hide");
    }
    
    
    });
    }
                  

    function tutupmodal() {
    
    } 
    });
    


//end function edit data

    $('form').submit(function(){
    
    return false;
    });
    
    });
    
    
    

    function tutupalert() {
    $(".alert").hide("fast")
    }
    


</script>

<?php include 'footer.php'; ?>
