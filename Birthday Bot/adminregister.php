<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email_id = $_POST["email"];
    $password = $_POST["password"];

    try {
        $db = new PDO('pgsql:host=localhost;port=5432;dbname=birthday;user=postgres;password=root');

        // Check if the username already exists
        $checkUsernameQuery = $db->prepare("SELECT * FROM admin WHERE adminname = :username");
        $checkUsernameQuery->bindParam(':username', $username);
        $checkUsernameQuery->execute();
        $existingUsername = $checkUsernameQuery->fetch();

        // Check if the email id already exists
        $checkEmailQuery = $db->prepare("SELECT * FROM admin WHERE email_id = :email");
        $checkEmailQuery->bindParam(':email', $email_id);
        $checkEmailQuery->execute();
        $existingEmail = $checkEmailQuery->fetch();

        if ($existingUsername) {
            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Username already exists. Choose a different username.</div>';
            echo '<meta http-equiv="refresh" content="3;url=adminregister.php">';
        } elseif ($existingEmail) {
            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Email ID already exists. Choose a different email ID.</div>';
            echo '<meta http-equiv="refresh" content="3;url=adminregister.php">';
        } else {
            // Insert the new user into the database
            $insertQuery = $db->prepare("INSERT INTO admin (adminname, email_id, password) VALUES (:username, :email_id, :password)");
            $insertQuery->bindParam(':username', $username);
            $insertQuery->bindParam(':email_id', $email_id);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery->bindParam(':password', $hashedPassword);
            $insertQuery->execute();
          
            //registered sucessfully
        echo  '<div class="container d-flex justify-content-center align-items-center" style="height: 100vh; width:750px">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
           Registered successfully.
            
        </div>
    </div>';
    // Change body background color to dark
echo '<script>
document.body.style.backgroundColor = "#343a40"; // You can change this color code to your desired dark color
</script>';
    

        // Use JavaScript to reload the page after 2 seconds
        echo '<script>
        setTimeout(function() {
            location.href = "adminlogin.php"; // Replace with the URL you want to navigate to
        }, 3000);
        
              </script>';










        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Database error: ' . $e->getMessage() . '</div>';
    }
}
?>

            
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body
        {
            background-image: url("");
            background-size: 200px 200px;  /* w h */
           
        }
</style>

</head>
<body >



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5 bg-dark p-4">
                <div class="card-body ">
                    <h5 class="card-title text-info text-center">ADMIN REGISTRATION PAGE</h5>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-5" >
                    <div class="mb-3">
    <label for="username" class="form-label text-secondary"> Username</label>
    <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Enter your username" required>
</div>

<div class="mb-3">
<label for="email" class="form-label text-secondary">Email id</label>
    <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Enter your email" required>
</div>
 
<div class="mb-3">
    <label for="password" class="form-label text-secondary"> Set Password</label>
    <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Enter your password" required>
</div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3 w-50">Register</button>
                        </div>
                        
                    </form>
                    
                        
                         
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
