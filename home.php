<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: index.php");
  return;
}

$contacts = $conn->query("SELECT * FROM contacts WHERE user_id ={$_SESSION["user"]["id"]}");

?>

<?php require "partials/header.php"?>
      <div class="container pt-4 pt-3">
        <div class="row">
          <?php if ($contacts->rowCount() == 0):?>
            <div class="col-md-4 mx-auto">
              <div class="card car-body text-center">
                <p>No contacts</p>
                <a href="add.php" class="btn btn-primary">Add contact</a>
              </div>
            </div>
          <?php else: ?>
          <?php foreach ($contacts as $contact) : ?>
            <div class="col-md-4 mb-3">
              <div class="card text-center">
                <div class="card-body">
                  <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
                  <p class="m-2"><?= $contact["phone_number"] ?></p>
                  <a href="update.php?id=<?= $contact["id"] ?>" class="btn btn-secondary">Edit contact</a>
                  <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger">Delete contact</a>
                </div>
              </div>
            </div>
          <?php endforeach; endif; ?>
        </div>
      </div>
<?php require "partials/footer.php"?>
