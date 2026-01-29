$(document).ready(function(){

    iniciarCadastro();

    navegacaoArea();

    andamentoPreenchimento();

    exibirPlanos();

    filtroPlano();

    selecionarPlano();

    gerenciarStatus();

    assinaturaDigital();

    ativarBoxAssinatura();

    responsaveisEmpresa();

    dependentes();

    checkboxAcaoListaDependentes();

    uploadLote();

    checkboxAcaoLista();

    anexoDependente();

    assinaturaDependente();

    enviarSolicitacaoAceite();

    buscar_dependentes();

    filtroStatus();

    selecionarEletivos();

    gerenciarMenuAcao();

    if($(".checkout-pagamento").length > 0){

        var url = $("a.checkout-pagamento").attr("href");

        window.location.href = url;

    }

    $(".salvar:not('.checkout-pagamento')").click(function(){

        var url = $(this).parents(".conteudoInterno").attr("modulo");

        var form = $(this).parents(".conteudoInterno").find("form:not('.form-desabilitado')").attr("id");

        if($(this).hasClass("finalizar-cadastro")){

            if($(".assinatura-digital").length > 0){
            
                zkSignature.save();
    
                var assinaturaGerada = $("#saveSignature").attr("src");
    
                $("textarea[name='assinatura-assinatura_digital_titular'").val(assinaturaGerada);

                $("textarea[name='assinatura-assinatura_digital_titular'").prop("disabled", false);
    
                $(".assinatura-atual img").attr("src", assinaturaGerada);
    
                $(".box-gerar-assinatura").fadeOut(
                    function(){
    
                        $(".box-visualizar-assinatura").fadeIn();
    
                    }
                );

            }

            setTimeout(
                function(){

                $.validarCampos(form, url);

                },1000
            );

        }else{

            $.validarCampos(form, url);

        }

    });

});

function iniciarCadastro(){

    if($(".iniciar-cadastro").length > 0){

        var id_usuario = $(".iniciar-cadastro").attr("id_usuario");
        var id_plano = $(".iniciar-cadastro").attr("id_plano");
        
        $.post(
            "action.php",
            {id_usuario:id_usuario, id_plano:id_plano, action:"iniciarCadastro"},
            function(response){

                if(response.salvo){

                    location.reload();

                }

            },"json"
        );

    }
    
}

function navegacaoArea(){

    setTimeout(
        
        function(){

            $(".box-navegacao-cadastro-assinatura .item-area.ativo a").click();

            if($(".box-navegacao-cadastro-assinatura .item-area.ativo").length == 0){

                $(".box-navegacao-cadastro-assinatura .item-area:not('.marcado') a").click();

            }

        },100
    );

    $(".box-navegacao-cadastro-assinatura").on("click", ".item-area.marcado a, .item-area:not('.marcado'):eq(0) a", function(evt){

        evt.stopImmediatePropagation();

        var box = $(this).attr("box");

        $(".box-campos input, .box-campos select").prop("disabled",true);

        if(!$(this).hasClass("ativo")){

            $(".box-navegacao-cadastro-assinatura .item-area.ativo").removeClass("ativo");

            $(this).parent().addClass("ativo");

            $(".box-campos").hide(

                function(){

                    $("."+box).show();

                    $("."+box+" input, ."+box+" select").prop("disabled",false);

                }

            );

        }

    });

}

function andamentoPreenchimento(){

    $(".box-navegacao-cadastro-assinatura .item-area").each(function(){

        var obj = $(this);

        var box = obj.children("a").attr("box");

        var totalPreenchidos = 0;

        var totalObrigatorio = 0;

        var totalObrigatorioPreenchidos = 0;

        $("."+box+" .campo").each(function(){

            if($(this).parents(".box-cadastro-dependentes").length == 0){

                if($(this).val() != ""){

                    totalPreenchidos++;

                }

                if($(this).hasClass("validar")){

                    totalObrigatorio++;

                    if($(this).val() != ""){

                        totalObrigatorioPreenchidos++;

                    }

                }

            }

        });

        
    });

    ativarCampos();

}

function ativarCampos(){

    var total_itens = $(".box-navegacao-cadastro-assinatura .item-area").length;

    var total_marcador = $(".box-navegacao-cadastro-assinatura .item-area.marcado").length;

    var total_ativo = $(".box-navegacao-cadastro-assinatura .item-area.ativo").length;

    if(total_itens == total_marcador && total_ativo == 0){

        $(".box-navegacao-cadastro-assinatura .item-area:last-child").addClass("ativo");

        var boxView = $(".box-navegacao-cadastro-assinatura .item-area:last-child").children("a").attr("box");

        $("."+boxView).show();

    }

    $(".box-navegacao-cadastro-assinatura .item-area").each(function(){

        var obj = $(this);

        var box = obj.children("a").attr("box");

        if(obj.hasClass("ativo")){

            $("."+box+" input, ."+box+" select, ."+box+" textarea").prop("disabled",false);

        }else{

            $("."+box+" input, ."+box+" select, ."+box+" textarea").prop("disabled",true);

        }

    });

}

function exibirPlanos(){

    var labelBtn = "";

    $(".exibirPlanos").click(function(){

        if($(this).hasClass("ativo")){

            $(this).text(labelBtn);
            
            $(".box-lista-planos").hide(
                function(){

                    $(".box-visualizar-plano-ativo").show();

                }
            );

            $(this).removeClass("ativo");

        }else{

            labelBtn = $(this).text();

            $(this).text("Ocultar planos");

            $(".box-visualizar-plano-ativo").hide(
                function(){

                    $(".box-lista-planos").show();

                }
            );

            $(this).addClass("ativo");

        }

    });

}

function filtroPlano(){

    $("select[name='filtro_plano'").change(function(){

        var valor = $(this).val();

        if(valor == "" || valor == 0){

            $(".box-lista-planos .botao-plano").parent().show();

        }else if(valor > 0){

            $(".box-lista-planos .botao-plano").parent().hide();

            $(".box-lista-planos .botao-plano[tipo_plano='"+valor+"']").parent().show();

        }

    });
}

function selecionarPlano(){

    //AÇÃO SELECIONAR PLANO

    $(".box-lista-planos .botao-plano").click(function(){

        if($(this).hasClass("ativo")){

            var id_plano = "";

            var plano = "";

            var valor = "";

            var parcelas = "";

            var pontos = "";

            var adesao = "";

            var valor_adesao = "";

            var valor_vida_adicional = "";

            var degustacao = "";

            var descricao_plano = "";

            var tipo_plano = "";

            var vidas_min = "";

            var vidas_max = "";

            var tipo_pessoa = "";

            var tipo_cobranca_cartao = "";

            $(this).removeClass("ativo");

        }else{

            $(".box-lista-planos .botao-plano.ativo").removeClass("ativo");

            $(this).addClass("ativo");

            var id_plano = $(this).attr("id_plano");

            var parcelas = $(this).attr("parcelas");

            var pontos = $(this).attr("pontos");

            var adesao = $(this).attr("adesao");

            var valor_adesao = $(this).attr("valor_adesao");

            var valor_vida_adicional = $(this).attr("valor_vida_adicional");

            var degustacao = $(this).attr("degustacao");

            var tipo_plano = $(this).attr("tipo_plano");

            var vidas_min = $(this).attr("vidas_min");

            var vidas_max = $(this).attr("vidas_max");

            var tipo_cobranca_cartao = $(this).attr("tipo_cobranca_cartao");

            var plano = $(this).find(".botao-plano-titulo").text();

            var valor = $(this).find(".botao-plano-valor").attr("valor");

            var descricao_plano = $(this).find(".botao-plano-descricao").text();

            if(tipo_plano == 3){

                var tipo_pessoa = 1;

            }else{

                var tipo_pessoa = 0;

            }

        }


        $("input[name='assinatura-id_plano']").val(id_plano);

        $("input[name='assinatura-plano']").val(plano);

        $("input[name='assinatura-valor']").val(valor);

        $("input[name='assinatura-parcelas']").val(parcelas);

        $("input[name='assinatura-pontos']").val(pontos);

        $("input[name='assinatura-adesao']").val(adesao);

        $("input[name='assinatura-valor_adesao']").val(valor_adesao);

        $("input[name='assinatura-valor_vida_adicional']").val(valor_vida_adicional);

        $("input[name='assinatura-degustacao']").val(degustacao);

        $("input[name='assinatura-descricao_plano']").val(descricao_plano);

        $("input[name='assinatura-tipo_plano']").val(tipo_plano);

        $("input[name='assinatura-vidas_min']").val(vidas_min);

        $("input[name='cliente-tipo_pessoa']").val(tipo_pessoa);

        $("input[name='assinatura-vidas_max']").val(vidas_max);

        $("input[name='assinatura-tipo_cobranca_cartao']").val(tipo_cobranca_cartao);

        if(tipo_plano == 3){

            $(".box-selecao-plano-empresa .campo-empresa:not('.campo')").addClass("campo");

            $(".box-selecao-plano-empresa .campo-empresa:not('.validar')").addClass("validar");

            $(".box-selecao-plano-empresa .campo-outros.campo").removeClass("campo");

            $(".box-selecao-plano-empresa .campo-outros.validar").removeClass("validar");

            $(".box-selecao-plano-empresa:hidden").show();

        }else{

            $(".box-selecao-plano-empresa .campo-outros:not('.campo')").addClass("campo");

            $(".box-selecao-plano-empresa .campo-outros:not('.validar')").addClass("validar");

            $(".box-selecao-plano-empresa .campo-empresa.campo").removeClass("campo");

            $(".box-selecao-plano-empresa .campo-empresa.validar").removeClass("validar");

            $(".box-selecao-plano-empresa:visible").hide();

        }

    });

    //SELECIONAR PLANO AUTOMATICAMENTE

    if($(".box-lista-planos .botao-plano").length == 1 && $(".box-lista-planos .botao-plano.ativo").length == 0){

        $(".box-lista-planos .botao-plano").trigger("click");

    }

}

