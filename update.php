<?php

require "database.php";

session_start();

if(!isset($_SESSION["user"])) {
  header("Location: index.php");
  return;
}

$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->bindParam(":id", $id);
$statement->execute();

if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo "contact not found";
  return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC);
$addressStatement = $conn->query("SELECT * FROM address WHERE id = {$contact["address_id"]} LIMIT 1");
$address = $addressStatement->fetch(PDO::FETCH_ASSOC);

if ($contact["user_id"] != $_SESSION["user"]["id"]) {
  http_response_code(403);
  echo "HTTP 403 Forbidden";
  return;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty($_POST['name']) || empty($_POST['phone_number'])) {
    $error = "fill all the fields";
  } else if (strlen($_POST['phone_number']) < 9) {
    $error = "invalid phone number, must be at least 9 digits";
  } else {
    require "database.php";
    $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id LIMIT 1");
    $statement->execute([
        ":id" => $id,
        ":name" => $_POST["name"],
        ":phone_number" => $_POST["phone_number"],
    ]);
    $_SESSION['flash']=["message" =>"Contact {$_POST['name']} updated successfully"];

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
            <form method="POST" action="update.php?id=<?= $contact['id'] ?>">
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name"
                         value="<?= $contact['name'] ?>"
                         type="text"
                         class="form-control"
                         name="name"
                         autocomplete="name"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

                <div class="col-md-6">
                  <input id="phone_number"
                         value="<?= $contact['phone_number'] ?>"
                         type="tel"
                         class="form-control"
                         name="phone_number"
                         autocomplete="phone_number"
                         autofocus>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="street" class="col-md-4 col-form-label text-md-end">Street</label>

                <div class="col-md-6">
                  <input id="street"
                         value="<?= $address['street'] ?>"
                         type="text"
                         class="form-control"
                         name="street"
                         required autocomplete="street"
                         placeholder="Campclar"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="city" class="col-md-4 col-form-label text-md-end">City</label>

                <div class="col-md-6">
                  <input id="city"
                         value="<?= $address['city'] ?>"
                         type="text"
                         class="form-control"
                         name="city"
                         required autocomplete="city"
                         placeholder="Tarragona"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="state" class="col-md-4 col-form-label text-md-end">State</label>

                <div class="col-md-6">
                  <input id="state"
                         value="<?= $address['state'] ?>"
                         type="text"
                         class="form-control"
                         name="state"
                         required autocomplete="state"
                         placeholder="Tarragona"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="postal_code" class="col-md-4 col-form-label text-md-end">Postal code</label>

                <div class="col-md-6">
                  <input id="postal_code"
                         value="<?= $address['postal_code'] ?>"
                         type="text"
                         class="form-control"
                         name="postal_code"
                         required autocomplete="postal_code"
                         placeholder="43007"
                         autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="country" class="col-md-4 col-form-label text-md-end">Country</label>

                <div class="col-md-6">
                  <input id="country"
                         value="<?= $address['country'] ?>"
                         type="text"
                         class="form-control"
                         name="country"
                         required autocomplete="country"
                         placeholder="Spain"
                         autofocus>
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
