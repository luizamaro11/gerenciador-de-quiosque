<?php

// Inicialize a sessão
session_start();
 
// Verifique se o usuário já está logado, em caso afirmativo, redirecione-o para a página de boas-vindas
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../../src/widgets/tables/tables.php");
    exit;
}
 
// Incluir arquivo de configuração
require_once(__DIR__ . "/../config/config.php");
 
// Defina variáveis e inicialize com valores vazios
// $username = $password = "";
// $username_err = $password_err = $login_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // limpa o input
    
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    $errors = [];
 
    // Verifique se o nome de usuário está vazio
    if (empty($username)) {
        $errors[] = "Por favor, insira o nome de usuário.";
    }
    
    // Verifique se a senha está vazia
    if (empty($password)) {
        $errors[] = "Por favor, insira sua senha.";
    }
    
    // Validar credenciais
    if (empty($errors)) {

        // Prepare uma declaração selecionada
        $sql = "SELECT id, user, password FROM users WHERE user = :user";
        
        if ($stmt = $pdo->prepare($sql)) {

            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":user", $username, PDO::PARAM_STR);
            
            // Tente executar a declaração preparada
            if ($stmt->execute()) {

                // Verifique se o nome de usuário existe, se sim, verifique a senha
                if ($stmt->rowCount() == 1) {

                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["user"];
                        $hashed_password = $row["password"];

                        if (password_verify($password, $hashed_password)) {

                            // A senha está correta, então inicie uma nova sessão
                            session_start();
                            
                            // Armazene dados em variáveis de sessão
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirecionar o usuário para a página de boas-vindas
                            header("location: ../../src/widgets/tables/tables.php");
                        } else {
                            // A senha não é válida, exibe uma mensagem de erro genérica
                            $errors = "Nome de usuário ou senha inválidos.";
                        }
                    }
                } else {
                    // O nome de usuário não existe, exibe uma mensagem de erro genérica
                    $errors = "Nome de usuário ou senha inválidos.";
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
