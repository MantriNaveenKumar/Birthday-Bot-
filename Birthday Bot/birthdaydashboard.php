<?php
// admin.php

// Include your database connection code here
$db = new PDO('pgsql:host=localhost;port=5432;dbname=birthday;user=postgres;password=root');

// Fetch upcoming birthdays
$currentDate = date("Y-m-d");
$queryUpcoming = $db->prepare("
    SELECT * FROM birthday_details
    WHERE 
        EXTRACT(MONTH FROM dob)::TEXT || '-' || EXTRACT(DAY FROM dob)::TEXT 
        >= EXTRACT(MONTH FROM CURRENT_DATE)::TEXT || '-' || EXTRACT(DAY FROM CURRENT_DATE)::TEXT
    ORDER BY dob ASC
    LIMIT 15
");
$queryUpcoming->execute();
$upcomingBirthdays = $queryUpcoming->fetchAll(PDO::FETCH_ASSOC);

// Fetch completed birthdays
$queryCompleted = $db->prepare("
    SELECT * FROM birthday_details 
    WHERE 
        (EXTRACT(MONTH FROM dob)::TEXT || '-' || EXTRACT(DAY FROM dob)::TEXT 
            <= EXTRACT(MONTH FROM CURRENT_DATE)::TEXT || '-' || EXTRACT(DAY FROM CURRENT_DATE)::TEXT
        )
    ORDER BY dob DESC 
    LIMIT 15
");
$queryCompleted->execute();
$completedBirthdays = $queryCompleted->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>


<style>
   body
        {
            background-image: url("https://tse3.explicit.bing.net/th?id=OIP.QV6VV5_o6Qn6P0WcWdxrPAHaC9&pid=Api&P=0&h=500");
            
        }
</style>

<body class="p-2">

<div class="card mt-5">
    <h1 class="card-header text-center">Birthday Dashboard</h1>
    <div class="card-body mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card messages-sent">
                        <h2 class="card-header text-center bg-dark text-secondary">Birthday Messages Sent</h2>
                        <div class="card-body">
                            <!-- Display completed birthdays with wishes sent -->
                            <?php foreach ($completedBirthdays as $completedBirthday): ?>
                                <p><?= $completedBirthday['name'] ?> - Wishes sent!</p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card messages-to-be-sent">
                        <h2 class="card-header text-center bg-dark text-danger">Upcoming Birthdays</h2>
                        <div class="card-body">
                            <!-- Display upcoming birthdays -->
                            <?php foreach ($upcomingBirthdays as $upcomingBirthday): ?>
                                <p><?= $upcomingBirthday['name'] ?> - <?= $upcomingBirthday['dob'] ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    
</script>
</body>
</html>
