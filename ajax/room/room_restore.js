$(document).ready(function(){    
    //Xoá (soft delete)
    $(document).on('click',"#delete_room_id", function(){
        let delete_room_id = $(this).closest('tr').find('#id').data("id");
        Swal.fire({
            title: "Xoá phòng này?",
            text: "Sau khi xoá phòng có thể vào Khôi phục để xem!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=delete_room",
                    method: "POST",
                    data: {delete_room_id},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 'success'){
                            Swal.fire({                                    
                                title: "Xoá phòng thành công!",
                                text: res.message,
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload()
                            });
                            
                        }else{
                            Swal.fire({                                    
                                title: "Xoá phòng thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }
                    },
                    error: function(){
                        Swal.fire({                                
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })

    //Xoá hoàn toàn (delete)
    $(document).on('click',"#cpl_delete_room_id", function(){
        let delete_room_id = $(this).closest('tr').find('#id').data("id");
        Swal.fire({
            title: "Xoá phòng này?",
            text: "Sau khi xoá phòng sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=cpl_delete_room",
                    method: "POST",
                    data: {delete_room_id},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 'success'){
                            Swal.fire({                                    
                                title: "Xoá phòng thành công!",
                                text: res.message,
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload()
                            });
                            
                        }else{
                            Swal.fire({                                    
                                title: "Xoá phòng thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }
                    },
                    error: function(){
                        Swal.fire({                                
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })

    //Khôi phục   
    $(document).on('click',"#restore_room", function(){
        let restore_room_id = $(this).closest('tr').find('#id').data("id");
        Swal.fire({
            title: "Khôi phục?",
            text: "Khi khôi phục xong, hãy vào Quản lí phòng để xem!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=restore_room",
                    method: "POST",
                    data: {restore_room_id},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 'success'){
                            Swal.fire({                                    
                                title: "Khôi phục phòng thành công!",
                                text: res.message,
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            });
                            setTimeout(function(){
                                window.location.reload();
                            }, 930)
                        }else{
                            Swal.fire({                                    
                                title: "Khôi phục phòng thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }
                    },
                    error: function(){
                        Swal.fire({                                
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })
})