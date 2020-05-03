<?php
session_start();
ob_start();
$date = date("d-m-Y");
$heure = date("H:i");
include('../include/connect_bdd.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="../../css/bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../DataTables/media/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../DataTables/media/css/datatable.css">
    <script type="text/javascript" src="../../js/demandebo.js"></script>
    <link href="../../css/css.css" rel="stylesheet">
    <title>Gestion Historique BO</title>
</head>
<body>
<?php include('../include/header.php'); ?>
<main>
    <?php include('gestionBomenue.php'); ?>

    <section>
        <div class="divBO">
            <section  class="bloc1BO">
                <h3> Historique </h3>
                <?php
                $demande = $bdd ->prepare ("SELECT * FROM `demandes` where date_demande < now() group by ref_devis ");
                $demande ->execute(array());

                if(isset($_GET['search']) && !empty($_GET['search'])){
                    $search = htmlspecialchars($_GET['search']);
                    $selectid = $bdd -> prepare('select id_membre from membre where nom = ? ');
                    $selectid->execute(array($search));
                    $id_m = $selectid->fetch();
                    $search= $id_m['id_membre'];
                    $demande = $bdd -> query("SELECT * FROM demandes WHERE id_membre LIKE '%".$search."%' and date_demande < now() group by ref_devis  ");
                }
                ?>
                <form  method="get">
                    <label  class="search" for="">Rechercher les demandes d'un client :</label>
                    <input class="search" type="search" name="search" placeholder="Recherche..." value="<?php if(isset($search)){ echo $search;} ?>">
                    <input class="search" type="submit" name="" value="Valider">
                </form>
                <table class="tablebo">
                    <tr>
                        <th> Demande n° </th>
                        <th> Demandeur </th>
                        <th> Nom Intervention </th>
                        <th > Lieu </th>
                        <th> Date </th>
                        <th> Heure </th>
                        <th> Facture n° </th>
                        <th> Devis n° </th>
                        <th> Détail</th>
                    </tr>
                    <?php while($demandes = $demande->fetch()){ ?>
                    <tr>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                        <?php
                        $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                        $membres->execute(array($demandes['id_membre']));
                        $membre = $membres->fetch();
                        ?>
                        <td><input class="modifie" type="text"
                                   value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                        <td > <input class="modifie" type="text" value="<?php echo $demandes['nom_demande']; ?>">  </td>
                        <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                        <td> <input class="modifie" type="date" value="<?php echo $demandes['date_demande']?>"></td>
                        <td> <input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                        <?php if($demandes['type_demande']=='simple'){?>
                        <td> <a href="../../images/Devis/<?php echo $demandes['ref_devis'];?>"><?php echo $demandes['ref_devis']; ?></a></td>
                        <?php }else{ ?>
                        <td> <a href="../../images/DevisPerso/<?php echo $demandes['ref_devis'];?>"><?php echo $demandes['ref_devis']; ?></a></td>
                        <?php }?>
                        <?php if($demandes['type_demande']=='simple'){?>
                        <td> <a href="../../images/Facture/<?php echo $demandes['ref_facture'];?>"><?php echo $demandes['ref_facture']; ?></a></td>
                        <?php }else{ ?>
                        <td> <a href="../../images/FacturePerso/<?php echo $demandes['ref_facture'];?>"><?php echo $demandes['ref_facture']; ?></a></td>
                        <?php }?>
                        <td>
                            <a  href="gestionBoDetailDemande.php?facture=<?= $demandes['ref_facture']; ?>&&id_membre=<?= $demandes['id_membre']; ?>"
                                class="popupinfo"> Detail </a></td>
                    </tr>
                    <?php } ?>
                </table>
            </section>
            <section  class="bloc1BO">
                <h3> Demandes refusées </h3>
                <?php
                $demande = $bdd ->query ("SELECT * from demandes where refuser = 1");

                ?>
                <table>
                    <tr>
                        <th> Demande n°
                        <th>Demandeur</th>
                        <th> Nom Intervention </th>
                        <th > Lieu </th>
                        <th> Date </th>
                        <th> Heure </th>
                    </tr>
                    <?php while($demandes = $demande->fetch()){ ?>
                        <tr>
                            <td > <input class="modifie" type="text" value="<?php echo $demandes['id_demandes'];?>"></td>
                            <?php
                            $membres = $bdd->prepare('select nom,prenom from membre where id_membre = ? ');
                            $membres->execute(array($demandes['id_membre']));
                            $membre = $membres->fetch();
                            ?>
                            <td><input class="modifie" type="text"
                                       value="<?php echo $membre["nom"] . ' ' . $membre['prenom']; ?>"</td>
                            <td > <input class="modifie" type="text" value="<?php echo $demandes['nom_demande']; ?>">  </td>
                            <td> <input class="modifie" type="text" value="<?php echo $demandes['adresse']?>"><input class="modifie" type="text" value="<?php echo $demandes['ville']?>"><input class="modifie" type="text" value="<?php echo $demandes['code_postal']?>"></td>
                            <td> <input class="modifie" type="date" value="<?php echo $demandes['date_demande']?>"></td>
                            <td> <input class="modifie" type="time" value="<?php echo $demandes['heure']?>"></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </section>
</main>
<?php include('../include/footer.php'); ?>
</body>
</html>

