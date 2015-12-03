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
                              </ul>
                          </div>
                      </div>
                      
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
                                <button type="button" class="btn btn-warning mTicket" data-id="<?php echo $item->idTicket ?>"><span class="glyphicon glyphicon-edit"></span></button>
                                <button type="button" class="btn btn-primary verSeguimiento" data-id="<?php echo $item->idTicket ?>" data-toggle="modal" data-target="#ver"><span class="glyphicon glyphicon-eye-open"></span></button>
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
            $("#nuevo").click(function(){
                $("#frmTicket").slideDown('slow');
                $("#tickets").attr("action", "<?php echo site_url('inicio/nuevo') ?>");
                $("#guardar").text("Guardar");
            });
            
            $(".mTicket").click(function(){
                $.ajax({
                    url: '<?php echo site_url('inicio/getTicket') ?>',
                    type: 'POST',
                    data: {id: $(this).data("id")},
                    dataType: 'JSON',
                    success: function(p){
                        $("#departamento").val(p.idDepartamento);
                        $("#nombre").val(p.nombre);
                        $("#descripcion").val(p.descripcion);
                        $("#idTicket").val(p.idTicket);
                        $("#frmTicket").slideDown('slow');
                        $("#tickets").attr("action", "<?php echo site_url('inicio/modificar') ?>");
                        $("#guardar").text("Modificar");
                    }
                });
            });
            
            $(".verSeguimiento").click(function(){
                $(".contenido").remove();
                $(".noResult").removeClass("oculto");
                $.ajax({
                    url: '<?php echo site_url('inicio/getSeguimiento') ?>',
                    type: 'POST',
                    data: {ticket:$(this).data("id")},
                    dataType: 'JSON',
                    success: function(p){
                        $.each(p, function(i, v){
                            $(".noResult").addClass("oculto");
                            $("#seguimiento tbody").append('<tr class="contenido"><td>'+v.nombreTicket+'</td><td>'+v.descripcionTicket+'</td><td>'+v.descripcionSeguimiento+'</td><td>'+v.estatus+'</td><td>'+v.persona+'</td></tr>')
                        });
                    }
                });
            });
            /*
            $("#guardar").click(function(){
                var data=$("#tickets").serialize();
                alert(data);
                $.ajax({
                    url: '<?php //echo site_url('inicio/nuevo') ?>',
                    type: 'POST',
                    data: data,
                    success: function(p){
                        window.location.reload();
                    }
                });
            });*/
        });
    </script>
  </body>
</html>