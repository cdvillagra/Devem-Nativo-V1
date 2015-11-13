<?php
/*
 * @Projeto: 	Devem
 * @Script: 	Classe de disparo de layout (View) no MVC
*/
class View
{
    private $st_contents;
    private $st_view;
    private $v_params;
      
    function __construct($st_view = null, $v_params = null, $v_custom = false, $v_ignore = false) 
    {
        if($st_view != null)
            $this->setView(Configuracoes::CheckFileCustomer($st_view, false, ($v_custom === false ? false : Configuracoes::CustomerTemp()), $v_ignore));
        $this->v_params = $v_params;
    }   
      
    public function setView($st_view)
    {
        if(file_exists($st_view))
            $this->st_view = $st_view;
        else
            throw new Exception("Esta View '$st_view' não existe");       
    }
      
    public function getView()
    {
        return $this->st_view;
    }
    
	public function pParametros(Array $val = null)
	{
		if($val == ""){
			return $this->v_params;
		}else{
			$this->v_params = $val; 	
		}	
	}
    
    public function getConteudo()
    {
        ob_start();
        if(isset($this->st_view))
            require_once $this->st_view;
        $this->st_contents = ob_get_contents();
        ob_end_clean();
        return $this->st_contents;   
    }
      
    public function Show()
    {
        echo $this->getConteudo();
        exit;
    }

    public static function acessoNegado($force_ajax_on_screen = false) {

        if(Request::ajax() && !$force_ajax_on_screen) {

            $view = new View("app/view/layout/modalerro.phtml");
            $view->pParametros(
                array(
                    'modal_info' => array(
                        'title'     =>  'Erro de permissão',
                        'texto'     =>  'Você não possui permissão de acesso à esta sessão.',
                        'label_bt'  =>  'Fechar',
                        'campos'    =>  ''
                    )
                )
            );
        }
        else {           

            $view = new self("app/view/layout/acessonegado.phtml");

        }

        $view->Show();
        
        exit;        
    }
}
?>