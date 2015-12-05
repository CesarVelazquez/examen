<?php
class Ticket extends CI_Model
{
    function getTickets()
    {
        $query=  $this->db->get('ticket');
        /*
        $query=  $this->db->query('
                 select t.idTicket, t.idDepartamento, t.fechaAlta, t.nombre, t.descripcion, t.estatus, d.nombre as departamento
                 from ticket t
                 join departamento d
                 on t.idDepartamento=d.idDepartamento');
         * 
         */
        return $query->result();
    }

    function getTicket($id)
    {
        $query=  $this->db->get_where('ticket', array('idTicket'=>$id));
        return $query->row();
    }
    
    function getTicketsByDepartamento($idDepartamento)
    {
        $query=  $this->db->get_where('ticket', array('idDepartamento'=>$idDepartamento));
        return $query->result();
    }
    
    function getTicketSeguimiento($idDepartamento)
    {
        $query=  $this->db->query('
                    select t.idTicket, t.idDepartamento, t.idPersonal, t.fechaAlta, t.nombre, t.descripcion, s.estatus, d.nombre as departamento, s.idSeguimiento, (select se.idSeguimiento from seguimiento se where se.idTicket=t.idTicket and se.estatus!="creado" order by s.idSeguimiento desc limit 1) as idSeguimiento2
                    from ticket t
                    left join seguimiento s
                    on t.idTicket=s.idTicket and s.estatus="creado"
                    inner join departamento d
                    on t.idDepartamento=d.idDepartamento
                    where t.idDepartamento='.$idDepartamento);
        return $query->result();
    }
    
    function getAll()
    {
        $query=  $this->db->query('
                    select t.idTicket, t.idDepartamento, t.idPersonal, t.fechaAlta, t.nombre, t.descripcion, s.estatus, d.nombre as departamento, s.idSeguimiento, (select se.idSeguimiento from seguimiento se where se.idTicket=t.idTicket and se.estatus!="creado" order by s.idSeguimiento desc limit 1) as idSeguimiento2
                    from ticket t
                    left join seguimiento s
                    on t.idTicket=s.idTicket and s.estatus="creado"
                    inner join departamento d
                    on t.idDepartamento=d.idDepartamento');
        return $query->result();
    }
    
    function getTicketsByPersona($idPersona)
    {
        //$query=  $this->db->get_where('ticket', array('idPersonal'=>$idPersona));
        $query=  $this->db->query(
                 'select t.*, (select s.estatus from seguimiento s where s.idTicket=t.idTicket order by s.idSeguimiento desc limit 1) as estatus
                 from ticket t
                 where t.idPersonal='.$idPersona);
        return $query->result();
    }
    
    function setTicket($data)
    {
        $this->db->insert('ticket', $data);
        return $this->db->insert_id();
    }
    
    function updateTicket($id, $data)
    {
        $this->db->where('idTicket', $id);
        $this->db->update('ticket', $data);
    }
    
    function deleteTicket($id)
    {
        $this->db->delete('ticket', array('idTicket'=>$id));
    }
}
?>