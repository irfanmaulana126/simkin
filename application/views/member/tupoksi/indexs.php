<style>
.table a
{
    display:block;
    text-decoration:none;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Tupoksi
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>

              <div class="box-tools">
                <form action="<?= base_url();?>member/tupoksi" method="post">
                  <div class="input-group input-group-sm" style="width: 190px;float:left;">
                    <input type="text" name="table_search" id="datepicker" class="form-control pull-right" placeholder="Cari tanggal">

                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  <form>
                </div>
                &nbsp;
                &nbsp;
                      <a type="submit" href="<?= base_url()?>member/tupoksi/cetak/<?= $dates?>"  target='_blank' class="btn btn-default" style="height: 30px;padding: 5px 10px;font-size: 12px;line-height: 1.5;border-radius: 3px;"><i class="fa fa-print fa-2x"></i></a>
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-borderedr">
               <thead>
                <tr>
                  <td colspan="7">A. Kuantitas</td>
                </tr>                
                <tr class="text-center">
                  <td><b>No</b></td>
                  <td><b>Indikator Yang dinilai</b> </td>
                  <td><b>Difinisi Oprasional</b> </td>
                  <td><b>Target</b> </td>
                  <td><b>Capaian</b> </td>
                  <td><b>Bobot</b> </td>
                  <td><b>Hasil Kinerja</b> </td>
                </tr>
               </thead>
               <tbody>
               <?php if(!empty($Kuantitas))
                        {
                          $a=0;$b=0;$c=0;$d=0;$e=0;
                            foreach($Kuantitas as $record)
                            {
                                ?>
                <tr>
                  <td><a class="showinfo" href="#"> <?= ++$a ?></a></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi_ops ?></td>
                  <td class="text-center"><?= $record->target;$b+=$record->target ?></td>
                  <?php if(!empty($record->id_tindakan)){ ?>
                  <td class="text-center"><a href="<?= base_url('/member/tupoksi/cetak_detail_tupoksi/').$record->id_tindakan."/".$dates?>" target="_blank" rel="noopener noreferrer"><?= $record->nilai;$d+=$record->nilai ?></a></td>
                  <?php }else{ ?>
                  <td class="text-center"><?= $record->nilai;$d+=$record->nilai ?></td>
                  <?php } ?>
                  <td class="text-center"><?= $record->bobot;$c+=$record->bobot ?></td>
                  <td class="text-center"><?= number_format($record->tot,2);$e+=number_format($record->tot,2) ?></td>
                </tr>
                <?php $id_tindakan=$record->id_tindakan;}
              }?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotalkuantitastarget=(empty($b))? '0':$b; ?></b></td>
                  <?php if(!empty($id_tindakan)){?>
                  <td><b><a href="<?= base_url('/member/tupoksi/cetak_detail_all/').$dates?>" target="_blank" rel="noopener noreferrer"><?= $sumtotalkuantitasnilai=(empty($d))?'0':$d;?></a></b></td>
                  <?php }else{?>
                  <td><b><?= $sumtotalkuantitasnilai=(empty($d))?'0':$d;?></b></td>
                  <?php }?>
                  <td><b><?= $sumtotalkuantitasbobot=(empty($c))?'0':$c;?></b></td>
                  <td><b><?= $sumtotalkuantitashasil=(empty($e))?'0':$e;?></b></td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="7">B. Kualitas</td>
                </tr>  
                <tr class="text-center">
                  <td><b>No</b></td>
                  <td><b>Indikator Yang dinilai</b></td>
                  <td><b>Difinisi Oprasional</b></td>
                  <td><b>Target</b></td>
                  <td><b>Capaian</b></td>
                  <td><b>Bobot</b></td>
                  <td><b>Hasil Kinerja</b></td>
                </tr>
               </thead>
               <tbody>
               <?php if(!empty($Kualitas))
                        {
                            
                          $a=0;$f=0;$g=0;$h=0;$i=0;
                            foreach($Kualitas as $record)
                            {
                                ?>
               <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi_ops ?></td>
                  <td class="text-center"><?= $record->target;$f+=$record->target ?></td>
                  <td class="text-center"><?= $record->nilai;$h+=$record->nilai ?></td>
                  <td class="text-center"><?= $record->bobot;$g+=$record->bobot ?></td>
                  <td class="text-center"><?= number_format($record->tot,2);$i+=number_format($record->tot,2) ?></td>
                </tr>
                <?php }}?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotalkualitastarget=(empty($f))? '0':$f; ?></b></td>
                  <td><b><?= $sumtotalkualitasnilai=(empty($h))?'0':$h;?></b></td>
                  <td><b><?= $sumtotalkualitasbobot=(empty($g))?'0':$g;?></b></td>
                  <td><b><?= $sumtotalkualitashasil=(empty($i))?'0':$i;?></b></td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="7">C. Perilaku</td>
                </tr>       
                <tr class="text-center">
                  <td><b>No</b></td>
                  <td><b>Indikator Yang dinilai</b></td>
                  <td><b>Difinisi Oprasional</b></td>
                  <td><b>Target</b></td>
                  <td><b>Capaian</b></td>
                  <td><b>Bobot</b></td>
                  <td><b>Hasil Kinerja</b></td>
                </tr>
               </thead>
               <tbody>
               <?php if(!empty($Perilaku))
                        {
                            $a=0;$j=0;$k=0;$l=0;$m=0;
                            foreach($Perilaku as $record)
                            {
                                ?>
               <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi_ops ?></td>
                  <td class="text-center"><?php echo $record->target; $j+=$record->target ?></td>
                  <td class="text-center"><?php echo $record->nilai; $l+=$record->nilai ?></td>
                  <td class="text-center"><?php echo $record->bobot; $k+=$record->bobot ?></td>
                  <td class="text-center"><?php echo number_format($record->tot,2);$m+=number_format($record->tot,2) ?></td>
                </tr>
                <?php }}?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotalperilakutarget=(empty($j))? '0':$j; ?></b></td>
                  <td><b><?= $sumtotalperilakubobot=(empty($l))?'0':$l;?></b></td>
                  <td><b><?= $sumtotalperilakucapaian=(empty($k))?'0':$k;?></b></td>
                  <td><b><?= $sumtotalperilakuhasil=(empty($m))?'0':number_format($m,2);?></b></td>
                </tr>
                <tr><td colspan="7"></td></tr>
               <tr class="text-center">
                  <td colspan="6"><b>Total Keseluruhan</b></td>
                  <td><b><?= $sumtotalkuantitashasil + $sumtotalkualitashasil + $sumtotalperilakuhasil ?></b></td>
                </tr>
               </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
</div>
<script>
  $(function () {
    $('#datepicker').datepicker({
      format: "yyyy-mm",
      viewMode: "months", 
      minViewMode: "months"
    }).datepicker("setDate", "<?= $dates ?>");
  })
  $('.test').hide();
$('.showinfo').click(function(){
    $('.test',$(this).parent()).toggle();    
});
</script>