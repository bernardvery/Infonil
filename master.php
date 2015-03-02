<?php
$mstr = array("dsn", "jdw", "mhs", "mk", "nilai");
if (in_array($nim, $mstr)) {
    switch ($nim){
        case "dsn":
            $query="select * from dsn";
            break;
        case "jdw":
            $query="SELECT jdw.jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
                dsn.dsn_nama, jdw.jdw_status FROM jdw Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE jdw.jdw_tahun=$tahun AND jdw.jdw_per=$per ORDER BY jdw_jam ASC";
            break;
        case "mhs":
            $query="select * from mhs";
            break;
        case "mk":
            $query="select * from mk";
            break;
        case "nilai":
            $query="SELECT DISTINCT nilai.nil_jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
                dsn.dsn_nama, nilai.nil_mhs_nim, mhs.mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
                nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai Left Join mhs ON nilai.nil_mhs_nim = mhs.mhs_nim Left Join jdw ON nilai.nil_jdw_kode = jdw.jdw_kode
                Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE nilai.nil_tahun=$tahun AND nilai.nil_per=$per ORDER BY nilai.nil_jdw_kode ASC";
            break;
    }
    
    $perintah=mysql_query($query);
    $i=0;
    echo "<h2>List of $nim</h2>
    	  <table class='tableizer-table'>
    	  <tr class='tableizer-firstrow'>";
    //--------------------
    while ($i < mysql_num_fields($perintah)) {
        $meta = mysql_fetch_field($perintah, $i);
        if (!$meta) {
            echo "No information available<br />\n";
        }
        echo "<th >$meta->name</th>";
        $i++;
    }
    //-------------------------
    
    if ($nim=="jdw"){
        echo "<th>Download CSV</th>";
    }
    echo "</tr>";
    
    while ($row = mysql_fetch_array($perintah, MYSQL_NUM)) { 
        echo "<tr align='center'>"; 
        $count = count($row);
        $y = 0; 
        while ($y < $count) { 
            if ($row[$y]=="T"){
                echo '<td><font style="color: red; font-weight: bold;">Nilai Belum</font></td>';
            }elseif ($row[$y]=="Y"){
                echo '<td><font style="color: green; font-weight: bold;">Nilai Sudah</font></td>';
            }else{
                echo '<td>' . $row[$y]. '</td>';
            }
            $y++; 
        }
        if ($nim=="jdw"){
            //echo "<td><a href='export2csv.php?csv=$row[0]'>$row[0]".".csv"."</td>";
            echo "<td><a href='export2csv.php?csv=$row[0]&thn=$tahun&per=$per'>Download</td>";
        }
        echo '</tr>'; 
    }
    echo "</table>";
}else{
    echo "<br/><b>INFO:</b> Kata kunci pencarian yang Anda masukkan SALAH!.<br/>";
}
?>