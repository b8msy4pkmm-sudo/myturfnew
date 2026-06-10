<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta class="description" content="<?= $page_description; ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!--Gestion des css -->
    <?php if (!empty($files_css)) : ?>
        <?php foreach($files_css as $file_css) : ?>
            <link rel="stylesheet" href="<?= URL?>public/css/<?= $file_css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <title><?= $page_title; ?></title>
    <link rel="icon" type="image/x-icon" href="/public/pictures/homepage/horse_racing.ico">
</head>
<body>
    <!-- Espace réservé pour l'entete du site -->
    <?php require ("mainHeader.php");?>

    <!-- Espace réservé pour la secion principale du site -->
    <div class="container-main">
       
    <!-- Espace réservé pour les messages d'alertes -->
        <?php  if(!empty($_SESSION['alert'])) : ?>
            <?php   foreach ($_SESSION['alert'] as $alert) : ?>    
                <div class="zone-alert <?= $alert['type']; ?>">
                    <div class="msg-alert">
                        <?= $alert['message'];?>
                    </div> 
                    <button class="btn-alert"><span class="btn-close material-symbols-outlined">close</span>
                </div>
            <?php endforeach;?>
        <?php unset($_SESSION['alert']); endif ; ?>

        <!-- Contenu de la page -->
        <?= $page_content;?>
    </div>

    <!-- Espace réservé pour le footer du site -->
    <?php require ("mainFooter.php");?> 

    <!--Gestion des javaScripts -->
    <?php if (!empty($files_js)) : ?>
        <?php foreach($files_js as $file_js) : ?>
            <script src="<?= $page_url ?>public/js/<?= $file_js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>