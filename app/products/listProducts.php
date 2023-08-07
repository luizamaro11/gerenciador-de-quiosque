<?php

function listProducts($pdo) {
    // Prepare uma declaração selecionada
    $sql = "SELECT `id`, `name`, `unit_type`, `value`, `amount`, `stock_quantity` FROM products";
            
    if ($stmt = $pdo->prepare($sql)) {

        if ($stmt->execute()) {

            if ($stmt->rowCount() > 0) {

                $rows = [];
                foreach ($stmt->fetchAll() as $row) {

                    $rows[] = [
                        "id" => $row["id"],
                        "name" => $row["name"],
                        "unit_type" => $row["unit_type"],
                        "value" => $row["value"],
                        "amount" => $row["amount"],
                        "stock_quantity" => $row["stock_quantity"]
                    ];
                }

                return $rows;
            }
        }
    
        // Fechar declaração
        unset($stmt);
    }
}
