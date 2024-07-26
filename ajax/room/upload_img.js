//xử lý khi có sự kiện click thằng an làm
$('#upload_img').on('click', function () {
    //Lấy ra files
    var file_data = $('#file').prop('files')[0];
    //lấy ra kiểu file
    var type = file_data.type;
    //Xét kiểu file được upload
    var match = ["image/gif", "image/png", "image/jpg","image/jpeg"];
    //kiểm tra kiểu file
    if (type == match[0] || type == match[1]  || type == match[2] || type == match[3]) {
        //khởi tạo đối tượng form data
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', file_data);
        //sử dụng ajax post
        $.ajax({
            url: 'Controller/admin/admin_room_list.php?act=upload_img', 
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,    
            type: 'post',
            success: function (res) {
                var data = JSON.parse(res);
                if(data.status==200){
                    //gán src  
                    $('#link_url').attr('value', data.data);
                    $('#image_url').attr('src', data.data);
                    $('#image_url_0').attr('src', data.data);
                // console.log(res);
                }else{
                    console.log(data.message);
                    alert(data.message);
                }                
            }
        });
    } else {
        $('#img_error').text('Chỉ được upload file ảnh');
        $('#file').val('');
    }
    return false;
});