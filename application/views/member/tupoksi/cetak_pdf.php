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
$pdf->SetMargins(10, 5, 10); // kiri, atas, kanan
$pdf->setPrintHeader(false);
$pdf->SetHeaderMargin(1); // mengatur jarak antara header dan top margin
$pdf->SetFooterMargin(10); //  mengatur jarak minimum antara footer dan bottom margin
$pdf->AddPage('P', 'A4');

 

$str='
<table>
    <tr>
        <td align="center" width="90px"><img src="'.base_url().'assets/images/Logo-Kemenkes.png"  width="50" height="50"></td>
        <td align="center" width="320px"> KEMENTRIAN KESEHATAN RI <br> <b>DIREKTORAT JENDRAL PELAYANAN KESEHATAN <br>RSPI Prof.Dr. SULIANTI SAROSO</b><br>Jalan Baru Sunter Permai Raya, Jakarta Utara 14340<br>Telp : (021) 6506559 Hunting, Fax : (021) 6401411</td>
        <td align="center" width="130px"><img src="'.base_url().'assets/images/logo-sultra.png"  width="50" height="50"></td>
    </tr>	
    <tr>
        <td><hr></td>
        <td><hr></td>
        <td><hr></td>
    </tr>	
</table>
<table>
	<tr>
		<td width="50px">
			Nama
		</td>
		<td>
			 '.$this->session->userdata('pgw_nama').'
		</td>

	</tr>	
    	<tr>
		<td>
			Nip
		</td>
		<td>
            '.$this->session->userdata('nip').'
		</td>

	</tr>	
    	<tr>
		<td>
			Jabatan
		</td>
		<td>
        '.$this->session->userdata('nama_unit').'
		</td>
    </tr>	
    <tr>	
    	<td>
        </td>
        <td>
        </td>
    </tr>
</table>

