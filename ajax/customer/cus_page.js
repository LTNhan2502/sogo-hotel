$(document).ready(function(){
    $('.pagination a').click(function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var limit = $("#limit").data("limit");
        
        console.log(page);
        $.ajax({
            type: 'GET',
            url: 'Controller/admin/admin_cus_list.php?act=pages',
            data: {page, limit},
            success: function(html) {
                $('#rec_list').html(html);
                window.history.pushState(null, null, 'admin_index.php?action=admin_cus_list&page=' + page);
                window.location.reload();
            }
        });
    });
});
