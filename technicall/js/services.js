let total_demande = 0;
$(document).ready(function () {
    $("#popup").hide();
    $("#popupadd").hide();
    $('#tableDS').DataTable({
        dom : 'lftip',
        pagingType: "simple_numbers",
        lengthMenu:[5,10,15],
        pageLength: 10,
        order: [[1, 'desc'], [0, 'asc']],
        language: {
            url: "../DataTables/media/French.json"
        }
    });
    $('.listds').on("click",function(){
        var nameservice = this.innerHTML;
        var priceservice = $(this).parents('.odd , .even').children('.price_td').children('.listds');
        var typeservice = $(this).parents('.odd , .even').children(':last').children('.listds');
        $("#popup").show();
        $(".nameservice").html(nameservice);
        $("#nameservices").attr("value",nameservice);
        $(".priceservice").html("Tarif : " + priceservice.html() );
        $('#tarifservices').attr("value",priceservice.html());
        $(".typeservice").html("Type : " + typeservice.html());
        $('#typeservices').attr("value",typeservice.html());
    });
    $('.submitservice').on("click",function(){
        $('#popup').hide();
    });
    $('#button_add').on("click",function(){
        $('#popupadd').show();
    });

    $('.nb_heure_demande').on("keyup",function(){
        var totalm = $(this).parents('.number_td').next().next('.total_td').children('p').html();
        totalm = totalm.split(' ');
        total_demande =  total_demande - parseInt(totalm[0]) ;
        $('.prix_Ttotal').text('Total : ' + total_demande + '€');

        var nb_heure = this.value;
        var tarif = $(this).parents('.number_td').next('.price_td').children().html();
        var total = nb_heure * tarif;
        $(this).parents('.number_td').next().next('.total_td').children('p').text(total + '€');
        console.log();
        console.log(total);
        var checkbox = $(this).parents().prev().prev('.checkbox').children('.checkbox_demande');
        console.log(checkbox);

        if((checkbox).is(':checked')){
            var price =  $(this).parents('.number_td').next().next('.total_td').children('p').html();
            price = price.split('€');
            total_demande = parseInt(price[0]) + total_demande;
            $('.prix_Ttotal').text('Total : ' + total_demande + '€');
        }
    });

        $('.checkbox_demande').change(function () {
            if (this.checked) {
                var totalp = $(this).parents('.checkbox').next().next().next().next().children().html();
                totalp = totalp.split(' ');
                total_demande = parseInt(totalp[0]) + total_demande;
                console.log(total_demande);
                $('.prix_Ttotal').text('Total : ' + total_demande + '€');
            }else {
                var totalm = $(this).parents('.checkbox').next().next().next().next().children().html();
                totalm = totalm.split(' ');
                total_demande =  total_demande - parseInt(totalm[0]) ;
                console.log(total_demande);
                $('.prix_Ttotal').text('Total : ' + total_demande + '€');
            }
        });

});
