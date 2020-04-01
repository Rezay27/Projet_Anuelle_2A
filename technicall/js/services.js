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
});
