$(document).ready(function(){
    let isShow = false;
    let isreShow = false;
    //Hiển thị pass
    function showPass(btn, input){
        $(document).on("click", btn, function(){   
            if(isShow == false){
                $(input).attr("type", "text");
                isShow = true;
            }
            else{
                $(input).attr("type", "password");
                isShow = false;
            }
        });
    }
})