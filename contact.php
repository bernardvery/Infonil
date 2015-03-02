<?php
/*
function checkEmail($email) 
{
   if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) 
   {
      return FALSE;
   }

   list($Username, $Domain) = split("@",$email);

   if(getmxrr($Domain, $MXHost)) 
   {
      return TRUE;
   }
   else 
   {
      if(fsockopen($Domain, 25, $errno, $errstr, 30)) 
      {
         return TRUE; 
      }
      else 
      {
         return FALSE; 
      }
   }
}
*/
?>
<html>
<head>
<title>Kontak Saya</title>
<style type="text/css">
    body{
    font-family: Verdana, Arial, Helvetica, Sans-serif;
    font-size: 12px;
    }
</style>
</head>
<body>
<?php
include("koneksi.php");

if (isset($_POST['Kirim'])){
	$nim = $_POST['nim'];
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$kelas = $_POST['kelas'];
	/*
    if ($kelas=='pagi'){
		$dir = "tgs1/pagi/";
	}else{
		$dir = "tgs1/sore/";
	}
    */
	$pesan = $_POST['pesan'];
	//echo $nim.$nama.$email.$kelas.$dir.$file;
    if (empty($nim) || empty($nama) || empty($email) || empty($kelas) || empty($pesan)){
    	$status="Semua field harus diisi!";	
    //}elseif (checkEmail($email) == FALSE){
    //    $status="Alamat E-mail tidak valid, silahkan ulangi lagi.";
    }else{
	
    //$query="insert into wp_tgs1(nim,nama,email,kelas,file,tanggal,jam) values('$nim','$nama','$email','$kelas','$nama_file',CURDATE(),CURTIME())";
	//$result=mysql_query($query);
	//if (is_uploaded_file($_FILES['file']['tmp_name'])) {
	//	$cek = move_uploaded_file ($_FILES['file']['tmp_name'],$dir.$nama_file);
	//}

	//if ($result && $cek){
		
		require 'geekMail.php';
		 
		$geekMail = new geekMail();
		 
		$geekMail->setMailType('html');
		 
		$geekMail->from($email, $nama);
		//$geekMail->from($email, 'Tugas1');
		 
		$geekMail->to('very@ftik.usm.ac.id');

		 
		$geekMail->subject('Pesan Infonil');
		 
		$geekMail->message("NIM : $nim <br/>NAMA : $nama<br/>KELAS : $kelas<br/><p>$pesan</p>");
		 
		//$geekMail->attach($dir.$nama_file);

		 
		if (!$geekMail->send())
		{
		  $errors = $geekMail->getDebugger();
		  print_r($errors);
		}
        $status="Pesan sudah terkirim, <a href='http://in.bernard-very.com'>Klik disini</a> untuk kembali ke Informasi Nilai Online.";
	//}else{
	//	$status="File Tugas 1 gagal terkirim!";		
	//}
	}
}
?>

<table width="100%" border="0">
<tr>
    <td valign="middle"><a href="http://in.bernard-very.com"><img src="pict/header.png"/></a></td>
    <td>&nbsp; </td>
</tr>
</table>

<p>
<form action="" method="post" name="form1">
<table width="500" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td colspan="3" bgcolor="#FFFF66" ><?php echo "<font size='2'>Status : $status</font>"; ?></td>
    </tr>
  <tr>
    <td colspan="3"><b>Kontak Saya</b><br><br><font size="2">Formulir kontak ini sebagai media komunikasi antara Anda dan saya mengenai pertanyaan-pertanyaan yang mungkin ingin Anda ajukan ke saya. Untuk itu mohon gunakan alamat email yang <b>VALID</b> sebagai alamat tujuan balasan pesan.</font><hr>     </td>
    </tr>
  <tr>
    <td width="10%">NIM*</td>
    <td width="3%">:</td>
    <td>
      <input type="text" name="nim"> 
      ( Format : G.XXX.XX.XXXX )     </td>
  </tr>
  <tr>
    <td valign="top">Nama*</td>
    <td valign="top">:</td>
    <td><input name="nama" type="text" size="50"></td>
  </tr>
  <tr>
    <td valign="top">Email*</td>
    <td valign="top">:</td>
    <td><input name="email" type="text" size="30"> 
      ( Contoh : me@yahoo.com )<br/>
       <font size="2"><i>* Alamat email untuk balasan pesan</i></font></td>
  </tr>
  <tr>
    <td valign="top">Kelas*</td>
    <td valign="top">:</td>
    <td><p>
      <label>
      <input type="radio" name="kelas" value="pagi">
  Kelas Pagi</label>
      <label>
      <input type="radio" name="kelas" value="sore">
  Kelas Sore</label>
      <label>
      <br>
    </p></td>
  </tr>
  <tr>
    <td valign="top">Pesan* </td>
    <td valign="top">:</td>
    <td> <textarea name="pesan" rows="15" cols="60"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="Kirim" type="submit" value="Kirim">
      <input name="Batal" type="reset" value="Batal"></td>
  </tr>
</table>
</form>
</p>
</p>
<div class="footer">
<p>
<font size="1">&copy;2011-2012 Bernard Very.</font>
</p>
<a href="http://in.bernard-very.com">Back to in.bernard-very.com ...</a>
</div>
</body>
</html>