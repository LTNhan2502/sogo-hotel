$(document).ready(function(){
    $('.pagination a').click(function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        
        console.log(page);
        $.ajax({
            type: 'GET',
            url: 'Controller/admin/admin_bill_list.php?act=pages',
            data: 'page=' + page,
            dataType: "JSON",
            success: function(res) {
                var html = '';
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
                $('#bill_list').html(html);
                window.history.pushState(null, null, 'admin_index.php?action=admin_bill_list&page=' + page);
                window.location.reload();
            }
            
        });
    });
});
