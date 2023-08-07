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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <title>Funcionario</title>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-2 menu">
            <div class="row linhaHeader">
                <div class="col-md-12 cabecalho">
                    <ul>
                    <li><a href="../tables/tables.php"><img src="../../public/images/mesa.png" alt="">Mesas</a></li>
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
                        <h1>Funcionário</h1>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-block btn-info" data-toggle="modal" data-target="#newEmployee">ADICIONAR FUNCIONÁRIO</button>
                    </div>
                </div>
            </div>

            <div class="row table-responsive">
                <div class="col-md-12 funcTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Telefone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                                
                        <tbody>
                            <?php if (!empty(listEmployees($pdo))): ?>
                                <?php foreach (listEmployees($pdo) as $employee): ?>
                                    <tr>
                                        <td scope="row"><?= $employee["name"] ?></td>
                                        <td><?= $employee["phone"] ?></td>
                                        <td><?= $employee["email"] ?></td>
                                        <td>
                                            <button class="btn-block btn-primary updateEmployee" data-id="<?= $employee["id"] ?>" data-toggle="modal" data-target="#updateEmployee">ALTERAR</button>
                                        </td>
                                        <td>
                                            <a href="/gerenciador-de-quiosque/app/employees/delete.php?id=<?= $employee["id"] ?>"><button class="btn-block btn-danger">EXCLUIR</button></a>
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

    <!--Modal do Botão Adicionar Funcionario-->
    <div id="newEmployee" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="../../../app/employees/create.php" method="post">
          
                <!--Container da modal--> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionando Funcionário</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label style="color: #000">Nome</label>
                                <input type="text" name="name" class="form-control" placeholder="nome">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Telefone</label>
                                <input type="number" name="phone" class="form-control" placeholder="telefone">
                            </div>
                            
                            <div class="col-md-6">
                                <label style="color: #000">Usuario</label>
                                <input type="text" name="username" class="form-control" placeholder="nome de usuario">
                            </div>
                            
                            <!-- aqui vem um select para a opção de administrador ou funcionario -->
                            
                            <div class="col-md-6">
                                <label style="color: #000">Nivel de Acesso</label>
                                <select class="form-control" name="access_level">
                                    <option value="administrador">Administrador</option>
                                    <option selected="selected" value="funcionario">Funcionario</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">E-mail</label>
                                <input type="text" name="email" class="form-control" placeholder="email">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Senha</label>
                                <input type="password" name="password" class="form-control" placeholder="senha">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Confirmar Senha</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar senha">
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

    <!--Modal do Botão Alterar funcionário-->
    <div id="updateEmployee" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form action="../../../app/employees/update.php" method="post">

          
                <!--Container da modal--> 
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Atualizando Funcionário</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label style="color: #000">Nome</label>
                                <input type="text" name="name" class="form-control" placeholder="nome">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Telefone</label>
                                <input type="number" name="phone" class="form-control" placeholder="telefone">
                            </div>
                            
                            <div class="col-md-6">
                                <label style="color: #000">Usuario</label>
                                <input type="text" name="username" class="form-control" placeholder="nome de usuario">
                            </div>
                            
                            <!-- aqui vem um select para a opção de administrador ou funcionario -->
                            
                            <div class="col-md-6">
                                <label style="color: #000">Nivel de Acesso</label>
                                <select class="form-control" name="access_level">
                                    <option value="administrador">Administrador</option>
                                    <option selected="selected" value="funcionario">Funcionario</option>
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">E-mail</label>
                                <input type="text" name="email" class="form-control" placeholder="email">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Senha</label>
                                <input type="password" name="password" class="form-control" placeholder="senha">
                            </div>
                            
                            <div class="col-md-12">
                                <label style="color: #000">Confirmar Senha</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirmar senha">
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