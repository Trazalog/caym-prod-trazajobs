<input type="hidden" id="permission" value="<?php echo $permission;?>">   

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h2 class="box-title ">Cheques Emitidos</h2>
           <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" id="listado">Ver Listado</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
         
          <table id="cheque" class="table table-bordered table-hover" style="text-align: center">
            <thead>
              <tr>
               
                <th  width="20%" style="text-align: center">Acciones</th>
                <th style="text-align: center">Mes</th>
                <th style="text-align: center">Año</th>
                <th style="text-align: center">Monto</th>
                             
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($list as $z)
                {
                  $id=$z['cheqid'];
                  $im=$z['mes'];

                
                    echo '<tr id="'.$id.'" class="'.$im.'" >';
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                      echo '<i class="fa fa-calculator" style="color: #0000FF; cursor: pointer; margin-left: 15px;" title="ver detalle" data-toggle="modal" data-target="#modalmostrar"></i>';
                  }
                  
                  
                      
                  echo '</td>';
                  echo '<td style="text-align: center">'.$z['mes'].'</td>';
                  echo '<td style="text-align: center">'.$z['an'].'</td>';
                  echo '<td style="text-align: center">'.$z['monto'].'</td>';
                 
                  
                  
                  echo '</tr>';
                  
                }
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->





<script>

$(document).ready(function(event) {
  $('#listado').click( function cargarVista(){
      WaitingOpen();
      $('#content').empty();
      $("#content").load("<?php echo base_url(); ?>index.php/Cheqpropio/index/<?php echo $permission; ?>");
      WaitingClose();
  });

  var ed="";

    //Editar
  $(".fa-calculator").click(function (e) { 
   $("#modalmostrar tbody tr").remove();
    var idcheq = $(this).parent('td').parent('tr').attr('id');
    console.log("ID de cheque");
    console.log(idcheq);
    ed=idcheq;

    var idmes= $(this).parent('td').parent('tr').attr('class');
    console.log(idmes);
    datos= parseInt(idmes);
    console.log("Mes");
    console.log(datos);
    $.ajax({
        type: 'GET',
        data: { datos:datos},
        url: 'index.php/Cheqpropio/getche', //index.php/
        success: function(data){
          console.log("llego el detalle");
          console.log(data);
        //console.log(data[0]['cheqnro']);
          
          for (var i = 0; i < data.length; i++) {

            // if (data[i]['cheqestado']== 1){
            // var estado= 'Curso';
            // }
            // else 
            //   if (data[i]['cheqestado']== 2){
            //   var estado= 'Pagado';
            //   }

              var tr = "<tr >"+
                "<td ></td>"+
                "<td>"+data[i]['cheqnro']+"</td>"+
                "<td>"+data[i]['provnombre']+"</td>"+
                "<td>"+data[i]['cheqmonto']+"</td>"+
                "<td>"+data[i]['cheqfechae']+"</td>"+
                "<td>"+data[i]['cheqvenc']+"</td>"+
                "<td>"+data[i]['cheqestado']+"</td>"+
                //"<td>"+estado+"</td>"+
                "</tr>";
                $('#tabladetalle tbody').append(tr);

           }

          console.log(tr);

              },
          
        error: function(result){
              console.log("Entro x el error de detalle");
              
              console.log(result);
            },
            dataType: 'json'
        });
  
  });

  $('#cheque').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "language": {
                "lengthMenu": "Ver _MENU_ filas por página",
                "zeroRecords": "No hay registros",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrando de un total de _MAX_ registros)",
                "sSearch": "Buscar:  ",
                "oPaginate": {
                    "sNext": "Sig.",
                    "sPrevious": "Ant."
                  }
          }
  });

});
 

</script>
  
<!-- Modal editar-->
 <div class="modal fade" id="modalmostrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 60%">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="fa fa-calculator" style="color: #0000FF" > </span> Detalle de Cheques Emitidos</h4>
       </div> <!-- /.modal-header  -->

      <div class="modal-body input-group ui-widget" id="modalBodyArticle">
        
        <div class="row" >
          <div class="col-sm-12 col-md-12">

          <table class="table table-bordered table-hover" id="tabladetalle">
            <thead>
              <tr>
                <th width="10%"></th>                  
                <th>Nro de cheque</th>
                <th>Proveedor</th>
                <th>Monto</th>
                <th>Fecha de Emision</th>
                <th>Fecha de Vencimiento</th>
                <th>Estado</th>

              </tr>
            </thead>
            <tbody>
                    
            </tbody>
          </table>


      </div>
      </div>
      </div>

       </div>  <!-- /.modal-body -->
    </div> <!-- /.modal-content -->

  </div>  <!-- /.modal-dialog modal-lg -->
</div>  <!-- /.modal fade -->
<!-- / Modal -->

























 