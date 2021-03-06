<?php
//dump($proveedores);
//dump($factura);
?>
<section class="content">
  <div class="row">
    <div class="col-sm-12 col-md-12">

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Nueva Factura</h3>
          <button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" id="listado">Ver Listado</button>
        </div><!-- /.box-header -->
        <div class="box-body">

          <div role="tabpanel" class="tab-panel">
            <div class="form-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">Proveedores</h2>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabpanelProveedores">
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="col-xs-6"><label>Proveedor: </label>
                            <select id="selectProveedor" name="Proveedor" class="form-control input-sm select2">
                              <?php
                              foreach($proveedores as $prov)
                              {
                                if( $prov['provid'] == $factura[0]['facProveedorId'] ) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                                echo '<option value="'.$prov['provid'].'"
                                  data-cuit="'.$prov['provcuit'].'"
                                  data-estado="'.$prov['provestado'].'"
                                  '.$selected.' >'.$prov['provnombre'].'</option>';
                              }
                              ?>
                            </select>
                            <input type="hidden" id="id_proveedor" name="id_proveedor">
                          </div><!-- /.col-xs-6 -->
                          <div class="col-xs-6">
                            <label style="display:block">Razón social:
                              <input type="text" class="form-control input-sm" id="razonSocial" value="<?php echo $factura[0]['provnombre']; ?>">
                            </label>
                          </div><!-- /.col-xs-6 -->
                        </div><!-- /.col-xs-12 -->
                        <div class="col-xs-12">
                          <div class="col-xs-6">
                            <label style="display:block">CUIT:
                              <input type="text" class="form-control input-sm" id="cuit" value="<?php echo $factura[0]['provcuit']; ?>">
                            </label>
                          </div><!-- /.col-xs-6 -->
                          <div class="col-xs-6">
                            <label style="display:block">Condición:
                              <input type="text" class="form-control input-sm" id="condicion"
                              value="<?php echo ($factura[0]['provestado'] == '8' ? 'Activo' : ($factura[0]['provestado'] == '9' ? 'Inactivo' : 'Suspendido')); ?>">
                            </label>
                          </div><!-- /.col-xs-6 -->
                        </div><!-- /.col-xs-12 -->
                      </div><!-- /.row -->
                    </div><!-- /.tabpanel -->
                  </div><!-- /.tab-content -->
                </div><!-- /.panel-body -->
              </div><!-- /.panel-default -->
            </div><!-- /.form-group -->
          </div><!-- /.tab-panel -->

          <div role="tabpanel" class="tab-panel">
            <div class="form-group">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">Factura</h2>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabpanelFactura">

                      <div class="row">
                        <div class="col-xs-12">
                          <div class="alert alert-danger alert-dismissable" id="error" style="display: none">
                                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                Revise que todos los campos esten completos
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-xs-12">
                          <!--
                          NC = nota de compra
                          ND = nota de debito
                          RE = remito
                          -->
                          <div class="col-xs-2">
                            <input type="radio" name="radioTipoComprobante" value="FA" checked> Factura<br>
                          </div><!-- /.col-xs-2 -->
                          <div class="col-xs-2">
                            <input type="radio" name="radioTipoComprobante" value="NC"> Nota de Compra<br>
                          </div><!-- /.col-xs-2 -->
                          <div class="col-xs-2">
                            <input type="radio" name="radioTipoComprobante" value="ND"> Nota de Débito<br>
                          </div><!-- /.col-xs-2 -->
                          <div class="col-xs-2">
                            <input type="radio" name="radioTipoComprobante" value="RE"> Remito<br>
                          </div><!-- /.col-xs-2 -->
                          <div class="col-xs-2 col-xs-offset-1">
                            <input type="checkbox" id="chkPagado" name="ckeckPagado" value="Pagada" <?php
                            if( $factura[0]['facEstado'] == 'P' ) {
                              echo "checked";
                            } ?> > Pagado<br>
                          </div><!-- /.col-xs-2 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">

                        <div class="col-xs-12">

                          <div class="col-xs-3">
                            <label style="display:block">Número:
                              <input type="text" id="txtNumeroFac" class="form-control input-sm" placeholder="<?php //echo
                              $lastIdFactura+1; ?>"  value="<?php echo $factura[0]['facNumero']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3">
                            <label style="display:block">Tipo:
                              <select id="SelectTipoFac" name="SelectTipoFac" class="form-control input-sm select2">
                                <option value="A" <?php if( $factura[0]['facTipo'] == 'A' ){ echo "selected"; } ?>>Factura A</option>
                                <option value="B" <?php if( $factura[0]['facTipo'] == 'B' ){ echo "selected"; } ?>>Factura B</option>
                                <option value="C" <?php if( $factura[0]['facTipo'] == 'C' ){ echo "selected"; } ?>>Factura C</option>
                              </select>
                            </label>
                            <input type="hidden" id="id_equipo" name="id_equipo">
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3 col-xs-offset-3">
                            <label style="display:block">Fecha:
                              <input type="text" id="dateFecha" class="form-control input-sm" value="<?php echo $factura[0]['facFecha']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">

                        <div class="col-xs-12">
                          <div class="col-xs-6">
                            <label style="display:block">Subtotal ($):
                              <input type="number" class="form-control input-sm" id="txtSubtotal" value="<?php echo $factura[0]['facSubtotal']; ?>">
                            </label>
                          </div><!-- /.col-xs-6 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">

                        <div class="col-xs-12">
                          <div class="col-xs-3" style="display:inline-block; float:none;">
                            <label style="display:block">IVA (%):
                              <input type="number" class="form-control input-sm" id="txtIva" value="<?php echo round( $factura[0]['facIva']*100/$factura[0]['facSubtotal'], 2); ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3" style="display:inline-block; float:none;">
                            <label style="display:block">IVA ($):
                              <input type="number" class="form-control input-sm" id="txtIva2" value="<?php echo $factura[0]['facIva']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3" style="vertical-align:bottom; display:inline-block; float:none;">
                            <input type="button" class="btn btn-primary" id="btnIva2" value="+" >
                          </div><!-- /.col-xs-3 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row" id="RowIva2" style="display:none">

                        <div class="col-xs-12">
                          <div class="col-xs-3" style="display:inline-block; float:none;">
                            <label style="display:block">IVA2 (%):
                              <input type="number" class="form-control input-sm" id="txtOtroIva" value="<?php echo round( $factura[0]['facIva2']*100/$factura[0]['facSubtotal'], 2); ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3" style="display:inline-block; float:none;">
                            <label style="display:block">IVA2 ($):
                              <input type="number" class="form-control input-sm" id="txtOtroIva2" value="<?php echo $factura[0]['facIva2']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">

                        <div class="col-xs-12">
                          <div class="col-xs-3">
                            <label style="display:block">Ing. Brutos (%):
                              <input type="number" class="form-control input-sm" id="txtIngresosBrutos" value="<?php echo round( $factura[0]['facIngresosBrutos']*100/$factura[0]['facSubtotal'], 2); ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3">
                            <label style="display:block">Ing. Brutos ($):
                              <input type="number" class="form-control input-sm" id="txtIngresosBrutos2" value="<?php echo $factura[0]['facIngresosBrutos']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="col-xs-3">
                            <label style="display:block">Retenciones (%):
                              <input type="number" class="form-control input-sm" id="txtRetenciones" value="<?php echo round( $factura[0]['facRetenciones']*100/$factura[0]['facSubtotal'], 2); ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                          <div class="col-xs-3">
                            <label style="display:block">Retenciones ($):
                              <input type="number" class="form-control input-sm" id="txtRetenciones2" value="<?php echo $factura[0]['facRetenciones']; ?>">
                            </label>
                          </div><!-- /.col-xs-3 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->
                      <br>
                      <div class="row">

                        <div class="col-xs-12">
                          <div class="col-xs-12">
                            <label style="display:block">Neto ($):
                              <input type="number" class="form-control input-sm" id="txtTotal" value="<?php echo $factura[0]['facTotal']; ?>">
                            </label>
                            <input type="hidden" id="facId" value="<?php echo $factura[0]['facId']; ?>">
                          </div><!-- /.col-xs-6 -->
                        </div><!-- /.col-xs-12 -->

                      </div><!-- /.row -->

                    </div><!-- /.tabpanel -->
                  </div><!-- /.tab-content -->
                </div><!-- /.panel-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" id="btnCancelarForm">Cancelar</button>
                  <button type="button" class="btn btn-primary" id="btnGuardarForm">Guardar</button>
                </div>

              </div><!-- /.panel-default -->
            </div><!-- /.form-group -->
          </div><!-- /.tab-panel -->

        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </div><!-- /.col-sm-12 .col-md-12 -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
