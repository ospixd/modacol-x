var tableRoles;
vLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {
    tableRoles = $('#tableRoles').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Roles/getRoles",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idrol" },
            { "data": "nombrerol" },
            { "data": "descripcion" },
            { "data": "status" },
            { "data": "options" }

        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });


    //Nuevo Rol
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function (e) {
        e.preventDefault();

        var intIdRol = document.querySelector('#idRol').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector('#listStatus').value;
        if (strNombre == '' || strDescripcion == '' || intStatus == '') {
            Swal.fire("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        divLoading.style.display = "flex";
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/Roles/setRol';
        var formData = new FormData(formRol);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    Swal.fire("Roles de usuario", objData.msg, "success");
                    tableRoles.ajax.reload();
                } else {
                    Swal.fire("Error", objData.msg, "error");
                }
                
            }
            divLoading.style.display = "none";
                return false;

        }

    }
});

$('#tableRoles').DataTable();

function openModal() {
    document.querySelector('#idRol').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector('#formRol').reset();
    $('#modalFormRol').modal('show');
}

window.addEventListener('load', function () {
    // fntEditRol();
    // fntDelRol();
    // fntPermisos();

}, false);

function fntEditRol(idrol) {
    // var btnEditRol = document.querySelectorAll('.btnEditRol');
    // btnEditRol.forEach(function (btnEditRol) {
    //     btnEditRol.addEventListener('click', function () {
            document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
            document.querySelector('#btnText').innerHTML = "Actualizar";

            var idrol = idrol; //this.getAttribute("rl");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/Roles/getRol/' + idrol;
            request.open("GET", ajaxUrl, true);
            request.send();

            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {

                    var objData = JSON.parse(request.responseText);

                    if (objData.status) {
                        document.querySelector("#idRol").value = objData.data.idrol;
                        document.querySelector("#txtNombre").value = objData.data.nombrerol;
                        document.querySelector("#txtDescripcion").value = objData.data.descripcion;

                        if (objData.data.status == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }

                        var htmlSelect = `${optionSelect}
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        `;

                        document.querySelector("#listStatus").innerHTML = htmlSelect;
                        $('#modalFormRol').modal('show');
                    } else {
                        Swal.fire("Error", objData.msg, "error");
                    }
                }
            }


    //     });
    // });
}


function fntDelRol(idrol) {
    // var btnDelRol = document.querySelectorAll('.btnDelRol');
    // btnDelRol.forEach(function (btnDelRol) {
    //     btnDelRol.addEventListener('click', function () {
            var idrol = idrol; //this.getAttribute("rl");
            Swal.fire({
                title: "Eliminar Rol",
                text: "¿Realmente deseas eliminar el rol?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, Cancelar!"
            })
                .then(resultado => {
                    if (resultado.value) {
                        //Hicieron click en si
                        console.log("eliminando dato");
                        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //validamos que navegador estamos usando
                        var ajaxUrl = base_url + '/Roles/delRol';
                        var strData = "idrol=" + idrol;
                        request.open("POST", ajaxUrl, true);
                        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        request.send(strData);
                        request.onreadystatechange = function () {
                            if (request.readyState == 4 && request.status == 200) {
                                var objData = JSON.parse(request.responseText);
                                if (objData.status) {
                                    Swal.fire("Eliminado", objData.msg, "success");
                                    tableRoles.ajax.reload();
                                } else {
                                    Swal.fire("Atención!", objData.msg, "error");
                                }
                            }
                        }

                    } else {
                        //Hicieron click en no
                        console.log("no s eelimina el dato");
                    }
                });
    //     });
    // });
}

//Función para los permisos de los roles
function fntPermisos(idrol) {
    
            
            var idrol = idrol; //Obtenemos el elemento al hacer click rl= id del rol
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //validamos que navegador estamos usando
            var ajaxUrl = base_url+'/Permisos/getPermisosRol/'+idrol; //URL de ruta concatenando permisos (controlador) y metodo getPermisosRol
            request.open("GET",ajaxUrl,true); //abrimos la conexión
            request.send(); //enviamos petición

            request.onreadystatechange = function(){ //validación
                if(request.readyState == 4 && request.status == 200){
                    document.querySelector('#contentAjax').innerHTML = request.responseText;
                    $('.modalPermisos').modal('show'); //Mostrar elemento Modal 
                    document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
                    
                    
                    
                }
            }
            


}

function fntSavePermisos(evnet){
    evnet.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos';
    var formElement = document.querySelector("#formPermisos");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                Swal.fire({
                    target: document.getElementById('modalPermisos'),
                    icon: 'success',
                    title: 'Permisos de usuario',
                    text: objData.msg,
                    
                  }
                  );
            }else{
                Swal.fire("Error", objData.msg , "error");
            }
            
        }
    }
}


function cancel(){
    location.reload();
}


