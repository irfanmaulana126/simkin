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
            <table >
        <thead>
        </thead>
        <tbody>
            <tr id="filter_col3" data-column="2">
                <td>Filter Tanggal Kunjungan</td>
                <td align="center"><input class="column_filter form-control" id="min" type="text"></td>
                <td>Hingga</td>
                <td align="center"><input class="column_filter form-control" id="max" type="text"></td>
            </tr>
            <tr id="filter_col2" data-column="1">
                <td>Filter Nama Pasien</td>
                <td align="center"><input class="column_filter form-control" id="col1_filter" type="text"></td>
            </tr>
            <tr id="filter_col4" data-column="3">
                <td>Filter Tindakan</td>
                <td align="center">
                  <select class="column_filter form-control" id="col3_filter">
                    <option value=""></option>  
                    <?php foreach ($tindakan as $key ) { ?>
                    <option value="<?=$key->fol_nama?>"><?=$key->fol_nama?></option>  
                    <?php }?>
                  </select></td>
            </tr>
        </tbody>
        </table>
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
     $(document).ready(function(){
        $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            var max = $('#max').datepicker("getDate");
            var startDate = new Date(data[2]);
            // alert(startDate);
            if (min == null && max == null) { return true; }
            if (min == null && startDate <= max) { return true;}
            if(max == null && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
            return false;
        }
        );

       
            $("#min").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ format: 'yyyy-mm-dd',onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            var table = $('#table').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });
function filterColumn ( i ) {
      $('#table').DataTable().column(i).search(
          $('#col'+i+'_filter').val(),
      ).draw();
}
 $(document).ready( function () {
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
 
    $('input.column_filter').on('keyup change', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
    $('select.column_filter').on('click', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
} );
 </script>