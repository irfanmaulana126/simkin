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
                  <div class="input-group input-group-sm" style="width: 190px;float:left;">
                    <input type="text" name="date" id="datepicker" class="form-control pull-right" placeholder="Cari tanggal">
                    <input type="hidden" name="usr_id" id="usr_id" class="form-control pull-right" value="<?= $usr_id?>">
                    <input type="hidden" name="unit" id="unit" class="form-control pull-right" value="<?= $unit?>">
                    <input type="hidden" name="jabatan" id="jabatan" class="form-control pull-right" value="<?= $jabatan->jenis_pegawai?>">

                    <div class="input-group-btn">
                      <button type="submit" onclick="table_search()" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
              </div>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table>
            <?php foreach ($pegawai as $key ) {?>
                <tr>
                    <td width="100px">
                        Nama
                    </td>
                    <td>
                    :
                    </td>
                    <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key->pgw_nama; ?>
                    </td>

                </tr>	
                    <tr>
                    <td>
                        Nip
                    </td>
                    <td>
                    :
                    </td>
                    <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key->pgw_nip; ?>
                    </td>

                </tr>	
                    <tr>
                    <td>
                        Unit Kerja
                    </td>
                    <td>
                    :
                    </td>
                    <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $key->nama_unit; ?>
                    </td>
                </tr>
<?php } ?>
                <tr>
                    <td>
                        Tanggal
                    </td>
                    <td>
                    :
                    </td>
                    <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('F-Y', strtotime($dates)) ?>
                    </td>
                    
                </tr>		
                <tr>	
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>
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
				  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td><b>Action</b> </td>
                <?php }?>
                  </tr>
               </thead>
               <tbody>
               <?php if(!empty($Kuantitas))
                        {
                          $a=0;$b=0;$c=0;$d=0;$e=0;
                            foreach($Kuantitas as $key=>$datas)
                            {
                              foreach ($datas as $record) {
                                if($record->indikator_tupoksi=='1'){
                                ?>
                <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi ?></td>
                  <td class="text-center"><?= $record->target;$b+=$record->target ?></td>
                  <?php if($record->jns_input=='0'){ ?>
                  <td class="text-center"><a href="<?= base_url('/member/tupoksi/cetak_detail_tupoksi_folio/').$usr_id."/".$record->id."/".$dates."/".$record->id_unit_kerja?>" target="_blank" rel="noopener noreferrer"><?= $record->sumall;$d+=$record->sumall ?></a></td>
                  <?php }else if($record->jns_input=='1'){ ?>
                  <td class="text-center"><a href="<?= base_url('/member/tupoksi/cetak_detail_tupoksi_tindakan/').$usr_id."/".$record->id."/".$dates."/".$record->id_unit_kerja?>" target="_blank" rel="noopener noreferrer"><?= $record->sumall;$d+=$record->sumall ?></a></td>
                  <?php }else{ ?>
                  <td class="text-center"><?= $record->sumall;$d+=$record->sumall ?></td>
                  <?php } ?>
                  <td class="text-center"><?= $record->bobot;$c+=$record->bobot ?></td>
                  <td class="text-center"><?= number_format($record->total,2);$e+=number_format($record->total,2) ?></td>
				  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td class="text-center"><a class="btn btn-sm btn-info" onclick="edit('<?= $usr_id?>','<?= $record->id ?>','<?=$record->input?>','<?=$record->indikator_tupoksi?>')" title="Detail"><i class="fa fa-pencil"></i></a></td>
				  <?php }?>
			  </tr>
                <?php $id_tindakan=$record->id;}}}
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
                  <td></td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="8">B. Kualitas</td>
                </tr>  
                <tr class="text-center">
                  <td><b>No</b></td>
                  <td><b>Indikator Yang dinilai</b></td>
                  <td><b>Difinisi Oprasional</b></td>
                  <td><b>Target</b></td>
                  <td><b>Capaian</b></td>
                  <td><b>Bobot</b></td>
                  <td><b>Hasil Kinerja</b></td>
                  <td></td>
                </tr>
               </thead>
               <tbody>
               <?php if(!empty($Kualitas))
                        {
                            
                          $a=0;$f=0;$g=0;$h=0;$i=0;
                            foreach($Kualitas as $key=>$datas)
                            {
                              foreach ($datas as $record) {
                                if($record->indikator_tupoksi=='2'){
                                ?>
               <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi ?></td>
                  <td class="text-center"><?= $record->target;$f+=$record->target ?></td>
                  <td class="text-center"><?= $record->sumall;$h+=$record->sumall ?></td>
                  <td class="text-center"><?= $record->bobot;$g+=$record->bobot ?></td>
                  <td class="text-center"><?= number_format($record->total,2);$i+=number_format($record->total,2) ?></td>
                  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td class="text-center"><a class="btn btn-sm btn-info" onclick="edit('<?= $usr_id?>','<?= $record->id ?>','<?=$record->input?>','<?=$record->indikator_tupoksi?>')" title="Detail"><i class="fa fa-pencil"></i></a></td>
				  <?php }?>
                </tr>
                <?php }}}}?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotalkualitastarget=(empty($f))? '0':$f; ?></b></td>
                  <td><b><?= $sumtotalkualitasnilai=(empty($h))?'0':$h;?></b></td>
                  <td><b><?= $sumtotalkualitasbobot=(empty($g))?'0':$g;?></b></td>
                  <td><b><?= $sumtotalkualitashasil=(empty($i))?'0':$i;?></b></td>
                  <td></td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="8">C. Perilaku</td>
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
                            foreach($Perilaku as $key=>$datas)
                            {
                              foreach ($datas as $record) {
                                if($record->indikator_tupoksi=='3'){
                                ?>
               <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi ?></td>
                  <td class="text-center"><?php echo $record->target; $j+=$record->target ?></td>
                  <td class="text-center"><?php echo $record->sumall; $l+=$record->sumall ?></td>
                  <td class="text-center"><?php echo $record->bobot; $k+=$record->bobot ?></td>
                  <td class="text-center"><?php echo number_format($record->total,2);$m+=number_format($record->total,2) ?></td>
                  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td class="text-center"><a class="btn btn-sm btn-info" onclick="edit('<?= $usr_id?>','<?= $record->id ?>','<?=$record->input?>','<?=$record->indikator_tupoksi?>')" title="Detail"><i class="fa fa-pencil"></i></a></td>
                <?php }?>
                  </tr>
                <?php }}}}?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotalperilakutarget=(empty($j))? '0':$j; ?></b></td>
                  <td><b><?= $sumtotalperilakubobot=(empty($l))?'0':$l;?></b></td>
                  <td><b><?= $sumtotalperilakucapaian=(empty($k))?'0':$k;?></b></td>
                  <td><b><?= $sumtotalperilakuhasil=(empty($m))?'0':number_format($m,2);?></b></td>
                  <td></td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="7">D. Kegiatan Tambahan</td>
                  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td class="text-center"><a class="btn btn-sm btn-info" onclick="kegiatan('<?= $usr_id?>')" title="Detail"><i class="fa fa-plus"></i></a></td>
                <?php }?>
                  </tr>       
                <tr class="text-center">
                  <td><b>No</b></td>
                  <td><b>Indikator Yang dinilai</b></td>
                  <td><b>Difinisi Oprasional</b></td>
                  <td><b>Target</b></td>
                  <td><b>Capaian</b></td>
                  <td><b>Bobot</b></td>
                  <td><b>Hasil Kinerja</b></td>
                  <td></td>
                </tr>
               </thead>
               <tbody>
               <?php if(!empty($Tambahan))
                        {
                            $a=0;$j=0;$k=0;$l=0;$m=0;
                            foreach($Tambahan as $key=>$datas)
                            {
                              foreach ($datas as $record) {
                                if($record->indikator_tupoksi=='4'){
                                ?>
               <tr>
                  <td><?= ++$a ?></td>
                  <td><?= $record->indikator ?></td>
                  <td><?= $record->difinisi ?></td>
                  <td class="text-center"><?php echo $record->target; $j+=$record->target ?></td>
                  <td class="text-center"><?php echo $record->sumall; $l+=$record->sumall ?></td>
                  <td class="text-center"><?php echo $record->bobot; $k+=$record->bobot ?></td>
                  <td class="text-center"><?php echo number_format($record->total,2);$m+=number_format($record->total,2) ?></td>
                  <?php if($jabatan->jenis_pegawai=='0'){?>
                  <td class="text-center"><a class="btn btn-sm btn-danger delete" href="#" data-id="<?php echo $record->input; ?>" data-id_master_indikator="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a></td>
              <?php }?>  
			  </tr>
                <?php }}}}?>
               <tr class="text-center">
                  <td colspan="3"><b>Jumlah</b></td>
                  <td><b><?= $sumtotaltambahantarget=(empty($j))? '0':$j; ?></b></td>
                  <td><b><?= $sumtotaltambahanbobot=(empty($l))?'0':$l;?></b></td>
                  <td><b><?= $sumtotaltambahancapaian=(empty($k))?'0':$k;?></b></td>
                  <td><b><?= $sumtotaltambahanhasil=(empty($m))?'0':number_format($m,2);?></b></td>
                  <td></td>
                </tr>
                <tr><td colspan="8"></td></tr>
               <tr class="text-center">
                  <td colspan="6"><b>Total Keseluruhan</b></td>
                  <td><b><?= $sumtotalkuantitashasil + $sumtotalkualitashasil + $sumtotalperilakuhasil +  $sumtotaltambahanhasil?></b></td>
                </tr>
               </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Tambah Indikator Kualitas Pegawai</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>member/PegawaiUnit/addNew" id="forms" method="POST">
        <input type="hidden" name="usr_id" id="usr_ids">
        <input type="hidden" name="indikator" id="id_indikators">
        <input type="hidden" name="tupoksi" id="indikator_tupoksis">
        <input type="hidden" name="date" value="<?= $dates ?>">
        <input type="hidden" name="unit" value="<?= $unit ?>">
        <div class="form-group">
              <label >Capaian</label>
              <input type="number" min='-1' name="nilai" id="nilai" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
        </div>

    </div>
  </div>
