<?php
class Bitacora extends CI_Model
{
    function getBitacoras()
    {
        $query=  $this->db->get('bitacora');
        return $query->result();
    }

    function getBitacora($id)
    {
        $query=  $this->db->get_where('bitacora', array('idBitacora'=>$id));
        return $query->row();
    }
    
    function getAll()
    {
        $query=  $this->db->query('select b.accion, p.usuario, p.email, t.fechaAlta, t.nombre, t.descripcion
        from bitacora b
        inner join personal p
        on b.idPersonal=p.idPersonal
        inner join ticket t
        on b.idTicket=t.idTicket');
        return $query->result();
    }
    
    function setBitacora($data)
    {
        $this->db->insert('bitacora', $data);
    }
    
    function updateBitacora($id, $data)
    {
        $this->db->where('idBitacora', $id);
        $this->db->update('bitacora', $data);
    }
    
    function deleteBitacora($id)
    {
        $this->db->delete('bitacora', array('idBitacora'=>$id));
    }
}
?>