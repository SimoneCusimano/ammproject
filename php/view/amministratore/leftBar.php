<h2>Navigazione</h2>
<ul>
    <?php
    $categorie = $vd->getMenuCategorie();
    //print_r($categorie);
        foreach ($categorie as $categoria) {
            echo "<li><a href=\"amministratore/".$categoria->getNome()."\">".$categoria->getNome()."</a></li>";
        }
    ?>
</ul>
