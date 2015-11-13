![Devem](https://github.com/cdvillagra/devem_dev/blob/master/app/view/default/img/icone_git.png) Devem Nativo V1
====================

ATENÇÃO > os links abaixo estão desativados temporariamente
----------------

[Devem][1] Nativo é a plataforma de desenvolvimento de sistemas e outras aplicações Web baseada em MVC.

Desenvolvido pela [DVillagra][2] com parceria com a [Smoke Developers][3].

Para iniciar é muito facil;
----------------
1. Clonando o Devem Nativo V1:
   ```bash
   cd path_to_devem/
   git clone https://github.com/cdvillagra/Devem-Nativo-V1.git devem
   ```

2. Antes de colocar a mão na massa, execute o root no seu navegador, no local em que ele estiver instalado
   - local: `localhost/devem`
   - web: `http://www.seudominio.com.br`

   OBS: Para não precisar realizar alterações no arquivo `HTACCESS`, sugerimos que você altere seu arquivo `httpd.conf`, deixando o valor do DocumentRoot como o caminho da pasta do devem no seu computador. Ex:. `DocumentRoot "C:/xampp/htdocs/devem"`

3. Abrirá um passo-a-passo para instalar algumas dependencias da plataforma, para que tudo funcione bem.
  - Passo 1: Algumas informações importantes
  - Passo 2: Você pode inserir ou não os dados de conexão com o banco de dados. O banco de dados já deve estar criado, para não ter a possibilidade de não criar o banco por permissões do usuário utilizado. Em caso de não utilizar o banco de dados, é só flegar a opção de que não será necessário utilizar o banco.
  - Passo 3: Alguns parametros para inserir, em caso de utilização de e-mail, upload de imagens via `S3` e outros detalhes.
  - Passo 4: Credencias de acesso ao Admin
  - Passo 5: Instalação propriamente dita

4. Após aparecer a mensagem de que a instalação foi concluída, clique em concluir para que o sistema finalize a instalação e libere a utilização da framework

5. Agora você pode acessar o root para exibir a aplicação, ou `URL/admin` para acessar o admin do seu sistema.

Documentação
----------------------
Para acessar a documentação do `Devem Nativo` acesse o site da [DVillagra][2], ou pelo endereço [http://devem.dv1.biz][1]

Duvidas
----------------------
Para dúvidas envie um e-mail para `devem@dvillagra.com.br`

License
---------
DVillagra
Copyright © 2015 Devem Nativo (http://devem.dv1.biz)

[1]: http://devem.dv1.biz
[2]: http://dvillagra.com.br
[3]: http://smokedev.com.br
