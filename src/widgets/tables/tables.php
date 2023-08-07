<?php

require_once(__DIR__ . "/../../../app/config/config.php");
require_once(__DIR__ . "/../../../app/tables/listTables.php");

// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../index.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <title>Mesas</title>
</head>
<body>
    <div class="container-fluid">           
        <div class="col-md-2 menu">
            <div class="row linhaHeader">
                <div class="col-md-12 cabecalho">
                    <ul>
                        <li><a href="./tables.php"><img src="../../public/images/mesa.png" alt="">Mesas</a></li>
                        <li><a href="../employees/employees.php"><img src="../../public/images/funcionario.png" alt="">Funcionário</a></li>
                        <li><a href="../products/products.php"><img src="../../public/images/produto.png" alt="">Produtos</a></li>
                        <li><a href="../../../app/login/logout.php"><img src="../../public/images/sair.png" alt="">Sair</a></li>
                    </ul>                  
                </div>
            </div>
        </div>
        <div class="col-md-10 tabelaDireita">
            <div class="row formTable">
                <div class="row linhaTable">
                    <div class="col-md-9">
                        <h3>Mesas</h3>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-block btn-info" data-toggle="modal" data-target="#newTable" id="funcionarioNovo">ADICIONAR MESA</button>
                    </div>
                </div>
                
                <div class="row table-responsive">
                    <div class="col-md-12 funcTable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Numero da mesa</th>
                                </tr>
                            </thead>
                            <tbody id="listarMesas">
                                <?php if (!empty(listTables($pdo))): ?>
                                    <?php foreach (listTables($pdo) as $table): ?>
                                        <tr>
                                            <th style="color: inherit; font-size: 20px; width: 88%;">Mesa <?= $table["number"] ?></th>
                                            <td>
                                                <a href="/gerenciador-de-quiosque/app/tables/delete.php?id=<?= $table["id"] ?>" id="delete"><button style="width: 100px;" class="btn-block btn-danger">EXCLUIR</button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>            
            </div>
        </div>
    </div>
        
    <!--Modal do Botão Adicionar-->
    <div id="newTable" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="../../../app/tables/create.php" method="post">
            
                <!--Container da modal--> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionando Mesa</h4>
                    </div>
                    <div class="modal-body">
                        <label for="numberTable" style="color: #000">Número da mesa</label>
                        <input id="numberTable" type="number" class="form-control" name="number_table" placeholder="digite o número da mesa">
                    </div>
                    
                    <div class="modal-footer">
                        <button id="save" type="submit" class="btn btn-default btn-success">SALVAR</button>
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="../../public/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="js/mesas.js"></script> -->
</body>
</html>
