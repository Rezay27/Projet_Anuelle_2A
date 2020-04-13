<?php session_start();
ob_start();
require('../include/connect_bdd.php');
$date = date("d-m-Y");
$heure = date("H:i");

if (isset($_POST['Modifier'])) {
    if (isset($_GET['abonnement'])) {
        $id = $_GET['abonnement'];

        $select_abonnement = $bdd->prepare("select * from type_abonnement inner join info_abonnement on type_abonnement.id = info_abonnement.type_abonnement where type_abonnement.id = ? ");
        $select_abonnement->execute(array($id));
        $abonnement = $select_abonnement->fetch();

        $nom = htmlspecialchars($_POST['nommodif']);
        $prix = htmlspecialchars($_POST['prixmodif']);
        $description1 = htmlspecialchars($_POST['description1modif']);
        $description2 = htmlspecialchars($_POST['description2modif']);
        $description3 = htmlspecialchars($_POST['description3modif']);
        $nbheure = htmlspecialchars($_POST['nbheuremodif']);

        $modif_type = $bdd->prepare("update type_abonnement set nom=?,prix=? where id=?");
        $modif_type->execute(array($nom, $prix * 100, $id));

        $modif_info = $bdd->prepare("update info_abonnement set description1 = ? , description2 = ? , description3 = ? , nb_heure = ? where type_abonnement = ? ");
        $modif_info->execute(array($description1, $description2, $description3, $nbheure, $id));

        header('Location: gestionBOAbonnement.php?modif=ok');

    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/css.css">
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>

    <section>
        <div class="divBO">
            <section class="bloc1BO">
                <h3> Les Abonnements </h3>
                <section class="servicebloc">
                    <h3> Ajouter un abonnement</h3>
                    <?php
                    if (isset($_GET['add']) && $_GET['add'] == 'ok') {
                    echo '<p style=\'green : red \'> La description 1 est trop longue (200 caractères) ! </p>';
                    }
                    ?>
                    <form onsubmit="return verifF(this)" action="verifaddabonnementbo.php" method="post" name="addabonnementbo" enctype="multipart/form-data" type="formulaire">
                        <label for="nom_abonnement"> Nom :</label>
                        <span id="erreur_nom"></span>
                        <input onblur="verifNom(this)" type="text" name="nom_abonnement" placeholder="Nom de l'abonnement">
                        <label> Prix :</label>
                        <input type="number" name="prix_abonnement" placeholder="Prix de l'abonnement">
                        <label> Description 1 :</label>
                        <span class="erreur_description1"></span>
                        <input ="description1" onblur="verifDescription1(this)" type="text" name="description1_abonnement" placeholder="Description n°1">
                        <label> Description 2 :</label>
                        <span class="erreur_description2"></span>
                        <input class="description" onblur="verifDescription2(this)" type="text" name="description2_abonnement" placeholder="Description n°2">
                        <label> Description 3 :</label>
                        <span class="erreur_description3"></span>
                        <input class="description" onblur="verifDescription3(this)" type="text" name="description3_abonnement" placeholder="Description n°3">
                        <label> Nombre d'heure :</label>
                        <input type="number" name="nombreH_abonnement" placeholder="Nombre d'heure">
                        <input class="submitservice" type="submit" name="valider_abonnement_bo" value="Ajouter le service">
                    </form>
                </section>
                <section >
                </section>
            <br>
                    <h3  class="servicebloc"> Liste des abonnements </h3>
                    <?php
                    $list_abonnements = $bdd->query("select * from type_abonnement inner join info_abonnement on type_abonnement.id = info_abonnement.type_abonnement");

                    if (isset($_GET['suppr']) && $_GET['suppr'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'abonnement à bien été supprimé ! </p>';
                    }

                    if (isset($_GET['modif']) && $_GET['modif'] == 'ok') {
                        echo '<p style=\'color : green \'> L\'abonnement à bien été modifié ! </p>';
                    }

                    ?>
                    <table>
                        <tr>
                            <th> Nom</th>
                            <th> Prix (€)</th>
                            <th> Description n°1</th>
                            <th> Description n°2</th>
                            <th> Description n°3</th>
                            <th> Nombre d'heure</th>
                            <th> Supprimer</th>
                            <th> Modifier</th>
                        </tr>

                        <?php while ($list_abonnement = $list_abonnements->fetch()) { ?>
                            <form action="gestionBOAdmin.php" method="post">
                                <tr>
                                    <td><input class="modifie" type="text" name="nommodif"
                                               value="<?php echo $list_abonnement['nom']; ?>"></td>
                                    <td><input class="modifie" type="text" name="prixmodif"
                                               value="<?php echo $list_abonnement['prix'] / 100; ?>"></td>
                                    <td><textarea class="modifie" type="text"
                                                  name="description1modif"><?php echo $list_abonnement['description1']; ?></textarea>
                                    </td>
                                    <td><textarea class="modifie" type="text"
                                                  name="description2modif"><?php echo $list_abonnement['description2']; ?></textarea>
                                    </td>
                                    <td><textarea class="modifie" type="text"
                                                  name="description3modif"><?php echo $list_abonnement['description3']; ?></textarea>
                                    </td>
                                    <td><input class="modifie" type="text" name="nbheuremodif"
                                               value="<?php echo $list_abonnement['nb_heure']; ?>"></td>
                                    <td><a href="gestionBOAbonnement.php?abonnement=<?= $list_abonnement['nom']; ?>">
                                            Supprimer </a></td>
                                    <?php if (isset($_GET['abonnement']) AND !empty($_GET['abonnement'])) {
                                        $nom = $bdd->prepare("select * from type_abonnement where nom = ? ");
                                        $nom->execute(array($_GET['abonnement']));
                                        $ids = $nom->fetch();
                                        $id = $ids['id'];
                                        var_dump($id);
                                        $delete_info = $bdd->prepare('DELETE from info_abonnement where type_abonnement= ?');
                                        $delete_info->execute(array($id));
                                        $delete_abo = $bdd->prepare('delete from type_abonnement where id=?');
                                        $delete_abo->execute(array($id));
                                        header("Location: gestionBOAbonnement.php?suppr=ok");
                                    } ?>
                                    <td>
                                        <input formaction="gestionBOAbonnement.php?abonnement=<?= $list_abonnement['type_abonnement']; ?>"
                                               type="submit" name="Modifier" value="Modifier *"></td>
                                </tr>
                            </form>
                        <?php } ?>
                    </table>
                    <p>* Pour modifier un abonnement , changer la valeur du champs puis cliquer sur modifier</p>
                </section>
            </section>
        </div>
    </section>
</main>
<?php include('../include/footer.php'); ?>
<script type="text/javascript" src="../../js/abonnement.js"></script>
</body>
</html>
