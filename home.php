<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/p5@1.4.0/lib/p5.min.js"></script>
  <script src="https://unpkg.com/ml5@0.5.0/dist/ml5.min.js"></script>
  <title>E-Parking</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <script type="text/javascript" src="asset/js/jquery.min.js"></script>
  <script type="text/javascript" src="asset/js/bootstrap.min.js"></script>


  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/nouislider.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/bootstrap-material-datetimepicker.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/mediaelementplayer.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->
  <link rel="shortcut icon" href="asset/img/logouajm.png">

</head>

<?php
include "config/koneksi.php";
date_default_timezone_set('UTC');
$tanggal = date('D, d M Y');
?>
<script>
var d = new Date(<?php echo time() * 1000 ?>);
function digitalClock() {
  d.setTime(d.getTime() + 1000);
  var hrs = d.getHours();
  var mins = d.getMinutes();
  var secs = d.getSeconds();
  mins = (mins < 10 ? "0" : "") + mins;
  secs = (secs < 10 ? "0" : "") + secs;
  var apm = (hrs < 12) ? "AM" : "PM";
  hrs = (hrs > 12) ? hrs - 12 : hrs;
  hrs = (hrs == 0) ? 12 : hrs;
  var ctime = hrs + ":" + mins + ":" + secs + " " + apm;
  document.getElementById("clock").firstChild.nodeValue = ctime;
}
window.onload = function() {
  digitalClock();
  setInterval('digitalClock()', 1000);
}
</script>
<?php

  $kode = "EP" . rand(100,999);

  $query = mysqli_query($con, "SELECT * FROM tb_daftar_parkir");
  $cek_isi = mysqli_num_rows($query);
  $cek_sisa = 200-$cek_isi;

  if (isset($_POST['btn_masuk'])) {
    
    $plat_nomor = $_POST['plat_nomor'];
    $merk = $_POST['merk'];
    $jam_masuk = date('H:i');
    $hitung_jam_masuk = date('H');
    $jenis = $_POST['jenis'];

    $select_isi = mysqli_num_rows($query);
    if ($select_isi >= 200) {
      echo "<script>alert('Parkiran Sudah Penuh')</script>";
    }
    else{
      $sisa = 200 - $seleksi_isi;
      $cek_kode = mysqli_num_rows(mysqli_query($con, "SELECT kode FROM tb_daftar_parkir WHERE kode='$kode'"));
      $cek_plat = mysqli_num_rows(mysqli_query($con, "SELECT plat_nomor FROM tb_daftar_parkir WHERE plat_nomor='$plat_nomor'"));

      if($cek_kode>=1) {
        $kode = "EP" . rand(100,999);
      }elseif ($cek_plat>=1) {
        echo "<script>alert('Kendaraan Tersebut Sudah Ada di Dalam Parkiran')</script>";
      }else{
        $sql = "INSERT INTO tb_daftar_parkir(kode, plat_nomor, jenis, merk, jam_masuk, hitung_jam_masuk, status) VALUES('$kode', '$plat_nomor', '$jenis', '$merk', '$jam_masuk', '$hitung_jam_masuk', '1')";
        $query = mysqli_query($con, $sql);        
        echo "<script>document.location.href='print.php?nama=$username&plat_nomor=$plat_nomor'</script>";
      }
    }
  }

 ?>

<body style="overflow-x: hidden;" class="dashboard topnav">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top bg-indigo">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
                <div class="navbar-brand" style="margin-left: -10px;" name="home_logo">
                <img src="asset/img/logouajm.png" class="img-circle" alt="logo" style="float: left;margin-top: -10px;" width="45px"/>
                 <b style="float: left;margin-left: 4px;">Parking System UAJM</b>
                </div>

              <ul class="nav navbar-nav search-nav" style="margin-left: 7%">
                  <li class="active"><a style="font-size: 18pt">Gate 1</a></li>
                  <li><a href="gate2.php"><span  style="font-size: 18pt">Gate 2</a></span></li>
                  <li><a href="keluar.php"><span  style="font-size: 18pt">Keluar</a></span></li>
              </ul>
              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="nav"><a href="admin/admin.php" style="font-size: 18pt">Admin</a></li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <!-- Content -->
      <div id="content">

            <!-- Masuk Parkir -->
                <div class="col-md-7" style="margin-top: 30px;">
                  <div class="col-md-10 panel">
                    <div class="col-md-12 panel-heading bg-indigo">
                      <h4 style="color: white;font-size: 20pt;">Masuk Gate 1</h4>
                    </div>
                    <div class="col-md-12 panel-body" style="text-align: center;">
                      <div class="col-md-12 animated fadeInLeft" style="margin-bottom: 100px;margin-top: 70px;text-align: center; font-size: 25pt;color: #160299;" id="clock">
                      <p class="" style="text-align: center; font-size: 25pt;color: #160299;"><?= $tanggal;?></p>
                      <h1 class="display-2" style="text-align: center;color: #280599">Selamat Datang di </h1>
                      <h1 class="display-2" style="text-align: center;color: #280599">Universitas Atma Jaya Makassar</h1>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end:Masuk Parkir -->

              <!-- Kamera -->
              <div class="col-md-5" style="margin-top: 20px">
                  <div class="col-md-10 panel">
<style>
#my_camera{
 width: 600px;
 height: 460px;
}
</style>
                    <div id="my_camera" class="col-md-10 panel-body" src ="<?=$output?>">
                    <!--test dulu -->
                    <script src="sketch.js"></script>  


                      <!-- <?php
                        echo shell_exec("python /opt/lampp/htdocs/Sistem_Parkir/mix.py 2>&1");
                      ?> -->
                      <!--<script type="text/javascript" src=""{{ url_for('video_feed') }}""></script>
                         <script language="JavaScript">
                          Webcam.set({
                          width: 650,
                          height: 460,
                          image_format: 'jpeg',
                          jpeg_quality: 90
                            }); 
                          Webcam.attach( '#my_camera' ); 
                          </script> -->
                      </div>
                  </div>
              </div>
              <!-- end:Kamera -->
              
      <!-- end: Content -->


</body>
</html>
