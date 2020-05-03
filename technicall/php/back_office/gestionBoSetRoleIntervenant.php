<?php
session_start();
include('../include/connect_bdd.php');

if(isset($_POST['valider_role_intervenant_bo']) && isset($_GET['id']))
{
    $idIntervenant= htmlspecialchars($_GET['id']);
    $role=$bdd->query("SELECT * FROM role");

    while($roles = $role->fetch()){
        $name_role = $roles["nom_role"];
        $id_role = $roles["id_role"];

        $checkequal = $bdd->prepare("SELECT * FROM role_intervenant WHERE id_role = ? and id_intervenant = ? " );
        $checkequal->execute(array($id_role,$idIntervenant));
        $count=$checkequal->fetch();

        if ($count != null){
            if (!isset($_POST[$name_role])){
                $del = $bdd->prepare("DELETE FROM role_intervenant WHERE id_role_intervenant= ?");
                $del->execute(array($count["id_role_intervenant"]));
            }

        }
        else{
            if(isset($_POST[$name_role])){
                $idRole=htmlspecialchars($_POST[$name_role]);

                $insert = $bdd -> prepare("insert into role_intervenant(id_role,id_intervenant) values (:id_role,:id_intervenant)");
                $insert->execute(array(
                    "id_role" => $idRole,
                    "id_intervenant" => $idIntervenant
                ));
            }
        }
    }
    header('Location:gestionBoAttributionRoleIntervenant.php?modif=ok');
}


?>