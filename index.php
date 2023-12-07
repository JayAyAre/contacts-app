<?php

require "database.php";

$contacts = $conn->query("SELECT * FROM contacts");

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/darkly/bootstrap.min.css"
    integrity="sha512-JjQ+gz9+fc47OLooLs9SDfSSVrHu7ypfFM7Bd+r4dCePQnD/veA7P590ovnFPzldWsPwYRpOK1FnePimGNpdrA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <script
    defer
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous">
  </script>

  <!-- Static Content -->
  <link rel="stylesheet" href="static/css/index.css">

  <title>Contacts App</title>
</head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="index.php">
        <img class="mr-2" src="./static/img/logo.png"/>
        ContactsApp
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <main>
      <div class="container pt-4 pt-3">
        <div class="row">
          <?php if ($contacts->rowCount() == 0):?>
            <div class="col-md-4 mx-auto">
              <div class="card car-body text-center">
                <p>No contacts</p>
                <a href="add.php" class="btn btn-primary">Add contact</a>
              </div>
            </div>
          <?php else:; ?>
          <?php foreach ($contacts as $contact) : ?>
            <div class="col-md-4 mb-3">
              <div class="card text-center">
                <div class="card-body">
                  <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                  <p class="m-2"><?= $contact["phone_number"] ?></p>
                  <a href="update.php?id=<?= $contact["id"]?>" class="btn btn-secondary">Edit contact</a>
                  <a href="delete.php?id=<?= $contact["id"]?>" class="btn btn-danger">Delete contact</a>
                </div>
              </div>
            </div>
          <?php endforeach; endif ?>
        </div>
      </div>
    </main>
  </body>
</html>