function gerenciarStatus(){

   // $(".box-selecao-status-assinatura").children("a").click(function(){

    $(".conteudoInterno").on("click",".box-selecao-status-assinatura a", function(){

        var box_lista = $(this).parent().find(".lista-status");

        var linha = $(this).parents("tr").index();

        if(box_lista.is(":visible")){

            box_lista.fadeOut("fast");

            $("table tbody tr .box-embassar").remove();

        }else{

            box_lista.fadeIn("fast");

            $("table tbody tr").not("tr:eq("+linha+")").append("<div class='box-embassar'></div>");

        }

    });


    /*ALTERAR STATUS*/

    $(".conteudoInterno").on("click",".box-selecao-status-assinatura .lista-status a", function(){

        var obj = $(this);

        var botaoClose = obj.parents(".box-selecao-status-assinatura").children("a");

        var status = obj.attr("status");

        var id = obj.parents("tr").attr("id_item");

        var campo = "assinatura-status%%:%%"+status;

        if(typeof id == typeof undefined){

            var id = $("input[name='id']").val();

            var id_dependente = obj.parents("tr").attr("id_dependente");

            var campo = "dependente-id%%:%%"+id_dependente+"%%,%%dependente-status%%:%%"+status;

        }
        
        if(status != "" && id != ""){

            $.post(
                "modulos/assinaturas/action.php",
                {id:id, campos:campo, action:"edit"},
                function(response, status){

                    if(status == "success"){

                        $("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();

                        setTimeout(
                            function(){

                                $("body .alertaMsg").fadeOut(
                                    function(){

                                        $("body .alertaMsg").remove();

                                    }
                                )

                            },1000
                        )

                        if(response.erro){	

                            botaoClose.click();

                        }else{

                            if($(".modalTl").is(":visible")){

                                $.post(
                                    "modulos/assinaturas/action.php",
                                    {id:id_dependente,action:"carregarStatusDependenteEletivo"},
                                    function(response, status){
                    
                                        if(status == "success"){
                    
                                            if(response.salvo){

                                                //console.log(response.status);

                                                obj.parents("td").html(response.status);

                                                $(".lista-dependentes table tbody tr .box-embassar").remove();
                                            }

                                        }

                                    },"json"

                                );

                            }else{

                                $(".conteudoInterno .box-conteudo .btn-acao-title-page a.atualizar").click();

                            }

                        }

                    }

                },"json"

            );

        }

    });

}

function assinaturaDigital(){

    if($(".box-gerar-assinatura #wrapper #canvas").length > 0){
 
        setTimeout(
            function(){

                zkSignature.capture(); 

            },1000
        );   
     
 
         $("a.salvar-assinatura-digital").click(function(){
 
             zkSignature.save();
 
             var assinaturaGerada = $("#saveSignature").attr("src");
 
             $("textarea[name='assinatura-assinatura_digital_titular'").val(assinaturaGerada);
 
             $(".assinatura-atual img").attr("src", assinaturaGerada);
 
             $(".box-gerar-assinatura").fadeOut(
                 function(){
 
                     $(".box-visualizar-assinatura").fadeIn();
 
                 }
             );
 
         });
 
         $("a.limpar-assinatura-digital").click(function(){
 
             zkSignature.clear();
 
         });
 
         $("a.excluir-assinatura-digital").click(function(){
 
             $(".ui-helper-hidden-accessible").remove();
 
             $("#canvas canvas").remove();

             $(".box-gerar-assinatura .action-assinatura .cancelar-alteracao-assinatura").show();
 
             $(".box-visualizar-assinatura").fadeOut(
                 function(){
 
                     $(".box-gerar-assinatura").fadeIn(function(){
 
                         zkSignature.capture();
 
                         $(".assinatura-atual").fadeIn();
 
                     });
 
                 }
             );
 
         });
 
         $("a.cancelar-alteracao-assinatura").click(function(){
 
             zkSignature.clear();
 
             $(".box-gerar-assinatura").fadeOut(
                 function(){
 
                     $(".box-visualizar-assinatura").fadeIn();
 
                 }
             );
 
         });
 
    }
 
 }

 function responsaveisEmpresa(){

    /*ADICIONAR NOVO RESPONSÁVEL*/

    $(".box-campos.box-selecao-titular .box-conteudo .add-novo-responsavel").click(function(){

        var box = $(this).parents(".box-conteudo");
        
        box.clone().appendTo(".box-responsavel-adicional");

        $(".box-responsavel-adicional .box-conteudo:last-child").hide();

        $(".box-responsavel-adicional .box-conteudo:last-child input").val("");

        $(".box-responsavel-adicional .box-conteudo:last-child .title-page a.add-novo-responsavel").addClass("remove-responsavel").removeClass("add-novo-responsavel");

        $(".box-responsavel-adicional .box-conteudo:last-child .title-page a.remove-responsavel").addClass("btn-danger").removeClass("btn-default");

        $(".box-responsavel-adicional .box-conteudo:last-child .title-page a.remove-responsavel").html('<span class="glyphicon glyphicon-trash"></span> <span>Excluir responsável</span>');

        $(".box-responsavel-adicional .box-conteudo:last-child .title-page:eq(0)").append(" <span class='posicao'></span>");

        contarPosicaoResponsavel();

        $(".box-responsavel-adicional .box-conteudo:last-child input").each(function(){

            var name = $(this).attr("name");

            var novoName = name.replace("cliente", "responsavel");

            $(this).attr("name",  novoName);

        });

        var id_assinatura = $("input[name='id']").val();

        $(".box-responsavel-adicional .box-conteudo:last-child").prepend("<input name='responsavel-id_assinatura' type='hidden' class='campo' value='"+id_assinatura+"'>");

        $(".box-responsavel-adicional .box-conteudo:last-child").fadeIn();

    });

    /*EXCLUIR RESPONSÁVEL*/

    $(".box-campos.box-selecao-titular").on("click",".box-conteudo .remove-responsavel",function(){

        var box = $(this).parents(".box-conteudo");

        var confirmacao = '<div class="bg-box-confirm"><div class="box-confirm" style="display:none;">Confirmar a exclusão desse responsável?<div  class="box-confirm-acao"><a href="javascript:void(0);" class="btn btn-default sim">Sim</a><a href="javascript:void(0);" class="btn btn-default nao">Não</a></div></div></div>';
        
        box.append(confirmacao);

        box.find(".box-confirm").fadeIn();

    });

    /*CANCELAR EXCLUSÃO RESPONSÁVEL*/

    $(".box-campos.box-selecao-titular").on("click",".box-conteudo .bg-box-confirm .box-confirm-acao a.nao",function(){

        var box = $(this).parents(".bg-box-confirm");

        box.fadeOut(
            function(){

                box.remove();

            }
        );

    });

    /*CONFIRMAR EXCLUSÃO RESPONSÁVEL*/

    $(".box-campos.box-selecao-titular").on("click",".box-conteudo .bg-box-confirm .box-confirm-acao a.sim",function(){

        var box = $(this).parents(".box-conteudo");

        if(box.find("input[name='responsavel-id']").length > 0){

            var id = box.find("input[name='responsavel-id']").val();

            $.post(
                "modulos/assinaturas/action.php",
                {id:id, action:"excluirResponsavelEmpresaAdicional"},
                function(response){
//console.log(response);
                    if(response.erro){

                        box.find(".box-confirm").html("<div class='retornoFormfalse'>"+response.mensagem+"</div>");

                        setTimeout(
                            function(){

                                box.find(".bg-box-confirm").fadeOut(
                                    function(){

                                        box.find(".bg-box-confirm").remove();

                                    }
                                ); 

                            },2000
                        )

                    }else{

                        box.fadeOut(
                            function(){
            
                                box.remove();

                                $("input[name='responsavel_anexo-id'][value='"+id+"']").parents(".form-group").remove();
            
                                contarPosicaoResponsavel();
            
                            }
                        );

                    }

                },"json"
            );

        }else{

            box.fadeOut(
                function(){

                    box.remove();

                    contarPosicaoResponsavel();

                }
            );

        }

    });

 }

 function contarPosicaoResponsavel(){

    var contador = 2;

    $(".box-campos.box-selecao-titular .box-responsavel-adicional .box-conteudo").each(function(){

        $(this).find(".title-page").find(".posicao").text(contador);

        contador++;

    });

 }

 function dependentes(){

    $(".menu-aba-dependentes").on("click", "a",function(){

        var obj = $(this);

        if(!obj.hasClass("ativo")){

            obj.parent().find(".ativo").removeClass("ativo");

            obj.addClass("ativo");

            var box = obj.attr("box");

            $(".box-cadastro-dependentes:visible").hide();

            $(".box-cadastro-dependentes:not('."+box+"') input").prop("disabled", true);

            $(".box-cadastro-dependentes."+box).show();

            $(".box-cadastro-dependentes."+box+" input").prop("disabled", false);

        }


    });

    /*MONTAR EDIÇÃO DEPENDENTES*/

    $(".lista-dependentes table tbody").on("click", "a.editar-dependente", function(){
        
        var linha = $(this).parents("tr");

        var id = linha.find(".dependente_id").text();

        var nome = linha.find(".dependente_nome").text();

        var email = linha.find(".dependente_email").text();

        var telefone = linha.find(".dependente_telefone").text();

        var telefone_ddi = linha.find(".dependente_telefone_ddi").text();

        var nascimento = linha.find(".dependente_nascimento").text();

        var nome_mae = linha.find(".dependente_nome_mae").text();

        var rg = linha.find(".dependente_rg").text();

        var cpf = linha.find(".dependente_cpf").text();

        var sexo = linha.find(".dependente_sexo").text();        

        if(sexo == "Feminino"){

            sexo = 0;

        }else if(sexo == "Masculino"){

            sexo = 1;

        }

        var cep = linha.find(".dependente_cep").text();

        var endereco = linha.find(".dependente_endereco").text();

        var numero = linha.find(".dependente_numero").text();

        var complemento = linha.find(".dependente_complemento").text();

        var bairro = linha.find(".dependente_bairro").text();

        var cidade = linha.find(".dependente_cidade").text();

        var estado = linha.find(".dependente_estado").text();

        if($(".box-selecao-dependentes .menu-aba-dependentes a[box='individual'].ativo").length == 0){

            $(".box-selecao-dependentes .menu-aba-dependentes a[box='individual']").click();

        }

        var box = $(".box-cadastro-dependentes.individual");

        box.find("input[name='dependente-nome']").val(nome);

        box.find("input[name='dependente-email']").val(email);

        box.find("input[name='dependente-telefone']").val(telefone);

        box.find("input[name='dependente-telefone_ddi']").val(telefone_ddi);

        box.find("input[name='dependente-nascimento']").val(nascimento);

        box.find("input[name='dependente-nome_mae']").val(nome_mae);

        box.find("input[name='dependente-rg']").val(rg);

        box.find("input[name='dependente-cpf']").val(cpf);

        box.find("select[name='dependente-sexo'] option:selected").prop("selected", false);

        box.find("select[name='dependente-sexo'] option[value='"+sexo+"']").prop("selected", true);

        if(typeof cep !== typeof undefined){

            box.find("input[name='dependente-cep']").val(cep);

            box.find("input[name='dependente-endereco']").val(endereco);

            box.find("input[name='dependente-numero']").val(numero);

            box.find("input[name='dependente-complemento']").val(complemento);

            box.find("input[name='dependente-bairro']").val(bairro);

            box.find("input[name='dependente-cidade']").val(cidade);

            box.find("select[name='dependente-estado'] option:selected").prop("selected", false);

            box.find("select[name='dependente-estado'] option[value='"+estado+"']").prop("selected", true);

        }

        if(box.find("input[name='dependente-id']").length == 0){

            box.append("<input type='hidden' name='dependente-id' class='campo' value='"+id+"'>");

        }else{

            box.find("input[name='dependente-id']").val(id);

        }

        $(".box-btn-action-epedentes a.salvar").children(".text-add").text("Atualizar vida");

        $(".box-btn-action-epedentes a.cancelar-edicao").show();

    });

    /*CANCELAR EDIÇÃO */

    $(".box-btn-action-depedentes").on("click", "a.cancelar-edicao", function(){

        var box = $(".box-cadastro-dependentes.individual");

        box.find("select option:selected").prop("selected", false);

        box.find("input").val("");

        box.find("input[name='dependente-id']").remove();

        $(".box-btn-action-epedentes a.salvar").children(".text-add").text("Adicionar vida");

        $(this).hide();

    });

    /*CONCLUIR CADASTRo DEPENDENTES E AVANÇAR*/

    $(".box-avancar-dependentes").on("click", "a.avancar", function(){

        var box = $(".box-cadastro-dependentes.individual");

        box.find("input").val("").prop("disabled", true);

        box.find("select").val("").prop("disabled", true);

        $(".box-selecao-dependentes input[name='assinatura-dependentes_concluido']").val(1);

        $(".box-btn-action-depedentes a.salvar").click();

    });

    /*OPEN CONFIRMAÇÃO EXCLUSÃO */

    $(".lista-dependentes table tbody").on("click", "a.excluir-dependente", function(){

        var obj = $(this);

        var id = obj.attr("id");

        var nome = obj.attr("nome");

        var cpf = obj.attr("cpf");

        $(".modal#modalExclusaoDependente input[name='id_dependente']").val(id);

        $(".modal#modalExclusaoDependente input[name='nome_dependente']").val(nome);

        $(".modal#modalExclusaoDependente input[name='cpf_dependente']").val(cpf);

    });

    //CONFIRMAR EXCLUSÃO

    $(".modal#modalExclusaoDependente .modal-footer a.confirmar-exclusao-dependente").click(function(evt){

        evt.stopImmediatePropagation();

        var obj = $(this);

        var id = obj.parents(".modal").find(".modal-body").find("input[name='id_dependente']").val();

        var id_assinatura = $("input[name='id']").val();

        var linha = $(".lista-dependentes table tbody tr[id_dependente='"+id+"']");

        $.post(
            "action.php",
            {id:id, id_assinatura:id_assinatura, action:"excluirdependente"},
            function(response){

                obj.parent().find("button").click();

                $("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();

                if($(".conteudo .loading").length == 0){

                    $(".conteudo").prepend("<div class='loading'></div>");
            
                }

                if(response.erro){	

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });
                    
                }else{

                    linha.fadeOut(
                        function(){
                            linha.remove();
                        }
                    );

                    contadorVidas();

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });

                }

                setTimeout(
                    function(){

                        $(".alertaMsg").fadeOut(function(){

                            $(".alertaMsg").remove();

                        });

                    },2000
                );

            },"json"
        );

        

    });

    /*OPEN CONFIRMAÇÃO MULTIPLAS EXCLUSÕES */

    $(".box-selecao-dependentes").on("click", "a.excluir-dependentes-selecionados:not('.disabled')", function(){

        var obj = $(this);

        var id_assinatura = obj.attr("id_assinatura");

        setTimeout(

            function(){

                $(".modal#modalExclusaoDependentesSelecionados .id_assinatura").text(id_assinatura);

            },100
        );

    });

    //CONFIRMAR MULTIPLAS EXCLUSÕES

    $(".modal#modalExclusaoDependentesSelecionados .modal-footer a.confirmar-exclusao-dependentes-selecionados").click(function(evt){

        evt.stopImmediatePropagation();

        var obj = $(this);

        var id_assinatura = $("input[name='id']").val();

        var vidas = [];

        $(".lista-dependentes table tbody input[type='checkbox'][name='campo']:checked").each(function(){

            var id = $(this).parents("tr").attr("id_dependente");

            vidas.push(id);

        });

        if(vidas.length > 0){

            $.post(
                "modulos/assinaturas/action.php",
                {id_assinatura:id_assinatura, vidas:vidas, action:"excluirDependentesSelecionados"},
                function(response){

                    //console.log(response);

                    obj.parent().find("button").click();

                    $("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();

                    if($(".conteudo .loading").length == 0){

                        $(".conteudo").prepend("<div class='loading'></div>");
                
                    }

                    if(response.erro){	

                        $(".conteudo .loading").fadeOut(function(){

                            $(".conteudo .loading").remove();

                        });
                        
                    }else{

                        if(response.linha.length > 0){

                            for(i = 0; i < response.linha.length; i++){

                                $(".lista-dependentes table tbody tr[id_dependente='"+response.linha[i]+"']").fadeOut(
                                    function(){
                                        $(this).remove();
                                    }
                                );

                            }

                        }

                        contadorVidas();

                        $(".conteudo .loading").fadeOut(function(){

                            $(".conteudo .loading").remove();

                        });

                    }

                    setTimeout(
                        function(){

                            $(".alertaMsg").fadeOut(function(){

                                $(".alertaMsg").remove();

                            });

                        },2000
                    );

                },"json"
            );

        }

    });

    /*OPEN CONFIRMAÇÃO RESET ASSINATURA E TERMO DE ADESÃO */

    $(".lista-dependentes table tbody").on("click", "a.resetar-assinatura-dependente", function(){

        var obj = $(this);

        var id = obj.attr("id");

        var nome = obj.attr("nome");

        var cpf = obj.attr("cpf");

        $(".modal#modalResetarAssinaturaDependente input[name='id_dependente']").val(id);

        $(".modal#modalResetarAssinaturaDependente input[name='nome_dependente']").val(nome);

        $(".modal#modalResetarAssinaturaDependente input[name='cpf_dependente']").val(cpf);

    });

    //CONFIRMAR RESET ASSINATURA E TERMO DE ADESÃO

    $(".modal#modalResetarAssinaturaDependente .modal-footer a.confirmar-reset-assinatura-dependente").click(function(evt){

        evt.stopImmediatePropagation();

        var obj = $(this);

        var id = obj.parents(".modal").find(".modal-body").find("input[name='id_dependente']").val();

        var id_assinatura = $("input[name='id']").val();

        var linha = $(".lista-dependentes table tbody tr[id_dependente='"+id+"']");

        $.post(
            "modulos/assinaturas/action.php",
            {id:id, id_assinatura:id_assinatura, action:"resetarAssinaturaETermoDependente"},
            function(response){

                obj.parent().find("button").click();

                $("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();

                if($(".conteudo .loading").length == 0){

                    $(".conteudo").prepend("<div class='loading'></div>");
            
                }

                if(response.erro){	

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });
                    
                }else{

                    linha.find(".modal-assinatura-dependente").find(".texto-btn-assinatura").text("Adicionar assinatura");

                    linha.find(".modal-assinatura-dependente.assinatura-confirmada").removeClass("assinatura-confirmada");

                    linha.find(".menu-acao").find(".resetar-assinatura-dependente").remove();

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });

                }

                setTimeout(
                    function(){

                        $(".alertaMsg").fadeOut(function(){

                            $(".alertaMsg").remove();

                        });

                    },2000
                );

            },"json"
        );

        

    });

 }

 function contadorVidas(){

    setTimeout(
        function(){

            var totalVidas = $(".lista-dependentes table tbody tr").length;

            $(".vidas-atuais").html(totalVidas);

        },1000
    );

 }

 function uploadLote(){

	$(".box-selecao-dependentes .box-cadastro-dependentes.lote .box-form-upload-lista a.btn.upload-planilha").click(function(){

		var obj = $(this);

		var form_data = new FormData();           

		form_data.append('arquivo', $('#upload_lote').prop('files')[0]);
		form_data.append('tipo_upload', obj.attr("tipo_upload")); 
        form_data.append('action', 'uploadLote'); 

		$.ajax({
			url: 'modulos/assinaturas/action.php',
			dataType: 'json',//'text', 
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,  
			type: 'post',
			beforeSend:function(){
				obj.text('Enviando...');
			},
			success: function(data){

				//console.log(data);

				obj.text('Fazer upload');

				obj.parents(".box-form-upload-lista").find("input[type='file']").val("");

				if(!data.erro){

					obj.parents(".box-form-upload-lista").hide();

					obj.parents(".box-form-upload-lista").next($(".lista-dependentes-upload-lote")).html(data.lista);

					var linha = $(".lista-dependentes-upload-lote table tbody tr");  
					
					linha.each(function(){

						var nome = replaceSpecialChars($(this).children("td:eq(1)").children("input[name='dependente-nome']").val());

						nome = nome.split(" ");

						$(this).attr("nome", nome[0]);

					}); 

					var novosElementos = linha.get().sort(function (a, b) {
						
						if(a.getAttribute('nome').toString().charCodeAt(0) == b.getAttribute('nome').toString().charCodeAt(0)){ // se as letras forem iguais

							if(a.getAttribute('nome').toString().charCodeAt(1) == b.getAttribute('nome').toString().charCodeAt(1)){ // se as letras forem iguais

								return a.getAttribute('nome').toString().charCodeAt(2) - b.getAttribute('nome').toString().charCodeAt(2);

							}

							return a.getAttribute('nome').toString().charCodeAt(1) - b.getAttribute('nome').toString().charCodeAt(1);

						}

						return a.getAttribute('nome').toString().charCodeAt(0) - b.getAttribute('nome').toString().charCodeAt(0);

					}).map(function(el){

						return $(el).clone(true)[0];

					});
					
					linha.parent().html(novosElementos);

                    verificarImportacaoDisponivel();

                    verificarDuplicados();

                    ativarBotaoUploadLote();

				}else{

					obj.parents(".box-form-upload-lista").find("input[type='file']").parent().append("<span class='erro'>"+data.mensagem+"</span>");

					setTimeout(
						
						function(){

							obj.parents(".box-form-upload-lista").find(".erro").remove();

						},3000
					
					);
					
				}
			}
		});

	});


	$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote").on("click", ".excluir-linha", function(){

		$(this).parents("tr").remove();

		var total = $(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote table tbody tr").length;

		if(total == 0){

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote").html("");

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .box-form-upload-lista").show();

		}else{

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote h5 .count-dependentes").text(total);

		}

        verificarImportacaoDisponivel();

		verificarDuplicados();

        ativarBotaoUploadLote();

	});

	$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote").on("change", ".box-select-acao select", function(){

		$(this).prop("selected", false);

		$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote").find("input[name='campo']:checked").parents("tr").remove();

        var total = $(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote table tbody tr").length;

		if(total == 0){

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote").html("");

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .box-form-upload-lista").show();

		}else{

			$(".box-selecao-dependentes .box-cadastro-dependentes.lote .lista-dependentes-upload-lote h5 .count-dependentes").text(total);

		}

        verificarImportacaoDisponivel();

		verificarDuplicados();

        ativarBotaoUploadLote();

	});

}

