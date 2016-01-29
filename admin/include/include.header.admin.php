

            <!-- modal --> 
            <div class="modal fade" id="cal-new-event" tabindex="-1" role="dialog" aria-labelledby="new-event" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Fechar</button>
                    <h3 class="modal-title thin" id="new-event">Compartilhamento</h3>
                  </div>

                  <div class="modal-body" style="padding-top: 0 !important;">

                    <h3>Sua URL é:</h3>
                    <div class="form-group no-bottom-margin">

                      <div class="col-lg-12">
                        <div class="input-group input-group-lg margin-bottom-20">
                          <input type="text" class="form-control" id="url_compartilhamento" value="<?=Url::base('login/cadastrar/'.Session::get('user_login'))?>" readonly="readonly">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default" id="bt-copy" opt-id="url_compartilhamento">Copiar!</button>
                          </span>
                        </div><!-- /input-group -->
                      </div>

                    </div>

                  </div>
                  <form role="form" id="add-event" parsley-validate>
                    <div class="modal-body">
                      <h3>Redes Sociais</h3>
                      <p>Conteúdo</p>

                      <div class="form-group">
                          <div class="radio">
                            <input type="radio" checked="" value="convite" id="optionsRadios1" name="optionsRadios">
                            <label for="optionsRadios1">Convite Representante</label>
                          </div>
                          <div class="radio">
                            <input type="radio" value="produto" id="optionsRadios2" name="optionsRadios">
                            <label for="optionsRadios2">Produtos Rocha Branca</label>
                          </div>
                      </div>
                      <p>Veiculo</p>
                      <div class="form-group">
                          <div class="row" style="font-size: 90px;">
                            <div class="col-lg-4">
                              <input type="radio" name="optionsRadiosx" id="optionsRadios1" value="facebook" checked="">
                              <label for="optionsRadios1"><i class="fa fa-facebook-square"></i></label>
                            </div>
                            <div class="col-lg-4">
                              <input type="radio" name="optionsRadiosx" id="optionsRadios2" value="twitter">
                              <label for="optionsRadios2"><i class="fa fa-twitter-square"></i></label>
                            </div>
                            <div class="col-lg-4">
                              <input type="radio" name="optionsRadiosx" id="optionsRadios2" value="plus">
                              <label for="optionsRadios2"><i class="fa fa-google-plus-square"></i></label>
                            </div>
                          </div>
                      </div>

                    </div>

                    <div class="modal-footer">

                      <button class="btn btn-red" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                      <button class="btn btn-green">Compartilhar</button>

                    </div>

                  </form>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            	<!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top collapsed" role="navigation" id="navbar">
          
          <!-- Branding -->
          <div class="navbar-header col-md-2">
            <a href="<?=Url::baseAdmin('')?>" class="navbar-brand">
              Devem<strong>Anager</strong>
            </a>
            <div class="sidebar-collapse">
              <a href="#">
                <i class="fa fa-bars"></i>
              </a>
            </div>
          </div>
          <!-- Branding end -->


          <!-- .nav-collapse -->
          <div class="navbar-collapse">
                        
            <!-- Page refresh -->
            <ul class="nav navbar-nav refresh">
              <li class="divided">
                <a href="#" class="page-refresh"><i class="fa fa-refresh"></i></a>
              </li>
            </ul>
            <!-- /Page refresh -->

            <!-- Quick Actions -->
            <ul class="nav navbar-nav quick-actions">
              

              <li class="dropdown divided">
                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#">
                  <span>Formulários</span>
                  <i class="fa fa-envelope"></i>
                  <span class="label label-transparent-black qtd_msg off">1</span>
                </a>

                <ul class="dropdown-menu wider arrow nopadding messages">
                  <li id="msg_mensagem"><h1>Você tem <strong>0</strong> nova mensagem</h1></li>


                  <li class="topborder"><a href="<?=Url::baseAdmin('fomulario')?>">Todas Mensagens <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided">
                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#">
                  <span>Notificações</span>
                  <i class="fa fa-bell"></i>
                  <span class="label label-transparent-black off ">0</span>
                </a>

                <ul class="dropdown-menu wide arrow nopadding bordered">
                  <li id="msg_notificacao"><h1>Suas notificações</h1></li>
                  
                  

                   <li><a href="<?=Url::baseAdmin('configura/notificacao')?>">Todas Notificações <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided user" id="current-user">
                <div class="profile-photo">
                  <img src="<?=Url::imgApp(Session::get('auImagem'), false, true)?>" alt />
                </div>
                <a class="dropdown-toggle options" data-toggle="dropdown" href="#">
                  <?=Session::get('auNome')?>
                </a>
                
                <ul class="dropdown-menu arrow settings">

                  <!--li>
                    <a href="<?=Url::base('cliente/editar')?>"><i class="fa fa-user"></i> Editar Perfil</a>
                  </li-->
                  <li class="divider"></li>

                  <li>
                    <a href="javascript:devem.geral.deslogar();"><i class="fa fa-power-off"></i> Sair</a>
                  </li>
                </ul>
              </li>
            </ul>
            <!-- /Quick Actions -->



            <!-- Sidebar -->
            <ul class="nav navbar-nav side-nav" id="sidebar">
              
              

              <li class="navigation" id="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="#navigation">Conteúdo <i class="fa fa-file"></i></a>
                
                <ul class="menu">
                  
                  <li class=" dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-home"></i> Home <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?=Url::baseAdmin('conteudo/home/destaque')?>">
                          <i class="fa fa-certificate"></i> Destaque
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::baseAdmin('conteudo/home/blocos')?>">
                          <i class="fa fa-th"></i> Blocos
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::baseAdmin('conteudo/home/publicidade')?>">
                          <i class="fa fa-newspaper-o"></i> Publicidade
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::baseAdmin('conteudo/home/seo')?>">
                          <i class="fa fa-google"></i> SEO
                        </a>
                      </li>
                    </ul>
                  </li>
                  
                </ul>

              </li>
              <? if((int)Session::get('auNivel') < 2){ ?>
              <li class="navigation" id="navigation2">
                <a href="#" class="sidebar-toggle" data-toggle="#navigation2">Relatórios <i class="fa fa-bar-chart"></i></a>
                
                <ul class="menu">
                  
                  <li class="">
                    <a href="<?=Url::baseAdmin('relatorio/acesso')?>">
                      <i class="fa fa-line-chart"></i> Acessos e Cliques
                    </a>
                  </li>
                  
                </ul>

              </li>
              <? } ?>

              <? if((int)Session::get('auNivel') < 2){ ?>
              <li class="navigation" id="navigation3">
                <a href="#" class="sidebar-toggle" data-toggle="#navigation3">configurações <i class="fa fa-cogs"></i></a>
                
                <ul class="menu">
                  
                    <li class="">
                      <a href="<?=Url::baseAdmin('configura/usuario')?>">
                        <i class="fa fa-user"></i> Usuarios 
                      </a>
                    </li>
                  
                  <? if((int)Session::get('auNivel') == 0){ ?>
                  <li class="">
                    <a href="<?=Url::baseAdmin('configura/parametros')?>">
                      <i class="fa fa-cog"></i> Parametros 
                    </a>
                  </li>
                  <? } ?>

                  <? if((int)Session::get('auNivel') == 0){ ?>
                  <li class="">
                    <a href="<?=Url::baseAdmin('configura/regras')?>">
                      <i class="fa fa-asterisk"></i> Regras
                    </a>
                  </li>
                  <? } ?>

                  <li class="">
                    <a href="<?=Url::baseAdmin('configura/publicidade')?>">
                      <i class="fa fa-newspaper-o"></i> Publicidade
                    </a>
                  </li>
                  
                  <li class="">
                    <a href="<?=Url::baseAdmin('configura/seo')?>">
                      <i class="fa fa-google"></i> SEO
                    </a>
                  </li>

                </ul>

              </li>
              <? } ?>

                  
                  <li class="dv_versao">
                    <img src="<?=Url::imgApp('bola-admin-white.png',true, true)?>"><span><?=DEVEM_VERSAO?></span>
                  </li>
              
            </ul>
            <!-- Sidebar end -->






          </div>
          <!--/.nav-collapse -->

</div>