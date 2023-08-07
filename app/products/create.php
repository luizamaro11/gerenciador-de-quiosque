<?php

// Incluir arquivo de configuração
require_once(__DIR__ . "/../config/config.php");

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // limpa o input
    $nameProduct = htmlspecialchars($_POST["name_product"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $price = htmlspecialchars($_POST["price"]);
    $typeProduct = htmlspecialchars($_POST["type_product"]);

    // variaveis de erro
    $errors = [];

    if (empty($name)) {
        $erros[] = "Por favor coloque o nome do produto.";
    }
 
    // Validar nome de usuário
    if (empty($amount)) {
        $errors[] = "Por favor coloque a quantidade do produto.";
    }

    // Validar nome de usuário
    if (empty($price)) {
        $errors[] = "Por favor coloque o preço do produto.";
    }
    
    // Validar senha
    if (empty($typeProduct)) {
        $errors[] = "Por favor coloque o type do produto.";
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if (empty($errors)) {
        
        // Prepare uma declaração de inserção
        $sql = "INSERT INTO products (name, unit_type, value, amount) VALUES (:name, :unit_type, :value, :amount)";
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":name", $nameProduct, PDO::PARAM_STR);
            $stmt->bindParam(":unit_type", $typeProduct, PDO::PARAM_STR);
            $stmt->bindParam(":value", $price, PDO::PARAM_STR);
            $stmt->bindParam(":amount", $amount, PDO::PARAM_STR);

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                //Redirecionar para a página de login
                header("location: ../../src/widgets/products/products.php");
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
