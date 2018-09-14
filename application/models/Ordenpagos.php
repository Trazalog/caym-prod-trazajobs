<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordenpagos extends CI_Model{

    
    function __construct()
    {
        parent::__construct();
    }

    function ordenList(){
       
        $this->db->select('tbl_ordenpago.opid,                    
                    tbl_ordenpago.opfecha,
                    tbl_ordenpago.opmonto,
                    tbl_ordenpago.provid,
                    tbl_ordenpago.opestado,
                    abmproveedores.provnombre');
        $this->db->join('abmproveedores', 'tbl_ordenpago.provid = abmproveedores.provid');
        $this->db->from('tbl_ordenpago');

        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

        // Proveedores
    function proveedoresList(){

        $this->db->select('
            abmproveedores.provid,
            abmproveedores.provnombre,
            abmproveedores.provcuit,
            abmproveedores.provestado'
        );
        $this->db->from('abmproveedores');

        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
        // Facturas por proveedor
    function factPorProveedorListado($idproveedor){

        $id = $idproveedor['idproveedor'];
        $this->db->select('
                tbl_factura.facId,
                tbl_factura.facNumero,
                tbl_factura.facFecha,
                tbl_factura.facTipo,
                tbl_factura.facTotal,
                tbl_factura.facTipoComprobante,
                tbl_factura.facEstado,
                abmproveedores.provid,
                abmproveedores.provnombre,
                abmproveedores.provcuit,
                abmproveedores.provestado
                ');
        $this->db->from('abmproveedores');
        $this->db->join('tbl_factura', 'abmproveedores.provid = tbl_factura.facProveedorId', 'inner');
        $this->db->where('tbl_factura.facEstado', 'C');
        $this->db->where('abmproveedores.provid', $id);

        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();            
        }
        else
        {
            return false;
        }        
    }

    function getChequesTerceros(){
        $this->db->select('tbl_chequesterceros.id_che,
                        tbl_chequesterceros.numero,
                        tbl_chequesterceros.id_banco,
                        tbl_chequesterceros.cliente,
                        tbl_chequesterceros.estado,
                        tbl_chequesterceros.monto,
                        tbl_chequesterceros.fecha_vto');  
        $this->db->where('tbl_chequesterceros.Estado', 'C');
        $this->db->from('tbl_chequesterceros');
        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }          
    }

    function getChequesTerceroPorIds($data){
        
        $id = $data['id'];
        $this->db->select('tbl_chequesterceros.id_che,
                        tbl_chequesterceros.numero,
                        tbl_chequesterceros.id_banco,
                        tbl_chequesterceros.cliente,
                        tbl_chequesterceros.estado,
                        tbl_chequesterceros.monto,
                        tbl_chequesterceros.fecha_vto,
                        abmbancos.bancdescrip'); 
        $this->db->join('abmbancos', 'abmbancos.bancid = tbl_chequesterceros.id_banco');
        $this->db->where('tbl_chequesterceros.id_che', $id);                 
        $this->db->from('tbl_chequesterceros');
        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }  
    }

    function getChequesPropios(){
        $this->db->select('tbl_cheques.cheqid,
                        tbl_cheques.cheqnro,
                        tbl_cheques.cheqvenc,
                        tbl_cheques.provid,
                        tbl_cheques.cheqmonto,
                        tbl_cheques.cheqestado,
                        tbl_cheques.id_chequera,
                        tbl_cheques.cheqfechae');
        $this->db->where('tbl_cheques.cheqestado', 'C');
        $this->db->from('tbl_cheques');
        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }  
    }

    function getChequesPropiosPorId($data){

        $id = $data['id'];
        $this->db->select('tbl_cheques.cheqid,
                        tbl_cheques.cheqnro,
                        tbl_cheques.cheqvenc,
                        tbl_cheques.provid,
                        tbl_cheques.cheqmonto,
                        tbl_cheques.cheqestado,
                        tbl_cheques.id_chequera,
                        tbl_cheques.cheqfechae');
        $this->db->where('tbl_cheques.cheqid', $id); 
        $this->db->from('tbl_cheques');
        $query = $this->db->get();

        if ($query->num_rows()!=0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }  
    }

    function setOrdenPagos($data){
        
       $this->db->trans_start(); 

            //Guardo la orden de pago
        $datos = array(
                'opcomprobante' => 1,   // valor cualquiera
                'opfecha' => date('Y-m-d H:i:s'),
                'opmonto' => $data['monto'],
                'provid' => $data["id_proveedor"],
                'opestado' => 'P'
                 );
        $this->db->insert('tbl_ordenpago', $datos);
        $idInsert = $this->db->insert_id();

            // Saca el primer elemento del array
        $idsfactura = array_shift($data);
        $estfact['facEstado'] = 'P';        
            
            // Actualiza las facturas a estado 'P'
        foreach ($idsfactura as $id) {

            $this->db->where('facId', $id);
            $this->db->update('tbl_factura', $estfact); 
        }

            // Extrae del array principal cheques prop y terceros    
        $salida = array_slice($data, 3); 

            // Actualiza estado de Cheque Tercero y graba en detaorden
        if (isset($salida['cheq_tercero'])) {                

                foreach ($salida['cheq_tercero'] as $key ) {
                    $tipochT = 'tercero';
                    $id_chTerc = $key['id_chTercero'];
                    $montoChT = $key['monto'];
                    $this->actualizarChTercero($id_chTerc);
                    $this->setDetanota($idInsert,$montoChT,$tipochT);
                }               
        }
            // Actualiza estado de Cheque Propio y graba en detaorden
        if(isset($salida['cheq_propio'])){
                
            foreach ($salida['cheq_propio'] as $p) { 

                $tipoChP = 'propio';    
                $id_chProp = $p['id_chPropio'];
                $montoChP = $p['monto'];
                $this->actualizarChPropio($id_chProp);
                $this->setDetanota($idInsert,$montoChP,$tipoChP);
            } 
        }
            // Graba en detaorden el efectivo
        if ($data['efectivo'] > 0) {

            $tipo = 'efectivo';
            $montoEfect = $data['efectivo'];
            $this->setDetanota($idInsert,$montoEfect,$tipo);
        }


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
             return false;  
        }
        else{
             return true;
        } 
    }

    function actualizarChTercero($id_chTerc){//funcionando

        $estado['estado'] = 'E';
        $this->db->where('id_che', $id_chTerc);
        $this->db->update('tbl_chequesterceros', $estado); 
    }   

    function actualizarChPropio($id_chProp){

        $estado['cheqestado'] = 'E';
        $this->db->where('cheqid', $id_chProp);
        $this->db->update('tbl_cheques', $estado); 
    }

    function setDetanota($idInsert,$monto,$tipo){
       
        $datos = array(
                'opid' => $idInsert,   // valor cualquiera                
                'monto' => $monto,
                'fecha' => date('Y-m-d H:i:s'),
                'tipo' => $tipo,
                'comp' => 1
                 );
        $this->db->insert('tbl_detaordenpago', $datos);        
    }
}