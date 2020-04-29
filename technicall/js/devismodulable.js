$(document).ready(function () {



    $('#addline').on('click',function() {
        console.log("salut");
        var bloc = '<tr><td><input class="" name="nomadd[]" value="" placeholder="Saisir une entité"> </td>\n' +
            '                            <td><input class="nb_heuretd" name="addquantite[]" value="" placeholder="Saisir une quantité"> </td>\n' +
            '                            <td><input class="t_horairetd" name="addthoraire[]" value="" placeholder="Saisir un taux horaire"> </td>\n' +
            '                            <td><input class="totalline" name="addprixt[]" value="" placeholder="Saisir un prix total"> </td></tr>';
        $(this).before(bloc);

    });


    (function calculT(){
        $('.t_horairetd').on('keyup',function () {
            var nb_heure = $(this).parents('td').prev().children().val();
            var t_horaire = $(this).val();
            $(this).parents('td').next().children().val(nb_heure*t_horaire).trigger('change');
        });

        var somme = 0;
        $('.totalline').each(function(i,n){
            somme +=  parseInt($(n).val());
        });

        $('#total').val(somme);
        $('#ht').val(Math.round((somme/1.2)*100)/100);
        var tva = $('#total').val()-$('#ht').val();
        $('#tva').val(Math.round(tva*100)/100);
        setTimeout(calculT,2000);
    })();
});