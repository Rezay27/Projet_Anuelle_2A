<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
if (isset($_POST['Modifier'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $point = $_GET['point'];

        $nom = htmlspecialchars($_POST['nom']);
        $nb_heure = htmlspecialchars($_POST['nb_heure']);
        $unite = htmlspecialchars($_POST['unite']);
        $prix = htmlspecialchars($_POST['total']);

        if ($point == 1) {
            $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , point_unite = ? , point_demande = ? where id_demandes = ? ");
            $modif_info->execute(array($nom, $nb_heure, $unite, $prix, $id));
        } else {
            $modif_info = $bdd->prepare("update demandes set nom_demande = ? , nb_heure = ? , taux_horaire = ? , prix_demande = ? where id_demandes = ? ");
            $modif_info->execute(array($nom, $nb_heure, $unite, $prix, $id));
        }
        header('Location:gestionBoDemandesPerso.php?modif=ok');

    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <link href="../../css/css.css" rel="stylesheet">

    <title>Gestion Demandes BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>
    <div class="divBO">
        <section class="bloc1BO">
            <h3> Demandes Personnalisé</h3>
            <?php if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                echo '<p style=\'color : green \'> La demande à bien été modifié ! </p>';
            };
            $demande = $bdd->query("SELECT * FROM `demandes` where statut_demande = 0 AND type_demande = 'perso'  ");

            if (isset($demandes['prix_demande'])) {
                $point = 0;
            } else {
                $point = 1;
            }
            ?>
            <table id="tablebo">
                <thead>
                <tr>
                    <th> Demande n°</th>
                    <th> Demandeur</th>
                    <th> Nom</th>
                    <th> Nombre_heure</th>
                    <th>Taux Unité</th>
                    <th> Prix Total</th>
                    <th> Lieu</th>
                    <th> Date</th>
                    <th> Modifier</th>
                    <th> Devis</th>
                </tr>
                </thead>
                <?php while ($demandes = $demande->fetch()) {
                    if (isset($demandes['prix_demande'])) {
                        $point = 0;
                    } else {
                        $point = 1;
                    }
                    ?>
                    <form action="gestionBoDemandesPerso.php" method="post">
                        <tr>
                            <td><input class="modifie" type="text" name="demande"
                                       value="<?php echo $demandes['id_demandes']; ?>"></td>
                            <td><input class="modifie" type="text" name="membre"
                                       value="<?php echo $demandes['id_membre']; ?>"</td>
                            <td><input class="modifie" type="text" name="nom"
                                       value="<?php echo $demandes['nom_demande']; ?>"></td>
                            <td><input class="modifie" type="text" name="nb_heure"
                                       value="<?php echo $demandes['nb_heure']; ?>"></td>
                            <?php
                            if ($demandes['prix_demande']!== null) { ?>
                                <td><input class="modifie" type="text" name="unite" value="<?php echo $demandes['taux_horaire'] ?> ">€</td>
                                <td><input class="modifie" type="text" name="total" value="<?php echo $demandes['prix_demande']?> ">€</td>
                                <?php } else { ?>
                                <td><input class="modifie" type="text" name="unite" value="<?php echo $demandes['point_unite']; ?> ">points</td>
                                <td><input class="modifie" type="text" name="total" value="<?php echo $demandes['point_demande'] ?> ">points</td>
                            <?php } ?>
                            <td><input class="modifie" type="text" name="adresse"
                                       value="<?php echo $demandes['adresse'] ?>"><input class="modifie" type="text"
                                                                                         name="ville"
                                                                                         value="<?php echo $demandes['ville'] ?>"><input
                                        class="modifie" type="text" name="cp"
                                        value="<?php echo $demandes['code_postal'] ?>"></td>
                            <td><input class="modifie" type="date" name="date"
                                       value="<?php echo $demandes['date_demande'] ?>"><input class="modifie"
                                                                                              type="time" name="time"
                                                                                              value="<?php echo $demandes['heure'] ?>">
                            </td>
                            <td><a href="generationDevisBo.php?demande=<?= $demandes['id_demandes'] ?>"
                                > Générer le devis </a></td>
                            <td>
                                <input formaction="gestionBoDemandesPerso.php?id=<?= $demandes['id_demandes'] . "&point=" . $point; ?>"
                                       type="submit" name="Modifier" value="Modifier*"></td>
                        </tr>
                    </form>
                <?php } ?>
            </table>
        </section>
    </div>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>