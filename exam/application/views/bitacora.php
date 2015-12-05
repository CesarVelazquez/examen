<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitacora</title>
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
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Fecha</th>
                        <th>Acción</th>
                        <th>Usuario</th>
                        <th>Ticket</th>
                        <th>Descripcion</th>
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
                            <td><?php echo $item->fechaAlta ?></td>
                            <td><?php echo $item->accion ?></td>
                            <td><?php echo $item->usuario ?></td>
                            <td><?php echo $item->nombre ?></td>
                            <td><?php echo $item->descripcion ?></td>
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
  </body>
</html>