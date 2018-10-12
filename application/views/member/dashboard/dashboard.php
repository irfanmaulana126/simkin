<style>
        @-webkit-keyframes placeHolderShimmer {
          0% {
            background-position: -468px 0;
          }
          100% {
            background-position: 468px 0;
          }
        }

        @keyframes placeHolderShimmer {
          0% {
            background-position: -468px 0;
          }
          100% {
            background-position: 468px 0;
          }
        }

        .content-placeholder {
          display: inline-block;
          -webkit-animation-duration: 1s;
          animation-duration: 1s;
          -webkit-animation-fill-mode: forwards;
          animation-fill-mode: forwards;
          -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
          -webkit-animation-name: placeHolderShimmer;
          animation-name: placeHolderShimmer;
          -webkit-animation-timing-function: linear;
          animation-timing-function: linear;
          background: #f6f7f8;
          background: -webkit-gradient(linear, left top, right top, color-stop(8%, #eeeeee), color-stop(18%, #dddddd), color-stop(33%, #eeeeee));
          background: -webkit-linear-gradient(left, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
          background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
          -webkit-background-size: 800px 104px;
          background-size: 800px 104px;
          height: inherit;
          position: relative;
        }

        .post_data
        {
          padding:24px;
          border:1px solid #f9f9f9;
          border-radius: 5px;
          margin-bottom: 24px;
          box-shadow: 10px 10px 5px #eeeeee;
        }
        </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
    <?php if($this->session->flashdata('message')){ ?>
			<div class="box-body">
			<div class="alert alert-danger alert-dismissible">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
			<?php echo $this->session->flashdata('message'); ?>
			</div>
			</div>
			<?php }?>
          <div class="row">
            <div class="col-md-3 col-xs-6">
              <div class="box box-primary">
                  <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/dist/img/avatar5.png" alt="User profile picture">

                    <h3 class="profile-username text-center"> <?php echo $this->session->userdata('pgw_nama'); ?></h3>

                    <p class="text-muted text-center">Software Engineer</p>

                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        <b>Kuantitas</b> <a class="pull-right">0 %</a>
                      </li>
                      <li class="list-group-item">
                        <b>Kualitas</b> <a class="pull-right">0 %</a>
                      </li>
                      <li class="list-group-item">
                        <b>Perilaku</b> <a class="pull-right">0 %</a>
                      </li>
                    </ul>

                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal"><b>Upload Foto</b></button>
                  </div>
                  <!-- /.box-body -->
              </div>
            </div>
            <div class="col-lg-9">
              <div class="panel panel-primary">
                  <div class="panel-heading"><b>Your Time Line</b></div>
                <div class="panel-body" style="height:525px;overflow-y:auto;overflow-x:scroll;">
                 <!-- The timeline -->
                  <ul class="timeline timeline-inverse" >
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                    <li>
                    </li>
                    <li class="time-label">
                    </li>
                    <div id="load_data"></div>
                    <div id="load_data_message"></div>  
                    <li>
                      <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                  </ul>
                </div>
                <div class="panel-footer">
                    <div class="row">
                      <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Kegiatan</button>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
          </div>
    </section>
</div>
<!-- Modal -->

<script>
  $(document).ready(function(){

    var limit = '5';
    var start = '0';
    var action = 'inactive';

    function lazzy_loader(limit)
    {
      var output = '';
      for(var count=0; count<limit; count++)
      {
        output += '<div class="post_data">';
        output += '<p><span class="content-placeholder" style="width:100%; height: 30px;">&nbsp;</span></p>';
        output += '<p><span class="content-placeholder" style="width:100%; height: 100px;">&nbsp;</span></p>';
        output += '</div>';
      }
      $('#load_data_message').html(output);
    }

    lazzy_loader(limit);

    function load_data(limit, start)
    {
      $.ajax({
        url:"<?php echo base_url(); ?>member/Dashboard/fetch",
        method:"POST",
        data:{limit:limit, start:start},
        cache: false,
        success:function(data)
        {
          if(data == '')
          {
            $('#load_data_message').html('<ul class="timeline timeline-inverse" ><li>'+
                      '<i class="fa fa-comments bg-aqua"></i>'+
                      '<div class="timeline-item bg-gray">'+
                        '<div class="timeline-body">'+
                          '<p class="info-box-text">Anda Tidak Memiliki Data Kegiatan</p>'+
                        '</div>'+
                      '</div>'+
                    '</li></ul>');
            action = 'active';
          }
          else
          {
            $('#load_data').append(data);
            $('#load_data_message').html("");
            action = 'inactive';
          }
        }
      })
    }

    if(action == 'inactive')
    {
      action = 'active';
      load_data(limit, start);
    }

    $('.panel-body').scroll(function(){
      if($('.panel-body').scrollTop() + $('.panel-body').height() > $("#load_data").height() && action == 'inactive')
      {
        lazzy_loader(limit);
        action = 'active';
        start = start + limit;
        setTimeout(function(){
          load_data(limit, start);
        }, 1000);
      }
    });

  });
</script>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteUser", function(){
		var userId = $(this).data("id"),
		  tipes = $(this).data("tipe"),
			hitURL = baseURL + "admin/Indikator_tindakan_kualitas/delete",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this user ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { id : userId,tipe:tipes } 
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

function edit(id,tipe)
{
    save_method = 'update';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url()?>member/Dashboard/oldEdit/" + id +"/" + tipe,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id"]').val(data.id);
            $('#tupoksi').val(data.jenis).change();
            $('#id_tupoksi').val(data.id_tupoksi).change();
            $('[name="nilai"]').val(data.nilai);
            $('#form').removeAttr('action'); // show bootstrap modal when complete loaded
            $('#form').attr('action', '<?php echo base_url();?>member/Dashboard/edit/'+id+'/'+tipe+''); // show bootstrap modal when complete loaded
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
<script>
$(function(){
        $("#id_tupoksi").chained("#tupoksi");
});
  $(function () {
    $('.select2').select2();
  });
  $(document).ready(function(){
    $('#id_tupoksi').change(function(){
        var rBtnVal = $(this).val();
        if(rBtnVal == ''){
            $("#nilai").prop('readonly', true); 
        }
        else{ 
            $("#nilai").prop('readonly', false);
        }
    });
});
</script>
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kegiatan</h5>
      </div>
      <div class="modal-body">
    <form action="<?php echo base_url();?>member/Dashboard/addNew" id="form" method="POST">
        <div class="form-group">
            <label >Pilih Tupoksi</label>
            <select name="tupoksi" class="form-control select2" id="tupoksi" style="width: 100%;" required>
                <option>-Pilih Master Tupoksi-</option>
                <option value="kuantitas">Kuantitas</option>
                <option value="kualitas">Kualitas</option>
                <option value="perilaku">Perilaku</option>
            </select>
        </div>
        <div class="form-group">
            <label >Pilih Indikator</label>
            <select name="id_tupoksi" class="form-control select2" id="id_tupoksi" style="width: 100%;" required>
                <option value="">-Pilih Jenis Tupoksi-</option>
                <?php foreach ($kegiatans as $key) {?>
                <option value="<?= $key->id?>" class="<?= $key->jenis?>" ><?= $key->indikator." - ".$key->difinisi_ops?></option>
                <?php }?>
            </select>
        </div>
        <div class="form-group">
            <label >Capaian</label>
            <input type="number" min='-1' name="nilai" id="nilai" class="form-control" readonly required>
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

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Foto</h4>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('member/Dashboard/upload')?>" method="post" enctype="multipart/form-data">
      <?php echo form_open_multipart('member/Dashboard/upload'); ?>
        <div class="form-group">
			<label >File input</label>
			<input type="file" name="gambar" class="form-control" accept="image/*">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-info" value="Submit" name="submit">
      </div>
      </form>
    </div>
  </div>
</div>
