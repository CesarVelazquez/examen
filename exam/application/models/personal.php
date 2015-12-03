<?php
class Personal extends CI_Model
{
    function getPersonal()
    {
        $query=  $this->db->get('personal');
        return $query->result();
    }

    function getPersona($id)
    {
        $query=  $this->db->get_where('personal', array('idPersonal'=>$id));
        return $query->row();
    }
    
    function login($usuario, $clave)
    {
        $query=  $this->db->get_where('personal', array('usuario'=>$usuario, 'clave'=>$clave));
        return $query->row();
    }
    
    function setPersona($data)
    {
        $this->db->insert('personal', $data);
    }
    
    function updatePersona($id, $data)
    {
        $this->db->where('idPersonal', $id);
        $this->db->update('personal', $data);
    }
    
    function deletePersona($id)
    {
        $this->db->delete('personal', array('idPersonal'=>$id));
    }
}
?>