<?php
 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Irfan Maulana');
$pdf->SetTitle('Laporan Penilaian Kinerja');
// ---------------------------------------------------------
$pdf->SetFont('helvetica','', 9);
$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
$pdf->setFooterData(array(0,0,0),array(0,0,0));
 
// set margins
$pdf->SetMargins(10, 10, 10); // kiri, atas, kanan
$pdf->setPrintHeader(false);
$pdf->SetHeaderMargin(1); // mengatur jarak antara header dan top margin
$pdf->SetFooterMargin(10); //  mengatur jarak minimum antara footer dan bottom margin
$pdf->AddPage('P', 'A4');

 

$str='
<table>
    <tr>
        <td align="center" width="90px"><img src="'.base_url().'assets/images/Logo-Kemenkes.png"  width="50" height="50"></td>
        <td align="center" width="320px"> KEMENTRIAN KESEHATAN RI <br> <b>DIREKTORAT JENDRAL PELAYANAN KESEHATAN <br>RSPI Prof.Dr. SULIANTI SAROSO<br></b></td>
        <td align="center" width="130px"><img src="'.base_url().'assets/images/logo-sultra.png"  width="50" height="50"></td>
    </tr>	
    <tr>
        <td><hr></td>
        <td><hr></td>
        <td><hr></td>
    </tr>	
</table>
<table border="1" cellpadding="5">
    <thead>
        <tr align="center" bgcolor="#d3d3d3">
            <td>Nama Pasien</td>
            <td>Tanggal Transaksi</td>
            <td>Jenis Folio</td>
        </tr>
    </thead>';
   foreach($indikator as $row){
    $str.='<tr>
        <td>'.$row->cust_usr_nama.'</td>
        <td>'.$row->tindakan_tanggal.'</td>
        <td>'.$row->fol_nama.'</td>
    </tr>';
  }
$str.='</table>';
 $pdf->WriteHTML($str);
 $pdf->Output('dok01.pdf','I'); exit;      
?>