<?php
 require_once('tcpdf_include.php');
 
 $pdf = new TCPDF();
 $pdf->AddPage();
 $isi = 'Isi dari dokumen PDF';
 $pdf->Write(0,$isi);
 $pdf->AddPage();
 $html = '<b>Tulisan tebal</b>
	  <br/>
          <table border="1">
	    <tr>
	       <td>1</td>
	       <td>2</td>
	       <td>3</td>
	    </tr>
	    <tr>
	       <td>4</td>
	       <td align="center">5</td>
	       <td>6</td>
	    </tr>
	  </table>';
 $pdf->WriteHTML($html);
 $pdf->AddPage();
 
 mysql_connect('localhost','root','');
 mysql_select_db('plpw');
 $q = 'SELECT * FROM menu';
 $h = mysql_query($q);
 
 $str = '<table>
           <tr>
	      <td width="20">ID</td><td>Nama</td><td>Harga</td><td>Stok</td>
	   </tr>';
 
 while($r = mysql_fetch_assoc($h)){
	$str .= '<tr><td >'.$r['id'].'</td><td>'.$r['nama'].'</td><td>'.$r['harga'].'</td><td>'.$r['stok'].'</td></tr>'; 
 }
 $str .= '</table>';  //$str = $str . '</table>';     a = a + 10    a+=10
 $pdf->WriteHTML($str);
 
 $pdf->Output('dok01.pdf','I');

?>