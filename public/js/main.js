

//Quando a página for completamente carregada
$(function(){


    //$(".verifyEmail").on('blur',function(a){
    $(".verifyEmail").on('keyup',function(a){
        console.log("keyup")
            //if ($(this).val().length >= 3 && $(this).val().indexOf("@") > -1){
                var re = /\S+@\S+\.\S+/;
                if (re.test($(this).val())){
                    console.log("ajax")
                    $.ajax( SITE_URL + "/verificar_email/"+$(this).val(),{
                        element:$(this),
                        success:function(res){
                            console.log("resp")
                            console.log(res)
                            if(res.exists){
                                $("#email_exists").show();
                            } else {
                                $("#email_exists").hide();
                            }

                            if (res.exists || res.valid == false){
                                this.element.addClass('is-invalid');
                                this.element.removeClass('is-valid');
                            } else {
                                this.element.removeClass('is-invalid');
                                this.element.addClass('is-valid');
                            }
                        }
                    });
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).removeClass('is-valid');
                }
            //}
        });


})