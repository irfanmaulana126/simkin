<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Bobot dan Target Indikator
        <small>Unit Kerja</small>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#targetbobot">Tambah</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Bobot & Target List</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table class="table table-hover" id="myTable">
                  <thead>
                    <tr>
                      <th>no</th>
                      <th>Unit kerja</th>
                      <th>indikator Tupoksi</th>
                      <th>Indikator</th>
                      <th>Bobot</th>
                      <th>Target</th>
                      <th>Tanggal Awal</th>
                      <th>Tanggal Akhir</th>
                      <th>Status</th>
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
                      <td><?php echo $record->bobot ?></td>
                      <td><?php echo $record->target ?></td>
                      <td><?php echo $record->tgl_awal ?></td>
                      <td><?php echo $record->tgl_akhir ?></td>
                      <td><?php echo ($record->aktif == 'Y') ? 'Aktif' : 'Non Aktif';  ?></td>
                      <td class="text-center">
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
<script>
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("id"),
			hitURL = baseURL + "admin/Master_indikator/delete_target",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this ?");
		
		if(confirmation==true)
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
$(document).ready(function(){
    $("#tanggal_awal").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
    $("#tanggal_akhir").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
    $('#tanggal_awal, #tanggal_akhir').change(function(){
        var rBtnVal1 = $('#tanggal_awal').val();
        var rBtnVal2 = $('#tanggal_akhir').val();
        if(rBtnVal1 == '' && rBtnVal2 == ''){
            $("#target").prop('readonly', true); 
            $("#bobot").prop('readonly', true); 
        }
        else{ 
            $("#target").prop('readonly', false);
            $("#bobot").prop('readonly', false);
        }
    });
});
</script>

<div class="modal fade" id="targetbobot" tabindex="-1" role="dialog" aria-labelledby="targetbobotLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="targetbobotLabel">Tambah Target & Bobot Indikator</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>admin/Master_indikator/TargetBobot" id="form" method="POST">
    <div class="form-group">
            <label >Tanggal Awal</label>
            <input type="hidden" name="detail" id="detail" class="form-control" value="detail"readonly required>
            <input type="hidden" name="id" id="id" class="form-control" value="<?= $id ?>"readonly required>
            <input type="text" name="tgl_awal" id="tanggal_awal" class="form-control" required>
        </div>
        <div class="form-group">
            <label >Tanggal Akhir</label>
            <input type="text" name="tgl_akhir" id="tanggal_akhir" class="form-control" required>
        </div>
        <div class="form-group">
            <label >Target</label>
            <input type="number" min="1" name="target" id="target" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label >Bobot</label>
            <input type="number" min="1" name="bobot" id="bobot" class="form-control" readonly required>
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
