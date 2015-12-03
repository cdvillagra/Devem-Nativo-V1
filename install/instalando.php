<? session_start(); require_once ('../config/globals.php'); if(!defined('DV_INSTALL')) { ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Install Devem - Dvillagra</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="view/css/Install.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="view/js/Install.class.js"></script>
  </head>
  <body>

    <div class="content">
        <div class="titulo">
            <img src="view/img/bike-mini-white.png" width="45px">
            <h1>Instalação DEVEM</h1>
            <span>Processando...</span>
        </div>
        <div class="sub-content">
            
            <img src="view/img/220.GIF" class="loader">
            <p class="txt_loader">Aguarde...</p>

        </div>
        <div class="footer">
            <span>Direitos Reservados | DVillagra</span>
        </div>
    </div>
  
  </body>
  <script>devem.install.instalar();</script>
</html>
<? }else{ header('location: sucesso'); }?>