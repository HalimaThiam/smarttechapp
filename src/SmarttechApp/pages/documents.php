<?php
include('../includes/header.php');
include('../config.php');

// Gestion de l'upload
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $target_dir = "../uploads/";
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO documents (title, file_path) VALUES ('$title', '$target_file')";
        $conn->query($sql);
        echo "<div class='alert alert-success'>Fichier uploadé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'upload.</div>";
    }
}

// Suppression de document
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = $conn->query("SELECT file_path FROM documents WHERE id=$id");
    $file = $result->fetch_assoc()['file_path'];
    
    if (file_exists($file)) {
        unlink($file); // Supprime physiquement le fichier
    }

    $conn->query("DELETE FROM documents WHERE id=$id");
    echo "<div class='alert alert-success'>Document supprimé.</div>";
}
?>

<h2>Gestion des Documents</h2>

<!-- Formulaire d'upload -->
<form method="POST" enctype="multipart/form-data" class="mb-3">
    <input type="text" name="title" placeholder="Titre du document" required>
    <input type="file" name="file" required>
    <button type="submit" name="upload" class="btn btn-success">Uploader</button>
</form>

<!-- Liste des documents -->
<table class="table">
    <tr>
        <th>ID</th><th>Titre</th><th>Fichier</th><th>Action</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM documents");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>
                <a href='{$row['file_path']}' download class='btn btn-primary'>Télécharger</a>
            </td>
            <td><a href='documents.php?delete={$row['id']}' class='btn btn-danger'>Supprimer</a></td>
        </tr>";
    }
    ?>
</table>

<?php include('../includes/footer.php'); ?>
