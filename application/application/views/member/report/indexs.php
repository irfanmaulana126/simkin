<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Report
        <small>Control panel</small>
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
                  <td colspan="7">A. Kuantitas</td>
                </tr>                
                <tr>
                  <td>No</td>
                  <td>Indikator Yang dinilai</td>
                  <td>Difinisi Oprasional</td>
                  <td>Target</td>
                  <td>Capaian</td>
                  <td>Bobot</td>
                  <td>Hasil Kinerja</td>
                </tr>
               </thead>
               <tbody>
                <tr>
                  <td>1</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
                <tr>
                  <td colspan="3"><span class="center">Jumlah</span></td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="7">B. Kualitas</td>
                </tr>                
                <tr>
                  <td>No</td>
                  <td>Indikator Yang dinilai</td>
                  <td>Difinisi Oprasional</td>
                  <td>Target</td>
                  <td>Capaian</td>
                  <td>Bobot</td>
                  <td>Hasil Kinerja</td>
                </tr>
               </thead>
               <tbody>
               <tr>
                  <td>1</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
               <tr>
                  <td colspan="3"><span class="center">Jumlah</span></td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
               </tbody>
               <thead>
                <tr>
                  <td colspan="7">C. Perilaku</td>
                </tr>                
                <tr>
                  <td>No</td>
                  <td>Indikator Yang dinilai</td>
                  <td>Difinisi Oprasional</td>
                  <td>Target</td>
                  <td>Capaian</td>
                  <td>Bobot</td>
                  <td>Hasil Kinerja</td>
                </tr>
               </thead>
               <tbody>
               <tr>
                  <td>1</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
               <tr>
                  <td colspan="3"><span class="center">Jumlah</span></td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                  <td>coba</td>
                </tr>
                <tr><td colspan="7"></td></tr>
               <tr>
                  <td colspan="6"><span class="center">Total Keseluruhan</span></td>
                  <td>coba</td>
                </tr>
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
      autoclose: true,
      format:'dd-mm-yyyy',
      minDate:0,
      defaultDate:"+1w",
    }).datepicker("setDate", new Date());
  })
</script>