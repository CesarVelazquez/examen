<?php
class Departamento extends CI_Model
{
    function getDepartamentos()
    {
        $query=  $this->db->get('departamento');
        return $query->result();
    }

    function getDepartamento($id)
    {
        $query=  $this->db->get_where('departamento', array('idDepartamento'=>$id));
        return $query->row();
    }
    
    function setDepartamento($data)
    {
        $this->db->insert('departamento', $data);
    }
    
    function updateDepartamento($id, $data)
    {
        $this->db->where('idDepartamento', $id);
        $this->db->update('departamento', $data);
    }
    
    function deleteDepartamento($id)
    {
        $this->db->delete('departamento', array('idDepartamento'=>$id));
    }
}
?>