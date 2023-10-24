$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
});

var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector("#formLogin")){

        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;

            if(strEmail == "" || strPassword == "")
            {
                Swal.fire("Por favor", "Escribe usuario y contraseña.", "error");
                return false;
            }else{
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){

                if(request.readyState !=4) return;
                if(request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        //window.location = base_url+'dashboard';
                        window.location.reload(false);
                    }else{
                        Swal.fire("Atención", objData.msg, "error");
                        document.querySelector('#txtPassword').value = "";
                    }
                
                }else{
                    Swal.fire("Atención", "Error en el proceso", "error");
                }
                divLoading.style.display = "none";
                return false;
            }
            }
        }
    }

    if(document.querySelector("#formRecetPass")){
        let formRecetPass = document.querySelector("#formRecetPass");
        formRecetPass.onsubmit = function(e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmailReset').value;
            if(strEmail == "")
            {
                Swal.fire("Por favor", "Escribe tu correo electrónico.", "error");
                return false;
            }else{
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ?
                                new XMLHttpRequest() :
                                new ActiveXObject('Microsoft.XMLHTTP');
                
                var ajaxUrl = base_url+'/login/resetPass';
                var formData = new FormData(formRecetPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                            Swal.fire({
                                title: "",
                                text: objData.msg,
                                allowOutsideClick: false,
                                icon: "success",
                                confirmButtonText: "Aceptar",
                                
                            })
                                .then(resultado => {
                                    if (resultado.value) {
                                         window.location = base_url;
                                    }
                                })
                            }else{
                                Swal.fire("Atención", objData.msg, "error");
                            }
                        }
                        else{
                                Swal.fire("Atención", "Error en el proceso", "error");
                            }
                            divLoading.style.display = "none";
                            return false;
                        
                        
                    
                }
            }
        }
    }

    if(document.querySelector("#formCambiarPass")){
        let formCambiarPass = document.querySelector("#formCambiarPass");
        formCambiarPass.onsubmit = function(e){
            e.preventDefault();

            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
            let idUsuario = document.querySelector('#idUsuario').value;

            if(strPassword == "" || strPasswordConfirm ==""){
                Swal.fire("Por favor", "Escribe la nueva contraseña", "error");
                return false;
            }else{
                if(strPassword.length < 5){
                    Swal.fire("Atención", "La contraseña debe tener un minimo de 5 caracteres.", "info");
                    return false;
                }else{
                if(strPassword != strPasswordConfirm){
                    Swal.fire("Atención", "Las contraseñas no coinciden. Intente nuevamente.", "error");
                    return false;
                }
            }
                
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');

                var ajaxUrl = base_url+'/Login/setPassword';
                var formData = new FormData(formCambiarPass);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){

                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        
                        var objData = JSON.parse(request.responseText);

                        if(objData.status)
                        {
                            Swal.fire({
                                title: "",
                                text: objData.msg,
                                icon: "success",
                                allowOutsideClick: false,
                                confirmButtonText: "Iniciar Sesión",
                            })
                                .then(resultado => {
                                    if (resultado.value){
                                        window.location = base_url+'login';
                                    }
                                })
                        }else{
                            Swal.fire("Atención", objData.msg, "error");
                        }
                    }else{
                        Swal.fire("Atención","Error en el proceso","error");
                    }
                    divLoading.style.display = "none";
                }

            }
        }
    }
}, false);