<?php
    include("koneksi.php");
    $query="select * from opt";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result,MYSQL_BOTH);
    $tahun=$row[0];
    $per=$row[1];
    //echo $tahun."-".$per;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Bernard-Very" />

	<title>Informasi Nilai Online</title>
    <style type="text/css">
    body{
    font-family: Verdana, Arial, Helvetica, Sans-serif;
    font-size: 14px;
    }
    div {   
            padding: 3px; 
            margin: 5px; 
    }
    .background { 
            position: relative;
            background-color: #c0c0c0; 
            padding: 0; 
            color: #335500; 
    }    
    .boxinfo{
        display: block;
        background-color: black;
        color: white;
        padding: 5px;
        left:5px;
    }
    .info{
        position: relative;
    	border: thin groove;
    	margin: 5px;
    	padding: 5px;
        background-color: gray;
        #height: 400px;
    }
    .box1{
        float: left;
    	width: 300px;
    }
    .box2{
        float: left;
    	width: 300px;
    }
    .footer{
        clear: both;
        display: block;
    }
    table.tableizer-table {border: 1px solid #CCC; font-family: Arial, Helvetica, sans-serif; font-size: 14px;} .tableizer-table td {padding: 4px; margin: 3px; border: 1px solid #ccc;}
    .tableizer-table th {background-color: #FFFFFF; color: #000; font-weight: bold;}
    #menu {
        text-align: center;
        
    }
    #menu ul {
        list-style: none;
        padding-left: 10px;
    }
    #menu ul li {
        display: inline;
        font-size: 12px;
        line-height: 20px;
    }
    #menu ul li a {
        padding: 5px;
        color: #000000;
    }
    #menu ul li a:hover {
        color: #000000;
        background-color: #CCC;
        font-size: 14px;
        font-weight: bold;
    }

    </style>
</head>

<body>
<form action="" method="post" name="infonil">
<table width="100%" border="0">
<tr>
    <td valign="middle"><a href="http://in.bernard-very.com/"><img src="pict/header.png"/></a></td>
    <td align="center" valign="middle">&nbsp;</td>
</tr>
</table>
<br />
<table>
<tr>
    <td valign="middle">N.I.M</td>
    <td>:</td>
    <td>
    <input type="text" size="12" maxlength="13" name="nim"/>&nbsp;G.XXX.XX.XXXX
    </td>
    <td>&nbsp;</td>
</tr>
<tr>
   
    <td>SMT.</td>
    <td>:</td>
    <td>
    <font size="2">
    <select size="1" name="periode">
    
    <?php
    $query="select DISTINCT jdw_tahun, jdw_per from jdw ORDER BY jdw_tahun,jdw_per ASC";
    $result = mysql_query($query);
    $count = mysql_num_rows($result);
    while ($row = mysql_fetch_array($result,MYSQL_BOTH))
    {
        //$periode="Smt. ";
        $periode="";
        if ($row[1]==1) $periode.="Gasal "; else $periode.="Genap ";
        $periode.=$row[0]."/".($row[0]+1);
        
        if ($row[0]==$tahun AND $row[1]==$per)
            echo "<option value=$row[0]$row[1] selected>$periode</option>";
        else
            echo "<option value=$row[0]$row[1]>$periode</option>";
    }
    ?>
        
    </select>
    </font>
    </td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>OPSI</td>
    <td>:</td>
    <td>
    <font size="2">
    <input type="radio" name="opsi" value="com" checked/>Semua Nilai
    <input type="radio" name="opsi" value="sim"/>Nilai Huruf
    </font>
    </td>
   <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="lihat" value="Lihat Nilai" style="height: 30px; width: 200px" /></td>
    <td>&nbsp;</td>
