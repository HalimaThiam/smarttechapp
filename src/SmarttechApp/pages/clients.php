<?php 
include('../includes/header.php'); 
include('../config.php'); 

// Ajouter un client
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO clients (name, email, phone) VALUES ('$name', '$email', '$phone')";
    $conn->query($sql);
}

// Supprimer un client
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM clients WHERE id=$id";
    $conn->query($sql);
}
?>

<h2>Gestion des Clients</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Téléphone" required>
    <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
</form>

<table class="table">
    <tr><th>ID</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Action</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM clients");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['phone']}</td>
            <td><a href='clients.php?delete={$row['id']}' class='btn btn-danger'>Supprimer</a></td>
        </tr>";
    }
    ?>
</table>

<?php include('../includes/footer.php'); ?>
