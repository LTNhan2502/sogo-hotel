$(document).ready(function(){
    let isText = false;
    let isInput = false;
    //Hiển thị pass
    function showPass(btn, input){
        $(document).on("click", btn, function(){   
            if(isText == false){
                $(input).attr("type", "text");
                isText = true;
            }
            else if(isInput == false){
                $(input).attr("type", "password");
                isShow = false;
            }
        });
    }
})