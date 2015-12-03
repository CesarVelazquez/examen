<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inicio
 *
 * @author admin
 */
class Inicio  extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('personal');
        $this->load->model('ticket');
        $this->load->model('departamento');
        $this->load->model('seguimiento');
    }
    
    function sendEmail()
    {
        $config = array();
        $config['useragent']="CodeIgniter";
        $config['mailpath']="/usr/sbin/sendmail";
        
        
        $config['protocol']="smtp";
        $config['smtp_host']="smtp.gmail.com";
        $config['smtp_port']="465";
        $config['mailtype']='html';
        $config['charset']='utf-8';
        $config['smtp_user']="csar.vlazquez@gmail.com";
        $config['$smtp_pass']="sa";
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('csar.vlazquez@gmail.com', 'Administrador');
        $this->email->to('cesar43f@gmail.com');
        $this->email->subject('prueba');
        $this->email->message('mensaje de prueba');
        $this->email->send();
        //mail('csar.vlazquez@gmail.com', 'csar.vlazquez@gmail.com', 'mensaje de prueba');
    }
    
    function index($data=NULL)
    {
        if($this ->session->userdata('usuario')!=NULL)
        {
            header('Location: '.  site_url('inicio/inicio'));
        }
        else
        {
            if(isset($data))
            {
                $this->load->view('inicio', array('data'=>TRUE));
            }
            else
            {
                $this->load->view('inicio', array('data'=>FALSE));
            }
        }
        
    }
    
    function login()
    {
        $usuario=  $this->input->post('usuario');
        $clave=  $this->input->post('clave');
        $data=  $this->personal->login($usuario, $clave);
        if(count($data)>0)
        {
            $session['usuario']=$data->nombre;
            $session['nivel']=$data->tipo;
            $session['departamento']=$data->idDepartamento;
            $session['persona']=$data->idPersonal;
            $this ->session->set_userdata($session);
            header('Location: '.  site_url('inicio/inicio'));
        }
        else
        {
            header('Location: '.  site_url('inicio/index/error'));
        }
    }
    
    function inicio()
    {
        if($this ->session->userdata('usuario')==NULL)
        {
            header('Location: '.  site_url());
        }
        if($this ->session->userdata('nivel')=='administrador')
        {
            $data=  $this->ticket->getTickets();
        }
        else
        {
            $data=  $this->ticket->getTicketsByPersona($this ->session->userdata('persona'));
        }
        $departamentos=  $this->departamento->getDepartamentos();
        $this->load->view('tickets', array('data'=>$data, 'departamentos'=>$departamentos, 'usuario'=>$this ->session->userdata('usuario')));
    }
    
    function seguimiento()
    {
        if($this ->session->userdata('usuario')==NULL)
        {
            header('Location: '.  site_url());
        }
        if($this ->session->userdata('nivel')=='administrador')
        {
            $data=  $this->ticket->getTickets();
        }
        else
        {
            $data=  $this->ticket->getTicketSeguimiento($this ->session->userdata('departamento'));
        }
        $departamentos=  $this->departamento->getDepartamentos();
        $this->load->view('seguimiento', array('data'=>$data, 'departamentos'=>$departamentos, 'usuario'=>$this ->session->userdata('usuario')));
    }
    
    function nuevo()
    {
        if($this ->session->userdata('usuario')!=NULL)
        {
            $departamento=  $this->input->post('departamento');
            $nombre=  $this->input->post('nombre');
            $descripcion=  $this->input->post('descripcion');
            $data=array('idDepartamento'=>$departamento, 'idPersonal'=>$this ->session->userdata('persona'), 'nombre'=>$nombre, 'descripcion'=>$descripcion, 'fechaAlta'=>  date('Y-m-d')/*, 'estatus'=>'registrado'*/);
            $idTicket=$this->ticket->setTicket($data);
            $dataSeguimiento=array('idTicket'=>$idTicket, 'idPersonal'=>$this ->session->userdata('persona'), 'descripcion'=>'ticket asignado', 'estatus'=>  'creado');
            $this->seguimiento->setSeguimiento($dataSeguimiento);
            header('Location: '.  site_url('inicio/inicio'));
        }
        else
        {
            header('Location: '.  site_url('inicio/login'));
        }
    }
    
    function modificar()
    {
        if($this ->session->userdata('usuario')!=NULL)
        {
            $idTicket=  $this->input->post('idTicket');
            $departamento=  $this->input->post('departamento');
            $nombre=  $this->input->post('nombre');
            $descripcion=  $this->input->post('descripcion');
            $data=array('idDepartamento'=>$departamento, 'nombre'=>$nombre, 'descripcion'=>$descripcion, 'fechaAlta'=>  date('Y-m-d'));
            $this->ticket->updateTicket($idTicket, $data);
            header('Location: '.  site_url('inicio/inicio'));
        }
        else
        {
            header('Location: '.  site_url('inicio/login'));
        }
    }
    
    function asignarTicket()
    {
        if($this ->session->userdata('usuario')!=NULL)
        {
            $idTicket=  $this->input->post('idTicket');
            $data=array('idTicket'=>$idTicket, 'idPersonal'=>$this ->session->userdata('persona'), 'descripcion'=>'ticket asignado', 'estatus'=>  'proceso');
            $this->seguimiento->setSeguimiento($data);
            echo 'ok';
        }
        else
        {
            echo 'error';
        }
        
    }
    
    function logout()
    {
        $this ->session->sess_destroy();
        header('Location: '.  site_url());
    }
    
    function getTicket()
    {
        if($this ->session->userdata('usuario')!=NULL)
        {
            $id=  $this->input->post('id');
            $data=  $this->ticket->getTicket($id);
            echo json_encode($data);
        }
    }
    
    function darSeguimiento()
    {
        $idTicket=  $this->input->post('ticket');
        $descripcion=  $this->input->post('descripcion');
        $estatus=  $this->input->post('estatus');
        $data=array('idTicket'=>$idTicket, 'idPersonal'=>$this ->session->userdata('persona'), 'descripcion'=>$descripcion, 'estatus'=>$estatus);
        $this->seguimiento->setSeguimiento($data);
        echo 'ok';
    }
    
    function getSeguimiento()
    {
        $idTicket=  $this->input->post('ticket');
        $data=  $this->seguimiento->getSeguimientoByTicket($idTicket);
        echo json_encode($data);
    }
    
    function _setBitacora($ticket, $accion)
    {
        $this->load->model('bitacora');
        $data=array('idPersona'=>$this ->session->userdata('persona'), 'idTicket'=>$ticket, 'accion'=>$accion, 'fecha'=>  date('Y-m-d'));
        $this->bitacora->setBitacora($data);
    }
}
