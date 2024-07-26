$(document).ready(function() {
    // Gán giá trị đã nhập vào url để khi reload trang nó sẽ truyền ngược vào input
    //Tạo đối tượng từ chuỗi url hiện tại
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('keyword')) {
        //Lấy giá trị của keyword trên url để truyền vào input
        $('#search').val(urlParams.get('keyword'));     
    }
    
    // Hàm để thực hiện tìm kiếm và phân trang
    function fetchRooms(search_value, page, limit) {
        $.ajax({
            url: search_value ? "Controller/admin/admin_room_list.php?act=search&keyword=" + search_value + "&page=" + page : 'Controller/admin/admin_room_list.php?act=pages',
            method: "GET",
            data: { search_value, page, limit },
            success: function(res) {
                $('#room_list_body').empty().append(res);
                window.history.pushState(null, null, 'admin_index.php?action=admin_room_list&page=' + page + (search_value ? '&keyword=' + search_value : ''));
                bindEvents(); // Gọi hàm mở modal sau khi cập nhật DOM

                if($("#room_list_body").children().length == 0){
                    $('#room_list_body').html('<tr><td colspan="8" class="text-center"><h3>Không có thông tin!</h3></td></tr>');
                    $("#div_nav").empty()
                }else{
                    window.location.reload()
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    // Bắt sự kiện mở modal và các sự kiện khác nếu cần
    function bindEvents() {
        $(document).on("click", ".modal_btn", function() {
            var target = $(this).data("target");
            $(target).modal('show');
        });
    }

    // Bắt sự kiện khi người dùng thay đổi giá trị trong ô tìm kiếm
    $(document).on("change", "#search", function() {
        var search_value = $(this).val();
        var page = 1; // Đặt lại trang về 1 khi thực hiện tìm kiếm mới
        var limit = $("#limit").data("limit");
        fetchRooms(search_value, page, limit);
    });

    // Bắt sự kiện khi người dùng nhấp vào phân trang
    $(document).on("click", ".pagination a", function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var search_value = $("#search").val();
        var limit = $("#limit").data("limit");
        fetchRooms(search_value, page, limit);
    });

    // Gọi hàm ràng buộc sự kiện khi trang được tải lần đầu
    bindEvents();
});
