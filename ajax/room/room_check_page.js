$(document).ready(function(){
    $('.pagination a').click(function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        
        console.log(page);
        $.ajax({
            type: 'GET',
            url: 'Controller/admin/admin_room_check.php?act=pages',
            data: {page},
            success: function(html) {
                $('tbody').html(html);
                window.history.pushState(null, null, 'admin_index.php?action=admin_room_check&page=' + page);
                window.location.reload();
            }
        });
    });
});
