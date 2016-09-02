<?php

    // Codigo abaixo sera executado quando clicar em "adicionar"
    if(isset($_POST['enviarZona'])){
        $objeto = new Zona($_POST['inputNameDominio'], $_POST['type']);
        $retorno = $objeto->add($connect_ssh);
        if($retorno){ //Executa se Adicionou com sucesso...

            //Scripts abaixo mostram popup dizendo sucesso ou falha para adicionar Zona
?>          <script type="text/javascript">
                alert(" <?php echo 'Zona adicionada com sucesso!! '; ?> ");
            </script>
<?php
        }else{

?>          <script type="text/javascript">
                alert(" <?php echo 'Erro ao adicionar Zona :('; ?> ");
            </script>
<?php
        }
    } 
?>


<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">
                Zonas Diretas</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="dashboard.php">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Zonas Diretas</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Zonas Diretas</li>
        </ol>
        <div class="clearfix">
        </div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--BEGIN CONTENT-->
    <div class="page-content">
        <div id="tab-general">
            <div class="row mbl">
                <div class="col-lg-12">
                    <div class="col-md-12">
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">

                    <!-- Lista Abas -->
                    <div class="col-lg-12">
                        <ul id="generalTab" class="nav nav-tabs responsive">
                            <li class="active"><a href="#adicionar-tab" data-toggle="tab">Adicionar</a></li>

                            <li><a href="#note-tab" data-toggle="tab">Editar</a></li>

                            <!--<li><a href="#label-badge-tab" data-toggle="tab">Visualizar</a></li>-->
                        </ul>

                    <div id="generalTabContent" class="tab-content responsive">

                    <!-- ABA ADICIONAR DO CONTEUDO -->
                    <div id="adicionar-tab" class="tab-pane fade in active">
                        <div class="row">
                            <form action="" method="post">

                            <!-- First Columm First Tab-->
                            <div class="col-lg-6">

                                <h3>Basic Setting</h3><br>
                                <!-- Begin Campo Dominio -->
                                <div class="form-group">
                                    <input name="inputNameDominio" type="text" placeholder="Nome Dominio" class="form-control"/>
                                </div>
                                <!-- End Campo Dominio -->

                                <div class="form-group">
                                    <select class="form-control" name="type">
                                        <option value="master">master</option>
                                        <option value="slave">slave</option>
                                    </select>
                                </div>

                                <!-- End Select File -->

                                <br>
                                <button type="submit" class="btn btn-primary" name="enviarZona">Adicionar</button>

                            </div>


                            </form>

                        </div><br>

                    </div>
                    <!-- END -->
                    <!-- ABA EDITAR DO CONTEUDO -->
                    <div id="note-tab" class="tab-pane fade">
                        <div class="row">
                            <div class="col-lg-12">

                                <form action="" method="post">

                                <h3>Pesquisar:</h3><br>
                                <div class="col-lg-6">
                                    <input name="domainPesquisar" type="text" placeholder="Domain" class="form-control"/>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputName" class="col-md-2 control-label">
                                            Type:</label>
                                        <div class="col-md-9">
                                            <div class="input-icon right">
                                                <select class="form-control" name="type">
                                                    <option value="master">Master</option>
                                                    <option value="slave">Slave</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br><br><br><br>
                                <button type="submit" class="btn btn-primary" name="pesquisar">Search</button>

                                </form>

                                <br>

                                <?php

                                    // Inicio codigo para Pesquisar Zona

                                    if(isset($_POST['pesquisar'])){
                                        $domain = $_POST['domainPesquisar'];
                                        $type = $_POST['type']; //nao utilizando no momento..

                                        //Criando objeto Zona, com "domain" e "type" passado
                                        $obj_zona_find = new Zona($domain, $type);

                                        //Chama metodo pesquisaZona do objeto e retorna um array com os
                                        // dados da Zona como "file" e "type" para jogar numa table
                                        $array_pesquisa = $obj_zona_find->pesquisaZona($connect_ssh, $domain);
                                        if(!$array_pesquisa){ 
                                            //Se retornou false...
                                            echo "Nada encontrado !!";
                                        }else{
                                ?>
                                            <h3>Zona direta:</h3><br>

                                            <table class="table table-hover table-bordered">
                                                <tr>
                                                    <td>Type</td>
                                                    <td>File</td>
                                                    <td>Editar</td>
                                                    <td>Excluir</td>
                                                </tr>
                                                <tr>

                                                    <?php for($i=0; $i < count($array_pesquisa); $i++){   ?>      
                                                            <td> <?php  echo $array_pesquisa[$i];  ?>  </td>
                                                    <?php } ?>

                                                    <td><a href=""><img src="images/conf.png" class="icons"></a></td>
                                                    <td><a href="del_zona.php?domain=<?php echo $domain; ?>"><img src="images/del.png" class="icons"></a></td>
                                                </tr>
                                            </table>

                                            <?php
                                                // Recebe o array com os registros de recursos
                                                $dados_zona = $obj_zona_find->getRRDominio($connect_ssh, $domain);

                                                if (!$dados_zona) {
                                                    echo "Não encontrado arquivo de Registro de Recurso de domínio!! ";
                                                }else{
                                                    // Para visualiza o array descomente linha abaixo...
                                                    //print_r($dados_zona);
                                            ?>
                                                    <!-- Table mostrando todos os dados da Zona-->
                                                    <br>
                                                    <h3>Registros de Recursos do domínio:</h3><br>

                                                    <table class="table table-hover table-bordered"> 
                                                        <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Class</th>
                                                            <th>Type</th>
                                                            <th>Data</th>
                                                            <th>Editar</th>
                                                            <th>Excluir</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?php // Laço mostrando dados do array retornado...
                                                                for ($i=0; $i < count($dados_zona); $i++) {
                                                                // Laco constroi linhas da tabela em html...
                                                        ?>
                                                                    <tr>

                                                                    <?php   for ($j=0; $j < 4; $j++) {     //4 -> qtde de dados qm cada linha da matriz
                                                                                // Laço mostrando dados das linhas...   ?>
                                                                                <td> <?php echo $dados_zona[$i][$j]; ?> </td>
                                                                    <?php   } ?>

                                                                            <td><a href=""></a><img src="images/conf.png" class="icons"></a></td>
                                                                            <td><a href=""></a><img src="images/del.png" class="icons"></a></td>
                                                                    </tr>
                                                        <?php   } ?>

                                                        </tbody>
                                                    </table>


                                            <?php

                                                }

                                            ?>


                                <?php
                                        }
                                    }
                                    $_POST['pesquisar'] = false;

                                ?>

                            </div>
                        </div>
                    </div>
                    <!-- END -->

                    </div>
                    </div>
                </div>
        </div>
    </div>
    <!--END CONTENT-->
    <!--BEGIN FOOTER-->
    <div id="footer">
        <div class="copyright">
            <a href="http://themifycloud.com">2015 © KAdmin Responsive Multi-Purpose Template</a>
        </div>
    </div>
    <!--END FOOTER-->
</div>
<!--END PAGE WRAPPER-->
