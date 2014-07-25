<a class="menu-item" href="amministratore/login">Home</a></li>
    <?php
        $categorie = $vd->getMenuCategorie();
        
        foreach ($categorie as $categoria) {
            echo "<a class=\"menu-item\" href=\"amministratore/".$categoria->getNome()."\">".$categoria->getNome()."</a>";
        }
    ?>