$(function() {
  /* habilita plugin datepicker en campo fecha */
  $( "#dateFecha" ).datepicker({
    dateFormat: 'yy-mm-dd',
  });

  /* Si la factura tiene segundo iva, lo muestro */
  if( $("#txtOtroIva").val() != 0 ) {
    $("#RowIva2").css('display', 'block');
    $("#btnIva2").val("-");
  }

  /* cargo la vista que lista facturas */
  $("#listado, #btnCancelarForm").on("click", function(){
    cargarView('Factura', 'index', 'Add-Edit-Del-');
  });


  /* cargo parametros al seleccionar el proveedor */
  $("#selectProveedor").on("change", function() {
    //si option value != -1
    $("#razonSocial").val( $("#selectProveedor option:selected").text() );
    $("#cuit").val( $("#selectProveedor option:selected").data("cuit") );
    $("#condicion").val( $("#selectProveedor option:selected").data("estado") );
    // y activo la factura
    $("#tabpanelFactura input, #tabpanelFactura select, #btnGuardarForm, #btnCancelarForm").removeAttr("disabled");
  });


  /* ver/ocultar iva2 */
  $("#btnIva2").on("click", function(){
    if( $("#RowIva2").css('display') === 'none' ) {
      $("#RowIva2").show(200);
      $(this).val("-");
    } else {
      $("#RowIva2").hide(200);
      $(this).val("+");
      $("#txtOtroIva, #txtOtroIva2").val(0);
      calcularMonto();
    }
  });


  /* cargo parametros al seleccionar el proveedor */
  $('#txtSubtotal, #txtIva, #txtOtroIva, #txtIngresosBrutos, #txtRetenciones').keyup( function() {
    calcularMonto();
  });

  function calcularMonto(){
    //Obtengo el valor de los txt
    var subTotal       = parseFloat( $('#txtSubtotal').val() );
    var iva            = parseFloat( $('#txtIva').val() );
    var otroIva        = parseFloat( $('#txtOtroIva').val() );
    var ingresosBrutos = parseFloat( $('#txtIngresosBrutos').val() );
    var retenciones    = parseFloat( $('#txtRetenciones').val() );
    //Hago la operaciones matemáticas
    var iva2            = (iva/100)*subTotal;
    var otroIva2        = (otroIva/100)*subTotal;
    var ingresosBrutos2 = (ingresosBrutos/100)*subTotal;
    var retenciones2    = (retenciones/100)*subTotal;
    var total           = subTotal + iva2 + otroIva2 + ingresosBrutos2 + retenciones2;
    //Uso solo dos decimales
    subTotal            = (Math.round(subTotal * 100)/100).toFixed(2);
    iva2                = (Math.round(iva2 * 100)/100).toFixed(2);
    otroIva2            = (Math.round(otroIva2 * 100)/100).toFixed(2);
    ingresosBrutos2     = (Math.round(ingresosBrutos2 * 100)/100).toFixed(2);
    retenciones2        = (Math.round(retenciones2 * 100)/100).toFixed(2);
    total               = (Math.round(total * 100)/100).toFixed(2);
    //var new_number = (Math.round(number *100)/100).toFixed(2);
    //Lleno los txt
    $('#txtIva2').val(iva2);
    $('#txtOtroIva2').val(otroIva2);
    $('#txtIngresosBrutos2').val(ingresosBrutos2);
    $('#txtRetenciones2').val(retenciones2);
    $('#txtTotal').val(total);
  }


  /* guardo la factura */
  $("#btnGuardarForm").on("click", function(){

    hayError = false;
    if( ($('#txtNumeroFac').val() == '') || ($('#txtNumeroFac').val() == '0') )
    {
      alert("nro factura= 0");
      hayError = true;
    }
    if($('#SelectTipoFac').val() == '-1')
    {
      alert("tipo factura= -1");
      hayError = true;
    }
    if($('#dateFecha').val() == '')
    {
      alert("fecha= vacia");
      hayError = true;
    }
    if( ($('#txtSubtotal').val() == '0') || ($('#txtSubtotal').val() == '') )
    {
      alert("monto= vacia");
      hayError = true;
    }
    if( ($('#txtTotal').val() == '0') || ($('#txtTotal').val() == '') )
    {
      alert("total= vacia");
      hayError = true;
    }

    if(hayError == true){
      $('#error').fadeIn('slow');
      return;
    }

    $('#error').fadeOut('slow');

    WaitingOpen('Guardando cambios');

    $.ajax({
      data: {
        facid              : $('#facId').val(),
        facnumero          : $('#txtNumeroFac').val(),
        facfecha           : $('#dateFecha').val(),
        factipo            : $('#SelectTipoFac').val(),
        facproveedorid     : $('#selectProveedor').val(),
        facsubtotal        : $('#txtSubtotal').val(),
        faciva             : $('#txtIva2').val(),
        faciva2            : $('#txtOtroIva2').val(),
        facingresosbrutos  : $('#txtIngresosBrutos2').val(),
        facretenciones     : $('#txtRetenciones2').val(),
        factotal           : $('#txtTotal').val(),
        factipocomprobante : $('input[name=radioTipoComprobante]:checked').val(),
        facestado          : $('#chkPagado').prop('checked') ? 'P' : 'C'
      },
      dataType: 'json',
      type: 'POST',
      url: 'index.php/Factura/updateFactura',
      success: function(result){
        WaitingClose();
        //alert("ok"+result);
        cargarView('Factura', 'index', 'Add-Edit-Del-' );
      },
      error: function(){
        WaitingClose();
        alert("Error al guardar la factura");
      }
    });
  });

});
</script>