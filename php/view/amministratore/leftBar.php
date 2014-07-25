<h2>Navigazione</h2>
<ul>
    <?php
    $categorie = $vd->getMenuCategorie();
    //print_r($categorie);
        echo "<li><a href=\"amministratore/Registro\">Registro</a></li>";
        foreach ($categorie as $categoria) {
            echo "<li><a href=\"amministratore/".$categoria->getNome()."\">".$categoria->getNome()."</a></li>";
        }
    ?>
</ul>
