<?php

/* 
-------------------------------------------------------------------- 
DEVEM License, versão 1.0 [Nativo]
Copyright (c) 2015 DVillagra. All rights reserved.
--------------------------------------------------------------------

Algumas observações de uso da framework:

  1. O uso de métodos e funções nativas da framework, requer um certo
     conhecimento mínimo de programação e lógica, com enfase em orientação
     a objeto e conhecimento em arquitetura MVC.
 
  2. Como sugestão, ao realizar alterações em quaquer arquivo do path Core
     o desenvolvedor deverá executar a sua implementação de forma generica
     para que em qualquer parte do sistema que utilizar o bloco implementado
     se comporte da forma esperada.

  3. Qualquer comunicação que o terceiro precisar realizar com a equipe
     de desenvolvimento ou qualquer outra equipe da DVILLAGRA, terá que
     ser realizada via formulário através da seguinte URL:
     <http://www.dvillagra.com.br/contato>".

ESTE SOFTWARE É FORNECIDO PELA EQUIPE DE DESENVOLVIMENTO DA DVILLAGRA
E POR SER UM SOFTWARE OPENSOURCE, NÃO GARANTE QUALQUER FUNCIONAMENTO
DA APLICAÇÃO DESENVOLVIDA PELO TERCEIRO, EM QUALQUER CIRCUNSTANCIA.
A CONTRIBUIÇÃO [IMPLEMENTAÇÃO] COM A FRAMEWORK É SEMPRE BEM VINDA, 
PORTANTO O TERCEIRO PODERÁ ENVIAR SUA CONTRIBUIÇÃO SEMPRE QUE QUISER
PARA QUE A EQUIPE DE HOMOLOGAÇÃO ANALISE E APROVE/REPROVE. EM CASO DE
APROVAÇÃO A CONTRIBUIÇÃO SERÁ INCLUIDA COMO PATCH VERSION. QUALQUER 
OUTRA INCLUSÃO DE SERVIDOR SERÁ REALIZADA PELA EQUIPE DE DESENVOLVIMENTO
DA DVILLAGRA, ONDE ALTERAÇÕES GERAIS HOMOLOGADAS SERÃO INSERIDAS COMO 
MINOR VERSION E FECHAMENTOS DE VERSÃO SERÁ INSERIDA COMO MAJOR VERSION.
--------------------------------------------------------------------
*/

class Upload
{

    /**
     *
     * @var string 
     */
    protected $destination;
    // img
    private $img, $img_data, $img_name_old;   
    // dimensões
    private $largura, $altura, $nova_largura, $nova_altura;
    // dados do arquivo
    private $mime, $extensao;

    function __construct($destination)
    {
        $this->destination = $destination;
    }

    public function salvarArquivoS3($arquivo,$nome){

        if (!defined('awsAccessKey')) define('awsAccessKey', Configuracoes::Valor('s3_key'));
        if (!defined('awsSecretKey')) define('awsSecretKey', Configuracoes::Valor('s3_secret'));

        $s3 = new S3(awsAccessKey, awsSecretKey);

        $bucket = Configuracoes::Valor('s3_bucket');

        // Check for CURL
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
            exit("\nERROR: CURL extension not loaded\n\n");

        $s3->putObjectFile($arquivo,  $bucket, $this->destination.'/'.baseName($nome),S3::ACL_PUBLIC_READ);
            
    }

    public function ChecaExistenciaArquivoS3($arquivo){
        
        if (!class_exists('S3')) require_once 'modulo/S3/S3.class.php';
        if (!class_exists('S3Request')) require_once 'modulo/S3/S3Request.class.php';
        if (!class_exists('S3Wrapper')) require_once 'modulo/S3/S3Wrapper.class.php';


        S3::setAuth(Configuracoes::Valor('s3_key'), Configuracoes::Valor('s3_secret'));

        $bucket = Configuracoes::Valor('s3_bucket');

        $caminho = $this->destination.'/';

        return  file_exists("s3://{$bucket}/".$caminho.$arquivo);

    }

    public function salva64S3($dataIMG, $novo_nome, $temp = false){

        if (!class_exists('S3')) require_once 'modulo/S3/S3.class.php';
        if (!class_exists('S3Request')) require_once 'modulo/S3/S3Request.class.php';
        if (!class_exists('S3Wrapper')) require_once 'modulo/S3/S3Wrapper.class.php';

        S3::setAuth(Configuracoes::Valor('s3_key'), Configuracoes::Valor('s3_secret'));

        $bucket = Configuracoes::Valor('s3_bucket');
        
        list($type, $dataIMG) = explode(';', $dataIMG);
        list(, $dataIMG)      = explode(',', $dataIMG);
        $dataIMG = base64_decode($dataIMG);

        $arquivo = $novo_nome;

        $caminho = ($temp !== false ? 'temp/' : '').$this->destination.'/';

        $stream = fopen("s3://{$bucket}/".$caminho.$arquivo, 'w');

        fwrite($stream, $dataIMG);
        fclose($stream);

        return true;

    }

