<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Pelanggaran
        <small>Control panel</small>
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
                      <th>Nama Pegawai</th>
                      <th>SK Pelanggaran</th>
                      <th class="text-center">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/filesize/3.5.11/filesize.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("id"),
			hitURL = baseURL + "admin/Indikator_tindakan_prilaku/delete",
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
  });
  $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'MAX FILE SIZE {0}'); 
$(document).ready(function(){
	var addUserForm = $("#form");
	
	var validator = addUserForm.validate({
		
		rules:{
			id_pegawai:{ required : true, selected : true},
			file_sk: { required : true, extension:"jpg|jpeg|pdf", filesize: 1000 * 1024 },
		},
		messages:{
			id_pegawai : { required : "This field is required", selected : "Please select atleast one option" },			
		}
	});
});
$(function(){
        $("#unit").chained("#jabatan");
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
        url : "<?php echo base_url()?>admin/Indikator_tindakan_prilaku/oldEdit/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('#jabatan').val(data.id_jabatan).change();
            $('#unit').val(data.id_unit_kerja).change();
            $('[name="indikator"]').val(data.indikator);
            $('[name="nama_posisi"]').val(data.nama_pos);
            $('[name="target"]').val(data.target);
            $('[name="bobot"]').val(data.bobot);
            $('[name="difinisi"]').val(data.difinisi_ops);
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>admin/Indikator_tindakan_prilaku/edit/'+id+''); // show bootstrap modal when complete loaded
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Indikator Kuantitas Pegawai'); // Set title to Bootstrap modal title

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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Indikator Kuantitas Pegawai</h5>
      </div>
      <div class="modal-body">
    <form id="form" method="POST" enctype="multipart/form-data">
    <div class="form-group">
            <label>Nama Pegawai</label>
            <select name="id_pegawai" class="form-control select2" id="id_pegawai" style="width: 100%;" required>
                <option value="">-Pilih Nama Pegawai-</option>
                <?php foreach ($pegawai as $key) {?>
                <option value="<?= $key->pgw_id?>"><?= $key->pgw_nama?></option>
                <?php }?>
            </select>
        </div>
    <div class="form-group">
            <label>File SK Pelanggaran</label>
            <input type="file" class="form-control" name="file_sk" id="file_sk" required>
        </div>
    <div class="form-group">
            <label>Keterangan</label>
            <input type="text" class="form-control" name="ket" id="ket" required>
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

