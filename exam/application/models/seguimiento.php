<?php
class Seguimiento extends CI_Model
{
    function getSeguimientos()
    {
        $query=  $this->db->get('seguimiento');
        return $query->result();
    }

    function getSeguimiento($id)
    {
        $query=  $this->db->get_where('seguimiento', array('idSeguimiento'=>$id));
        return $query->row();
    }
    
    function getSeguimientoByTicket($idTicket)
    {
        $query=  $this->db->query('
                 select t.idTicket, t.idPersonal, t.nombre as nombreTicket, t.descripcion as descripcionTicket, s.descripcion as descripcionSeguimiento, s.estatus, p.nombre as persona
                 from ticket t
                 join seguimiento s
                 on t.idTicket=s.idTicket
                 join personal p
                 on p.idPersonal=s.idPersonal
                 where t.idTicket='.$idTicket);
        return $query->result();
    }
    
    function setSeguimiento($data)
    {
        $this->db->insert('seguimiento', $data);
    }
    
    function updateSeguimiento($id, $data)
    {
        $this->db->where('idSeguimiento', $id);
        $this->db->update('seguimiento', $data);
    }
    
    function deleteSeguimiento($id)
    {
        $this->db->delete('seguimiento', array('idSeguimiento'=>$id));
    }
}
?>