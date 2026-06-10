<?php

if (!empty($_POST)) {
    $_SESSION['sauvegarde'] = $_POST;

    // Gérer le fichier avant la redirection si nécessaire
    if (!empty($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['fichier']['tmp_name'];
        $dest = '/tmp/' . basename($_FILES['fichier']['name']);
        move_uploaded_file($tmpName, $dest);
        $_SESSION['uploaded_file'] = $dest;
    }

    $fichierActuel = $_SERVER['PHP_SELF'];
    if (!empty($_SERVER['QUERY_STRING'])) {
        $fichierActuel .= '?' . $_SERVER['QUERY_STRING'];
    }

    header('Location: ' . $fichierActuel);
    exit;
}

// Restauration
if (isset($_SESSION['sauvegarde'])) {
    $_POST = $_SESSION['sauvegarde'];
    unset($_SESSION['sauvegarde']);
}
