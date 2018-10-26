<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Data Tindakan Pasien yang ditangani
        <small>Yang Ditangani</small>
      </h1>
    </section>
    
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filter Pasien</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <form action="<?php echo base_url()?>member/tindakan_pasien" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Tanggal</label>
                            <div class="row">
                                <div class="col-md-6">
                                <input type="text" name="min" id="min" class="form-control" placeholder="Tanggal Awal" value="<?php if(!empty($min)){echo $min;}?>">
                                </div>
                                <div class="col-md-6">
                                <input type="text" name="max" id="max" class="form-control" placeholder="Tanggal Akhir" value="<?php if(!empty($max)){echo $max;}?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Tindakan</label>
                            <select class="column_filter form-control" name="tindakan" id="tindakan">
                                <option value=""></option>  
                                <?php foreach ($tindakan as $key ) { ?>
                                <option value="<?=$key->id?>"  <?php if($indikator==$key->id){echo "selected";}?>><?=$key->indikator?></option>  
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label >Nama Pasien</label>
                            <input type="text" name="nama" id="nama" class="form-control"  value="<?php if(!empty($nama)){echo $nama;}?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <input type="reset" value="Reset" id="reset" class="btn btn-warning" >
                    <input type="submit" value="Filter" class="btn btn-primary" >
                </div>
            </div>
            </form>
            </div>
        </div>
      </div>
            
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pasien Yang Telah di Tangani</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-borderedr">
               <thead>              
                <tr>
                  <td>No</td>
                  <td>Nama Pasien</td>
                  <td>Tanggal Kunjungan</td>
                  <td>Tindakan</td>
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
                  <td><?= ++$a?></td>
                  <td><?= $record->cust_usr_nama?></td>
                  <td><?= $record->tindakan_tanggal?></td>
                  <td><?= $record->fol_nama?></td>
                </tr>
                        <?php }}?>
               </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
</div>

<script type="text/javascript">
 $(document).ready( function () {
            $("#min").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
    $('#table').DataTable({"lengthMenu": [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
            "bDestroy": true,"processing": true,"dom": 'lBfrtip',"buttons": [
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                    {
                        extend: 'excel', title: 'Data Pasien Yang Telah di Tangani',
                    },
                    {
                        extend: 'pdf', title: 'Data Pasien Yang Telah di Tangani',
                    },
                    {
                        extend: 'print', title: 'Data Pasien Yang Telah di Tangani',
                    },
                ]
            }
        ]});
    $("#reset").click(function() {
        $("#min").removeAttr('value');
        $("#max").removeAttr('value');
        $("#tindakan option:selected").removeAttr('selected');
        $("#nama").removeAttr('value');
    })
} );
 </script>