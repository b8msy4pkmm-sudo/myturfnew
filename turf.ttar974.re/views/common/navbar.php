<nav class="nav-header">
    <ul class="menu-navbar h-80 flex-row flex-end">
        <li class="menu-item logo">
            <p>Mon site TURF</p>
        </li>
        <?php if(isset($_SESSION["profil"])) :?>
            <li class="menu-item">
                <a class="menu-item-link" href="<?= URL?>memberSession/homePage">Accueil</a>
            </li>
            <!-- <li class="menu-item dropdown">
                <a class="menu-item-link" href="#">Suivi<span class="dropdown-menu-symbol"></span></a>
                <ul class="dropdown-menu display-none">
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>member">Simple Gagnant</a>
                    </li>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>member">Simple ZeSchow</a>
                    </li>
                </ul>
            </li> -->
        <?php endif;?>
        <li class="menu-item dropdown">
            <a class="profil-picture menu-item-link" href="#">
                <?php if (!isset($_SESSION['profil'])) :?>
                    <img class="profil" src="<?= URL?>public/pictures/profil.png" title="Se connecter à mon compte" alt="Se connecter à mon compte">
                <?php endif ;?>
                <?php if (isset($_SESSION['profil'])) :?>
                    <img src="<?=URL?>public/pictures/<?= $_SESSION['profil']['picture'];?>" alt="photo de Profil" title="<?=URL?>public/pictures/<?= $_SESSION['profil']['picture'];?>" class="rounded-circle profilPicture">
                <?php endif ;?>
            </a>
            <ul class="dropdown-menu display-none">
                <?php if (!isset($_SESSION['profil'])) :?>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>formForCreateUserAccount">S'inscrire</a>
                    </li>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>formForLoginUserSession">Se connecter</a>
                    </li>
                <?php endif ;?>
                <?php if (isset($_SESSION['profil'])) :?>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/profilMember">Mes infos</a>
                    </li>
                    <?php if (isset($_SESSION['profil']['user_role']) && $_SESSION['profil']['user_role']=="admin") :?>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/manageAccess">Administrer</a>
                    </li>
                    <?php endif ;?>
                    <li class="dropdown-menu-item">
                        <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/disconnection">Quitter</a>
                    </li>
                <?php endif;?>
            </ul>
        </li>
    </ul>
</nav>
<?php if (isset($ssMenu) && $ssMenu) :?>
    <nav class="nav-footer">
        <ul class="flex-row flex-center">
            <li class="menu-item">
                <a class="menu-item-link" href="<?= URL?>member">Quinté +</a>
            </li>
        </ul>
    </nav>
<?php endif; ?> 
