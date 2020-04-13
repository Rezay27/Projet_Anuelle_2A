//-------------Fonction surligne ------------

function surligne(champ, erreur)
{
    if(erreur)
        champ.style.boxShadow = " 0 0 5px  #d6486e";
    // champ.style.backgroundColor = "#d18478";
    else
    // champ.style.backgroundColor = "#03D201r";
        champ.style.boxShadow ="0 0 5px green";

}


//------------Verification nom-----------
function verifNom(champ)
{
    var regex = new RegExp("^[a-zA-Z0-9]{5,25}$","g");
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        document.getElementById("erreur_nom").innerHTML ='Le nom de l\'abonnement doit contenir entre 5 et 25 caractère sans caractère spéciaux !';
        return false;

    }
    else
    {
        surligne(champ, false);
        document.getElementById("erreur_nom").innerHTML ='';
        return true;


    }
}

//------------Verification description 1-----------
function verifDescription1(champ)
{
    var length = document.addabonnementbo.description1_abonnement.value.length;
    if(length > 100)
    {
        surligne(champ, true);
        document.getElementsByClassName("erreur_description1").innerHTML ='La description 1 ne doit pas dépasser 50 caractère !';
        return false;

    }
    else
    {
        surligne(champ, false);
        document.getElementsByClassName("erreur_description1").innerHTML ='';
        return true;

    }
}

//------------Verification description 2-----------
function verifDescription2(champ)
{
    var length = document.addabonnementbo.description2_abonnement.value.length;
    if(length > 100)
    {
        surligne(champ, true);
        document.getElementsByClassName("erreur_description2").innerHTML ='La description 2 ne doit pas dépasser 50 caractère !';
        return false;

    }
    else
    {
        surligne(champ, false);
        document.getElementsByClassName("erreur_description2").innerHTML ='';
        return true;

    }
}
//------------Verification description 3-----------
function verifDescription3(champ)
{
    var length = document.addabonnementbo.description3_abonnement.value.length;
    if(length > 100)
    {
        surligne(champ, true);
        document.getElementsByClassName("erreur_description3").innerHTML ='La description 3 ne doit pas dépasser 50 caractère !';
        return false;

    }
    else
    {
        surligne(champ, false);
        document.getElementsByClassName("erreur_description3").innerHTML ='';
        return true;

    }
}

//--------------- Verification total ------------

function verifF(f)
{
    var nomOk = verifNom(f.nom_abonnement);
    var description1Ok = verifDescription1(f.description1_abonnement);
    var description2Ok = verifDescription2(f.description2_abonnement);
    var description3Ok = verifDescription3(f.description3_abonnement);


    if(nomOk === true && description1Ok === true && description2Ok === true && description3Ok === true)
    {
        return true;
    }
    else
    {

        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}

