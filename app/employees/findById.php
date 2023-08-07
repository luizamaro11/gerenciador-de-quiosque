<?php

require_once(__DIR__ . "/../config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idEmployee = (int) $_GET["id"];

    $errors = [];

    // Prepare uma declaração selecionada
    $sql = "SELECT * FROM users WHERE id = :id";
        
    if ($stmt = $pdo->prepare($sql)) {
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":id", $idEmployee, PDO::PARAM_STR);
        
        // Tente executar a declaração preparada
        if ($stmt->execute()) {
            if (!$stmt->rowCount() == 1) {
                echo "Funcionário não encontrado";
            } else {
                header("Content-Type: application/json;charset=utf-8");
                echo json_encode($stmt->fetch());
                exit();
            }
        } else {
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        // Fechar declaração
        unset($stmt);
    }
}
