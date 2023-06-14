<?php

function listTables($pdo) {
    // Prepare uma declaração selecionada
    $sql = "SELECT * FROM tables;";
            
    if ($stmt = $pdo->prepare($sql)) {

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $rows = [];
                foreach ($stmt->fetchAll() as $row) {

                    $rows[] = [
                        "id" => $row["id"],
                        "number" => $row["number"]
                    ];
                }

                return $rows;
            }
        }
    
        // Fechar declaração
        unset($stmt);
    }
}
