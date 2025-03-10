<?php 
include('../includes/header.php'); 
include('../config.php');

// Fonction pour générer un mot de passe
function generatePassword($length = 10) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

// Fonction pour envoyer un mail
function sendMail($email, $name, $password) {
    $to = $email;
    $subject = "Bienvenue chez Smarttech !";

    $message = "
    <html>
    <head><title>Bienvenue chez Smarttech</title></head>
    <body>
        <h2>Bienvenue, $name !</h2>
        <p>Votre compte employé a été créé avec succès.</p>
        <p><b>Email :</b> $email</p>
        <p><b>Mot de passe :</b> $password</p>
        <p><i>Veuillez changer votre mot de passe dès votre première connexion.</i></p>
    </body>
    </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: admin@smarttech.local" . "\r\n";   

    if (mail($to, $subject, $message, $headers)) {
        return "E-mail envoyé avec succès à $email.";
    } else {
        error_log("Erreur mail() : Impossible d'envoyer l'e-mail à $email.");
        return "Erreur lors de l'envoi de l'e-mail.";
    }
}

// Ajouter un employé
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    // Générer un mot de passe aléatoire et le hasher
    $password = generatePassword();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Requête d'insertion
    $sql = "INSERT INTO employees (name, email, position, password) VALUES ('$name', '$email', '$position', '$hashed_password')";

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Employé ajouté avec succès.</div>";

        // Envoyer un e-mail avec le mot de passe
        $message = sendMail($email, $name, $password);
        echo "<div class='alert alert-info'>$message</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur SQL : " . $conn->error . "</div>";
    }
}

// Supprimer un employé
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); // Sécuriser l'ID
    $sql = "DELETE FROM employees WHERE id=$id";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Employé supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur SQL : " . $conn->error . "</div>";
    }
}
?>

<h2>Gestion des Employés</h2>

<!-- Formulaire d'ajout -->
<form method="POST" class="mb-3">
    <input type="text" name="name" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="position" placeholder="Poste" required>
    <button type="submit" name="add" class="btn btn-primary">Ajouter</button>
</form>

<!-- Liste des employés -->
<table class="table">
    <tr>
        <th>ID</th><th>Nom</th><th>Email</th><th>Poste</th><th>Action</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM employees");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>{$row['position']}</td>
            <td><a href='employees.php?delete={$row['id']}' class='btn btn-danger'>Supprimer</a></td>
        </tr>";
    }
    ?>
</table>

<?php include('../includes/footer.php'); ?>

