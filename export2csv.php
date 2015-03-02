<?php
include "koneksi.php";
$header=null;
$data=null;
    
$csv = $_GET['csv'];
$tahun = $_GET['thn'];
$per = $_GET['per'];

// -- get filename from jadwal table
    $query1="SELECT jdw.jdw_kode, jdw.jdw_mk_kode, mk.mk_nama, jdw.jdw_kls, jdw.jdw_klp FROM jdw Left Join mk ON jdw.jdw_mk_kode = mk.mk_kode WHERE jdw.jdw_tahun=$tahun AND jdw.jdw_per=$per AND jdw.jdw_kode='".$csv."'";
    $result1 = mysql_query($query1);
    $count1 = mysql_num_rows($result1); 
    if( $count1 > 0){
        while ($row1 = mysql_fetch_array($result1)){
            $smt=substr($row1[1],5,1).substr($row1[3],0,1);
            if (substr($row1[3],1,1)=="1"){
                $kls="Pagi";
            }else{
                $kls="Sore";
            }
            $filename=$kls."-".$smt."-".$row1[2]."-".$csv;
            //echo "<li><a href='?page=$row1[0]'>$kls-$smt-$row1[2]</a></li>";    
        }
    }
// end of get filename    
$select = "SELECT DISTINCT nilai.nil_jdw_kode, nilai.nil_mhs_nim,nilai.nil_mhs_nama, nilai.nil_tgs1, nilai.nil_tgs2, nilai.nil_tgs3, nilai.nil_tgs4, nilai.nil_tgs5, nilai.nil_rttgs, nilai.nil_uts,
            nilai.nil_uas, nilai.nil_angka, nilai.nil_huruf FROM nilai WHERE nilai.nil_tahun=$tahun AND nilai.nil_per=$per AND nilai.nil_jdw_kode ='".$csv."' ORDER BY nilai.nil_mhs_nim ASC";
$export = mysql_query ( $select ) or die ( "Sql error : " . mysql_error( ) );
$fields = mysql_num_fields ( $export );
for ( $i = 0; $i < $fields; $i++ )
{
    //$header .= mysql_field_name( $export , $i ) . ';'. "\t";
    $header .= mysql_field_name( $export , $i ) . ';';    
}
$header=substr($header,0,strlen($header)-1);

while( $row = mysql_fetch_row( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = ';';
        }
        elseif(end($row) === $value)
        {
            $value = str_replace( "\n" , "" , $value );
            //$value =$value;
        }else
        {
            $value = str_replace( "\n" , "" , $value );
            $value =$value.';';
        }
        $line .= $value;
    }
    //$line=substr($line,0,strlen($line)-1);
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";                        
}

header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=".$filename.".csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";

?>