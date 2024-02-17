<?php
// Connection to the PostgreSQL database (you need to replace these with your actual database credentials)
$host = "localhost";
$dbname = "birthday";
$user = "postgres";
$password = "root";

// Establish the database connection
$pdo = new PDO("pgsql:host=$host;dbname=$dbname;user=$user;password=$password");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch user input
    $name = $_POST["name"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];

    // Check if the email is already present in the database
    $stmt = $pdo->prepare("SELECT * FROM birthday_details WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Email is already present, show an error message
        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">Email is already registered</div>';
        echo '<meta http-equiv="refresh" content="3;url=birthdayregister.php">';
    } else {
        // Email is not present, insert the new user details into the database
        $stmt = $pdo->prepare("INSERT INTO birthday_details (name, email, dob) VALUES (:name, :email, :dob)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dob', $dob);
        $stmt->execute();

        // Show success message
        echo '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">Registration successful!</div>';
        echo '<meta http-equiv="refresh" content="3;url=birthdayregister.php">';
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    body
        {
            background-image: url("https://tse3.mm.bing.net/th?id=OIP.ddYDCpQceh2bO21mNbnTQwHaFW&pid=Api&P=0&h=180");
        }
</style>

</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
    <div class="card">
                <div class="card-body">
      <h2 class="mb-4 text-center">Birthday Registration Form</h2>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
    <label for="dob" class="form-label">DOB</label>
    <input type="date" class="form-control" id="dob" name="dob" required>
    </div>

       
        <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3 w-50">Submit</button>
                        </div>
                        
                    </form>
                    <div class="text-center mt-5">
                        <p> Click Here for the Birthday Dashboard </p>
                        <form action="birthdayprocess.php">
                            <button type="submit" class="btn btn-dark ">Birthday Dashboard</button>
                        </form>
                    </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
