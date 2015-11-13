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
if (typeof devem.core.mascara == 'undefined') { devem.core.mascara = new Object(); }

devem.core.mascara = {
    registrar: function ()
    {
		devem.core.mascara.aplicaMascara();
	},
	
	removePlaceholder: function(obj){
		$(obj).blur(function(){
			$(this).val() == "" ? $(this).attr("placeholder",'') : $(this).val();
		});
	},
	
	aplicaMascara: function()
	{
		if(document.all && !window.atob){
			$("body").on('focus', '.mascara-cep', function () { $(this).setMask({ mask: '99999-999', autoTab: false }) });
			$("body").on('focus', '.mascara-cpf', function () { $(this).setMask({ mask: '999.999.999-99', autoTab: false }) });
			$("body").on('focus', '.mascara-cnpj', function () { $(this).setMask({ mask: '99.999.999/9999-99', autoTab: false }) });
			$("body").on('focus', '.mascara-data', function () { $(this).setMask({ mask: '99/99/9999', autoTab: false }) });
		}else{

			$("body").on('focus', '.mascara-cep', function () { $(this).setMask({ mask: '99999-999', autoTab: false }).attr("placeholder", '_____-___'); devem.core.mascara.removePlaceholder($(this)); });
			$("body").on('focus', '.mascara-cpf', function () { $(this).setMask({ mask: '999.999.999-99', autoTab: false }).attr("placeholder", '___.___.___-__'); devem.core.mascara.removePlaceholder($(this)); });
			$("body").on('focus', '.mascara-cnpj', function () { $(this).setMask({ mask: '99.999.999/9999-99', autoTab: false }).attr("placeholder", '__.___.___/____-__'); devem.core.mascara.removePlaceholder($(this)); });
			$("body").on('focus', '.mascara-data', function () { $(this).setMask({ mask: '99/99/9999', autoTab: false }).attr("placeholder", '__/__/____'); devem.core.mascara.removePlaceholder($(this)); });
		}
		
		$("body").on('click', '.mascara-time', function () { $(this).datetimepicker({
			  datepicker:false,
  				format:'H:i',
			 allowTimes:[
			  '00:00', '00:30',
			  '01:00', '01:30',
			  '02:00', '02:30',
			  '03:00', '03:30',
			  '04:00', '04:30',
			  '05:00', '05:30',
			  '06:00', '06:30',
			  '07:00', '07:30',
			  '08:00', '08:30',
			  '09:00', '09:30',
			  '10:00', '10:30',
			  '11:00', '11:30',
			  '12:00', '12:30',
			  '13:00', '13:30',
			  '14:00', '14:30',
			  '15:00', '15:30',
			  '16:00', '16:30',
			  '17:00', '17:30',
			  '18:00', '18:30',
			  '19:00', '19:30',
			  '20:00', '20:30',
			  '21:00', '21:30',
			  '22:00', '22:30',
			  '23:00', '23:30',
			  '24:00'
			 ]

			 
		}).focus();});
		$("body").on('focus', '.mascara-numero', function () { $(this).setMask({ mask: '999999999', autoTab: false }); });
		$("body").on('focus', '.mascara-qtde', function () { $(this).setMask({ mask: '99', autoTab: false }); });
		$("body").on('focus', '.mascara-preco', function () { $(this).setMask({ mask: '99,999.999.99', type: 'reverse', autoTab: false }).css('text-align' , 'left'); });
		$("body").on('focus', '.mascara-area', function () { $(this).setMask({ mask: '99,999.99', type: 'reverse', autoTab: false }).css('text-align' , 'left'); });
		$("body").on('focus', '.mascara-calendario', function () {
			
			//# Fefo - Máscara que pega a data atual como data limitadora
			
			dataMaxima = null;
			if ($(this).hasClass('data-hoje')) {
				//# Se o picker for um picker máximo hoje
				dataMaxima = 0;
			}
			
			dataMinima = null;
			if ($(this).hasClass('data-ate-hoje')) {
				//# Se o picker for um picker máximo hoje
				dataMinima = 0;
			}
			
			$(this).datepicker({ maxDate: dataMaxima, minDate: dataMinima });
		});
		//#Resto do Matheus
		$("body").on('focus', '.mascara-hora', function () { $(this).setMask({ mask: '99:99', autoTab: false }).attr("placeholder", '  :  ').placeholder(); devem.core.mascara.removePlaceholder($(this)); });
		$("body").on('focus', '.mascara-telefone', function () {
			if(document.all && !window.atob != true){
				$(this).attr("placeholder", '(__) ____-____').placeholder(); devem.core.mascara.removePlaceholder($(this));
			}
			$(this).keydown(function (e) {

                if (!(e.which >= 48 && e.which <= 57) && !(e.which >= 96 && e.which <= 105) && e.which != 8 && e.which != 46) {
                    return;
                }

                 if ($(this).val().length < 15 && $(this).data('mask').mask == '(99) 99999-9999') {
                     $(this).setMask({ mask: '(99) 99999-9999', autoTab: false });
                }

                else if ($(this).val().length >= 14 && !(e.which == 8 || e.which == 46)) {
                    $(this).setMask({ mask: '(99) 99999-9999', autoTab: false });
                }

                else if ($(this).val().length == 15 && (e.which == 8 || e.which == 46)) {
                    var inputTelefone = this;
                    setTimeout(function () { $(inputTelefone).setMask({ mask: '(99) 9999-9999', autoTab: false }); }, 50);
                }
            });

            if (($(this).val().length == 11) || ($(this).val().length == 15)) {
                $(this).setMask({ mask: '(99) 99999-9999', autoTab: false });
            }
            else {
                $(this).setMask({ mask: '(99) 9999-9999', autoTab: false });
            }
        });
        
	}
};

$(document).ready(devem.core.mascara.registrar);	