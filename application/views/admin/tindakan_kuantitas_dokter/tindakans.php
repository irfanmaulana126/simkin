<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Indikator Tindakan Kuantitas Dokter Management
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Pegawai List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                      <th>no</th>
                      <th>Jabatan</th>
                      <th>Unit Kerja</th>
                      <th>Header Instalasi</th>
                      <th>Header Tindakan</th>
                      <th>Tindakan/Indikator</th>
                      <th>Definsi oprasional</th>
                      <th>Target</th>
                      <th>bobot</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($indikator))
                    {
                        $a=0;
                        foreach($indikator as $record)
                        {
                            ?>
                    <tr>
                      <td><?php echo ++$a ?></td>
                      <td><?php echo $record->nama_jabatan ?></td>
                      <td><?php echo $record->nama_unit ?></td>
                      <td><?php  if($record->klinik_kategori_tindakan_header_instalasi_nama==''){
                          echo 'Seluruh Pasien';
                      }else{
                          echo $record->klinik_kategori_tindakan_header_instalasi_nama;
                      } ?></td>
                      <td><?php if($record->kategori_tindakan_header_nama==''){echo 'Seluruh Pasien';}else{echo $record->kategori_tindakan_header_nama;} ?></td>
                      <td><?php if($record->kategori_tindakan_nama==''){echo 'Seluruh Pasien';}else{echo $record->kategori_tindakan_nama;} ?></td>
                      <td><?php echo $record->definisi_ops ?></td>
                      <td><?php echo $record->target ?></td>
                      <td><?php echo $record->bobot ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit('<?=  $record->id;?>')"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-id="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("id"),
			hitURL = baseURL + "admin/Indikator_tindakan_kuantitas_dokter/delete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : userId } 
			}).done(function(data){
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});

$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>

$(function(){
        $("#header").chained("#instalasi");
});
$(function(){
        $("#tindakan").chained("#header");
});	
$(function(){
        $("#posisi").chained("#master");
});
$( "#tindakan" ).change(function() {
		$("#nama_kategori").val($('select[name="tindakan"] :selected').attr('ids'));
	});
$(document).ready(function(){
    $('#tindakan').change(function(){
        var rBtnVal = $(this).val();
        if(rBtnVal == ''){
            $("#inputs").prop('readonly', true); 
            $("#inputs2").prop('readonly', true); 
            $("#definisi_ops").prop('readonly', true); 
        }
        else{ 
            $("#inputs").prop('readonly', false);
            $("#inputs2").prop('readonly', false);
            $("#definisi_ops").prop('readonly', false);
        }
    });
});

function edit(id)
{
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url()?>admin/Indikator_tindakan_kuantitas_dokter/oldEdit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('#master').val(data.id_jenis_pos).change();
            $('#posisi').val(data.id_pos).change();
            $('#instalasi').val(data.id_header_instalasi).change();
            $('#header').val(data.id_header).change();
            $('#tindakan').val(data.id_tindakan).change();
            $('[name="definisi_ops"]').val(data.definisi_ops);
            $('[name="nama_kategori"]').val(data.uraian);
            $('[name="target"]').val(data.target);
            $('[name="bobot"]').val(data.bobot);
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>admin/Indikator_tindakan_kuantitas_dokter/edit/'+id+''); // show bootstrap modal when complete loaded
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Indikator Kuantitas Dokter'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
$(function () {
    $('.select2').select2();
  })
</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Tambah Indikator Kuantitas Dokter</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>admin/Indikator_tindakan_kuantitas_dokter/addNew" id="form" method="POST">
        <div class="form-group">
            <label >Jabatan</label>
            <select name="master" class="form-control" id="master" style="width: 100%;">
                <option value="">-Pilih Jabatan-</option>
                <?php foreach ($JenisPosisiKategori as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama_jabatan?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Unit Kerja</label>
            <select name="posisi" class="form-control select2" id="posisi" style="width: 100%;">
                <option value="">-Pilih Unit Kerja-</option>
                <?php foreach ($JenisPosisi as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_jabatan?>"><?= $key->nama_unit?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan Header Instalasi</label>
            <select name="instalasi" class="form-control select2" id="instalasi" style="width: 100%;">
                <option value="">-Pilih Kategori Instalasi-</option>
                <option value="all">- Seluruh Data Pasien-</option>
                <?php foreach ($KategoriHeaderInstalasi as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan Header</label>
            <select name="header" class="form-control select2" id="header" style="width: 100%;">
                <?php foreach ($KategoriTindakanHeader as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_instilasi?>"><?= $key->nama?></option>
                <?php }?>
                <option value="alls" class="all">All Pasien</option>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan</label>
            <select name="tindakan" class="form-control select2" id="tindakan" style="width: 100%;">
                <option value="">-Pilih Kategori-</option>
                <?php foreach ($KategoriTindakan as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_header?>" ids="<?= $key->nama?>"><?= $key->nama?></option>
                <?php }?>                
                <option value="all" class="alls">All Pasien</option>
            </select>
        </div>
        <div class="form-group">
            <label >Difinisi Oprasional</label>
            <input type="text" name="definisi_ops" id="definisi_ops" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label >Target</label>
            <input type="hidden" name="nama_kategori" id="nama_kategori" class="form-control" readonly required>
            <input type="number" min="1" name="target" id="inputs" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label >bobot</label>
            <input type="number" min="1" name="bobot" id="inputs2" class="form-control" readonly required>
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

