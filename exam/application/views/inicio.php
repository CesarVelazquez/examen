<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>examen</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        .container{margin-top: 40px}
    </style>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <div class="container">
          <div class="row">
              <div class="col-md-4 col-md-offset-4">
                  <?php
                  if($data==true)
                  {
                      ?>
                  <div class="alert alert-warning" role="alert">El usuario o la contraseña son incorrectos</div>
                  <?php
                  }
                  ?>
                  <form class="form-signin" method="POST" action="<?php echo site_url('inicio/login') ?>">
                    <h2 class="form-signin-heading">Iniciar Sesión</h2>
                    <label for="usuario" class="sr-only"></label>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingresa el Usuario" required autofocus>
                    <label for="clave" class="sr-only">Contraseña</label>
                    <input type="password" id="clave" name="clave" class="form-control" placeholder="*********" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesión</button>
                  </form>
              </div>
          </div>
      </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  </body>
</html>