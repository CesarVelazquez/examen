<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seguimiento</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        .container{margin-top: 40px}
        .oculto{display: none}
    </style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div class="container">
          
          <div class="modal fade" id="darSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Dar Seguimiento</h4>
                </div>
                <div class="modal-body">
                    <form id="frmSeguimiento">
                        <div class="form-group">
                          <label for="descripcion">Descripcion</label>
                          <input type="hidden" id="ticket" name="ticket" value="">
                          <textarea id="descripcion" required="" name="descripcion" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="estatus">Estatus</label>
                          <select id="estatus" name="estatus" class="form-control" required>
                              <option value=""></option>
                              <option value="registrado">Registrado</option>
                              <option value="abierto">Abierto</option>
                              <option value="proceso">Proceso</option>
                              <option value="finalizado">Finalizado</option>
                              <option value="cerrado">Cerrado</option>
                          </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="well">
                      <div class="row">
                          <div class="col-md-8"><h2>Bienvenido <?php echo $usuario ?></h2></div>
                          <div class="col-md-4">
                              <ul class="list-group">
                                <li class="list-group-item"><a href="<?php echo site_url('inicio/logout') ?>">Cerrar Sesión</a></li>
                                <li class="list-group-item"><a href="<?php echo site_url('inicio/inicio') ?>">Mis Tickets</a></li>
                                <li class="list-group-item"><a href="<?php echo site_url('inicio/seguimiento') ?>">Asignarme Tickets</a></li>
                                <?php
                                if($this ->session->userdata('nivel')=='administrador')
                                {
                                    ?>
                                <li class="list-group-item"><a href="<?php echo site_url('inicio/bitacora') ?>">Ver Bitacora</a></li>
                                <?php
                                }
                                ?>
                              </ul>
                          </div>
                      </div>
                      
                  </div>
                  <div class="well" id="frmTicket" style="display:none">
                      <form id="tickets" method="POST" action="<?php echo site_url('inicio/nuevo') ?>">
                        <div class="form-group">
                          <label for="departamento">Departamento</label>
                          <select class="form-control" id="departamento" name="departamento">
                              <?php
                              foreach($departamentos as $departamento)
                              {
                                  ?>
                              <option value="<?php echo $departamento->idDepartamento ?>"><?php echo $departamento->nombre ?></option>
                              <?php
                              }
                              ?>
                          </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="idTicket" id="idTicket" value="">
                          <label for="nombre">Nombre</label>
                          <input type="text" class="form-control" required="" id="nombre" name="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                          <label for="descripcion">Descripcion</label>
                          <textarea name="descripcion" required="" class="form-control" id="descripcion"></textarea>
                        </div>
                        <button type="submit" id="guardar" class="btn btn-primary">Guardar</button>
                      </form>
                  </div>
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>idTicket</th>
                        <th>Alta</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Seguimiento</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(count($data)==0)
                        {
                            ?>
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron tickets!</td>
                        </tr>
                        <?php
                        }
                        foreach ($data as $item) {
                            ?>
                        <tr>
                            <td><?php echo $item->idTicket ?></td>
                            <td><?php echo $item->fechaAlta ?></td>
                            <td><?php echo $item->nombre ?></td>
                            <td><?php echo $item->estatus ?></td>
                            <td>
                                <button type="button" class="btn seguimiento <?php if($item->idSeguimiento2!=NULL){echo 'asignado btn-warning';} else{echo 'btn-primary';} ?>" data-id="<?php echo $item->idTicket ?>"><span class="glyphicon glyphicon-list-alt"></span> Ticket</button>
                                <button type="button" class="btn btn-primary registrar <?php if($item->idSeguimiento2==NULL){echo 'oculto';} ?>" data-id="<?php echo $item->idTicket ?>" data-toggle="modal" data-target="#darSeguimiento">Dar Seguimiento</button>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                  </table>
              </div>
          </div>
      </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script>
        $(function(){
            
            $(".seguimiento").not(".asignado").click(function(){
                var sThis=$(this);
                $.ajax({
                    url: '<?php echo site_url('inicio/asignarTicket') ?>',
                    type: 'POST',
                    data: {idTicket: $(this).data("id")},
                    success: function(p){
                        if(p=="ok")
                        {
                            sThis.addClass("asignado").removeClass("btn-primary").addClass("btn-warning");
                        }
                    }
                });
            });
            
            $(".registrar").click(function(){
                $("#ticket").val($(this).data("id"));
            });
            
            $("#guardar").click(function(){
                var data=$("#frmSeguimiento").serialize();
                $.ajax({
                    url: '<?php echo site_url('inicio/darSeguimiento') ?>',
                    type: 'POST',
                    data: data,
                    success: function(p){
                        if(p=="ok")
                        {
                            window.location.reload();
                        }
                    }
                });
            });
        });
    </script>
  </body>
</html>