var specialChars = [
	{val:"a",let:"áàãâä"},
	{val:"e",let:"éèêë"},
	{val:"i",let:"íìîï"},
	{val:"o",let:"óòõôö"},
	{val:"u",let:"úùûü"},
	{val:"c",let:"ç"},
	{val:"A",let:"ÁÀÃÂÄ"},
	{val:"E",let:"ÉÈÊË"},
	{val:"I",let:"ÍÌÎÏ"},
	{val:"O",let:"ÓÒÕÔÖ"},
	{val:"U",let:"ÚÙÛÜ"},
	{val:"C",let:"Ç"},
	{val:"",let:"?!()/-"}
];

function replaceSpecialChars(str) {
	var $spaceSymbol = ' ';
	var regex;
	var returnString = str;
	for (var i = 0; i < specialChars.length; i++) {
		regex = new RegExp("["+specialChars[i].let+"]", "g");
		returnString = returnString.replace(regex, specialChars[i].val);
		regex = null;
	}
	return returnString.replace(/\s/g,$spaceSymbol).toLowerCase();
};

function verificarDuplicados(){
	
	$(".lista-dependentes-upload-lote h5 .duplicados").remove();

	var duplicado = [];

	var totalDuplicados = 0;
	
	$(".lista-dependentes-upload-lote table tbody tr").each(function(){

        var email = $(this).find("input[name='dependente-email']").val();

		var cpf = $(this).find("input[name='dependente-cpf']").val();

		if(duplicado.includes(email) || duplicado.includes(cpf)){

            $(this).find("input[name='campo']").prop("checked", true);

			totalDuplicados++;

		}else{

			duplicado.push(email);

            duplicado.push(cpf);

		}

	}); 

	if(totalDuplicados > 0){

		$(".lista-dependentes-upload-lote h5").append("<span class='duplicados' style='margin-left:15px;'><strong>"+totalDuplicados+"</strong> dependentes(s) duplicado(s)</span>");

	}

}

