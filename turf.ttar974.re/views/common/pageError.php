
<div class="error-page">
    <h1>Oups! ça peut arriver!</h1>
    <h2><?=($msgError)??'';?></h2>
    <p><?php echo "<pre>";print_r($_SESSION['profil']??"");echo "</pre>";?></p>
</div>
