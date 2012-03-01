/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){  

var form=$("#login-form");
var name=$("#login-input");
var pass=$("#pass-input");

function validateName() 
{
    if(name.val().length==0)
        {
            name.addClass("error");
            $("#error #error-login").css("visibility", "visible");
            return false;
        }
        else 
            {
                name.removeClass("error");
                $("#error #error-login").css("visibility", "hidden");
                return true;
            }
}
function validatePass()
{
    if(pass.val().length<4)
        {
            pass.addClass("error");
            $("#error #pass-error").css("visibility", "visible");
            return false;
        }
        else 
            {
                pass.removeClass("error");
                $("#error #pass-error").css("visibility", "hidden");
                return true;
            }
}

name.blur(validateName);
pass.blur(validatePass);

name.keyup(validateName);
pass.keyup(validatePass);

form.submit(function(){  
    if(validateName() && validatePass())  
        return true  
    else  
        return false;  
    });  
   
$("input#sigin").click(function(){
    $.post("php_script/validation.php",
    {
        login:$("input#login-input").val(),
        pass:$("input#pass-input").val()
    }, 
function(data) {
    $("body").append(data);
                }    
);
return false;
});

}); 