</tr>
</table>
</form>
<div align="right"><a href="contact.php"><img src="pict/contact.jpg"/></a></div>
<hr />
<?
if (isset($_POST['lihat'])){
    $nim = $_POST['nim']; 
    $opsi = $_POST['opsi'];
    if (isset($_POST['periode'])){
        $periode=$_POST['periode'];
        $tahun=substr($periode,0,4);
        $per=substr($periode,4,1);
    }
    //$left=substr($nim,0,3);
    //echo $left;
if (substr($nim,0,3)=="TIS" OR substr($nim,0,3)=="SIS"){
    $query0 = "SELECT jdw.jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
            dsn.dsn_nama FROM jdw Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode where (jdw_tahun=$tahun AND jdw_per=$per) AND jdw_kode='".$nim."'" ;
    $result0 = mysql_query($query0);
    $count0 = mysql_num_rows($result0);
        
    if( $count0 > 0){
        $row0 = mysql_fetch_array($result0);
        $smt=substr($row0[1],5,1).substr($row0[4],0,1);
        if (substr($row0[4],1,1)=="1"){
            $kls="Pagi";
        }else{
            $kls="Sore";
        }
        echo "<p><table width=80%><tr><td width=10%><b>KODE JADWAL</b></td><td width=1%>:</td><td>$row0[0]</td></tr>";
        echo "<tr><td width=25%><b>KODE/NAMA/SKS MATKUL</b></td><td width=1%>:</td><td>$row0[1]/$row0[2]/$row0[3]</td></tr>";
        echo "<tr><td><b>KELAS/KLP</b></td><td>:</td><td>$kls-$smt/Kelp-$row0[5]</td></tr>";
        echo "<tr><td><b>HARI/JAM/RUANG</b></td><td>:</td><td>$row0[6]/$row0[7]/$row0[8]</td></tr>";
        echo "<tr><td><b>KODE/NAMA DOSEN</b></td><td>:</td><td>$row0[9]/$row0[10]</td></tr></table></strong></p>";
    //}
?>
        <p>
         <table width="100%" class="tableizer-table">
          <tr class="tableizer-firstrow">
              <th>No</th>
              <th>NIM</th>
              <th>Nama</th>
              <? if ($opsi=='com'){
                 echo "<th>Tgs1</th>
                      <th>Tgs2</th>
                      <th>Tgs3</th>
                      <th>Tgs4</th>
                      <th>Tgs5</th>
                      <th>Rata.Tgs</th>
                      <th>UTS</th>
                      <th>UAS</th>";
              } ?>
              <th>Nilai Angka</th>
              <th>Nilai Huruf</th>
           </tr>
        <?
            /*
            $query="SELECT DISTINCT nilai.nil_jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
            dsn.dsn_nama, nilai.nil_mhs_nim, mhs.mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
            nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai Left Join mhs ON nilai.nil_mhs_nim = mhs.mhs_nim Left Join jdw ON nilai.nil_jdw_kode = jdw.jdw_kode
            Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE (nilai.nil_tahun=$tahun AND nilai.nil_per=$per) AND nilai.nil_jdw_kode =  '".$nim."' ORDER BY nilai.nil_mhs_nim ASC";
            */
        	$query="SELECT DISTINCT nilai.nil_tahun, nilai.nil_per, nilai.nil_jdw_kode, nilai.nil_mhs_nim, nilai.nil_mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
            nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai WHERE (nilai.nil_tahun=$tahun AND nilai.nil_per=$per) AND nilai.nil_jdw_kode='".$nim."' ORDER BY nilai.nil_mhs_nim ASC";
         
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            $i=1;
            if( $count > 0){
            while ($row = mysql_fetch_array($result))
                  {
                      $nimmhs = $row['nil_mhs_nim'];
            		  $namamhs = $row['nil_mhs_nama'];
                      $tgs1 = $row['nil_tgs1'];
                      $tgs2 = $row['nil_tgs2'];
                      $tgs3 = $row['nil_tgs3'];
                      $tgs4 = $row['nil_tgs4'];
                      $tgs5 = $row['nil_tgs5'];
                      $rttgs = $row['nil_rttgs'];
                      $uts = $row['nil_uts'];
                      $uas = $row['nil_uas'];
                      $nilangka = $row['nil_angka'];
                      $nilhuruf = $row['nil_huruf'];
            		  
            		  echo "<tr>
                              <td align='center'>$i</td>
            			      <td>$nimmhs</td>
            			      <td>$namamhs</td>";
                      if ($opsi=='com'){
                            echo "<td align='center'>$tgs1</td>
                              <td align='center'>$tgs2</td>
                              <td align='center'>$tgs3</td>
                              <td align='center'>$tgs4</td>
                              <td align='center'>$tgs5</td>
                              <td align='center'>$rttgs</td>
                              <td align='center'>$uts</td>
                              <td align='center'>$uas</td>";
                        }
            	        echo "<td align='center'>$nilangka</td>
                              <td align='center'>$nilhuruf</td></tr>";
                   $i++;
            	   } // end of while
            	} //end of if( $count > 0) data nilai
             //}
        ?>
          </table>
          </p>
        <?
         }else{ //end of if( $count > 0) data mahasiswa 
          echo "<br/><b>INFO:</b> KODE JADWAL yang Anda masukkan salah!.<br/>";  
         }
}elseif (substr($nim,0,1)=="G"){
    $query0 = "SELECT mhs_nama FROM mhs where mhs_nim='".$nim."'";
    $result0 = mysql_query($query0);
    $count0 = mysql_num_rows($result0);
        
    if( $count0 > 0){
        $row0 = mysql_fetch_array($result0);
        echo "<p><table width=80%><tr><td width=10%><b>NIM</b></td><td width=1%>:</td><td>$nim</td></tr>";
        echo "<tr><td><b>NAMA</b></td><td>:</td><td>$row0[0]</td></tr></table></strong></p>";
    //}
?>
        <p>
        <table width="100%" class="tableizer-table">
          <tr class="tableizer-firstrow">
              <th>Kode Matakuliah</th>
              <th>Nama Matakuliah</th>
              <th>SKS</th>
        <? if ($opsi=='com'){
                 echo "
              <th>Tgs1</th>
              <th>Tgs2</th>
              <th>Tgs3</th>
              <th>Tgs4</th>
              <th>Tgs5</th>
              <th>Rata.Tgs</th>
              <th>UTS</th>
              <th>UAS</th>
              <th>Nilai Angka</th>";
            } ?>
              <th>Nilai Huruf</th>
           </tr>
        <?  /*
            $query="SELECT DISTINCT nilai.nil_jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
            dsn.dsn_nama, nilai.nil_mhs_nim, mhs.mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
            nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai Left Join mhs ON nilai.nil_mhs_nim = mhs.mhs_nim Left Join jdw ON nilai.nil_jdw_kode = jdw.jdw_kode
            Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE (nilai.nil_tahun=$tahun AND nilai.nil_per=$per) AND nilai.nil_mhs_nim =  '".$nim."' ORDER BY nilai.nil_jdw_kode ASC";
            */
            $query="SELECT DISTINCT nilai.nil_jdw_kode, jdw.jdw_mk_kode, mk.mk_nama,mk.mk_sks,nilai.nil_mhs_nim, nilai.nil_mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
            nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai Left Join jdw ON nilai.nil_jdw_kode = jdw.jdw_kode left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE (nilai.nil_tahun=$tahun AND nilai.nil_per=$per) AND nilai.nil_mhs_nim='".$nim."' ORDER BY nilai.nil_jdw_kode ASC";
            $result = mysql_query($query);
            $count = mysql_num_rows($result);
            
            if( $count > 0){
            while ($row = mysql_fetch_array($result))
                  {
                      $kodemk = $row['jdw_mk_kode'];
            		  $namamk = $row['mk_nama'];
                      $sksmk = $row['mk_sks'];
                      $tgs1 = $row['nil_tgs1'];
                      $tgs2 = $row['nil_tgs2'];
                      $tgs3 = $row['nil_tgs3'];
                      $tgs4 = $row['nil_tgs4'];
                      $tgs5 = $row['nil_tgs5'];
                      $rttgs = $row['nil_rttgs'];
                      $uts = $row['nil_uts'];
                      $uas = $row['nil_uas'];
                      $nilangka = $row['nil_angka'];
                      $nilhuruf = $row['nil_huruf'];
            		  
            		  echo "<tr>
            			      <td>$kodemk</td>
            			      <td>$namamk</td>
                              <td align='center'>$sksmk</td>";
                     if ($opsi=='com'){
                            echo "
                              <td align='center'>$tgs1</td>
                              <td align='center'>$tgs2</td>
                              <td align='center'>$tgs3</td>
                              <td align='center'>$tgs4</td>
                              <td align='center'>$tgs5</td>
                              <td align='center'>$rttgs</td>
                              <td align='center'>$uts</td>
                              <td align='center'>$uas</td>
            			      <td align='center'>$nilangka</td>";
                        }
            			 echo "<td align='center'>$nilhuruf</td>
            			    </tr>";
            	   } // end of while
            	} //end of if( $count > 0) data nilai
             //}
        ?>
          </table>
          </p>
        <?
         }else{ //end of if( $count > 0) data mahasiswa 
          echo "<br/><b>INFO:</b> NIM yang Anda masukkan salah atau Anda bukan mahasiswa saya!.<br/>";  
         }
   }else{
        //echo "<br/><b>INFO:</b> NIM atau KODE JADWAL yang Anda masukkan salah!.<br/>";
        include("master.php");
   } // end of if substr
 
 } // end of if (isset)
 
