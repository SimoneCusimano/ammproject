<div class="content">
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Iva</th>
            <th>Prezzo Vendita</th>
            <th>Quantita'</th>
            <th>Categoria</th>
        </tr>

        
        <?php
        $prodotti = $vd->getProdotti();
        foreach ($prodotti as $prodotto) {
            echo "<tr>";
                echo "<th>".$prodotto->getId()."</th>";
                echo "<th>".$prodotto->getNome()."</th>";
                echo "<th>".$prodotto->getDescrizione()."</th>";
                echo "<th>".$prodotto->getIva()."</th>";
                echo "<th>".$prodotto->getPrezzoVendita()."</th>";
                echo "<th>".$prodotto->getQuantita()."</th>";
                echo "<th>".$prodotto->getCategoria()."</th>";
            echo "</tr>";
        }
    ?>
    </table>
</div>
