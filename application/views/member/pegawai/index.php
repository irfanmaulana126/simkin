<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Pegawai
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-borderedr" id="myTable">
               <thead>
                <tr>
                    <td>Nama Pegawai</td>
                    <td>Unit Kerja</td>
                    <td>Action</td>
                </tr>
               </thead>
               <tbody>
               <?php foreach ($pegawai as $key) {?>
                <tr>
                    <td><?=  $key->pgw_nama;?></td>
                    <td><?=  $key->nama_unit;?></td>
                    <td><a class="btn btn-sm btn-info" href="<?=base_url();?>member/PegawaiUnit/pegawaiDetail/<?= $key->usr_id;?>/<?= $key->id_unit_kerja;?>/<?= date('Y-m')?>" title="Detail"><i class="fa fa-pencil"></i></a></td>
                </tr>
               <?php }?>
               </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
</div>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );

</script>