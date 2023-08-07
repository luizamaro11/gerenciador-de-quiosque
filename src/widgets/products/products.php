<?php

require_once(__DIR__ . "/../../../app/config/config.php");
require_once(__DIR__ . "/../../../app/products/listProducts.php");

// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../index.html");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Produtos</title>
	<link rel="stylesheet" href="../../public/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../public/css/bootstrap.css">
	<link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
        <div class="container-fluid">           
            <div class="col-md-2 menu">
                <div class="row linhaHeader">
                    <div class="col-md-12 cabecalho">
                        <ul>
                            <li><a href="../tables/tables.php"><img src="../../public/images/mesa.png" alt="">Mesas</a></li>
                            <li><a href="../employees/employees.php"><img src="../../public/images/funcionario.png" alt="">Funcionário</a></li>
                            <li><a href="./products.php"><img src="../../public/images/produto.png" alt="">Produtos</a></li>
                            <li><a href="../../../app/login/logout.php"><img src="../../public/images/sair.png" alt="">Sair</a></li>
                        </ul>                  
                    </div>
                </div>
            </div>
            <div class="col-md-10 tabelaDireita">
                <div class="row formTable">
                    <div class="row linhaTable">
                        <div class="col-md-9">
                            <h3>Produtos</h3>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#addProduct">ADICIONAR PRODUTO</button>
                        </div>
                    </div>
                    
                    <div class="row table-responsive">
                        <div class="col-md-12 funcTable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Quantidade</th>
                                        <th scope="col">tipo</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty(listProducts($pdo))): ?>
                                        <?php foreach (listProducts($pdo) as $product): ?>
                                            <tr>
                                                <td scope="row"><?= $product["name"] ?></td>
                                                <td><?= $product["amount"] ?></td>
                                                <td><?= $product["unit_type"] ?></td>
                                                <td><?= $product["value"] ?></td>
                                                <td>
                                                    <button class="btn-block btn-primary updateProduct" data-id="<?= $product["id"] ?>" data-toggle="modal" data-target="#updateProduct">ALTERAR</button>
                                                </td>
                                                <td>
                                                    <a href="/gerenciador-de-quiosque/app/products/delete.php?id=<?= $product["id"] ?>"><button class="btn-block btn-danger">EXCLUIR</button></a>
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
    <div id="addProduct" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="../../../app/products/create.php" method="post">
          
                <!--Container da modal--> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Produto</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" style="color: #000">Nome do produto</label>
                                <input id="name_product" type="text" class="form-control" name="name_product" placeholder="digite o nome do produto">
                            </div>

                            <div class="col-md-6">
                                <label style="color: #000">Quantidade</label>
                                <input id="amount" type="number" class="form-control" name="amount" placeholder="digite a quantidade de produto">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label style="color: #000">Preço do Produto</label>
                                <input id="price" type="number" class="form-control" name="price" placeholder="digite o valor do produto">	
                            </div>

                            <div class="col-md-6">							
                                <label style="color: #000">Tipo de Produto</label>
                                <select id="type_product" class="form-control" name="type_product">
                                    <option>Porção</option>
                                    <option>Bebidas</option>
                                    <option>Pastel</option>
                                </select>	
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default btn-success">CADASTRAR</button>
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Modal do Botão alterar para listar as informações do produto selecionado-->
    <div id="updateProduct" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="../../../app/products/update.php" method="post">

                <!--Container da modal--> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Alterar Produto</h4>
                    </div>
    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" style="color: #000">Nome do produto</label>
                                <input id="name_product" type="text" class="form-control" name="name_product">
                            </div>
    
                            <div class="col-md-6">
                                <label style="color: #000">Quantidade</label>
                                <input id="amount" type="number" class="form-control" name="amount">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
                                <label style="color: #000">Preço do Produto</label>
                                <input id="price" type="number" class="form-control" name="price">	
                            </div>
    
                            <div class="col-md-6">							
                                <label style="color: #000">Tipo de Unidade</label>
                                <select id="type_product" class="form-control" name="type_product">
                                    <option>unidades</option>
                                    <option>porção</option>
                                    <option>litros</option>
                                    <option>kg</option>
                                </select>	
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default btn-success">ATUALIZAR</button>
                        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">CANCELAR</button>
                    </div>
                </div>
            </form>
          
        </div>
    </div>

    <script type="text/javascript" src="../../public/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../../public/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../public/js/main.js"></script>
</body>
</html>
