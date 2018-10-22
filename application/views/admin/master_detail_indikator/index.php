<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Master Detail Indikator
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
    <?php if ($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a> <?= $this->session->flashdata('success') ?> </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>
    <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                <button type="button" class="btn btn-primary" id="tambah">Tambah</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Indikator List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                      <th>no</th>
                      <th>Jabatan</th>
                      <th>Unit kerja</th>
                      <th>Indikator</th>
                      <th>Header Instalasi</th>
                      <th>Header</th>
                      <th>Instalasi</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($datas))
                    {
                        $a=0;
                        foreach($datas as $record)
                        {
                            ?>
                    <tr>
                      <td><?php echo ++$a ?></td>
                      <td><?php echo $record->nama_jabatan ?></td>
                      <td><?php echo $record->nama_unit ?></td>
                      <td><?php echo $record->indikator ?></td>
                      <td><?php echo $record->nama_header_instalasi ?></td>
                      <td><?php echo $record->header_nama ?></td>
                      <td><?php echo $record->nama_tindakan ?></td>
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
			hitURL = baseURL + "admin/Master_detail_indikator/delete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation == true)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("User successfully deleted"); }
				else if(data.status = false) { alert("User deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
    $('#tambah').click(function () {
            $('#jabatan').val('');
            $('#unit').val('');
            $('#indikator_tupoksi').val('');
            $('#indikator').val('');
            $('#instalasi').val('');
            $('#header').val('');
            $('#tindakan').val('');
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>admin/Master_detail_indikator/addNew'); // show bootstrap modal when complete loaded
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Create Indikator Kualitas Pegawai'); // Set title to Bootstrap modal title

    })
	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});

$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>
  $(function () {
    $('.select2').select2();
  })
$(function(){
        $("#indikator").chained("#unit");
        $("#unit").chained("#jabatan");
        $("#header").chained("#instalasi");
        $("#tindakan").chained("#header");
        $("#posisi").chained("#master");
});
$( "#unit" ).change(function() {
		$("#nama_posisi").val($('select[name="unit"] :selected').attr('ids'));
	});
$(document).ready(function(){
    $('#unit').change(function(){
        var rBtnVal = $(this).val();
        if(rBtnVal == ''){
            $("#inputs").prop('readonly', true); 
            $("#inputs2").prop('readonly', true); 
            $("#inputs3").prop('readonly', true); 
            $("#inputs4").prop('readonly', true); 
        }
        else{ 
            $("#inputs").prop('readonly', false);
            $("#inputs2").prop('readonly', false);
            $("#inputs3").prop('readonly', false);
            $("#inputs4").prop('readonly', false);
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
        url : "<?php echo base_url()?>admin/Master_detail_indikator/oldEdit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#jabatan').val(data.id_jabatan).change();
            $('#unit').val(data.id_unit_kerja).change();
            $('#indikator').val(data.id_master_indikator).change();
            $('#instalasi').val(data.id_header_instalasi).change();
            $('#header').val(data.id_header).change();
            $('#tindakan').val(data.id_tindakan).change();
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>admin/Master_detail_indikator/edit/'+id+''); // show bootstrap modal when complete loaded
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Indikator Kualitas Pegawai'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>
<!-- Modal -->
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
    <form action="<?php echo base_url();?>admin/Master_detail_indikator/addNew" id="form" method="POST">
        <div class="form-group">
            <label >Jabatan</label>
            <select name="jabatan" class="form-control select2" id="jabatan" style="width: 100%;" required>
                <option value="">-Pilih Jabatan-</option>
                <?php foreach ($JenisPosisiKategori as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama_jabatan?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label>Unit Kerja</label>
            <select name="unit" class="form-control select2" id="unit" style="width: 100%;" required>
                <option value="">-Pilih Unit Kerja-</option>
                <?php foreach ($JenisPosisi as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_jabatan?>" ids="<?= $key->nama_unit?>"><?= $key->nama_unit?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label>Indikator</label>
            <select name="indikator" class="form-control select2" id="indikator" style="width: 100%;" required>
                <option value="">-Pilih indikator-</option>
                <?php foreach ($Indikator as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_unit_kerja?>"><?= $key->indikator?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan Header Instalasi</label>
            <select name="instalasi" class="form-control select2" id="instalasi" style="width: 100%;">
                <option value="">-Pilih Kategori Instalasi-</option>
                <?php foreach ($KategoriHeaderInstalasi as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan Header</label>
            <select name="header" class="form-control select2" id="header" style="width: 100%;">
            <option value="">-Pilih Tindakan Header-</option>
                <?php foreach ($KategoriTindakanHeader as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_instilasi?>"><?= $key->nama?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Nama Kategori Tindakan</label>
            <select name="tindakan" class="form-control select2" id="tindakan" style="width: 100%;">
                <option value="">-Pilih Kategori-</option>
                <?php foreach ($KategoriTindakan as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_header?>" ids="<?= $key->nama?>"><?= $key->nama?></option>
                <?php }?>                
            </select>
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
