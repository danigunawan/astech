<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $nama_konsumen = stringdoang($_GET['nama_konsumen']);
  $alamat_konsumen = stringdoang($_GET['alamat_konsumen']); 
  $kode_toko = stringdoang($_GET['kode_toko']); 
  $no_faktur = stringdoang($_GET['no_faktur']); 
  $nama_toko = stringdoang($_GET['nama_toko']); 
  $kode_ekspedisi = stringdoang($_GET['kode_ekspedisi']); 
  $keterangan = stringdoang($_GET['keterangan']);

    	$manggil_nama_toko = $db->query("SELECT id,nama_toko,no_toko FROM toko WHERE id = '$kode_toko' ");
		$toko = mysqli_fetch_array($manggil_nama_toko);

      $manggil_nama_ekspedisi = $db->query("SELECT id,nama_ekspedisi FROM ekspedisi WHERE id = '$kode_ekspedisi' ");
    $ekspedisi = mysqli_fetch_array($manggil_nama_ekspedisi);

    $select_perusahaan = $db->query("SELECT foto,nama_perusahaan,alamat_perusahaan,no_telp FROM perusahaan ");
    $data_perusahaan = mysqli_fetch_array($select_perusahaan);

 ?>
<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    <div class="row"> 
       <div class="col-sm-6"> 
        <div class="col-sm-6"><br>
         <b>#<?php echo $no_faktur; ?> <br><br>
         Dari: <?php echo $nama_toko; ?>  <br>
         Telepon: <?php echo $toko['no_toko']; ?> <br></b>
        </div>

        <div class="col-sm-6">
            <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='100' height='100`'>  
        </div>
  
        <div class="col-sm-12">
        <hr>
         Nama Tujuan:<b> <?php echo $nama_konsumen; ?> </b><br>
         Alamat Tujuan: <b><?php echo $alamat_konsumen; ?></b><br><br>
         Informasi Pengirim: <br>
         <b><?php echo $ekspedisi['nama_ekspedisi']; ?> </b><br><br>
         <h6><b>Daftar Produk:</b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>

            <th class="table1" style="width: 5%"> <center> No. </center> </th>
            <th class="table1" style="width: 65%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 5%"> <center> Jumlah </center> </th>
            <th class="table1" style="width: 10%"> <center> Satuan </center> </th>    
            
        </thead>

        <tbody>
        <?php

        $no_urut = 0;

            $query5 = $db->query("SELECT nama_barang, jumlah_barang, harga, kode_barang, satuan AS id_satuan, asal_satuan, subtotal,satuan.nama AS satuan FROM detail_penjualan INNER JOIN satuan ON detail_penjualan.satuan = satuan.id WHERE no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {
 $pilih_konversi = $db->query("SELECT $data5[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan,sk.konversi FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data5[id_satuan]' AND sk.kode_produk = '$data5[kode_barang]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);

          $query900 = $db->query("SELECT nama FROM satuan WHERE id = '$data_konversi[satuan]'");
           $cek011 = mysqli_fetch_array($query900);


                if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") 
                {             
                   $jumlah_barang = $data_konversi['jumlah_konversi'];
                   $konver = $jumlah_barang * $data_konversi['konversi'];
                }
                else{
                  $jumlah_barang = $data5['jumlah_barang'];
                  $konver = "";
                }


              $no_urut ++;

            echo "<tr>
            <td class='table1' align='center'>".$no_urut."</td>
            <td class='table1'>". $data5['nama_barang'] ."</td>
            <td class='table1' align='right'>". rp($jumlah_barang) ."</td>";

            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {                
            echo "<td class='table1' align='right'>". $data5['satuan'] ." ( ".$konver." ".$cek011['nama']." ) </td>";
            }
            else{
              echo "<td class='table1' align='right'>". $data5['satuan'] ."</td>";
            } 

            }

            //Untuk Memutuskan Koneksi Ke Database

            mysqli_close($db); 

        ?>
   


      </tbody>
    </table> 
         <b>Keterangan:</b><br>
         <?php echo $keterangan; ?>
        </div>

       </div>
    </div>
</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>



<?php include 'footer.php'; ?>