<?php
include_once 'ViewDescriptor.php';
include_once basename(__DIR__) . '/../Settings.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?= $vd->getTitolo() ?></title>
        <base href="<?= Settings::getApplicationPath() ?>php/"/>
        <link href="../css/global.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
        <script type="text/javascript" src="../js/qualcosa.js"></script>
    </head>

    <body>
        <div id="page">
            <div id="header">
                <?php
                    $logo = $vd->getLogoFile();
                    require "$logo";
                ?>
                <div id="menu">
                    <?php
                        $menu = $vd->getMenuFile();
                        require "$menu";
                    ?>
                </div>
            </div>
            
            <div id="sidebarLX">
                <li id="categories">
                    <?php
                        $left = $vd->getLeftBarFile();
                        require "$left";
                    ?>
                </li>
            </div>
            
            <div id="content">
                <?php
                    if ($vd->getMessaggioErrore() != null) {
                ?>
                <div class="error">
                    <div>
                        <?=
                            $vd->getMessaggioErrore();
                        ?>
                    </div>
                </div>
                <?php
                    }
                ?>
                <?php
                    if ($vd->getMessaggioConferma() != null) {
                ?>
                        <div class="confirm">
                            <div>
                                <?=
                                    $vd->getMessaggioConferma();
                                ?>
                            </div>
                        </div>
                <?php
                    }
                ?>
                
                <?php
                    $content = $vd->getContentFile();
                    require "$content";
                ?>

            </div>
            <div id="footer">
                <p>
                    Progetto per l'esame di Amministrazione di Sistema.
                </p>
            </div>
        </div>
    </body>
</html>

