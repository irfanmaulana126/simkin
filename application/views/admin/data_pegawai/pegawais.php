<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah Jabatan</button>
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nip</th>
                        <th>Jabatan</th>
                        <th>Unit Kerja</th>
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
                        <td><?php echo $record->pgw_nama ?></td>
                        <td><?php echo $record->pgw_nip ?></td>
                        <td><?php echo $record->nama_jabatan ?></td>
                        <td><?php echo $record->nama_unit ?></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-info" href="javascript:void(0)" title="Edit" onclick="edit(<?=  $record->id;?>)"><i class="fa fa-pencil"></i></a>
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
			hitURL = baseURL + "admin/pegawai/delete",
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
  $(function () {
    $('.select2').select2();
  })
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
<script>

$(function(){
        $("#unit").chained("#jabatan");
});
$( "#posisi" ).change(function() {
		$("#nama_posisi").val($('select[name="posisi"] :selected').attr('ids'));
	});

function edit(id)
{
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url()?>admin/pegawai/oldEdit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('#jabatans').val(data.id_jabatan).change();
            $('#units').val(data.id_unit_kerja).change();
            $('#id_pegawais').val(data.id_pgw);
            $('#forms').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#forms').attr('action', '<?php echo base_url();?>admin/pegawai/edit/'+id+''); // show bootstrap modal when complete loaded
            $('#exampleModaledit').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Unit Kerja Pegawai'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Tambah Unit Kerja Pegawai</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>admin/pegawai/addNew" id="form" method="POST">
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
            <label>Nama Pegawai</label>
            <select name="id_pegawai" class="form-control select2" id="id_pegawai" style="width: 100%;" required>
                <option value="">-Pilih Nama Pegawai-</option>
                <?php foreach ($pegawai as $key) {?>
                <option value="<?= $key->pgw_id?>"><?= $key->pgw_nama?></option>
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
<div class="modal fade" id="exampleModaledit" role="dialog" aria-labelledby="exampleModaleditLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModaleditLabel"></h5>
      </div>
      <div class="modal-body">
    <form action="" id="forms" method="POST">
    <input type="hidden" name="id_pegawai" id="id_pegawais">
        <div class="form-group">
            <label >Jabatan</label>
            <select name="jabatan" class="form-control select2" id="jabatans" style="width: 100%;" required>
                <option value="">-Pilih Jabatan-</option>
                <?php foreach ($JenisPosisiKategori as $key) {?>
                <option value="<?= $key->id?>"><?= $key->nama_jabatan?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label>Unit Kerja</label>
            <select name="unit" class="form-control select2" id="units" style="width: 100%;" required>
                <option value="">-Pilih Unit Kerja-</option>
                <?php foreach ($JenisPosisi as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->id_jabatan?>" ids="<?= $key->nama_unit?>"><?= $key->nama_unit?></option>
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
