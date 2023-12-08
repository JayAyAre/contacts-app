<?php

session_start();

if(isset($_SESSION["user"])) {
  header("Location: index.php");
  return;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
    $error = "fill all the fields";
  }else {
    require "database.php";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $statement = $conn->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
    $statement->bindParam(":name", $name);
    $statement->bindParam(":email", $email);
    $statement->execute();

    if($statement->rowCount()>=1) {
      $error = "user already exists";
      header("Location: register.php");
    }else{
      $statement = $conn->prepare("INSERT INTO users(name,email,password_hash) VALUES (:name,:email,:password_hash)");
      $statement->bindParam(":name", $name);
      $statement->bindParam(":email", $email);
      $statement->bindParam(":password_hash", $password_hash);
      $statement->execute();

      $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
      $statement->bindParam(":email", $email);
      $statement->execute();
      $user = $statement->fetch(PDO::FETCH_ASSOC);

      session_start();
      unset($user['password_hash']);
      $_SESSION['user'] = $user;
      header("Location: home.php");
    }
  }
}
?>

<?php require "partials/header.php" ?>
<main>
  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>
          <div class="card-body">
            <?php if ($error): ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif ?>
            <form method="POST" action="register.php">
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus placeholder="your name">
                </div>
              </div>

              <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus placeholder="email@example.com">
                </div>
              </div>

              <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end">password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus placeholder="password">
                  <small id="passwordHelp" class="form-text text-muted">The password must be at least 8 characters.</small>
                </div>
              </div>

              <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require "partials/footer.php" ?>