function ativarBotaoUploadLote(){

    if($(".box-cadastro-dependentes.lote").is(":visible")){

        var total = 0;

        $(".lista-dependentes-upload-lote table tbody tr").each(function(){

            if(!$(this).children("td:eq(1)").children("input").is(":disabled")){

                total++;

            }

        });

        if($(".lista-dependentes-upload-lote").is(":visible") && total > 0){

            $(".box-cadastro-dependentes.lote .title-page-bottom:hidden").show();

        }else{

            $(".box-cadastro-dependentes.lote .title-page-bottom:visible").hide();

        }


    }else{

        $(".box-cadastro-dependentes.lote .title-page-bottom:visible").hide();

    }


}

function checkboxAcaoLista(){

	$(".lista-dependentes-upload-lote").on("click", "table thead input[type='checkbox'][name='selecionarTodos']", function(){

		if($(this).is(":checked")){

			$(".lista-dependentes-upload-lote table tbody input[type='checkbox'][name='campo']").prop("checked", true);

		}else{

			$(".lista-dependentes-upload-lote table tbody input[type='checkbox'][name='campo']").prop("checked", false);

		}

	});

}

function verificarImportacaoDisponivel(){

    $(".lista-dependentes-upload-lote h5 .excedentes").remove();

    $(".lista-dependentes-upload-lote input.campo").prop("disabled", false);

    $(".lista-dependentes-upload-lote select.campo").prop("disabled", false);

    $(".lista-dependentes-upload-lote textarea.campo").prop("disabled", false);

    $(".lista-dependentes-upload-lote input[name='campo']").prop("checked", false);

    var vidas_atuais = parseInt($(".vidas-atuais").text());

    var vidas_totais = parseInt($(".vidas-totais").text());

    var vidas_disponiveis = vidas_totais - vidas_atuais;

    var total_vidas_importadas = $(".lista-dependentes-upload-lote table tbody tr").length;

    if(total_vidas_importadas > vidas_disponiveis){

        var contador = 1;

        var total_excedente = 0;

        $(".lista-dependentes-upload-lote table tbody tr").each(function(){
            
            if(contador > vidas_disponiveis){

                $(this).find("input.campo").prop("disabled", true);

                $(this).find("select.campo").prop("disabled", true);

                $(this).find("textarea.campo").prop("disabled", true);

                $(this).find("input[name='campo']").prop("checked", true);

                total_excedente++;

            }

            contador++;


        });

        if(total_excedente > 0){

            $(".lista-dependentes-upload-lote h5").append("<span class='excedentes' style='margin-left:15px;'><strong>"+total_excedente+"</strong> dependentes(s) excedentes(s)</span>");

        }

    }else{

        $(this).find("input.campo:disabled").prop("disabled", false);

        $(this).find("select.campo:disabled").prop("disabled", false);

        $(this).find("textarea.campo:disabled").prop("disabled", false);

    }

}

