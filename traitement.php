<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die('Erreur');
}

$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$sexe = isset($_POST['sexe']) ? $_POST['sexe'] : '';
$ville = isset($_POST['ville']) ? $_POST['ville'] : '';
$loisirs = isset($_POST['loisirs']) ? $_POST['loisirs'] : array();
$animaux = isset($_POST['animaux']) ? trim($_POST['animaux']) : '';

$nom = htmlspecialchars($nom);
$email = htmlspecialchars($email);
$sexe = htmlspecialchars($sexe);
$ville = htmlspecialchars($ville);
$animaux = htmlspecialchars($animaux);

$erreurs = array();

if (empty($nom)) {
    $erreurs[] = "Le nom est obligatoire";
} else if (strlen($nom) < 2 || strlen($nom) > 50) {
    $erreurs[] = "Le nom doit faire entre 2 et 50 caractères";
}

if (empty($email)) {
    $erreurs[] = "L'email est obligatoire";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs[] = "Email invalide";
}

if (empty($password)) {
    $erreurs[] = "Le mot de passe est obligatoire";
} else if (strlen($password) < 6 || strlen($password) > 20) {
    $erreurs[] = "Le mot de passe doit faire entre 6 et 20 caractères";
}

if ($sexe != 'H' && $sexe != 'F') {
    $erreurs[] = "Sexe invalide";
}

$villes_ok = array('Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Bordeaux');
if (!in_array($ville, $villes_ok)) {
    $erreurs[] = "Ville invalide";
}

if (empty($loisirs)) {
    $erreurs[] = "Choisissez au moins un loisir";
} else {
    $loisirs_ok = array('Sport', 'Lecture', 'Musique', 'Cinéma', 'Voyage');
    foreach ($loisirs as $l) {
        if (!in_array($l, $loisirs_ok)) {
            $erreurs[] = "Loisir invalide";
            break;
        }
    }
}

if (count($erreurs) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Erreurs</title>
    </head>
    <body class="container">
        <h1 class="text-center mt-5">Erreurs</h1>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($erreurs as $err): ?>
                    <li><?php echo $err; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="index.html" class="btn btn-secondary">Retour</a>
    </body>
    </html>
    <?php
    exit;
}

$profils = array(
    array('nom' => 'Dupont', 'email' => 'dupont@mail.com', 'sexe' => 'H', 'ville' => 'Paris', 'loisirs' => array('Sport', 'Musique')),
    array('nom' => 'Martin', 'email' => 'martin@mail.com', 'sexe' => 'F', 'ville' => 'Lyon', 'loisirs' => array('Lecture', 'Cinéma')),
    array('nom' => 'Durand', 'email' => 'durand@mail.com', 'sexe' => 'H', 'ville' => 'Marseille', 'loisirs' => array('Sport', 'Voyage')),
    array('nom' => 'Bernard', 'email' => 'bernard@mail.com', 'sexe' => 'F', 'ville' => 'Paris', 'loisirs' => array('Musique', 'Lecture')),
    array('nom' => 'Petit', 'email' => 'petit@mail.com', 'sexe' => 'H', 'ville' => 'Lyon', 'loisirs' => array('Sport', 'Cinéma')),
);

$resultats = array();
foreach ($profils as $p) {
    $ok = true;
    
    if ($p['sexe'] != $sexe) {
        $ok = false;
    }
    
    if ($p['ville'] != $ville) {
        $ok = false;
    }
    
    $commun = false;
    foreach ($loisirs as $l) {
        if (in_array($l, $p['loisirs'])) {
            $commun = true;
            break;
        }
    }
    if (!$commun) {
        $ok = false;
    }
    
    if ($ok) {
        $resultats[] = $p;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Résultat</title>
</head>
<body class="container">
    
    <h1 class="text-center mt-5">Inscription réussie</h1>
    
    <div class="card mt-4">
        <div class="card-body">
            <h3>Vos informations</h3>
            <p><b>Nom :</b> <?php echo $nom; ?></p>
            <p><b>Email :</b> <?php echo $email; ?></p>
            <p><b>Sexe :</b> <?php echo ($sexe == 'H') ? 'Homme' : 'Femme'; ?></p>
            <p><b>Ville :</b> <?php echo $ville; ?></p>
            <p><b>Loisirs :</b> <?php echo implode(', ', $loisirs); ?></p>
            <p><b>Animaux :</b> <?php echo !empty($animaux) ? $animaux : 'Aucun'; ?></p>
        </div>
    </div>

    <h2 class="mt-5">Profils correspondants (<?php echo count($resultats); ?>)</h2>
    
    <?php if (count($resultats) == 0): ?>
        <div class="alert alert-warning">Aucun profil trouvé</div>
    <?php else: ?>
        <?php foreach ($resultats as $r): ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h4><?php echo $r['nom']; ?></h4>
                    <p>Email : <?php echo $r['email']; ?></p>
                    <p>Ville : <?php echo $r['ville']; ?></p>
                    <p>Loisirs : <?php echo implode(', ', $r['loisirs']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <a href="index.html" class="btn btn-secondary mt-4 mb-5">Retour au formulaire</a>

</body>
</html>
