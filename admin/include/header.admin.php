<!-- Header Start -->
    <header>
      <a href="<?=Url::base('admin/')?>" class="logo">
        <img src="<?=Url::baseAdmin('view/img/logo.png')?>" alt="Devem Admin"/>
      </a>
      <div class="pull-right">
        <ul id="mini-nav" class="clearfix">
          <li class="list-box hidden-xs">
            <a href="#" data-toggle="modal" data-target="#modalMd">
              <span class="text-white">Modal</span> <i class="fa fa-list-alt"></i>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-danger" id="myModalLabel5">Titulo modal </h4>
                  </div>
                  <div class="modal-body">
                    <p>Lorem Lorem e mais Lorem</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="list-box dropdown">
            <a id="drop5" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-film"></i>
            </a>
            <span class="info-label info-bg">9+</span>
            <ul class="dropdown-menu stats-widget clearfix">
              <li>
                <h5 class="text-success">$37895</h5>
                <p>Vendas <span class="text-success">+2%</span></p>
                <div class="progress progress-mini">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">40% Completos (Sucesso)</span>
                  </div>
                </div>
              </li>
              <li>
                <h5 class="text-warning">47,892</h5>
                <p>Downloads <span class="text-warning">+39%</span></p>
                <div class="progress progress-mini">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">40% Completos (Alerta)</span>
                  </div>
                </div>
              </li>
              <li>
                <h5 class="text-danger">28214</h5>
                <p>Uploads <span class="text-danger">-7%</span></p>
                <div class="progress progress-mini">
                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                    <span class="sr-only">40% Completos (Perigo)</span>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <li class="list-box dropdown">
            <a id="drop5" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-calendar"></i>
            </a>
            <span class="info-label success-bg">6</span>
            <ul class="dropdown-menu server-activity">
              <li>
                <p><i class="fa fa-flag text-info"></i> Requisição pendente<span class="time">3 hrs</span></p>
              </li>
              <li>
                <p><i class="fa fa-fire text-warning"></i>Cache do Servidor<span class="time">3mins</span></p>
              </li>
              <li>
                <p><i class="fa fa-user text-success"></i>3 Novos Usuários<span class="time">1 min</span></p>
              </li>
              <li>
                <p><i class="fa fa-bell text-danger"></i>Requestes pendentes<span class="time">5 min</span></p>
              </li>
              <li>
                <p><i class="fa fa-plane text-info"></i>Baixa erformance<span class="time">25 min</span></p>
              </li>
              <li>
                <p><i class="fa fa-envelope text-warning"></i>12 novos emails<span class="time">25 min</span></p>
              </li>
              <li>
                <p><i class="fa fa-cog icon-spin text-success"></i> Configuração de localizacao<span class="time">4 hrs</span></p>
              </li>
            </ul>
          </li>
          <li class="list-box user-profile">
            <a id="drop7" href="#" role="button" class="dropdown-toggle user-avtar" data-toggle="dropdown">
              <img src="<?=Url::baseAdmin('view/img/user5.jpg')?>" alt="Usuario Devem">
            </a>
            <ul class="dropdown-menu server-activity">
              <li>
                <p><i class="fa fa-cog text-info"></i>Configuração da conta</p>
              </li>
              <li>
                <p><i class="fa fa-fire text-warning"></i>Detalhes de Pagamento</p>
              </li>
              <li>
                <div class="demo-btn-group clearfix">
                  <a href="#" data-original-title="" title="">
                    <i class="fa fa-facebook fa-lg icon-rounded info-bg"></i>
                  </a>
                  <a href="#" data-original-title="" title="">
                    <i class="fa fa-twitter fa-lg icon-rounded twitter-bg"></i>
                  </a>
                  <a href="#" data-original-title="" title="">
                    <i class="fa fa-linkedin fa-lg icon-rounded linkedin-bg"></i>
                  </a>
                  <a href="#" data-original-title="" title="">
                    <i class="fa fa-pinterest fa-lg icon-rounded danger-bg"></i>
                  </a>
                  <a href="#" data-original-title="" title="">
                    <i class="fa fa-google-plus fa-lg icon-rounded success-bg"></i>
                  </a>
                </div>
              </li>
              <li>
                <div class="demo-btn-group clearfix">
                  <button href="#" class="btn btn-danger">
                    Sair
                  </button>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </header>
    <!-- Header End -->

    <!-- Main Container start -->
    <div class="dashboard-container">

      <div class="container">
        <!-- Top Nav Start -->
        <div id='cssmenu'>
          <ul>
            <li class="<?=($p['mod'] == 'index' ? 'active' : '')?>">
              <a href="<?=Url::base('admin')?>">
                <i class="fa fa-dashboard"></i>
                Dashboard
              </a>
            </li>
            <li class="<?=($p['mod'] == 'form' ? 'active' : '')?>">
              <a href="<?=Url::base('admin/formulario')?>">
                <i class="fa fa-align-justify"></i>
                Formulários
              </a>
            </li>
            <li class="<?=($p['mod'] == 'grafs' ? 'active' : '')?>">
              <a href='#'><i class="fa fa-bar-chart-o"></i>Graficos</a>
              <ul>
                 <li><a href='<?=Url::base('admin/grafico/flot')?>'>Flot Graphs</a></li>
                 <li><a href='<?=Url::base('admin/grafico/graph')?>'>Google Graph</a></li>
                 <li><a href='<?=Url::base('admin/grafico/maps')?>'>Vector Maps</a></li>
              </ul>
            </li>
            <li class="<?=($p['mod'] == 'ui' ? 'active' : '')?>">
              <a href='#'><i class="fa fa-flask"></i>Elementos</a>
              <ul>
                 <li><a href="<?=Url::base('admin/ui/elementos')?>">UI Elements</a></li>
                 <li><a href="<?=Url::base('admin/ui/painel')?>">Panels</a></li>
                 <li><a href="<?=Url::base('admin/ui/notificacao')?>">Notifications</a></li>
                 <li><a href="<?=Url::base('admin/ui/icones')?>">Icons</a></li>
              </ul>
            </li>
            <li class="hidden-sm <?=($p['mod'] == 'extra' ? 'active' : '')?>">
              <a href='#'><i class="fa fa-dashboard"></i>Extras</a>
              <ul>
                <li><a href='#'>Blog</a>
                  <ul>
                    <li><a href='<?=Url::base('admin/extra/blog')?>'>Blog</a></li>
                    <li><a href='<?=Url::base('admin/extra/blogArtigo')?>'>Blog Full Page</a></li>
                  </ul>
                </li>
                <li><a href='<?=Url::base('admin/extra/perfil')?>'>Edit Profile</a></li>
                <li><a href='<?=Url::base('admin/extra/invoice')?>'>Invoice</a></li>
                <li><a href='<?=Url::base('admin/extra/default')?>'>default</a></li>
                <li><a href='<?=Url::base('admin/extra/ajuda')?>'>Help</a></li>
                <li><a href='<?=Url::base('admin/extra/e404')?>'>404</a></li>
                <li><a href='<?=Url::base('admin/extra/e500')?>'>500</a></li>
              </ul>
            </li>
            <li class="hidden-sm <?=($p['mod'] == 'tabela' ? 'active' : '')?>">
              <a href='#'><i class="fa fa-table"></i>Tables</a>
              <ul>
                 <li><a href='<?=Url::base('admin/tabela')?>'>Tables</a></li>
                 <li><a href='<?=Url::base('admin/tabela/preco')?>'>Pricing Plan</a></li>
                 <li><a href='<?=Url::base('admin/tabela/timeline')?>'>Timeline</a></li>
              </ul>
            </li>
            <li class="<?=($p['mod'] == 'media' ? 'active' : '')?>">
              <a href="<?=Url::base('admin/media')?>">
                <i class="fa fa-picture-o"></i>
                Media
              </a>
            </li>
            <li class="hidden-sm <?=($p['mod'] == 'calendario' ? 'active' : '')?>">
              <a href="<?=Url::base('admin/calendario')?>">
                <i class="fa fa-calendar"></i>
                Calendário
              </a>
            </li>
            <li class="hidden-sm <?=($p['mod'] == 'tipografia' ? 'active' : '')?>">
              <a href="<?=Url::base('admin/tipografia')?>">
                <i class="fa fa-font"></i>
                Tipografia
              </a>
            </li>
          </ul>
        </div>
        <!-- Top Nav End -->