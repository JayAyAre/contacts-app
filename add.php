<?php

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: index.php");
  return;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty($_POST['name']) || empty($_POST['phone_number']) || empty($_POST['street']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['postal_code']) || empty($_POST['country'])) {
    $error = "fill all the fields";
  } else if (strlen($_POST['phone_number']) < 9) {
    $error = "invalid phone number, must be at least 9 digits";
  } else {
    require "database.php";
    $statement = $conn->prepare("INSERT INTO address(street,city,state,postal_code,country) VALUES (:street,:city,:state,:postal_code,:country)");
    $statement->bindParam(":street", $_POST['street']);
    $statement->bindParam(":city", $_POST['city']);
    $statement->bindParam(":state", $_POST['state']);
    $statement->bindParam(":postal_code", $_POST['postal_code']);
    $statement->bindParam(":country", $_POST['country']);
    $statement->execute();

    $address_id = $conn->lastInsertId();

    $statement = $conn->prepare("INSERT INTO contacts(name,phone_number,user_id,address_id) VALUES (:name,:phone_number,:user_id,:address_id)");
    $statement->bindParam(":name", $_POST['name']);
    $statement->bindParam(":phone_number", $_POST['phone_number']);
    $statement->bindParam(":user_id", $_SESSION["user"]["id"]);
    $statement->bindParam(":address_id", $address_id);
    $statement->execute();

    $_SESSION['flash']=["message" =>"Contact {$_POST['name']} added successfully"];

    header("Location: home.php");
    return;
  }
}
?>

<?php require "partials/header.php" ?>

<main>
  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Add New Contact</div>
          <div class="card-body">
            <?php if ($error): ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif ?>
            <form method="POST" action="add.php">
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name"
                         type="text"
                         class="form-control"
                         name="name"
                         required autocomplete="name"
                         placeholder="John Doe"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

                <div class="col-md-6">
                  <input id="phone_number"
                         type="tel" class="form-control"
                         name="phone_number" required
                         autocomplete="phone_number"
                         placeholder="123456789"
                         autofocus>
                </div>
              </div>

              <?php require "address-form.php" ?>

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
