<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix du Mode de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .option {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background-color: #fff;
            cursor: pointer;
            transition: 0.3s;
        }
        .option:hover {
            background-color: #e0e0e0;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Choisissez votre mode de connexion</h1>

    <?php
    // Tableau des options de connexion
    $modes = [
        "ssh" => [
            "title" => "🔐 Connexion SSH",
            "description" => "Utilisez SSH pour accéder en ligne de commande au serveur.",
            "url" => "ssh://ton_utilisateur@ip_du_serveur:2222"
        ],
        "vnc" => [
            "title" => "🖥️ Connexion VNC/NoVNC",
            "description" => "Utilisez VNC pour accéder à une interface graphique distante.",
            "url" => "http://ip_du_serveur:6080"
        ],
        "rdp" => [
            "title" => "💻 Connexion RDP",
            "description" => "Utilisez RDP pour accéder à un poste Windows à distance.",
            "url" => "rdp://ip_du_serveur"
        ]
    ];

    // Affichage des options dynamiquement
    foreach ($modes as $key => $mode) {
        echo "<div class='option'>
                <h2>{$mode['title']}</h2>
                <p>{$mode['description']}</p>
                <form action='' method='POST'>
                    <input type='hidden' name='mode' value='$key'>
                    <button type='submit'>Se connecter</button>
                </form>
              </div>";
    }

    // Redirection en PHP selon le choix de l'utilisateur
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_mode = $_POST["mode"];
        if (isset($modes[$selected_mode])) {
            header("Location: " . $modes[$selected_mode]["url"]);
            exit();
        }
    }
    ?>
</div>

</body>
</html>
