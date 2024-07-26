$(document).ready(function(){
    //Đưa vào phần khôi phục
    $(document).on("click", "#soft_delete_btn", function(){
        let customer_booked_id = $(this).closest("tr").find("#customer_booked_id").data("customer_booked_id")

        Swal.fire({
            title: "Xoá tài khoản khách hàng này?",
            text: "Tài khoản bị xoá có thể xem lại trong phần Khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Huỷ",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_cus_list.php?act=soft_delete",
                    method: "POST",
                    data: {customer_booked_id},
                    dataType: "JSON",
                    success: function(res){
                        // console.log(res);
                        if(res.status == 200){
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
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }
        });
    })

    //Xoá vĩnh viễn
    $(document).on("click", "#delete_btn", function(){
        let customer_booked_id = $(this).closest("tr").find("#customer_booked_id").data("customer_booked_id")

        Swal.fire({
            title: "Xoá tài khoản khách hàng này?",
            text: "Tài khoản bị xoá sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Huỷ",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_cus_list.php?act=cpl_delete",
                    method: "POST",
                    data: {customer_booked_id},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 200){
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
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }
        });
    })

    //Khôi phục
    $(document).on("click", "#restore_btn", function(){
        let customer_booked_id = $(this).closest("tr").find("#customer_booked_id").data("customer_booked_id")

        Swal.fire({
            title: "Khôi phục?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Không",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_cus_list.php?act=restore_customer",
                    method: "POST",
                    data: {customer_booked_id},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 200){
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
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            }
        });
    })
})