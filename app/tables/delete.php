<?php

require_once(__DIR__ . "/../config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $idTable = (int) $_GET["id"];

    $errors = [];

    // Prepare uma declaração selecionada
    $sql = "SELECT `id` FROM tables WHERE id = :id";
        
    if ($stmt = $pdo->prepare($sql)) {
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":id", $idTable, PDO::PARAM_STR);
        
        // Tente executar a declaração preparada
        if ($stmt->execute()) {
            var_dump($stmt->fetch());
            if (!$stmt->rowCount() == 1) {
                $errors[] = "Mesa não encontrada";
            }
        } else {
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        // Fechar declaração
        unset($stmt);
    }

    if (empty($errors)) {
        $sql = "DELETE FROM tables WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":id", $idTable, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                header("location: ../../src/widgets/tables/tables.php");
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
    
            // Fechar declaração
            unset($stmt);
        }    
    }
}