</div>


<div class="modal fade" id="exampleModaltambahan" role="dialog" aria-labelledby="exampleModaltambahanLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModaltambahanLabel">Tambah Kegiatan</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>member/PegawaiUnit/addNew" id="form" method="POST">
    <input type="hidden" name="usr_id" id="usr_idss">
        <input type="hidden" name="date" value="<?= $dates ?>">
        <input type="hidden" name="tupoksi" value="4">
        <input type="hidden" name="unit" value="<?= $unit ?>">
          <div class="form-group">
              <label >Indikator</label>
              <input type="text" name="indikator_keterangan" class="form-control">
          </div>
          <div class="form-group">
              <label >definisi</label>
              <input type="text" name="definisi" class="form-control">
          </div>
        
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
        </div>

    </div>
  </div>
</div>

</div>
<script>
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".delete", function(){
		var id_input = $(this).data("id"),id_master_indikator = $(this).data("id_master_indikator"),
			hitURL = baseURL + "member/PegawaiUnit/delete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id_input : id_input,id_master_indikator:id_master_indikator }
			});
            
            location.reload();  
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
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
function table_search() {
    var date = $('#datepicker').val();
    var usr_id = $('#usr_id').val();
    var unit = $('#unit').val();
    var jabatan = $('#jabatan').val();
    window.location.href = "<?=base_url();?>member/PegawaiUnit/pegawaiDetail/"+usr_id+"/"+jabatan+"/"+unit+"/"+date+"";
}
function edit(userId,id_indikator,id_input,indikator_tupoksi)
{
    if(id_input !== ''){
        $.ajax({
            url : "<?php echo base_url()?>member/PegawaiUnit/oldEdit/" + id_input,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#usr_ids').val(userId);
                $('#id_indikators').val(id_indikator);
                $('#nilai').val(data.nilai);
                $('#indikator_tupoksis').val(data.indikator_tupoksi);
                $('#forms').removeAttr('action'); // show bootstrap modal when complete loaded
                $('#forms').attr('action', '<?php echo base_url();?>member/PegawaiUnit/edit/'+id_input); // show bootstrap modal when complete loaded
                $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Indikator Pegawai'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }else{     
        $('#usr_ids').val(userId);
        $('#id_indikators').val(id_indikator);
        $('#indikator_tupoksis').val(indikator_tupoksi);
        $('#nilai').val('');
        $('#forms').removeAttr('action'); // show bootstrap modal when complete loaded
        $('#forms').attr('action', '<?php echo base_url();?>member/PegawaiUnit/addNew'); // show bootstrap modal when complete loaded
        $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Tambah Indikator Pegawai'); // Set title to Bootstrap modal title

    }
}
function kegiatan(userId)
{
       
        $('#usr_idss').val(userId);
        $('#exampleModaltambahan').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Tambah Kegiatan Indikator Pegawai'); // Set title to Bootstrap modal titl
}
</script>
