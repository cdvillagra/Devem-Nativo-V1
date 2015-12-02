

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
            <a href="<?=Url::url()?>" class="navbar-brand">
              Água <strong>Rocha Branca</strong>
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
                  <i class="fa fa-envelope"></i>
                  <span class="label label-transparent-black qtd_msg off">1</span>
                </a>

                <ul class="dropdown-menu wider arrow nopadding messages">
                  <li id="msg_mensagem"><h1>Você tem <strong>0</strong> nova mensagem</h1></li>


                  <li class="topborder"><a href="<?=Url::base('mensagem')?>">Todas Mensagens <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided">
                
                <a class="dropdown-toggle button" data-toggle="dropdown" href="#">
                  <i class="fa fa-bell"></i>
                  <span class="label label-transparent-black off ">0</span>
                </a>

                <ul class="dropdown-menu wide arrow nopadding bordered">
                  <li id="msg_notificacao"><h1>Suas notificações</h1></li>
                  
                  

                   <li><a href="<?=Url::base('notificacao/consulta')?>">Todas Notificações <i class="fa fa-angle-right"></i></a></li>
                </ul>

              </li>

              <li class="dropdown divided user" id="current-user">
                <div class="profile-photo">
                  <img src="<?=Url::imgApp('avatar.jpg')?>" alt />
                </div>
                <a class="dropdown-toggle options" data-toggle="dropdown" href="#">
                  dfhdfg
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
                <a href="#" class="sidebar-toggle" data-toggle="#navigation">Navegação <i class="fa fa-angle-up"></i></a>
                
                <ul class="menu">
                  
                  <li class="active dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-users"></i> Clientes <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?=Url::base('cliente/consulta')?>">
                          <i class="fa fa-caret-right"></i> Consultar
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::base('cliente/cadastro')?>">
                          <i class="fa fa-caret-right"></i> Cadastrar
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-tint"></i> Pedidos <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?=Url::base('pedido/consulta')?>">
                          <i class="fa fa-caret-right"></i> Consultar
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::base('pedido/produto')?>">
                          <i class="fa fa-caret-right"></i> Produtos / Novo Pedido
                        </a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <a href="<?=Url::base('mensagem')?>">
                      <i class="fa fa-envelope"></i> Mensagens
                      <span class="badge badge-red qtd_msg off">1</span>
                    </a>
                  </li>

                  <li>
                    <a href="<?=Url::base('atividade')?>">
                      <i class="fa fa-exchange"></i> Atividades
                    </a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-star"></i> Rendimento  <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?=Url::base('rendimento/consulta')?>">
                          <i class="fa fa-caret-right"></i> Consulta e Resgate
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::base('rendimento/ranking')?>">
                          <i class="fa fa-caret-right"></i> Ranking
                        </a>
                      </li>
                    </ul>
                  </li>

                  <!--li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bar-chart-o"></i> Relatórios <b class="fa fa-plus dropdown-plus"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="<?=Url::base('relatorio/ganho')?>">
                          <i class="fa fa-caret-right"></i> Rendimentos
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::base('relatorio/resgates')?>">
                          <i class="fa fa-caret-right"></i> Resgates
                        </a>
                      </li>
                      <li>
                        <a href="<?=Url::base('relatorio/cliente')?>">
                          <i class="fa fa-caret-right"></i> Clientes
                        </a>
                      </li>
                    </ul>
                  </li-->
                </ul>

              </li>

              <li class="summary" id="order-summary">
                <a href="#" class="sidebar-toggle underline" data-toggle="#order-summary">Pedidos dos seus clientes<i class="fa fa-angle-up"></i></a>

                <div class="media">
                  <a class="pull-right" href="#">
                    <span id="sales-chart"></span>
                  </a>
                  <div class="media-body">
                    Pendentes
                    <h3 class="media-heading" id="pedidos_nav_pendente">0</h3>
                  </div>
                </div>

                <div class="media">
                  <a class="pull-right" href="#">
                    <span id="balance-chart"></span>
                  </a>
                  <div class="media-body">
                    Efetivados
                    <h3 class="media-heading" id="pedidos_nav_efetivado">0</h3>
                  </div>
                </div>

              </li>

              <li class="settings" id="general-settings">
                <a href="#" class="sidebar-toggle underline" data-toggle="#general-settings"> Compartilhe <i class="fa fa-angle-up"></i></a>

                
                    <a href="#cal-new-event" data-toggle="modal">
                      <i class="fa fa-desktop"></i> Redes Sociais</b>
                    </a>

              </li>

              
            </ul>
            <!-- Sidebar end -->






          </div>
          <!--/.nav-collapse -->

</div>