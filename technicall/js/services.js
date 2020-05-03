let total_demande = 0;
let tab = [];
$(document).ready(function () {

    // DATATABLE
    $('#tableDS').DataTable({
        dom: 'lftip',
        pagingType: "simple_numbers",
        lengthMenu: [5, 10, 15],
        pageLength: 10,
        order: [[1, 'desc'], [0, 'asc']],
        language: {
            url: "../DataTables/media/French.json"
        }
    });
    // END DATATABLE

    // POP UP INFO CLIENT
    $("#popupinfo").hide();

    $('.valide_total').on("click", function () {
        $("#popupinfo").show();

    });

    $('.submitservicenormal').on("click", function () {
        $('#popupinfo').hide();
        tab.pop();
    });
    // END POP UP INFO CLIENT

    // POP UP ADD SERVICE PERSO
    $("#popupadd").hide();

    $('.submitservice').on("click", function () {
        $('#popupadd').hide();
    });

    $('#button_add').on("click", function () {
        $('#popupadd').show();
    });
    // END POP UP ADD SERVICE PERSO

    // MISE EN PLACE AFFICHAGE PRIX TABLEAU
    $(".nb_heure_demande").prop('disabled', true);

    $('.nb_heure_demande').on("keyup", function () {
        var totalm = $(this).parents('.number_td').next().next('.total_td').children('p').html();
        var lastChar1 = totalm.substr(totalm.length-1);
        totalm = totalm.split(' ');
        total_demande = total_demande - parseInt(totalm[0]);
        if(lastChar1 === "€") {
            $('.prix_Ttotal').val('Total : ' + total_demande + ' €');
        }else{
            $('.prix_Ttotal').val('Total : ' + total_demande + ' points');
        }
        var name1 = $(this).parents(".number_td").prev().children().html();
        tab.forEach(function (name) {
            if (name.name === name1) {
                var index = tab.indexOf(name);
                tab.splice(index, 1);
            }
        });

        var nb_heure = this.value;
        var tarif = $(this).parents('.number_td').next('.price_td').children().html();
        var total = nb_heure * tarif;
        //$(this).parents('.number_td').next().next('.total_td').children('p').text(total + ' €');
        var totalp =  $(this).parents('.number_td').next().next('.total_td').children('p').html();
        var lastChar2 = totalp.substr(totalp.length-1);
        if(lastChar2 === "€") {
            $(this).parents('.number_td').next().next('.total_td').children('p').text(total + ' €');
        }else {
            $(this).parents('.number_td').next().next('.total_td').children('p').text(total + ' points');
        }

        var checkbox = $(this).parents().prev().prev('.checkbox').children('.checkbox_demande');

        t_horaire = $(this).parents('.number_td').next().children().html();


        if ((checkbox).is(':checked')) {
            var nb_heure = this.value;
            var price = $(this).parents('.number_td').next().next('.total_td').children('p').html();
            var lastChar3 = price.substr(price.length-1);
            price = price.split(' ');
            total_demande = parseInt(price[0]) + total_demande;
            if(lastChar3 === "€") {
                $('.prix_Ttotal').val('Total : ' + total_demande + ' €');
            }else{
                $('.prix_Ttotal').val('Total : ' + total_demande + ' points');
            }
            tab.push({name: $(this).parents('.number_td').prev().children().html(), nombre_h: nb_heure,taux_h : t_horaire, prix_total :price[0]});
            console.log(tab);

            var amount = total_demande * 100;
            console.log(amount);
             $(this).parentsUntil("body").find("#popupinfo").children(":last").find('script').children('.stripe-button').attr("data-amount", amount);
        }
    });

    $('.checkbox_demande').change(function () {
        if (this.checked) {
            var inputA = $(this).parents('.checkbox').next().next('.number_td').children();
            inputA.prop("disabled", false);
            var totalp = $(this).parents('.checkbox').next().next().next().next().children().html();
            var lastChar4 = totalp.substr(totalp.length-1);
            totalp = totalp.split(' ');
            total_demande = parseInt(totalp[0]) + total_demande;
            console.log(total_demande);
            if(lastChar4 === "€") {
                $('.prix_Ttotal').val('Total : ' + total_demande + ' €');
            }else{
                $('.prix_Ttotal').val('Total : ' + total_demande + ' points');
            }
            var t_horaire = $(this).parents('.checkbox').next().next().next().children().html();
            tab.push({name: $(this).parents('.checkbox').next().children().html(), nombre_h:  inputA , taux_h: t_horaire, prix_total : totalp[0]});
            console.log(tab)
        } else {
            var inputD = $(this).parents('.checkbox').next().next('.number_td').children();
            inputD.prop('disabled', true);
            var totalm = $(this).parents('.checkbox').next().next().next().next().children().html();
            var lastChar5 = totalm.substr(totalm.length-1);
            totalm = totalm.split(' ');
            total_demande = total_demande - parseInt(totalm[0]);
            if(lastChar5 === "€") {
                $('.prix_Ttotal').val('Total : ' + total_demande + ' €');
            }else{
                $('.prix_Ttotal').val('Total : ' + total_demande + ' points');
            }
            var name1 = $(this).parents(".checkbox").next().children().html();
            tab.forEach(function (name) {
                if (name.name === name1) {
                    var index = tab.indexOf(name);
                    tab.splice(index, 1);
                }
            });
        }
    });
    // END AFFICHAGE PRIX TABLEAU

    // ENVOIE DU TABLEAU
    $('.valide_total').on("click",function(){
        var tableau = [];
        var total = $(this).parents('.divSubmit').prev().children().val();
        total = total.split(" ");
        tab.push({prix_total : total[2]});
        tab.forEach(function (name) {
            for(const key in name){
                tableau.push(name[key]);
            }
        });
       var tableaujoin = tableau.join('-');
       console.log(tableaujoin);

       $('.tableau_demande').html(tableaujoin);

    });

    // END ENVOIE DU TABLEAU

    $('#prixtotal').change(function(){
        // Stripe accepts payment amounts in cents so we have to convert dollars to cents by multiplying by 100
        var amount = parseInt( $(this).val()*100);
        console.log(amount);
        $(".stripe-button").attr( "data-amount", amount );
    });

});