function checkboxAcaoListaDependentes(){

	$(".box-selecao-dependentes").on("click", ".lista-dependentes table thead input[type='checkbox'][name='selecionarTodos']", function(){

		if($(this).is(":checked")){

			$(".lista-dependentes table tbody input[type='checkbox'][name='campo']").prop("checked", true);

		}else{

			$(".lista-dependentes table tbody input[type='checkbox'][name='campo']").prop("checked", false);

		}

	});

}

function anexoDependente(){

    /*OPEN MODAL ANEXO */

    $(".lista-dependentes table tbody").on("click", "a.modal-anexo", function(){

        var id_dependente = $(this).parents("tr").find(".dependente_id").text();

        var nome_dependente = $(this).parents("tr").find(".dependente_nome").text();

        var cpf_dependente = $(this).parents("tr").find(".dependente_cpf").text();

        $("#modalDependentes .modal-body form input[name='id_dependente']").val(id_dependente);

        $("#modalDependentes .modal-body form input[name='nome_dependente']").val(nome_dependente);

        $("#modalDependentes .modal-body form input[name='cpf_dependente']").val(cpf_dependente);

        $(this).parents("tr").not($(".ativo")).addClass("ativo");

    });

    /*OPEN CONFIRMAÇÃO EXCLUSÃO */

    $(".lista-dependentes table tbody").on("click", "a.excluir-anexo", function(){

        var box_confirm_exclusao = $(this).parent().parent().find(".box-confirmar-exclusao-anexo");

        var linha = $(this).parents("tr").index();

        if(box_confirm_exclusao.is(":visible")){

            box_confirm_exclusao.fadeOut("fast");

            $(".lista-dependentes table tbody tr .box-embassar").remove();

        }else{

            box_confirm_exclusao.fadeIn("fast");

            $(".lista-dependentes table tbody tr").not("tr:eq("+linha+")").append("<div class='box-embassar'></div>");

        }

    });

    //CANCELAR EXCLUSÃO

    $(".lista-dependentes table tbody").on("click", ".box-confirmar-exclusao-anexo a.cancelar-exclusao-anexo", function(){

        var box_confirm_exclusao = $(this).parent().parent().find(".box-confirmar-exclusao-anexo");

        box_confirm_exclusao.fadeOut("fast");

        $(".lista-dependentes table tbody tr .box-embassar").remove();

    });

    //CONFIRMAR EXCLUSÃO

    $(".lista-dependentes table tbody").on("click", ".box-confirmar-exclusao-anexo a.confirmar-exclusao-anexo", function(){

        var linha = $(this).parents("tr");

        var id = $(this).attr("id");

        var arquivo = $(this).attr("arquivo");

        var id_assinatura = $("input[name='id']").val();

        if($(".conteudo .loading").length == 0){

            $(".conteudo").prepend("<div class='loading'></div>");
    
        }

        $.post(
            "modulos/assinaturas/action.php",
            {id:id, id_assinatura:id_assinatura, arquivo:arquivo, action:"excluirAnexoDepndente"},
            function(response){

                $("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();

                if(response.erro){	

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });
                    
                }else{

                    linha.children("td:eq(5)").html(response.botao);

                    $(".lista-dependentes table tbody tr .box-embassar").remove();

                    $(".conteudo .loading").fadeOut(function(){

                        $(".conteudo .loading").remove();

                    });

                }

                setTimeout(
                    function(){

                        $(".alertaMsg").fadeOut(function(){

                            $(".alertaMsg").remove();

                        });

                    },2000
                );

            },"json"
        )

    });

}

function ativarBoxAssinatura(){

    $(".ativar-box-assinatura a").click(function(){

        if($(this).hasClass("sim")){

            $(".envio_email").fadeOut(

                function(){

                    $(".assinatura_view").fadeIn();


                }

            );

           
        }else  if($(this).hasClass("nao")){

            $(".assinatura_view").fadeOut(

                function(){

                    $(".envio_email").fadeIn();


                }

            );

        }

    });
}

function assinaturaDependente(){

    /*OPEN MODAL ASSINATURA */

    $(".lista-dependentes table tbody").on("click", "a.modal-assinatura-dependente", function(){

        var id_dependente = $(this).parents("tr").find(".dependente_id").text();

        var nome_dependente = $(this).parents("tr").find(".dependente_nome").text();

        var cpf_dependente = $(this).parents("tr").find(".dependente_cpf").text();

        $("#modalDependentesAssinatura .modal-body form input[name='id_dependente']").val(id_dependente);

        $("#modalDependentesAssinatura .modal-body form input[name='nome_dependente']").val(nome_dependente);

        $("#modalDependentesAssinatura .modal-body form input[name='cpf_dependente']").val(cpf_dependente);

        $(this).parents("tr").not($(".ativo")).addClass("ativo");

        var id_assinatura = $(this).parents(".lista-dependentes").attr("id_assinatura");

        var id_contrato = $(this).parents(".lista-dependentes").attr("id_contrato");

        //console.log(id_assinatura+" - "+id_contrato);

        $.post(
            "modulos/assinaturas/action.php",
            {id:id_dependente, action:"verificarAssinaturaDependente"},
            function(response){

                $("#modalDependentesAssinatura .modal-body .box-assinatura-dependente").html(response.assinatura); 

                $("#modalDependentesAssinatura .modal-body .termo-adesao-dependente").html(response.termo_adesao); 

                if(id_assinatura != "" && id_assinatura > 0 && id_contrato != "" && id_contrato > 0){

                    $("#modalDependentesAssinatura .modal-body .visualizar-contrato").html('<a href="javascript:void(0);" class="btn btn-default open-impressao" id_contrato="'+id_contrato+'" id_assinatura="'+id_assinatura+'"  id_dependente_contrato="'+id_dependente+'">Visualizar contrato</a>');

                }



            },"json"
        );

    });

}

function enviarSolicitacaoAceite(){

    $(".enviar-email").click(function(){

        var obj = $(this);

        var legenda = obj.children(".texto").text();

        var nome = obj.attr("nome");

        var email = obj.attr("email");

        var info = $(this).attr("info");

        var mensagem = "Olá "+nome+"!<br>";
            mensagem += "Seja bem vindo(a) a <strong>AZO Benefícios</strong>!<br>";
            mensagem += "Para conclusão da sua adesão é necessário que acesse o link abaixo para confirmação de aceite do termo de adesão e escrever sua assinatura digital.<br>";
            mensagem += "<strong>Acesse o link abaixo:</strong><br>";
            mensagem += info;

        obj.children(".texto").text("Enviando...");    

        if(nome != "" && email != "" && info != ""){

            $.post(
                "modulos/assinaturas/action.php",
                {nome:nome, email:email, mensagem:mensagem, action:"enviarEmailSolicitacaoAceiteAdesao"},
                function(response){

                    obj.children(".texto").text(legenda);

                    if(response.erro){

                        obj.append("<div class='enviado'>Falha no envio!</div>");
                        
                    }else{

                        obj.append("<div class='enviado'>Enviado!</div>");

                    }

                    obj.parent().find(".enviado").fadeIn();
                    
                    setTimeout(
                        function(){
                
                            obj.parent().find(".enviado").fadeOut(function(){
                
                                obj.parent().find(".enviado").remove();
                
                            });
                
                        },2000
                    );

                },"json"

            );

        }else{

            obj.children(".texto").text(legenda);

            obj.append("<div class='enviado'>Falha no envio!</div>");
    
            obj.parent().find(".enviado").fadeIn();
        
            setTimeout(
                function(){
        
                    obj.parent().find(".enviado").fadeOut(function(){
        
                        obj.parent().find(".enviado").remove();
        
                    });
        
                },1000
            );

        }

    });
    
    $(".enviar-whatsapp").click(function(){

        var nome = $(this).attr("nome");;

        var whatsapp = $(this).attr("whatsapp");

        var info = $(this).attr("info");

        var mensagem = "Olá "+nome+"!%0A";
            mensagem += "Seja bem vindo(a) a *AZO Benefícios*!%0A";
            mensagem += "Para conclusão da sua adesão é necessário que acesse o link abaixo para confirmação de aceite do termo de adesão e escrever sua assinatura digital.%0A";
            mensagem += "*Acesse o link abaixo:*%0A";
            mensagem += info;

        var url = "https://web.whatsapp.com/send/?phone="+whatsapp+"&text="+mensagem;

        window.open(url,"_blank");

    });

    
	$(".copiar").click(function(){
  
        var obj = $(this);
    
        var info = obj.attr("info");
    
        if(typeof info !== typeof undefined){
    
            var texto = info;
    
        }else{
    
            var texto = obj.html();
    
        }
    
        if(obj.parent().find(".copiar-conteudo").length == 0){
    
            obj.parent().append("<input type='text' class='copiar-conteudo' value='"+texto+"'>");
    
        }
    
        $(".copiar-conteudo").select();
    
        document.execCommand('copy');
    
        $(".copiar-conteudo").remove();
    
        obj.append("<div class='copiado'>Copiado!</div>");
    
        obj.parent().find(".copiado").fadeIn();
    
        setTimeout(
            function(){
    
                obj.parent().find(".copiado").fadeOut(function(){
    
                    obj.parent().find(".copiado").remove();
    
                });
    
            },1000
        );
    
        
    });

}

