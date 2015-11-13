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

if (typeof devem == 'undefined') { devem = new Object(); }
if (typeof devem.core == 'undefined') { devem.core = new Object(); }
if (typeof devem.core.validar == 'undefined') { devem.core.validar = new Object(); }
devem.core.validar = {
    email: function (valor) {
        var rx = new RegExp("\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*");
        var matches = rx.exec(valor);
        if(matches != null && valor == matches[0]){
            var validandox = valor.split("@");
            validando = validandox[1].split(".");
            if(validando[0].length < 2){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    },


    cpf: function (valor) {
        var soma = 0;
        var resto = 0;
        var strCPF = valor.replace(".", "").replace("-", "").replace(".", "");
        var cpfValido = true;

        if (strCPF == "00000000000") {
            cpfValido = false;
        }
        for (var i = 1; i <= 9; i++) {
            soma = soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if ((resto == 10) || (resto == 11)) {
            resto = 0;
        }
        if (resto != parseInt(strCPF.substring(9, 10))) {
            cpfValido = false;
        }
        soma = 0;
        for (i = 1; i <= 10; i++) {
            soma = soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if ((resto == 10) || (resto == 11)) {
            resto = 0;
        }
        if (resto != parseInt(strCPF.substring(10, 11))) {
            cpfValido = false;
        }
        if (strCPF == "11111111111") {
            cpfValido = false;
        }
        if (strCPF == "22222222222") {
            cpfValido = false;
        }
        if (strCPF == "33333333333") {
            cpfValido = false;
        }
        if (strCPF == "44444444444") {
            cpfValido = false;
        }
        if (strCPF == "55555555555") {
            cpfValido = false;
        }
        if (strCPF == "66666666666") {
            cpfValido = false;
        }
        if (strCPF == "77777777777") {
            cpfValido = false;
        }
        if (strCPF == "88888888888") {
            cpfValido = false;
        }
        if (strCPF == "99999999999") {
            cpfValido = false;
        }
        if (strCPF == "00000000000") {
            cpfValido = false;
        }
        return cpfValido;
    },

    cnpj: function (valor) {
        valor = jQuery.trim(valor);
        valor = valor.replace('/', '');
        valor = valor.replace('.', '');
        valor = valor.replace('.', '');
        valor = valor.replace('-', '');

        var numeros, digitos, soma, i, resultado, pos, tamanho, digitosIguais;
        digitosIguais = 1;

        if (valor.length < 14 && valor.length < 15)
            return false;

        for (i = 0; i < valor.length - 1; i++) {
            if (valor.charAt(i) != valor.charAt(i + 1)) {
                digitosIguais = 0;
                break;
            }
        }

        if (!digitosIguais) {
            tamanho = valor.length - 2;
            numeros = valor.substring(0, tamanho);
            digitos = valor.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;

                if (pos < 2) {
                    pos = 9;
                }
            }

            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

            if (resultado != digitos.charAt(0))
                return false;

            tamanho = tamanho + 1;
            numeros = valor.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (i = tamanho; i >= 1; i--) {
                soma += numeros.charAt(tamanho - i) * pos--;

                if (pos < 2)
                    pos = 9;
            }

            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

            if (resultado != digitos.charAt(1))
                return false;

            return true;
        }
        else
            return false;

    },

    data: function (value) {
        if (value.length != 10) return false;

        var data = value;
        var dia = data.substr(0, 2);
        var barra1 = data.substr(2, 1);
        var mes = data.substr(3, 2);
        var barra2 = data.substr(5, 1);
        var ano = data.substr(6, 4);

        if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) return false;
        if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) return false;
        if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) return false;
        if (ano < 1900) return false;

        return true;
    },

    telefone: function (valor) {
        valor = valor.replace('(', '').replace(')', '').replace('-', '');
        var partes = valor.split(' ');

        if (partes.length != 2)
            return false;

        if (!/^\d+$/.test(partes[0]) || !/^\d+$/.test(partes[1]))
            return false;

        return (partes[0].length == 2 && (partes[1].length == 8 || partes[1].length == 9));
    },

    numero: function (valor) {
        return /^-?(?:\d+|\d{1,3}(?:.\d{3})+)(?:\,\d+)?$/.test(valor);
    },

    ddd: function (valor) {
        if (!/^\d+$/.test(valor))
            return false;

        return valor.length == 2;
    },
    
    dddtelefone: function ($valor) {
    	//# Array contendo os 10 digitos básicos para testar se tem repetição
    	var $varsCheck = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
    	
    	//# Declara um bool com a resposta - O retorno vai sempre ser inverso ao valor deste
		$erroRepeticao = false;
    	
    	//# Pegamos o valor e removemos todos os caracteres especiais possíveis do campo
    	$teltemp = $valor.replace("(", "").replace(" ", "").replace(")", "").replace("-", "");
		
    	//# Valor padrão de teste de repetição
    	$qtdRepeticao = 6;
    	
    	//# Se não for nulo e o tamanho for maior ou igual a 10 (2 digitos do DDD + 8 do telefone ou 9 do celular
		if ((!String.isNullOrWhiteSpace($teltemp)) && ($teltemp.length >= 10)) {
			
			//# Caso seja um celular, adicionamos um ao valor máximo de repetição
			if ($teltemp.length == 11) {
				$qtdRepeticao++;
			}
			
			//# Declara uma var com a quantidade de valores do array de números a serem checados
			$subCount = $varsCheck.length;
			
			
			
			//# Declara um for para automatizar o processo
			for ($x = 0; $x < $subCount; $x++) {

				//# Se a quantidade de ocorrências de um dos valores do array de checagem for maior que a quantidade de repetição
				if (($teltemp.split($varsCheck[$x]).length - 1) >= $qtdRepeticao) {
					//# É sinal de que o número gravado não é válido
					$erroRepeticao = true;
					//# Cancela-se todas as outras verificações já que a validação já deu como negativa
					$x = $subCount;
				}
			}
		} else {
			//# Se não estiver nestas condições, o telefone não é válido
			$erroRepeticao = true;
		}
		
		//# Retorna o inverso deste bool
		return !$erroRepeticao;
    }
};