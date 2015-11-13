<title><?=(isset($p['title']) ? (strlen($p['title']) > 64 ? substr($p['title'], 0, 61).'...' : $p['title'] ) : 'title default - '.ucfirst(strtolower($_REQUEST['controle'])))?></title>

<!-- for Google -->
<meta name="description" content="<?=(isset($p['description']) ? $p['description'] : 'Desc defauLt.')?>">
<meta name="keywords" content="<?=(isset($p['keywords']) ? $p['keywords'] : 'keywords default')?>">
<meta name="author" content="©<?=date('Y');?> DEVEM">

<!-- for Facebook -->          
<meta property="og:title" content="<?php echo htmlentities(isset($p['title_fb']) ? $p['title_fb'] : (isset($p['title']) ? $p['title'] : 'title default' ));?>" />
<meta property="og:description" content="<?php echo htmlentities(isset($p['description']) ? $p['description'] : 'Desc defaut.' );?>" />
<meta property="og:image" content="<?php echo (isset($p['image']) ? $p['image'] : Url::imgApp('logo.png') );?>" />
<meta property="og:url" content="<?php echo htmlentities("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");?>" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="Devem" />
<meta property="fb:app_id" content="464777950352006" />

<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@TWITTER" />
<meta name="twitter:title" content="<?php echo htmlentities(isset($p['title']) ? $p['title'] : 'title default' );?>" />
<meta name="twitter:description" content="<?php echo htmlentities(isset($p['description']) ? $p['description'] : 'Desc defaut.' );?>" />
<meta name="twitter:image" content="<?php echo (isset($p['image']) ? $p['image'] : Url::imgApp('logo.png') );?>" />