function buscar_dependentes(){

    if($(".box-buscar-dependentes").length > 0 && $(".box-buscar-dependentes input.buscar-dependentes").val() != ""){        

        var valor = removeAcento($(".box-buscar-dependentes input.buscar-dependentes").val());

        if(valor.length > 2){

            $(".box-buscar-dependentes a.limpar-busca").show();

            $(".lista-dependentes table tbody tr").hide();

            $(".lista-dependentes table tbody tr").each(function(){

                var info = removeAcento($(this).text());

                if(info.indexOf(valor) !== -1){

                    $(this).show();

                }

            });

        }

    };

    $(".box-buscar-dependentes input.buscar-dependentes").keyup(function(){

        var valor = removeAcento($(this).val());

        if(valor.length > 2){

            $(".box-buscar-dependentes a.limpar-busca").show();

            $(".lista-dependentes table tbody tr").hide();

            $(".lista-dependentes table tbody tr").each(function(){

                var info = removeAcento($(this).text());

                if(info.indexOf(valor) !== -1){

                    $(this).show();

                }

            });

        }else{

            $(".lista-dependentes table tbody tr").show();

            $(".box-buscar-dependentes a.limpar-busca").hide();

        }

    });

    /*limpar busca*/

    $(".box-buscar-dependentes a.limpar-busca").click(function(){

        $(".lista-dependentes table tbody tr").show();

        $(this).parent().find("input").val("");

        $(this).hide();

    });

}

function removeAcento(strToReplace) {
    str_acento= ".-/";
    str_sem_acento = "";
    var nova="";
    for (var i = 0; i < strToReplace.length; i++) {
        if (str_acento.indexOf(strToReplace.charAt(i)) != -1) {
            nova+=str_sem_acento.substr(str_acento.search(strToReplace.substr(i,1)),1);
        } else {
            nova+=strToReplace.substr(i,1);
        }
    }
    return nova.toLowerCase();
}

/*function filtroStatus(){

    $("a.box-filtro-status").click(function(){


        if($(this).hasClass("ativo")){

            $(this).removeClass("ativo");

            var status = "";

        }else{

            $("a.box-filtro-status").removeClass("ativo");

            $(this).addClass("ativo");

            var status =  $(this).attr("situacao");

        }        

        $(".box-filtros input[name='status']").val(status);

        $(".box-filtros input[name='status']").focus().blur()

    });

}*/

function filtroStatus(){

    $("a.box-filtro-status").click(function(){


        if($(this).hasClass("ativo")){

            if($(this).hasClass("todos")){

                $(".box-filtros a.box-filtro-status.ativo").removeClass("ativo");

            }else{
                $(this).removeClass("ativo");

            }

        }else{

            if($(this).hasClass("todos")){

                $(".box-filtros a.box-filtro-status:not('.ativo')").addClass("ativo");

            }else{

                $(this).addClass("ativo");

            }

        }

        var status = "";

        $(".box-filtros a.box-filtro-status.ativo:not('.todos')").each(function(){

            var valor = $(this).attr("situacao");

            status += valor+",";

        });

        status = status.substring(0,(status.length-1));

        $(".box-filtros input[name='status']").val(status);

        $(".box-filtros input[name='status']").focus().blur();

    });

}

function selecionarEletivos(){


    if($(".lista-dependentes.box-plano-eletivo").length > 0){

        $(".lista-dependentes.box-plano-eletivo input[type='checkbox']").change(function(){

            verificarVidasSelecionadas();

            verificarVidasSelecionadasExclusao();

        });

    }else{

        $(".lista-dependentes input[type='checkbox']").change(function(){

            verificarVidasSelecionadasExclusao();

        });

    }

}

function verificarVidasSelecionadasExclusao(){

    var selecionados = 0;

    $(".lista-dependentes tbody tr").each(function(){

        if($(this).find("input[type='checkbox'][name='campo']").is(":checked")){

            selecionados++;

        }

    });

    if(selecionados > 0){

        $(".excluir-dependentes-selecionados.disabled").removeClass("disabled");

        $(".excluir-dependentes-selecionados.btn").removeClass("btn");
        
    }else{

        $(".excluir-dependentes-selecionados:not('.disabled')").addClass("disabled");

        $(".excluir-dependentes-selecionados:not('.btn')").addClass("btn");

    }

}
    

function verificarVidasSelecionadas(){

    var totalPendenciaAceite = 0;

    var totalPendenciaPagamento = 0;
    
    $(".lista-dependentes.box-plano-eletivo tbody tr").each(function(){

        if($(this).find("input[type='checkbox'][name='campo']").is(":checked")){

            if($(this).find(".modal-assinatura-dependente").hasClass("assinatura-confirmada")){

                totalPendenciaPagamento++;

            }else{

                totalPendenciaAceite++;

            }
            
        }

    });

    if(totalPendenciaAceite > 0){

        $(".enviar-link-adesao.disabled").removeClass("disabled");

        $(".enviar-link-adesao .texto-adicional").text("para "+totalPendenciaAceite+" vida(s) selecionada(s)");
        
    }else{

        $(".enviar-link-adesao:not('.disabled')").addClass("disabled");

        $(".enviar-link-adesao .texto-adicional").text("");

    }

    if(totalPendenciaPagamento > 0){

        $(".enviar-link-checkout.disabled").removeClass("disabled");

        $(".enviar-link-checkout .texto-adicional").text("para "+totalPendenciaPagamento+" vida(s) selecionada(s)");
        
    }else{

        $(".enviar-link-checkout:not('.disabled')").addClass("disabled");

        $(".enviar-link-checkout .texto-adicional").text("");


    }

    //ENVIAR E-MAIL ADESÃO

    $(".enviar-link-adesao:not('.disabled')").click(function(evt){

        evt.stopImmediatePropagation();

        $(this).parents(".menu-acao.ativo").find(".open-menu-acao").click();

        $(this).parents(".btn-acao-title-page").prepend('<span class="enviando-solicitacao">Enviando solicitações...aguarde...</span>');

        $(".lista-dependentes.box-plano-eletivo tbody tr").each(function(){

            if($(this).find("input[type='checkbox'][name='campo']").is(":checked")){
    
                if(!$(this).find(".modal-assinatura-dependente").hasClass("assinatura-confirmada")){
    
                    var obj = $(this);

                    var nome = obj.find(".dependente_nome").text();

                    var email = obj.find(".dependente_email").text();

                    var info = $(this).attr("info");

                    var mensagem = "Olá "+nome+"!<br>";
                        mensagem += "Seja bem vindo(a) a <strong>AZO Benefícios</strong>!<br>";
                        mensagem += "Para conclusão da sua adesão é necessário que acesse o link abaixo para confirmação de aceite do termo de adesão e escrever sua assinatura digital.<br>";
                        mensagem += "<strong>Acesse o link abaixo:</strong><br>";
                        mensagem += info;

                    obj.css("border-left","1px solid #f0ad4e");   

                    if(nome != "" && email != "" && info != ""){
                        
                        $.post(
                            "modulos/assinaturas/action.php",
                            {nome:nome, email:email, mensagem:mensagem, action:"enviarEmailSolicitacaoAceiteAdesao"},
                            function(response){

                                if(response.erro){

                                    obj.css("border-color","#fb3838");
                                    
                                }else{

                                    obj.css("border-color","#15b74e");

                                }

                            },"json"

                        );

                    }else{

                        obj.css("border-color","#15b74e");

                    }
    
                }else{

                    $(this).find("input[type='checkbox'][name='campo']:checked").prop("checked", false);

                }
                
            }
    
        });

        $(".btn-acao-title-page .enviando-solicitacao").text('Envio concluído!');

        setTimeout(
            function(){

                $(".btn-acao-title-page .enviando-solicitacao").fadeOut(function(){

                    $(".btn-acao-title-page .enviando-solicitacao").remove();

                });

            },5000
        );

    });


    //ENVIAR E-MAIL CHECKOUT


    $(".enviar-link-checkout:not('.disabled')").click(function(evt){

        evt.stopImmediatePropagation();

        $(this).parents(".menu-acao.ativo").find(".open-menu-acao").click();

        $(this).parents(".btn-acao-title-page").prepend('<span class="enviando-solicitacao">Enviando solicitações...aguarde...</span>');

        $(".lista-dependentes.box-plano-eletivo tbody tr").each(function(){

            if($(this).find("input[type='checkbox'][name='campo']").is(":checked")){
    
                if($(this).find(".modal-assinatura-dependente").hasClass("assinatura-confirmada")){
    
                    var obj = $(this);

                    var nome = obj.find(".dependente_nome").text();

                    var email = obj.find(".dependente_email").text();

                    var info = $(this).attr("info");

                        info = info.replace("adesao", "checkout");

                        //console.log(info);

                    var mensagem = "Olá "+nome+"!<br>";
                        mensagem += "Seja bem vindo(a) a <strong>AZO Benefícios</strong>!<br>";
                        mensagem += "Para conclusão da sua adesão é necessário que acesse o link abaixo para conclusão do pagamento de sua assinatura AZO Benefícios.<br>";
                        mensagem += "<strong>Acesse o link abaixo:</strong><br>";
                        mensagem += info;

                    if(nome != "" && email != "" && info != ""){
                        
                        $.post(
                            "modulos/assinaturas/action.php",
                            {nome:nome, email:email, mensagem:mensagem, action:"enviarEmailCheckoutPagamento"},
                            function(response){

                                if(response.erro){

                                    obj.css("border-color","#fb3838");
                                    
                                }else{

                                    obj.css("border-color","#15b74e");

                                }

                            },"json"

                        );

                    }else{

                        obj.css("border-color","#15b74e");

                    }
    
                }else{

                    $(this).find("input[type='checkbox'][name='campo']:checked").prop("checked", false);

                }
                
            }
    
        });

        $(".btn-acao-title-page .enviando-solicitacao").text('Envio concluído!');

        setTimeout(
            function(){

                $(".btn-acao-title-page .enviando-solicitacao").fadeOut(function(){

                    $(".btn-acao-title-page .enviando-solicitacao").remove();

                });

            },5000
        );

    });

}

