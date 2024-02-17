<?php


                    session_start(); // Start a PHP session

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Retrieve the submitted username and password
                        $username = $_POST["username"];
                        $password = $_POST["password"];

                        // Establish a connection to your PostgreSQL database (replace with your database details)
                        $db = new PDO('pgsql:host=localhost;port=5432;dbname=birthday;user=postgres;password=root');

                        // Prepare a SQL query to fetch the user by username (email)
                        $query = $db->prepare("SELECT * FROM admin WHERE email_id = :email_id");
                        $query->bindParam(':email_id', $username);
                        $query->execute();
                        $user = $query->fetch();

                        // Check if a user with the provided username (email) exists and verify the password
                        if ($user && password_verify($password, $user['password'])) {
                            // Authentication successful
                            usleep(2000000);
                            header("location: birthdayregister.php");
                        }  else {
                            // Authentication failed, set an error message
                            usleep(2000000);
                            echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Username or password is not matched</div>';
                            echo '<meta http-equiv="refresh" content="3;url=adminlogin.php">';
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
            background-image: url("https://i.ytimg.com/vi/7SUJYQTRryc/hqdefault.jpg");
            background-size: 384px 340px;  /* w h */
            
        }
</style>

</head>
<body >



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mt-5 bg-dark p-4">
                <div class="card-body ">
                    <h5 class="card-title text-warning text-center">ADMIN LOGIN</h5>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4" >
                    <div class="mb-3">
    <label for="username" class="form-label text-secondary">Admin Username</label>
    <input type="text" class="form-control bg-light" id="username" name="username" placeholder="Enter your username" required>
</div>
<div class="mb-3">
    <label for="password" class="form-label text-secondary">Admin Password</label>
    <input type="password" class="form-control bg-light" id="password" name="password" placeholder="Enter your password" required>
</div>
                    
                     <div class="row text-center">
                        <div class=""> <button type="submit" class="btn btn-primary btn-block mt-3 w-50">Login</button></div>
                                 
                     </div>
                    </form>
                    

                    <div class="row text-center">
                      <form action="adminregister.php">
                        <label class="text-danger mt-5">Haven't Registered ? Click here for Registration</label>
                        <div class=""> <button type="submit" class="btn btn-success btn-block mt-3 w-50">Register</button></div>
                        </form>
                    </div>
                   
                         
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
