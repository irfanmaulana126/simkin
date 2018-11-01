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
              <h3 class="box-title">Responsive Hover Table</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="table_search" id="datepicker" class="form-control pull-right" placeholder="Cari tanggal">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-borderedr">
               <thead>              
                <tr>
                  <td>No</td>
                  <td>Nama Pasien</td>
                  <td>Tanggal Tindakan</td>
                  <td>Waktu Tindakan</td>
                  <td>Tindakan</td>
                  <td>Capaian</td>
                </tr>
               </thead>
               <tbody>
                
               </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </section>
</div>
<script>
  $(function () {
    $('#datepicker').datepicker({
      format: "mm-yyyy",
      viewMode: "months", 
      minViewMode: "months"
    }).datepicker("setDate", new Date());
  })
</script>