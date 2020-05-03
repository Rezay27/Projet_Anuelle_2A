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


//------------Verification pseudo-----------
function verifPseudo(champ)
{
  var regex = new RegExp("^[a-zA-Z0-9]{5,25}$","g");
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur").innerHTML ='Votre pseudo doit contenir entre 5 et 25 caractère sans caractère spéciaux !';
    return false;

  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur").innerHTML ='';
    return true;


  }
}

//---------Verification prenom -------
function verifPrenom(champ)
{
  var regex = new RegExp("^[a-zA-Z]{2,30}$","g");
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur1").innerHTML ='Votre prenom ne doit pas contenir de chiffre ni de caractère spéciaux !';
    return false;

  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur1").innerHTML ='';
    return true;


  }
}


//------------Verification nom --------------
function verifNom(champ)
{
  var regex = new RegExp("^[a-zA-Z]{2,30}$","g");
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur2").innerHTML ='Votre nom ne doit pas contenir de chiffre ni de caractère spéciaux !';
    return false;

  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur2").innerHTML ='';
    return true;


  }
}

//-------------Verification mot de passe -----------
function verifMdp(champ)
{
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
  var n1 = document.inscription.password;
  var n2 = document.inscription.conf_password;

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

// -------------- Verification email ------------
function verifMail(champ)
{
  var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur5").innerHTML ='Veuillez entrer une adresse mail valide';
    return false;
  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur5").innerHTML ='';
    return true;
  }
}

function verifMail2(champ)
{
  let n1 = document.inscription.email.value;
  let n2 = document.inscription.conf_email.value;

  if (n1 == n2){

    surligne(champ, false);
    document.getElementById("erreur6").innerHTML ='';
    return true;
  }
  else{
    surligne(champ, true);
    document.getElementById("erreur6").innerHTML ='Votre adresse mail doit être identique';
    return false;
  }
}

//------------------Verification Date Naissance ------------

function verifBirth(champ)
{
  var c1 = document.inscription.date_naissance;
  if( c1.value==""){
    surligne (champ,true);
    document.getElementById("erreur7").innerHTML ='Veuillez entrer une date de naissance';
    return false;
  }
  else{
    surligne(champ,false);
    document.getElementById("erreur7").innerHTML ='';
    return true;
  }
}

//-------------Verificiation telephone ------------

function verifTel(champ)
{
  var regex = new RegExp("^[0-9]{10}$","g");
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur8").innerHTML ='Veuillez entrer un numéro de téléphone valide ! ';
    return false;
  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur8").innerHTML ='';
    return true;
  }
}




//---------- Verification Chechbox -------
function verifBox (champ)
{
  if (document.inscription.condition.checked==false){
    alert("Veuillez accepter les conditions");
    return false;
  }
  else{
    return true;
  }
}

//-----------------Verif cp ----------------
function verifCp(champ)
{
  var regex = new RegExp("^[0-9]{5}$","g");
  if(!regex.test(champ.value))
  {
    surligne(champ, true);
    document.getElementById("erreur8").innerHTML ='Le code postal doit contenir 5 numeros!';
    return false;

  }
  else
  {
    surligne(champ, false);
    document.getElementById("erreur8").innerHTML ='';
    return true;


  }
}

//--------------- Verification total ------------

function verifF(f)
{
  var pseudoOk = verifPseudo(f.pseudo);
  var prenomOk = verifPrenom(f.prenom);
  var nomOk = verifNom(f.nom);
  var mailOk = verifMail(f.email);
  var mail2Ok = verifMail2(f.conf_email);
  var mdpOk = verifMdp(f.password);
  var mdp2Ok = verifMdp2(f.conf_password);
  var checkOk = verifBox(f.condition);
  var birthOk = verifBirth(f.date_naissance);
  var cpOk = verifCp(f.code_postal);


  if(cpOk == true && nomOk == true && prenomOk == true && birthOk == true && checkOk == true && pseudoOk == true && mailOk == true && mail2Ok == true && mdpOk == true && mdp2Ok == true)
  {
    return true;
  }
  else
  {

    alert("Veuillez remplir correctement tous les champs");
    return false;
  }
}
