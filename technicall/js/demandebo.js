$(document).ready(function () {

    $('#tablebo').DataTable({
        dom: 'lftip',
        pagingType: "simple_numbers",
        lengthMenu: [5, 10, 15],
        pageLength: 10,
        order: [[1, 'desc'], [0, 'asc']],
        language: {
            url: "../DataTables/media/French.json"
        }
    });


});