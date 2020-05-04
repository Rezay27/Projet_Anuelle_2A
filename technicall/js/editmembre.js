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



//-------------Verification mot de passe -----------
function verifMdp(champ)
{
    console.log('blabla');
    var regex = new RegExp("^[a-zA-Z0-9]{6,25}$","g");
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        document.getElementById("erreur3").innerHTML ='Votre mot de passe doit contenir entre 6 et 25 caractère sans caractère spéciaux !';
        return false;

    }
    else
    {
        surligne(champ, false);
        document.getElementById("erreur3").innerHTML ='';
        return true;
    }
}

function verifMdp2(champ)
{
    var n1 = document.inscription.editpassword;
    var n2 = document.inscription.editpasswordverif;

    if (n1.value == n2.value){

        surligne(champ, false);
        document.getElementById("erreur4").innerHTML ='';
        return true;
    }
    else{
        surligne(champ, true);
        document.getElementById("erreur4").innerHTML ='Votre mot de passe doit être identique!';
        return false;
    }
}
//--------------- Verification total ------------

function verifF(f)
{

    var mdpOk = verifMdp(f.editpassword);
    var mdp2Ok = verifMdp2(f.editpasswordverif);


    if(mdpOk == true && mdp2Ok == true)
    {
        return true;
    }
    else
    {

        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}
