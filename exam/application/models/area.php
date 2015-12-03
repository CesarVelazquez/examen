<?php
class Area extends CI_Model
{
    function getAreas()
    {
        $query=  $this->db->get('area');
        return $query->result();
    }

    function getArea($id)
    {
        $query=  $this->db->get_where('area', array('idArea'=>$id));
        return $query->row();
    }
    
    function setArea($data)
    {
        $this->db->insert('area', $data);
    }
    
    function updateArea($id, $data)
    {
        $this->db->where('idArea', $id);
        $this->db->update('area', $data);
    }
    
    function deleteArea($id)
    {
        $this->db->delete('area', array('idArea'=>$id));
    }
}
?>