<table border="1" cellpadding="2">
    <thead>
        <tr bgcolor="#d3d3d3">
            <td colspan="7">A. Kuantitas</td>
        </tr>                
        <tr align="center" bgcolor="#d3d3d3">
            <td width="30px"><b>No</b></td>
            <td width="124px"><b>Indikator Yang dinilai</b></td>
            <td width="184px"><b>Difinisi Oprasional</b></td>
            <td width="50px"><b>Target</b></td>
            <td width="50px"><b>Capaian</b></td>
            <td width="50px"><b>Bobot</b></td>
            <td width="50px"><b>Hasil Kinerja</b></td>
        </tr>
    </thead>';
    if(!empty($Kuantitas))
    {
        $a=0;$b=0;$c=0;$d=0;$e=0;
        foreach($Kuantitas as $record)
        {
    $str.='<tr>
        <td width="30px">'.++$a.'</td>
        <td width="124px">'.$record->indikator.'</td>
        <td  width="184px">'.$record->difinisi_ops.'</td>
        <td width="50px" align="center">'.$record->target.'</td>
        <td width="50px" align="center">'.$record->nilai.'</td>
        <td width="50px" align="center">'.$record->bobot.'</td>
        <td width="50px" align="center">'.number_format($record->tot,2).'</td>
    </tr>';
    $b+=$record->target;
    $c+=$record->nilai;
    $d+=$record->bobot;
    $e+=number_format($record->tot,2);
        }
    }else{
        $a=0;$b=0;$c=0;$d=0;$e=0;
        $str.='<tr>
        <td width="30px">'.++$a.'</td>
        <td width="124px">-</td>
        <td  width="184px">-</td>
        <td width="50px" align="center">'.$b.'</td>
        <td width="50px" align="center">'.$c.'</td>
        <td width="50px" align="center">'.$d.'</td>
        <td width="50px" align="center">'.number_format($e,2).'</td>
    </tr>'; 
    }
    $str.='
    <tr align="center" bgcolor="#d3d3d3">
        <td colspan="3"><b>Jumlah</b></td>
        <td align="center">'.$sumtotalkuantitastarget=$b.'</td>
        <td align="center">'.$sumtotalkuantitasbobot=$c.'</td>
        <td align="center">'.$sumtotalkuantitasnilai=$d.'</td>
        <td align="center">'.$sumtotalkuantitashasil=$e.'</td>
    </tr>
    ';
    $str.='
    <tr bgcolor="#d3d3d3">
        <td colspan="7">B. Kualitas</td>
    </tr>  
    <tr align="center">
        <td><b>No</b></td>
        <td><b>Indikator Yang dinilai</b></td>
        <td><b>Difinisi Oprasional</b></td>
        <td><b>Target</b></td>
        <td><b>Capaian</b></td>
        <td><b>Bobot</b></td>
        <td><b>Hasil Kinerja</b></td>
    </tr>
    ';
    if(!empty($Kualitas))
    {        
        $a=0;$b=0;$c=0;$d=0;$e=0;
        foreach($Kualitas as $record)
        {
    $str.='<tr>
            <td width="30px">'.++$a.'</td>
            <td width="124px">'.$record->indikator.'</td>
            <td  width="184px">'.$record->difinisi_ops.'</td>
            <td width="50px" align="center">'.$record->target.'</td>
            <td width="50px" align="center">'.$record->nilai.'</td>
            <td width="50px" align="center">'.$record->bobot.'</td>
            <td width="50px" align="center">'.number_format($record->tot,2).'</td>
    </tr>';
    $b+=$record->target;
    $c+=$record->nilai;
    $d+=$record->bobot;
    $e+=number_format($record->tot,2);
        }
    }else{
        $a=0;$b=0;$c=0;$d=0;$e=0;
        $str.='<tr>
        <td width="30px">'.++$a.'</td>
        <td width="124px">-</td>
        <td  width="184px">-</td>
        <td width="50px" align="center">'.$b.'</td>
        <td width="50px" align="center">'.$c.'</td>
        <td width="50px" align="center">'.$d.'</td>
        <td width="50px" align="center">'.number_format($e,2).'</td>
    </tr>'; 
    }
    $str.='
    <tr align="center" bgcolor="#d3d3d3">
        <td colspan="3"><b>Jumlah</b></td>
        <td align="center">'.$sumtotalkualitastarget=$b.'</td>
        <td align="center">'.$sumtotalkualitasbobot=$c.'</td>
        <td align="center">'.$sumtotalkualitasnilai=$d.'</td>
        <td align="center">'.$sumtotalkualitashasil=$e.'</td>
    </tr>
    ';
    $str.='
    <tr bgcolor="#d3d3d3">
        <td colspan="7">C. Perilaku</td>
    </tr>  
    <tr align="center" bgcolor="#d3d3d3">
        <td><b>No</b></td>
        <td><b>Indikator Yang dinilai</b></td>
        <td><b>Difinisi Oprasional</b></td>
        <td><b>Target</b></td>
        <td><b>Capaian</b></td>
        <td><b>Bobot</b></td>
        <td><b>Hasil Kinerja</b></td>
    </tr>
    ';
    if(!empty($Perilaku))
    {
        $a=0;$b=0;$c=0;$d=0;$e=0;
        foreach($Perilaku as $record)
        {
    $str.='<tr>
        <td width="30px">'.++$a.'</td>
        <td width="124px">'.$record->indikator.'</td>
        <td  width="184px">'.$record->difinisi_ops.'</td>
        <td width="50px" align="center">'.$record->target.'</td>
        <td width="50px" align="center">'.$record->nilai.'</td>
        <td width="50px" align="center">'.$record->bobot.'</td>
        <td width="50px" align="center">'.number_format($record->tot,2).'</td>
    </tr>';
    $b+=$record->target;
    $c+=$record->nilai;
    $d+=$record->bobot;
    $e+=number_format($record->tot,2);
        }
        $z=0;
    }else{
        $a=0;$b=0;$c=0;$d=0;$e=0;
        $str.='<tr>
        <td width="30px">'.++$a.'</td>
        <td width="124px">-</td>
        <td  width="184px">-</td>
        <td width="50px" align="center">'.$b.'</td>
        <td width="50px" align="center">'.$c.'</td>
        <td width="50px" align="center">'.$d.'</td>
        <td width="50px" align="center">'.number_format($e,2).'</td>
    </tr>'; 
    }
    $str.='
    <tr align="center" bgcolor="#d3d3d3">
        <td colspan="3"><b>Jumlah</b></td>
        <td align="center">'.$sumtotalperilakutarget=$b.'</td>
        <td align="center">'.$sumtotalperilakubobot=$c.'</td>
        <td align="center">'.$sumtotalperilakunilai=$d.'</td>
        <td align="center">'.$sumtotalperilakuhasil=$e.'</td>
    </tr>
    ';
    $str.='
    <tr align="center" bgcolor="#d3d3d3">
        <td colspan="6"><b>Jumlah</b></td>
        <td align="center">'.$sumtotal=$sumtotalkuantitashasil + $sumtotalkualitashasil + $sumtotalperilakuhasil.'</td>
    </tr>
    ';
$str.='</table>';
$str.='<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td align="center">Jakarta '.date('d-M-Y').' </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td align="center">Pegawai yang dinilai</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td align="center">'.$this->session->userdata('pgw_nama').'</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>NIP: '.$this->session->userdata('nip').'</td>
    </tr>
';

$str.='</table>';
 $pdf->WriteHTML($str);
 $pdf->Output('dok01.pdf','I'); exit;      
?>