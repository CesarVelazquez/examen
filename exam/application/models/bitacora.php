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