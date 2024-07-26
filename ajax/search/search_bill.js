$(document).ready(function() {
    // Gán giá trị đã nhập vào url để khi reload trang nó sẽ truyền ngược vào input
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('keyword')) {
        $('#search').val(urlParams.get('keyword'));
    }
    
    // Hàm để thực hiện tìm kiếm và phân trang
    function fetchRooms(search_value, page, limit) {
        $.ajax({
            url: search_value ? "Controller/admin/admin_bill_list.php?act=search&keyword=" + search_value + "&page=" + page : 'Controller/admin/admin_bill_list.php?act=pages',
            method: "GET",
            data: { search_value, page, limit },
            dataType: "JSON",
            success: function(res) {
                var html = '';
                if ($("#bill_list").children().length == 0) {
                    $('#bill_list').html('<div><h3 class="text-center">Không có thông tin!</h3></div>');
                    $("#div_nav").empty();
                } else {
                    for(let i = 0; i < res.length; i++) {
                        html += '<div class="col">';
                        html += '<div class="card h-100 shadow bg-body-tertiary rounded">';
                        html += '<div class="card-body">';
                        html += '<h5 class="card-title">ID đặt phòng: <span class="badge badge-primary" style="float: right;">' + res[i].booked_room_id + '</span></h5>';
                        html += '<h5 class="card-title">ID KH: <span class="badge badge-primary" style="float: right;">' + res[i].customer_booked_id + '</span></h5>';
                        html += '<div class="card-text">';
                        html += '<div>Khách hàng: <span>' + res[i].customer_name + '</span></div>';
                        html += '<div>Phòng: <span>' + res[i].room_name + '</span></div>';
                        html += '<div>Tổng: <span>' + res[i].bill_price + '</span></div>';
                        html += '<div>Ngày nhận: <span>' + res[i].bill_arrive + '</span></div>';
                        html += '<div>Ngày trả: <span>' + res[i].bill_leave + '</span></div>';
                        html += '<div>Thanh toán vào: <span>' + res[i].bill_checkout_at + '</span></div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }
                }
                $('#bill_list').html(html);
                window.history.pushState(null, null, 'admin_index.php?action=admin_bill_list&page=' + page + (search_value ? '&keyword=' + search_value : ''));
                window.location.reload()
            },
            error: function(error) {
                console.log(error);
                Swal.fire({
                    title: "Lỗi!",
                    text: "Lỗi không xác định!",
                    icon: "error",
                    timer: 3200,
                    timerProgressBar: true
                });
            }
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
});
