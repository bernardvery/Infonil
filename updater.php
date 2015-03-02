<html>
<head>
    <title>CSV Uploader</title>
</head>
<body>
<?php
include("koneksi.php");
$query="select * from opt";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result,MYSQL_BOTH);
    $tahun=$row[0];
    $per=$row[1];
    
if(isset($_FILES["csvfile"])){
    if (isset($_POST['periode'])){
        $periode=$_POST['periode'];
        $tahun=substr($periode,0,4);
        $per=substr($periode,4,1);
    }
    $tmp = $_FILES["csvfile"]["tmp_name"];
    $name = "temp.csv";
    $tempdir = $_SERVER['DOCUMENT_ROOT'] . "/csvtemp/";
    if(move_uploaded_file($tmp, $tempdir.$name)){ echo "file uploaded<br>"; }
    $csvfile = $tempdir.$name;
    $fin = fopen($csvfile,'r') or die('cant open file');
    $i=0;
    while (($data=fgetcsv($fin,1000,";"))!==FALSE) {
        //$query = "UPDATE nilai SET sku='$data[1]' WHERE entity_id='$data[0]'";
        $query = "UPDATE nilai SET nil_tgs1='$data[3]', nil_tgs2='$data[4]', nil_tgs3='$data[5]', nil_tgs4='$data[6]', nil_tgs5='$data[7]', nil_rttgs='$data[8]', nil_uts='$data[9]', nil_uas='$data[10]', nil_angka='$data[11]', nil_huruf='$data[12]' WHERE nil_tahun=$tahun AND nil_per=$per AND nil_jdw_kode='$data[0]' AND nil_mhs_nim='$data[1]'";
        //echo "'$data[0]':'$data[1]':'$data[2]':'$data[3]':'$data[4]':'$data[5]':'$data[6]':'$data[7]':'$data[8]':'$data[9]':'$data[10]':'$data[11]'<br/>";
        mysql_query($query);
        //echo $i.":Record updated <br />\n";
        $query1 = "UPDATE jdw SET jdw_status='Y' WHERE jdw_tahun=$tahun AND jdw_per=$per AND jdw_kode='$data[0]'";
        mysql_query($query1);
        $i++;
        }
        echo ($i-1)." Record updated <br />\n";
    fclose($fin);
    mysql_close();
} // submit 
?>
<form action="" enctype="multipart/form-data" method="POST">
<table>
<tr>
    <td>Pilih file</td>
    <td>:</td>
    <td>
    <input name="csvfile" type="file" />
    </td>
</tr>
<tr>
    <td>Periode</td>
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
        $periode="Smt. ";
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
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
    <td>
    <input type="submit" value="Update" name="submit" />
    </td>
</tr>
</table>
</form>
<p>
<font size="2">&copy;2011-2012 Bernard Very.</font>
</p>
<a href="http://in.bernard-very.com">Back to in.bernard-very.com ...</a>
</body>
</html>
