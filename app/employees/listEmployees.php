<?php

function listEmployees($pdo) {
    // Prepare uma declaração selecionada
    $sql = "SELECT `id`, `name`, `phone`, `email`, `access_level` FROM users WHERE access_level = :access_level";
            
    if ($stmt = $pdo->prepare($sql)) {

        $stmt->bindValue(":access_level", "funcionario", PDO::PARAM_STR);

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $rows = [];
                foreach ($stmt->fetchAll() as $row) {

                    $rows[] = [
                        "id" => $row["id"],
                        "name" => $row["name"],
                        "phone" => $row["phone"],
                        "email" => $row["email"]
                    ];
                }

                return $rows;
            }
        }
    
        // Fechar declaração
        unset($stmt);
    }
}
