$(document).on("click", "#do_checkout", function(){
    let $input = $(this).closest(".col");
    let booked_room_id = $input.find(".booked_room_id").data("id");
    let customer_booked_id = $input.find(".customer_booked_id").data("customer_id");
    let email = $input.find(".email").data("email");
    let customer_sum = $input.find(".customer_sum").data("customer_sum");
    let arrive = $input.find(".arrive").data("arrive");
    let quit = $input.find(".quit").data("quit");
    let left_at = $input.find(".left").data("left_at");
    let room_name = $input.find(".room_name").data("room_name");
    let customer_name = $input.find(".customer_name").data("customer_name");
    let tel = $input.find(".tel").data("tel");
    
    Swal.fire({
        title: "Thực hiện thanh toán?",
        text: "Thông tin hoá đơn sẽ nằm trong Danh sách hoá đơn!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Thanh toán!",
        cancelButtonText: "Huỷ"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "Controller/admin/admin_room_undo_list.php?act=do_checkout",
                method: "POST",
                data: {booked_room_id, customer_booked_id, email, customer_sum, arrive, quit, left_at, room_name, customer_name, tel},
                dataType: "JSON",
                success: function(res){
                    console.log(res);
                    if(res.status == 'success'){
                        Swal.fire({
                            title: "Thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        }).then(function(){
                            window.location.reload();
                        });
                    }else{
                        Swal.fire({                             
                            title: "Thất bại!",
                            text: "Thanh toán thất bại!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                        setTimeout(function(){
                            window.reload();
                        }, 3250)
                    }                    
                },
                error: function(){
                    Swal.fire({                         
                        title: "Lỗi!",
                        text: "Lỗi không xác định!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                    setTimeout(function(){
                        window.reload();
                    }, 3250)
                }
            })
        }
      });
    
})