    public function TempDefinitivoS3($arquivo){

        if (!class_exists('S3')) require_once 'modulo/S3/S3.class.php';
        if (!class_exists('S3Request')) require_once 'modulo/S3/S3Request.class.php';
        if (!class_exists('S3Wrapper')) require_once 'modulo/S3/S3Wrapper.class.php';


        S3::setAuth(Configuracoes::Valor('s3_key'), Configuracoes::Valor('s3_secret'));

        $bucket = Configuracoes::Valor('s3_bucket');

        $caminho_temp = 'temp/'.$this->destination.'/';
        $caminho_novo = $this->destination.'/';

        if(!opendir( 's3://'.$bucket.'/'.$caminho_novo )) mkdir('s3://'.$bucket.'/'.$caminho_novo);

        if(file_exists('s3://'.$bucket.'/'.$caminho_temp.$arquivo)){

            copy('s3://'.$bucket.'/'.$caminho_temp.$arquivo, 's3://'.$bucket.'/'.$caminho_novo.$arquivo);

            unlink('s3://'.$bucket.'/'.$caminho_temp.$arquivo);
        }
   
    }

    public function copiaArquivoS3($arquivo,$nome){
    

        if (!defined('awsAccessKey')) define('awsAccessKey', Configuracoes::Valor('s3_key'));
        if (!defined('awsSecretKey')) define('awsSecretKey', Configuracoes::Valor('s3_secret'));

        $s3 = new S3(awsAccessKey, awsSecretKey);

        $bucket = Configuracoes::Valor('s3_bucket');

        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
            exit("\nERROR: CURL extension not loaded\n\n");
    
        
        $s3->copyObject($bucket, $this->destination.'/'.$arquivo, $bucket, $this->destination.'/'.$nome, S3::ACL_PUBLIC_READ) ;

    
    }

    public function uploadWs($fieldName, $wO = false, $hO = false, $wT = false, $hT = false, $id = 'null'){

        if(isset($_FILES[$fieldName])){

            $this->img = $_FILES[$fieldName]['tmp_name'];

            list($this->largura, $this->altura) = getimagesize($this->img);

            $this->mime = strtolower( $_FILES[$fieldName]['type'] );

            $ext = explode('.', $_FILES[$fieldName]['name']);

            $this->img_name_old = $ext[0];

            $this->extensao = end($ext);

            $thumb = false;

            //dimensionar original
           if($wO !== false){

                $this->nova_largura = $wO;
                $this->nova_altura = $hO;

                $this->thumbImagem();

            }else{

                $data = file_get_contents($this->img);

                $fo = fopen($this->img, 'r');

                $data = fread($fo, filesize($this->img));

                $this->img_data = 'data:' . $this->mime . ';base64,' . base64_encode($data);

            }

            $retorno = $this->sendToMedia(false, $id);

            //criar thumb
            if($wT !== false){

                $this->nova_largura = $wT;
                $this->nova_altura = $hT;

                $this->thumbImagem();

                $this->sendToMedia(true, $id);

            }

            return $retorno['nome_arquivo'];

        }else{

            return false;

        }

    }

    public function sendToMedia($thumb = false, $id = 'null'){

        $url = G_API_URL;

        $arrPost = array('key' => G_API_KEY,
                        'format' => 'json',
                        'module' => $this->destination,
                        'method' => 'uploadImage',
                        'data' => $this->img_data,
                        'name' => $this->img_name_old,
                        'type'      => $this->extensao,
                        'thumb' => $thumb,
                        'id' => $id
                    );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch,CURLOPT_POSTFIELDS, $arrPost);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        $resposta = curl_exec($ch);

        if($resposta === false)
            return curl_error($ch);
        
        curl_close($ch);

        $arrReturn = array();

        $temp = json_decode($resposta);

        foreach ($temp as $key => $value) {

            $arrReturn[$key] = $value;
            
        }

        return $arrReturn;

    }

    public function thumbImagem($qualidade = 80){

        $jpeg_quality = $qualidade;

        $imgUrl = $this->img;

        $what = getimagesize($imgUrl);

        switch(strtolower($this->mime))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                $type = '.jpg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('tipo da imagem não suportada');
        }

        $resizedImage = imagecreatetruecolor($this->nova_largura, $this->nova_altura);
        imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $this->nova_largura, $this->nova_altura, $this->largura, $this->altura);   

        ob_start();

        header( "Content-type: ".strtolower($this->mime) ); 

        imagejpeg($resizedImage, NULL, $jpeg_quality);

        imagedestroy( $resizedImage );

        $i = ob_get_clean();

        $imageData = base64_encode($i);

        $this->img_data = 'data:'.strtolower($this->mime).';base64,'.$imageData;

    }

}
