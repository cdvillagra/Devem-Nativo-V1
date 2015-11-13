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

String.prototype.capitalise = function() {

    var s = this;
    return s.charAt(0).toUpperCase() + s.slice(1);
}

String.prototype.replaceAll = function (token, newToken) {
    var s = this;

    while (s.indexOf(token) != -1) {
        s = s.replace(token, newToken);
    }

    return s;
};

String.prototype.removeAll = function (token) {
    return this.replaceAll(token, '');
};

String.prototype.contains = function (value) {
    return this.indexOf(value) > -1;
};

String.prototype.startsWith = function (value) {
    return this.slice(0, value.length) == value;
};

String.prototype.endsWith = function (value) {
    return this.slice(-value.length) == value;
};

String.prototype.toFloat = function () {
    if (String.isNullOrWhiteSpace(this))
        return 0;

    var value = this.replaceAll('.', '').replaceAll(',', '.');

    if (isNaN(value))
        return null;

    return parseFloat(value);
};

String.prototype.toInt = function () {
    if (String.isNullOrWhiteSpace(this))
        return 0;

    var value = parseInt(this, 10);

    if (isNaN(value))
        return null;

    return value;
};

String.isNullOrEmpty = function (value) {
    return value == undefined || value == null || value == '';
};

String.isNullOrWhiteSpace = function (value) {
    return value == undefined || value == null || $.trim(value) == '';
};

String.serializeJSON = function(json) {
    var serial = '';

    for (var nome in json) {
        if (nome)
            serial += nome + '=' + json[nome] + '&';
    }

    return serial.substring(0, serial.length - 1);
};