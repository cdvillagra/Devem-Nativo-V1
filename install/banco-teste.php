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
    		<span>Definições > Banco de dados</span>
    	</div>
    	<div class="sub-content">
            <div class="alert">  </div>
    		<p>
    			Insira os dados de conexão
    		</p>
    		<form>
    			<input type="text" placeholder="Host" id="db_host" name="db_host" autocomplete="off" class="req" />
    			<input type="text" placeholder="Usuário" id="db_user" name="db_user" autocomplete="off" class="req" />
    			<input type="password" placeholder="Senha" id="db_pass" name="db_pass" autocomplete="off" />
    			<input type="text" placeholder="Base de Dados" id="db_db" name="db_db" autocomplete="off" class="req" />
    			<input type="checkbox" id="db_no" name="db_no" value="true" /> <span>Meu sistema não utilizará banco de dados</span>
                <input type="hidden" id="method" name="method" value="testeDb" />
    		</form>
    		<button id="bt-avancar-p2">Avançar<i class="fa fa-chevron-right"></i></button><button id="bt-testeDb">Testar Conexão<i class="fa fa-compress"></i></button>

    	</div>
    	<div class="footer">
    		<span>Direitos Reservados | DVillagra</span>
    	</div>
    </div>
  
  </body>
</html>
<? }else{ header('location: sucesso'); }?>