<?php

// Incluir arquivo de configuração
require_once(__DIR__ . "/../config/config.php");

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // limpa o input
    $idProduct = (int) $_GET["id"];

    $nameProduct = htmlspecialchars($_POST["name_product"]);
    $amount = htmlspecialchars($_POST["amount"]);
    $price = htmlspecialchars($_POST["price"]);
    $typeProduct = htmlspecialchars($_POST["type_product"]);

    var_dump($price);

    // variaveis de erro
    $errors = [];

    // Prepare uma declaração selecionada
    $sql = "SELECT * FROM products WHERE id = :id";
        
    if ($stmt = $pdo->prepare($sql)) {
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":id", $idProduct, PDO::PARAM_STR);
        
        // Tente executar a declaração preparada
        if ($stmt->execute()) {
            if (!$stmt->rowCount() == 1) {
                $errors[] = "Produto não encontrado";
            } else {

                $product = $stmt->fetch();

                if (empty($nameProduct)) {
                    $erros[] = "Por favor coloque o nome do produto.";
                }
                
                if (empty($amount)) {
                    $erros[] = "Por favor coloque a quantidade do produto.";
                }

                if (empty($price)) {
                    $erros[] = "Por favor coloque o preço do produto.";
                }

                if (empty($typeProduct)) {
                    $erros[] = "Por favor selecione o tipo de unidade.";
                }
                
            }

            // Verifique os erros de entrada antes de inserir no banco de dados
            if (empty($errors)) {
                
                // Prepare uma declaração de inserção
                $sql = "UPDATE products SET name = :name, unit_type = :unit_type, value = :value, amount = :amount WHERE id = :id";
                
                if ($stmt = $pdo->prepare($sql)) {

                    // Vincule as variáveis à instrução preparada como parâmetros
                    $stmt->bindParam(":name", $nameProduct, PDO::PARAM_STR);
                    $stmt->bindParam(":unit_type", $typeProduct, PDO::PARAM_STR);
                    $stmt->bindParam(":value", $price, PDO::PARAM_STR);
                    $stmt->bindParam(":amount", $amount, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $product["id"], PDO::PARAM_STR);

                    try {
                        $stmt->execute();
                    } catch (\Exception $e) {
                        var_dump($e->getMessage());
                    }

                    // Tente executar a declaração preparada
                    if ($stmt->execute()) {
                        //Redirecionar para a página com a lista de funcionários
                        header("location: ../../src/widgets/products/products.php");
                    } else {
                        echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
                    }

                    // Fechar declaração
                    unset($stmt);
                }
            }
        } else {
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        // Fechar declaração
        unset($stmt);
    }
    
    // Fechar conexão
    unset($pdo);
}
