<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Master Indikator
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
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
                      <th>Jabatan kerja</th>
                      <th>Unit kerja</th>
                      <th>indikator Tupoksi</th>
                      <th>Indikator</th>
                      <th>Definisi</th>
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
                      <td><?php echo $record->nama ?></td>
                      <td><?php echo $record->indikator ?></td>
                      <td><?php echo $record->difinisi ?></td>
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
			hitURL = baseURL + "admin/Master_indikator/delete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this ?");
		
		if(confirmation)
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
        $("#unit").chained("#jabatan");
});
$(document).ready(function(){
    $('#unit').change(function(){
        var rBtnVal = $(this).val();
        if(rBtnVal == ''){
            $("#inputs3").prop('readonly', true); 
            $("#inputs4").prop('readonly', true); 
            $("#indikator_tupoksi").prop('disabled', 'disabled'); 
        }
        else{ 
            $("#inputs3").prop('readonly', false);
            $("#inputs4").prop('readonly', false);
            $("#indikator_tupoksi").removeAttr('disabled');
        }
    });
    $('#tambah').click(function () {
            $('[name="id"]').val('');
            $('#jabatan').val('');
            $('#unit').val('');
            $('#indikator_tupoksi').val('');
            $('[name="indikator"]').val('');
            $('[name="difinisi"]').val('');
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', 'action="<?php echo base_url();?>admin/Master_indikator/addNew"'); // show bootstrap modal when complete loaded
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Create Indikator Kualitas Pegawai'); // Set title to Bootstrap modal title

    })
});

function edit(id)
{
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url()?>admin/Master_indikator/oldEdit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('#jabatan').val(data.id_jabatan).change();
            $('#unit').val(data.id_unit_kerja).change();
            $('#indikator_tupoksi').val(data.indikator_tupoksi).change();
            $('[name="indikator"]').val(data.indikator);
            $('[name="difinisi"]').val(data.difinisi);
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>admin/Master_inidikator/edit/'+id+''); // show bootstrap modal when complete loaded
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
    <form action="<?php echo base_url();?>admin/Master_indikator/addNew" id="form" method="POST">
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
            <select name="unit" class="form-control select2" id="unit" style="width: 100%;" required readonly>
                <option value="">-Pilih Unit Kerja-</option>
                <?php foreach ($JenisPosisi as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_jabatan?>" ids="<?= $key->nama_unit?>"><?= $key->nama_unit?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label>Indikator Tupoksi</label>
            <select name="indikator_tupoksi" class="form-control select2" id="indikator_tupoksi" style="width: 100%;" disabled required>
                <option value="">-Pilih Indikator Tupoksi-</option>
                <?php foreach ($Indikator as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Inidkator</label>
            <input type="text" name="indikator" id="inputs3" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label >Difinisi Oprasional</label>
            <input type="text" name="difinisi" id="inputs4" class="form-control" readonly required>
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