?>
<p>  
<strong>Keterangan:</strong>
<ul type="square">
    <li>Masukkan <b>NIM</b> Anda pada texbox pencarian, kemudian klik tombol <b>'Lihat Nilai'</b>.</li>
    <li>Layanan informasi nilai ini hanya diberikan untuk mahasiswa yang mengikuti matakuliah dengan dosen pengampu saya.</li>
    <li>Informasi nilai yang terdapat pada layanan in bersifat <b>nilai sementara</b>.</li>
    <li>Jika ada perbedaan informasi nilai antara SIA dengan informasi pada sistem ini, maka informasi yang ada pada SIA yang <b>VALID</b>.</li>
</ul>
</p>
<hr />
<p>
<!--strong>Info Tugas &amp; Project Matakuliah</strong//-->
<?
/*
    $query1="SELECT jdw.jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, jdw.jdw_kls, jdw.jdw_klp FROM jdw Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode ORDER BY jdw_jam ASC";
    $result1 = mysql_query($query1);
    $count1 = mysql_num_rows($result1);
    echo "<div id='menu'><ul>";       
    if( $count1 > 0){
        while ($row1 = mysql_fetch_array($result1)){
            $smt=substr($row1[1],5,1).substr($row1[3],0,1);
            if (substr($row1[3],1,1)=="1"){
                $kls="Pagi";
            }else{
                $kls="Sore";
            }
            echo "<li><a href='?page=$row1[0]'>$kls-$smt-$row1[2]</a></li>";    
        }
    }
    echo "</ul></div>";
*/
?>

</p>
<p>
<?
/*
if ($_REQUEST["page"]){
    $page=$_REQUEST["page"];
    $tempdir = $_SERVER['DOCUMENT_ROOT'] . "/info/";
    $filename=$tempdir.$page.".php";
    //echo $filename;
    if (file_exists($filename)){
        echo "<hr/>";
        include("jadwal.php");
        include ($filename);
    }
}
*/
?>
</p>
<div class="footer">
<p>
<font size="1">&copy;2011-2012 Bernard Very.</font>
</p>
<a href="http://bernard-very.com">Back to bernard-very.com ...</a>
</div>
</body>
</html>