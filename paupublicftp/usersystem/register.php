<?php
// Include config file
require_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
 $mysqli = connect_mysql();
// Define variables and initialize with empty values
$code = $username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$code_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    // Validate code
     if(empty(trim($_POST["code"]))){
        $code_err = "Siusplau, introdueix el codi d'activació";
    } else{
        // Prepare a select statement
        $sql = "SELECT notused FROM activation_codes WHERE code = ? AND notused = 1";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $code);
            // Set parameters
            $code = trim($_POST["code"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                if($stmt->num_rows >= 1){
                        $code_err = NULL; 
                } else {
                    $code_err = "Codi ja utilitzat o no valid.";
                }
            } else{
                echo "Oops! Error del servidor... paaau...";
            }

            // Close statement
            $stmt->close();
        }
    }
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Siusplau, introdueix un nom d'usuari";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows >= 1){
                    $username_err = "Aquest nom d'usuari ja està en us. Siusplau, tria'n un de diferent.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Error del servidor... paaau...";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Siusplau, introdueix una contrasenya.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contransenya ha de contenir mes de 6 caràcters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirma la contrasenya.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "No coincideixen";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($code_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        //use activation code 
        if($stmt = $mysqli->prepare( "UPDATE activation_codes SET notused = 0 WHERE code = ?")){
            $stmt->bind_param("s", $param_code);                
        };
        $stmt->execute();

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, code) VALUES (?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_password, $code);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo"Registrat correctament! Pots iniciar sessió: ";
                header("location: ../index.php");
                
            } else{
                echo "Oops! Error del servidor... paaau...";
            }


            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../default.css">
    <link rel="stylesheet" href="./users.css">
    <!--- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> --->

</head>
<body>
    <div class="formulari_usuaris">
        <h2>Registre</h2>
        <p>Ompliu:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Usuari</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contrasenya</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Confirma</label>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
                <label>Codi d'activació</label>
                <input type="text" name="code" value="<?php echo $code; ?>">
                <span class="help-block"><?php echo $code_err; ?></span>
            </div>

            <div>
                <input type="submit"  value="Registra't">
                <input type="reset"  value="Neteja">
            </div>
            
        </form>
        <p>Ja ets registrat? <a href="./login.php">Inicia sessió</a>.</p>
        </div>    
</body>
</html>