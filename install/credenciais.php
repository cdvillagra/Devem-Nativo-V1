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
    		<img src="view/img/logo_urso1.jpg" width="60px">
    		<h1>Instalação DEVEM</h1>
    		<span>Definições > Credenciais de Login</span>
    	</div>
    	<div class="sub-content">
            <div class="alert">  </div>
    		<p>
    			Ensira os dados de acesso ao Admin
    		</p>
    		<form>
                <input type="text" placeholder="Nome do Administrador" id="adm_nome" name="adm_nome" autocomplete="off" />
                <input type="text" placeholder="E-mail do Administrador" id="adm_email" name="adm_email" autocomplete="off" />
                <input type="text" placeholder="Usuario" id="adm_usuario" name="adm_usuario" autocomplete="off" />
                <input type="password" placeholder="Senha" id="adm_senha" name="adm_senha" autocomplete="off" />
                <input type="hidden" id="method" name="method" value="gravaSession" />
    		</form>
    		<button id="bt-avancar-p4">Instalar<i class="fa fa-chevron-right"></i></button>

    	</div>
    	<div class="footer">
    		<span>Direitos Reservados | DVillagra</span>
    	</div>
    </div>
  
  </body>
</html>
<? }else{ header('location: sucesso'); }?>