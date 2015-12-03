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
            <span>Definições > Parametros</span>
        </div>
        <div class="sub-content">
            <div class="alert">  </div>
            <p>
                Insira alguns parametros importantes para o funcionamento do sistema
            </p>
            <form class="form-parametros">

                <input type="text" placeholder="E-mail - Host" id="email_host" name="email_host" autocomplete="off" />
                <input type="text" placeholder="E-mail - Segurança" id="email_secure" name="email_secure" autocomplete="off" />
                <input type="text" placeholder="E-mail - Porta" id="email_porta" name="email_porta" autocomplete="off" />
                <input type="text" placeholder="E-mail - Usuário" id="email_usuario" name="email_usuario" autocomplete="off" />
                <input type="text" placeholder="E-mail - Senha" id="email_senha" name="email_senha" autocomplete="off" />
                <input type="text" placeholder="E-mail - Remetente [Nome]" id="email_rementente_nome" name="email_rementente_nome" autocomplete="off" />
                <input type="text" placeholder="E-mail - Remetente [E-Mail]" id="email_rementente_email" name="email_rementente_email" autocomplete="off" />
                <br />
                <input type="text" placeholder="S3 - SECRET" id="s3_secret" name="s3_secret" autocomplete="off" />
                <input type="text" placeholder="S3 - KEY" id="s3_key" name="s3_key" autocomplete="off" />
                <input type="text" placeholder="S3 - BUCKET" id="s3_bucket" name="s3_bucket" autocomplete="off" />
                <input type="text" placeholder="S3 - URL" id="s3_url" name="s3_url" autocomplete="off" />
                <br />
                <input type="checkbox" id="auth_app" name="auth_app" value="true" /> Meu Front-End ignora autenticação para as páginas

                <input type="hidden" id="method" name="method" value="gravaSession" />
            </form>
            <button id="bt-avancar-p3">Avançar<i class="fa fa-chevron-right"></i></button>

        </div>
        <div class="footer">
            <span>Direitos Reservados | DVillagra</span>
        </div>
    </div>
  
  </body>
</html>
<? }else{ header('location: sucesso'); }?>