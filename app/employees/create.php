<?php

// Incluir arquivo de configuração
require_once(__DIR__ . "/../config/config.php");

// Processando dados do formulário quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // limpa o input
    $name = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $username = htmlspecialchars($_POST["username"]);
    $accessLevel = htmlspecialchars($_POST["access_level"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmPassword = htmlspecialchars($_POST["confirm_password"]);

    // variaveis de erro
    $errors = [];

    if (empty($name)) {
        $erros[] = "Por favor coloque seu nome.";
    }
 
    // Validar nome de usuário
    if (empty($username)) {
        $errors[] = "Por favor coloque um nome de usuário.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    } else {

        // Prepare uma declaração selecionada
        $sql = "SELECT id FROM users WHERE user = :user";
        
        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":user", $username, PDO::PARAM_STR);
            
            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $errors[] = "Este nome de usuário já está em uso.";
                }
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }

    // Validar nome de usuário
    if (empty($email)) {
        $errors[] = "Por favor coloque um email.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = "Por favor coloque um email com formatação correta.";
    } else {

        // Prepare uma declaração selecionada
        $sql = "SELECT id FROM users WHERE email = :email";
        
        if ($stmt = $pdo->prepare($sql)) {
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            
            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $errors[] = "Este email já está em uso.";
                }
            } else {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Validar senha
    if (empty($password)) {
        $errors[] = "Por favor insira uma senha.";     
    } elseif(strlen($password) < 6){
        $errors[] = "A senha deve ter pelo menos 6 caracteres.";
    }
    
    // Validar e confirmar a senha
    if (empty($confirmPassword)) {
        $errors[] = "Por favor, confirme a senha.";     
    } else {
        if (empty($password_err) && ($password != $confirmPassword)) {
            $errors[] = "A senha não confere.";
        }
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if (empty($errors)) {
        
        // Prepare uma declaração de inserção
        $sql = "INSERT INTO users (name, phone, email, password, user, access_level) VALUES (:name, :phone, :email, :password, :user, :access_level)";

        $password = password_hash($password, PASSWORD_DEFAULT);
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":user", $username, PDO::PARAM_STR);
            $stmt->bindParam(":access_level", $accessLevel, PDO::PARAM_STR);

            // Tente executar a declaração preparada
            if ($stmt->execute()) {
                //Redirecionar para a página de login
                header("location: ../../src/widgets/employees/employees.php");
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
