<? unset($_SESSION); require_once ('../config/globals.php'); if(!defined('DV_INSTALL')) { ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Install Devem - Dvillagra</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="view/css/Install.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="view/js/Install.class.js"></script>
  </head>
  <body>

    <div class="content">
        <div class="titulo">
            <img src="view/img/bike-mini-white.png" width="45px">
            <h1>Instalação DEVEM</h1>
            <span>Bem Vindo</span>
        </div>
        <div class="sub-content">

            <div class="demo">
                <i class="fa fa-file-text"></i>
                <i class="fa fa-arrow-right"></i>
                <i class="fa fa-database"></i>
                <i class="fa fa-arrow-right"></i>
                <i class="fa fa-cogs"></i>
                <i class="fa fa-arrow-right"></i>
                <i class="fa fa-check"></i>
            </div>
            

            <p>
                Vamos lá! <br/>
                Nesses quatro passos, vamos definir algumas informações importantes para que você desenvolva seu sistema ou website com o DEVEM.<br/><br/>
                É importante que você não esteja com nenhum arquivo aberto, ou com a pasta de instalação aberta em algum lugar da sua máquina.<br/><br/>
                <br />Esperamos que você tenha sucesso com a sua aplicação.
            </p>

            <button id="bt-iniciar">Iniciar<i class="fa fa-sign-out"></i></button>

        </div>
        <div class="footer">
            <span>Direitos Reservados | DVillagra</span>
        </div>
    </div>
  
  </body>
</html>

<? }else{ header('location: sucesso'); }?>