$.validarCampos = function(form, modulo){

	if($(".conteudo .loading").length == 0){

		$(".conteudo").prepend("<div class='loading'></div>");

	}

	var erro = 0;
			
	$("#"+form+" .erro").remove();
	
	var total = $("#"+form+" .validar:not(':disabled')").length;
	
	var campos = $("#"+form+" .validar:not(':disabled')").toArray();

    let validacoes = [];
	
	for(i=0; i< total; i++){
		
		var valor = $(campos[i]).val();
		
		var tipo  = $(campos[i]).attr("tipo");
		
		if(valor == ""){
		
			$(campos[i]).parent().append("<span class='erro'>Campo obrigatório</span>");
			
			erro++;
			
		}else if(tipo == "login"){
			
			if($.trim(valor).match(/^[a-zA-Z0-9-]+$/) == null){
				
				$(campos[i]).parent().append("<span class='erro'>Login deve ter apenas letrar e/ou números</span>");
				
				$(campos[i]).val("");
				
				erro++;
				
			}
			
		}else if(tipo == "email"){
			
			if(!$.validarEmail($.trim(valor))){
				
				$(campos[i]).parent().append("<span class='erro'>E-mail inválido</span>");
				
				$(campos[i]).val("");
				
				erro++;
				
			}

        }else if(tipo == "idade_titular"){

            let campoAtual = $(campos[i]);

            let validacaoIdade = $.validarIdadeTitular($.trim(valor)).then(function(maiorIdade){

                if(!maiorIdade){

                    campoAtual.parent().append("<span class='erro'>O titular deve ter idade entre 18  e 79 anos</span>");
				
                    campoAtual.val("");
                    
                    erro++;

                }

            });

			validacoes.push(validacaoIdade);
			
		}else if(tipo == "senha"){
			
			if($(campos[i]).attr("id_senha")){
			
				var campoOrigem = $(campos[i]).attr("id_senha");
				
				if($("#"+campoOrigem).val() == ""){
					
					$(campos[i]).parent().append("<span class='erro'>O campo senha está vazio</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}else if($("#"+campoOrigem).val() == "" && valor == ""){
					
					$(campos[i]).parent().append("<span class='erro'>Confirme a senha</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}else if($("#"+campoOrigem).val() != valor){
					
					$(campos[i]).parent().append("<span class='erro'>As senhas não conferem</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}	
			
			}else{
				
				if($(campos[i]).attr("minlength") && $(campos[i]).attr("minlength") > 0){
					
					var minlength = $(campos[i]).attr("minlength");						
					
				}else{
					
					var minlength = valor.length;
					
				}
				
				if($(campos[i]).attr("maxlength") && $(campos[i]).attr("maxlength") > 0){
					
					var maxlength = $(campos[i]).attr("maxlength");						
					
				}else{
					
					var maxlength = valor.length;
					
				}
										
				if(valor.length < minlength){
					
					$(campos[i]).parent().append("<span class='erro'>Mínimo de "+minlength+" caracteres</span>");
					
					erro++;
				
				}else if(valor.length > maxlength){
					
					$(campos[i]).parent().append("<span class='erro'>Máximo de "+maxlength+" caracteres</span>");
					
					erro++;
								
				}					
			}
			
		}else if(tipo == "longtexto"){
			
			if($(campos[i]).attr("mintexto").length){
				
				var mintexto = $(campos[i]).attr("mintexto");
			
				if(valor.length < mintexto){
					
					$(campos[i]).parent().append("<span class='erro'>Mínimo de "+mintexto+" caracteres</span>");
					
					erro++;
					
				}
			
			}
			
		}
	
	}

    Promise.all(validacoes).then(function() {
			
        if(erro == 0){
        
            $.salvar(form, modulo);
            
        }else{

            $(".conteudo .loading").fadeOut(function(){

                $(".conteudo .loading").remove();

            });

        }

    });

}

$.validarCamposModal = function(idModal, modulo){

	if($(".conteudo .loading").length == 0){

		$(".conteudo").prepend("<div class='loading'></div>");

	}

	var erro = 0;
			
	$("#"+idModal+" .erro").remove();
	
	var total = $("#"+idModal+" .validar:not(':disabled')").length;
	
	var campos = $("#"+idModal+" .validar:not(':disabled')").toArray();

    let validacoes = [];
	
	for(i=0; i< total; i++){
		
		var valor = $(campos[i]).val();
		
		var tipo  = $(campos[i]).attr("tipo");
		
		if(valor == ""){
		
			$(campos[i]).parent().append("<span class='erro'>Campo obrigatório</span>");
			
			erro++;
			
		}else if(tipo == "login"){
			
			if($.trim(valor).match(/^[a-zA-Z0-9-]+$/) == null){
				
				$(campos[i]).parent().append("<span class='erro'>Login deve ter apenas letrar e/ou números</span>");
				
				$(campos[i]).val("");
				
				erro++;
				
			}
			
		}else if(tipo == "email"){
			
			if(!$.validarEmail($.trim(valor))){
				
				$(campos[i]).parent().append("<span class='erro'>E-mail inválido</span>");
				
				$(campos[i]).val("");
				
				erro++;
				
			}

        }else if(tipo == "idade_titular"){
			
			let campoAtual = $(campos[i]);

            let validacaoIdade = $.validarIdadeTitular($.trim(valor)).then(function(maiorIdade){

                if(!maiorIdade){

                    campoAtual.parent().append("<span class='erro'>O titular deve ter idade mínima de 18 anos</span>");
				
                    campoAtual.val("");
                    
                    erro++;

                }

            });

			validacoes.push(validacaoIdade);
			
		}else if(tipo == "senha"){
			
			if($(campos[i]).attr("id_senha")){
			
				var campoOrigem = $(campos[i]).attr("id_senha");
				
				if($("#"+campoOrigem).val() == ""){
					
					$(campos[i]).parent().append("<span class='erro'>O campo senha está vazio</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}else if($("#"+campoOrigem).val() == "" && valor == ""){
					
					$(campos[i]).parent().append("<span class='erro'>Confirme a senha</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}else if($("#"+campoOrigem).val() != valor){
					
					$(campos[i]).parent().append("<span class='erro'>As senhas não conferem</span>");
					
					$(campos[i]).val("");
					
					erro++;
					
				}	
			
			}else{
				
				if($(campos[i]).attr("minlength") && $(campos[i]).attr("minlength") > 0){
					
					var minlength = $(campos[i]).attr("minlength");						
					
				}else{
					
					var minlength = valor.length;
					
				}
				
				if($(campos[i]).attr("maxlength") && $(campos[i]).attr("maxlength") > 0){
					
					var maxlength = $(campos[i]).attr("maxlength");						
					
				}else{
					
					var maxlength = valor.length;
					
				}
										
				if(valor.length < minlength){
					
					$(campos[i]).parent().append("<span class='erro'>Mínimo de "+minlength+" caracteres</span>");
					
					erro++;
				
				}else if(valor.length > maxlength){
					
					$(campos[i]).parent().append("<span class='erro'>Máximo de "+maxlength+" caracteres</span>");
					
					erro++;
								
				}					
			}
			
		}else if(tipo == "longtexto"){
			
			if($(campos[i]).attr("mintexto").length){
				
				var mintexto = $(campos[i]).attr("mintexto");
			
				if(valor.length < mintexto){
					
					$(campos[i]).parent().append("<span class='erro'>Mínimo de "+mintexto+" caracteres</span>");
					
					erro++;
					
				}
			
			}
			
		}
	
	}
    Promise.all(validacoes).then(function() {
			
        if(erro == 0){
        
            $.salvarModal(idModal, modulo);
            
        }else{

            $(".conteudo .loading").fadeOut(function(){

                $(".conteudo .loading").remove();

            });

        }

    });

}

$.validarEmail = function (email)
{	
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;	
	if(er.exec(email)){	
		return true;	
	}else{	
		return false;
	}
}

$.validarIdadeTitular = function (data)
{	
    return new Promise(function(resolve) {

        $.post(
            "../php/validarIdade.php",
            {nascimento:data, action:"validarIdadeTitular"},
            function(response){

                if(!response.erro){

                    resolve(response.maior_idade);

                }else{

                    resolve(false);

                }           

            },"json"
            
        ).fail(function() {

            resolve(false); 
            
        });

    });
    
}
		
$.salvar = function(tipoForm, modulo){
	//SALVAR FORMULARIO
	
	var tipo = $("#"+tipoForm).attr("tipo");
	
	var total = $("#"+tipoForm+" select.campo:not(':disabled'):not([type='checkbox']),#"+tipoForm+" input.campo:not(':disabled'):not([type='checkbox']):not([type='radio']), #"+tipoForm+" input[type='checkbox'].campo:not(':disabled'):checked, #"+tipoForm+" input[type='radio'].campo:not(':disabled'):checked, #"+tipoForm+" textarea.campo:not(':disabled')").length;
	
	var campos = $("#"+tipoForm+" select.campo:not(':disabled'):not([type='checkbox']),#"+tipoForm+" input.campo:not(':disabled'):not([type='checkbox']):not([type='radio']), #"+tipoForm+" input[type='checkbox'].campo:not(':disabled'):checked, #"+tipoForm+" input[type='radio'].campo:not(':disabled'):checked, #"+tipoForm+" textarea.campo:not(':disabled')").toArray();
	
	var count = 0;
	
	var arrayCampo = "";
	
	var id = "";
	
	var action = "add";

    var box = $("#"+tipoForm).find(".box-campos:visible").attr("box");
	
	for(i = 0; i < total; i++){
		
		var nome = $(campos[i]).attr("name");
		
		var valor = $(campos[i]).val();
		
		if(nome == "id"){
			
			id = valor;
			
			action = "edit";

			count++;
		
		}else if(
			valor != "" ||
			valor == "" && !$(campos[i]).hasClass("validar")
		){
			
			count++;
			
			arrayCampo += nome+"%%:%%"+valor+"%%,%%";
		
		}
		
	}
	
	if(count > 0){
		
		arrayCampo = arrayCampo.substring(0,(arrayCampo.length-5));

		if(id != ""){

			var idRegistro = id;

		}

        //console.log(arrayCampo);
        				
		$.post(
			"action.php",
			{id:id, box:box, campos:arrayCampo, action:action, tipo:tipo},
			function (response, status){

				//console.log(response);

				if(status == "success"){

					$("body").prepend("<div class='"+response.classe+" alertaMsg'>"+response.mensagem+"</div>").fadeIn();
										
					if(response.erro){
								
						if(typeof response.limpar_cpf_cnpj != "undefined"){
						
							$("#"+tipoForm+" input[name='cpf_cnpj']").val("");
						
						}

						if(typeof response.limpar_email != "undefined"){
						
							$("#"+tipoForm+" input[name='email']").val("");
						
						}
						
					}else{

                       location.reload();

					}

					setTimeout(
						function(){

							$(".alertaMsg").fadeOut(function(){

								$(".alertaMsg").remove();

							});

						},3000
					);

				}else{

					$("body").prepend("<div class='alert-danger alertaMsg'><strong>Ops! Desculpe.</strong><br>Não foi possível carregar a página solicitada</div>").fadeIn();

			      	$(".conteudo .loading").fadeOut(function(){

			    		$(".conteudo .loading").remove();

			    	});

				}
				
			},"json"
			
		);	
		
	}

}

$(document).ready(function(){

    // Verifica se o navegador é mobile
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    // Verifica se é um dispositivo iOS
    var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

    if(isMobile || isIOS){

        /*AÇÃO MOBILE*/

        $("#geral:not('.mobile')").addClass("mobile");

        /*FIM AÇÃO MOBILE*/

        var id_contrato = $(".open-impressao").attr("id_contrato");

        if(typeof id_contrato != typeof undefined && id_contrato != ""){

            var id_assinatura = $(".open-impressao").attr("id_assinatura");

            if(typeof id_assinatura == typeof undefined){

                id_assinatura = "";

            }

            var id_dependente_contrato = $(".open-impressao").attr("id_dependente_contrato");

            if(typeof id_dependente_contrato == typeof undefined){

                id_dependente_contrato = "";

            }
            
            $.post(
                "../impressao/session-print.php",
                {id_contrato:id_contrato, id_assinatura: id_assinatura, id_dependente_contrato:id_dependente_contrato, metodo_print:"download", action:"documentPrint"},
                function(response){

                    if(response.salvo){

                        $.post(
                            "../impressao/",
                            function(response2){

                                $(".open-impressao").attr("href",response2);

                                if($(".open-impressao").hasClass("assinado")){

                                    $(".open-impressao").text("Visualizar contrato assinado");
                        
                                }else{
                        
                                    $(".open-impressao").text("Visualizar contrato prévio");
                        
                                }
            
                            }
            
                        );

                    }

                },"json"

            );

        }


    }else{

        if($(".open-impressao").hasClass("assinado")){

            $(".open-impressao").text("Visualizar contrato assinado");

        }else{

            $(".open-impressao").text("Visualizar contrato prévio");

        }

        $(".open-impressao").click(function(){

            var id_contrato = $(this).attr("id_contrato");
    
            if(typeof id_contrato != typeof undefined && id_contrato != ""){
    
                var id_assinatura = $(this).attr("id_assinatura");
    
                if(typeof id_assinatura == typeof undefined){
    
                    id_assinatura = "";
    
                }

                var id_dependente_contrato = $(".open-impressao").attr("id_dependente_contrato");

                if(typeof id_dependente_contrato == typeof undefined){

                    id_dependente_contrato = "";

                }
    
                $.post(
                    "../impressao/session-print.php",
                    {id_contrato:id_contrato, id_assinatura: id_assinatura, id_dependente_contrato:id_dependente_contrato, action:"documentPrint"},
                    function(response){
    
                        if(response.salvo){
    
                            if(response.salvo){

                                window.open('../impressao/', '_blank');
        
                            }
    
                        }
    
                    },"json"
    
                );
    
            }
    
        });


    }

});

function gerenciarMenuAcao(){
	 
	$("#geral").on("click",".menu-acao a.open-menu-acao", function(){

		var lista_itens = $(this).parent().find(".lista-itens");

		var linha = $(this).parents("tr").index();

		if(lista_itens.is(":visible")){

			$(this).parent().removeClass("ativo");

			lista_itens.fadeOut("fast");

			$("table tbody tr .box-embassar").remove();

		}else{

			var altura = lista_itens.height();

			lista_itens.css("top","-"+(altura/2)+"px");

			lista_itens.fadeIn("fast");

			$(this).parent().addClass("ativo");

			$("table tbody tr").not("tr:eq("+linha+")").append("<div class='box-embassar'></div>");			

		}

	});

	$("#geral").on("click",".menu-acao .lista-itens:visible a", function(){

		$(".menu-acao .lista-itens:visible").parents().children("a.open-menu-acao").click();

	});

	/*pressionar a tecla ESC quando o menu estiver ativo*/

	$(document).on('keyup',function(evt) {
		if (evt.keyCode == 27) {
		   
			/**MENU */

			if($(".menu-acao .lista-itens:visible").length > 0){

				$(".menu-acao .lista-itens:visible").parents().children("a.open-menu-acao").click();

			}

		}
	});

	$(document).click(function(e){

		e.stopImmediatePropagation();
				
		if($(".menu-acao.ativo").length > 0 && !$(".menu-acao.ativo").is(e.target) && $(".menu-acao.ativo").has(e.target).length === 0){

			$(".menu-acao .lista-itens:visible").parents().children("a.open-menu-acao").click();

		}

	});
 
 }