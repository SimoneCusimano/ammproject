<a class="menu-item" href="dipendente/login">Home</a></li>
    <?php
        $categorie = $vd->getMenuCategorie();
        
        foreach ($categorie as $categoria) {
            echo "<a class=\"menu-item\" href=\"dipendente/".$categoria->getNome()."\">".$categoria->getNome()."</a>";
        }
    ?>
