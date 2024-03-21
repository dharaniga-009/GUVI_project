<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-light bg-body-tertiary">
  <div class="cont">
    <a class="navbar-brand" href="#">
      <img
        src="guvi 2.jpg"
        height="90"
        alt="guvi"
        loading="lazy"
      />
    </a>
  </div>
</nav>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           $age = $_POST["age"];
           $gender = $_POST["gender"];
           $dateOfBirth = $_POST["date_of_birth"];
           $phoneNumber = $_POST["phone_number"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat) OR empty($age) OR empty($gender) OR empty($dateOfBirth) OR empty($phoneNumber)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           // You can add more validation rules here for age, date of birth, phone number, etc.

           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           } else {
            require_once "database.php";
            $sql = "SELECT * FROM register WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount>0) {
                array_push($errors,"Email already exists!");
                echo "<div class='alert alert-danger'>Email already exists!</div>";
            } else {
                $sql = "INSERT INTO register (full_name, email, password, age, gender, dateOfBirth, phoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssss", $fullName, $email, $passwordHash, $age, $gender, $dateOfBirth, $phoneNumber);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Something went wrong.</div>";
                }
            }
           }
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="age" placeholder="Age">
            </div>
            <div class="form-group">
                <select class="form-control" name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="date_of_birth" placeholder="Date of Birth">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Register</button>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>
</body>
</html>
