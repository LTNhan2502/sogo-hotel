$(document).ready(function(){
    // Mở form thêm thông tin chi tiết cho room
    $(document).on("click", ".open-create-detail", function(){
        let $parent = $(this).closest(".parent");
        let $createDetail = $parent.find(".create-detail");
        
        if ($createDetail.hasClass("hide")) {
            $createDetail.removeClass("hide").addClass("show");
            $parent.find(".open-btn").addClass("hide");
            $parent.find(".before-open-h5").addClass("hide");
            $parent.find(".after-open-h5").addClass("show");
        } else if ($createDetail.hasClass("show")) {
            $createDetail.removeClass("show").addClass("hide");
        }
    });
});
    