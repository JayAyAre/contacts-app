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
        <?php
        $addressStatement = $conn->query("SELECT * FROM address WHERE id = {$contact["address_id"]} LIMIT 1");
        $address = $addressStatement->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="col-md-4 mb-3">
          <div class="card text-center">
            <div class="card-body">
              <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3>
              <p class="m-2"><?= $contact["phone_number"] ?></p>
              <a href="update.php?id=<?= $contact["id"] ?>" class="btn btn-secondary">Edit contact</a>
              <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger">Delete contact</a>
              <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addressModal<?= $contact["id"] ?>">Show Direction</button>

              <!-- Modal -->
              <div class="modal fade" id="addressModal<?= $contact["id"] ?>" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="addressModalLabel">Address for <?= $contact["name"] ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p><strong>Street:</strong> <?= $address["street"] ?></p>
                      <p><strong>City:</strong> <?= $address["city"] ?></p>
                      <p><strong>State:</strong> <?= $address["state"] ?></p>
                      <p><strong>Postal Code:</strong> <?= $address["postal_code"] ?></p>
                      <p><strong>Country:</strong> <?= $address["country"] ?></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php require "partials/footer.php"?>
