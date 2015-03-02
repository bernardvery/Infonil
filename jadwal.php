<?php
    
    $query2 = "SELECT jdw.jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, mk.mk_sks, jdw.jdw_kls, jdw.jdw_klp, jdw.jdw_hari, jdw.jdw_jam, jdw.jdw_ruang, jdw.jdw_dsn_kode,
            dsn.dsn_nama FROM jdw Left Join dsn ON jdw.jdw_dsn_kode = dsn.dsn_kode Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode where jdw_kode='".$page."'";
    $result2 = mysql_query($query2);
    $count2 = mysql_num_rows($result2);
        
    if( $count2 > 0){
        $row2 = mysql_fetch_array($result2);
        $smt=substr($row2[1],5,1).substr($row2[4],0,1);
        if (substr($row2[4],1,1)=="1"){
            $kls="Pagi";
        }else{
            $kls="Sore";
        }
        echo "<p><table width=80%>";
        echo "<tr><td width=25%><b>KODE/NAMA/SKS MATKUL</b></td><td width=1%>:</td><td>$row2[1]/$row2[2]/$row2[3]</td></tr>";
        echo "<tr><td><b>KELAS/KLP</b></td><td>:</td><td>$kls-$smt/Kelp-$row2[5]</td></tr>";
        echo "<tr><td><b>HARI/JAM/RUANG</b></td><td>:</td><td>$row2[6]/$row2[7]/$row2[8]</td></tr>";
        echo "</table></p>";
    }
?>