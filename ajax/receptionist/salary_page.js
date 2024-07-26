$(document).ready(function(){
    $('.pagination a').click(function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var limit = $("#limit").data("limit");
        console.log(page);

        $.ajax({
            type: 'GET',
            url: 'Controller/admin/admin_rec_salary.php?act=pages',
            data: {page, limit},
            success: function(html) {
                $('tbody').html(html);
                window.history.pushState(null, null, 'admin_index.php?action=admin_rec_salary&page=' + page);
                window.location.reload();
            }
        });
    });
});
