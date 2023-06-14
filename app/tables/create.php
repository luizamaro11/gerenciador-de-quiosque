<?php

require_once(__DIR__ . "/../config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $numberTable = htmlspecialchars($_POST["number_table"]);

    $errors = [];

    // Prepare uma declaração selecionada
    $sql = "SELECT id FROM tables WHERE number = :number";
        
    if ($stmt = $pdo->prepare($sql)) {
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":number", $numberTable, PDO::PARAM_STR);
        
        // Tente executar a declaração preparada
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $errors[] = "Este número de mesa já está em uso.";
            }
        } else {
            echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
        }

        // Fechar declaração
        unset($stmt);
    }

    if (empty($errors)) {
        $sql = "INSERT INTO tables (`number`) VALUES (:number_table)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":number_table", $numberTable, PDO::PARAM_STR);

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
