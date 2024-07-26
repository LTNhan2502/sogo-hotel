$(document).ready(function(){
    const selectRoom = $('#select_room');
    const selectedRoomId = $("#selected_room_id").data("selected_room_id")
    const cardContainer = $('#room_cards');
    const overlay = $('#overlay');
    const showCardsBtn = $('#show_cards_btn');

    //Hiển thị sẵn nếu đã có $_GET['selected_room_id']
    if(selectedRoomId && selectedRoomId != 0){
        $("#select_room").val(selectedRoomId).trigger("change", [{ roomId: selectedRoomId }]);
        //Loại bỏ các selected trước đó
        $("#room_cards .card").removeClass('selected');
        // Thêm lớp 'selected' vào card hiện tại
        $("#room_cards .card[data-room_select_id='" + selectedRoomId + "']").addClass('selected');
        getDetail(selectRoom, selectedRoomId)
    }

    //Hiển thị các card khi nhấn vào button
    showCardsBtn.on('click', function(event) {
        event.stopPropagation();
        console.log(selectedRoomId);
        cardContainer.toggle();
        overlay.show();
        $('body').css('overflow', 'hidden'); //Chặn scroll
    });

    //Ẩn card khi ấn ra ngoài
    $(document).on('click', function(event) {
        if (!cardContainer.is(event.target) && cardContainer.has(event.target).length === 0 && event.target !== showCardsBtn[0]) {
            cardContainer.hide();
            overlay.hide();
            $('body').css('overflow', ''); //Cho phép scroll
        }
    });

    //Ẩn card và overlay khi nhấn vào overlay
    overlay.on('click', function() {
        cardContainer.hide();
        overlay.hide();
        $('body').css('overflow', ''); //Cho phép scroll
    });

    //Chặn scroll khi đã click vào show_cards_btn
    cardContainer.on('scroll', function(event) {
        event.stopPropagation();
    });

    //Click vào card thì thực các event
    $(document).on("click", "#room_cards .card", function(){
        // Loại bỏ lớp 'selected' từ tất cả các card
        $("#room_cards .card").removeClass('selected');
        // Thêm lớp 'selected' vào card hiện tại
        $(this).addClass('selected');

        //Xoá tất cả thông tin trong DOM
        $("#selected_name").text('');
        $("#selected_img").attr("src", '');
        $("#selected_price").text('');
        $("#service_list").empty();
        $("#requirement_list").empty();
        $("#stay-time").empty();
        $("#selected_sum").empty();
        $("#from, #to").val('');

        // Cập nhật giá trị của <select> và kích hoạt sự kiện change
        const roomId = $(this).closest('.room_card_list').data('room_select_id');
        $("#select_room").val(roomId).trigger("change", [{ roomId: roomId }]);
        console.log("RoomID: "+roomId);

        //Ẩn container chứa card và overlay khi click chọn 1 card
        cardContainer.hide();
        overlay.hide();
        $('body').css('overflow', ''); //Cho phép scroll
    });

    var isRequested = false; //Biến kiểm tra xem AJAX đã gửi request chưa
    $(document).on('change', '#select_room', function(event, extraData){
        var $input = $(this);
        const value_id = extraData ? extraData.roomId : $(this).val();
        console.log("Change event triggered!");
        // var value_id = $(this).val();
        console.log("Selected value:", value_id);

        // console.log(roomId);
        // $("#service_list").empty(); 
        // $("#requirement_list").empty();
        // $("#stay-time").empty();
        // $("#selected_sum").empty();
        // $("#from, #to").val('');
        //Reset các phần tử DOM trước đó
        $("#selected_name").text('');
        $("#selected_img").attr("src", '');
        $("#selected_price").text('');
        $("#service_list").empty(); //Để khi đổi sang phòng khác, các thẻ li sẽ không bị ghi đè
        $("#requirement_list").empty();
        $("#stay-time").empty();
        $("#selected_sum").empty();
        $("#from, #to").val('');
        
        getDetail($input, value_id)
    });    

    //Kiểm tra nếu AJAX vẫn chưa gửi request thì ẩn các div
    if(isRequested == false){
        $("#selected_info").hide(300);
        $("#selected_detail_price").hide(300);
        $("#selected_message").hide(300);
    };

    //Function gọi ajax để hiển thị thông tin
    function getDetail(input, value_id){
        $.ajax({
            url: "Controller/user/booking.php?act=show_detail",
            method: "GET",
            data: {value_id},
            dataType: "JSON",
            success: function(res){
                //Nếu đối tượng được chọn có thông tin đầy đủ
                if(res.id > 0 && res.id != undefined){
                    isRequested = true; 
                    input.val(value_id);
                    $("#selected_info").show(300);
                    $("#selected_detail_price").show(300);
                    $("#selected_message").hide(300);
                    $("#selected_name").text(res.name);
                    $("#selected_img").attr("src", "Content/images/"+res.img);

                    let value = (+res.price);
                    const formattedValue = value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    $("#selected_price").text(formattedValue); 
                    //Dấu + là để ép chuỗi thành số, như parseInt()
                    $("#selected_price").data("price", (+res.price));

                    $("#stay-time").text("");
                    $("#selected_sum").text("");
                    $("#from, #to").val('');
                    
                }
                //Nếu đối tượng được chọn là các phòng nhưng chưa có thông tin chi tiết
                else if(res.id == undefined && value_id != 0){
                    isRequested = true;
                    $("#selected_info").hide(300);
                    $("#selected_detail_price").hide(300);
                    $("#selected_message").show(300);
                }
                //Nếu đối tượng được chọn là ---Hãy chọn phòng---
                else if(res.id == undefined && value_id == 0){
                    isRequested = false;
                    $("#selected_info").hide(300);
                    $("#selected_detail_price").hide(300);
                    $("#selected_message").hide(300);
                }
                // console.log(res.name);
                //Nếu log ra là [{...}] thì cần phải res[0].name
                
            }
        });

        //Hiển thị dịch vụ
        $.ajax({
            url: "Controller/admin/admin_room_book.php?act=show_detail",
            method: "GET",
            data: {value_id},
            dataType: "JSON",
            success: function(res){
                var sv_name = res.service_name;
                var sv_arr = sv_name.split(" - ");

                for(let i = 0; i < sv_arr.length; i++){
                    $("#service_list").append('<li>'+ sv_arr[i] +'</li>');
                }                
            }    
        });

        //Hiển thị yêu cầu
        $.ajax({
            url: "Controller/admin/admin_room_book.php?act=show_detail",
            method: "GET",
            data: {value_id},
            dataType: "JSON",
            success: function(res){
                var rqm = res.requirement;
                var rqm_arr = rqm.split(" - ");
                 for(let i = 0; i < rqm_arr.length; i++){
                    $("#requirement_list").append('<li>'+ rqm_arr[i] +'</li>')
                 }
            }
        })
    }
})