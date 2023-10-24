let tableClientes;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableClientes = $('#tableClientes').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Clientes/getClientes",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idpersona" },
            { "data": "identificacion" },
            { "data": "nombres" },
            { "data": "apellidos" },
            { "data": "telefono" },
            { "data": "email_user" },
            { "data": "options" }
         ],

        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info",
                "exportOptions": {
                    "columns": [0,1,2,3,4,5]
                }
            }
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if(document.querySelector("#formCliente")){

        let formCliente = document.querySelector("#formCliente");
        formCliente.onsubmit = function(e) {
            e.preventDefault();
            let strIdentificacion = document.querySelector('#txtIdentificacion').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strNit = document.querySelector('#txtNit').value;
            let strNomFiscal = document.querySelector('#txtNombreFiscal').value;
            let strDirFiscal = document.querySelector('#txtDirFiscal').value;
            let strPassword = document.querySelector('#txtPassword').value;
            
            
    
            if(strIdentificacion == '' || strApellido == '' || strNombre == '' || strEmail == '' || strNit == '' || strNomFiscal == '' || strDirFiscal == '')
            {
                Swal.fire({
                    target: document.getElementById('modalFormCliente'),
                    icon: 'error',
                    title: 'Atención',
                    text: 'Todos los campos son obligatorios',
                    
                  }
                  );
                return false;
            }
    
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++){
                if(elementsValid[i].classList.contains('is-invalid')) {
                    Swal.fire("Atención", "Por favor verifique los campos en rojo." , "error" );
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Clientes/setCliente';
            let formData = new FormData(formCliente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tableClientes.ajax.reload();
                        }else{
                            
                            rowTable.cells[1].textContent = strIdentificacion;
                            rowTable.cells[2].textContent = strNombre;
                            rowTable.cells[3].textContent = strApellido;
                            rowTable.cells[4].textContent = intTelefono;
                            rowTable.cells[5].textContent = strEmail;
                            
                        }
                        
                        Swal.fire({
                            target: document.getElementById('modalFormCliente'),
                            icon: 'success',
                            title: '',
                            text: objData.msg,
                            
                          }
                          );
                          //$('#modalFormCliente').modal("hide");
                        formCliente.reset();
                        
                    }else{
                        Swal.fire({
                            target: document.getElementById('modalFormCliente'),
                            icon: 'error',
                            title: '',
                            text: objData.msg,
                            
                          }
                          );
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        } 
    }



},false);

function fntViewInfo(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                document.querySelector("#celNombre").innerHTML = objData.data.nombres;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidos;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                document.querySelector('#celIde').innerHTML = objData.data.nit;
                document.querySelector('#celNomFiscal').innerHTML = objData.data.nombrefiscal;
                document.querySelector('#celDirFiscal').innerHTML = objData.data.direccionfiscal;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                $('#modalViewCliente').modal('show');
            }else{
                Swal.fire({
                    target: document.getElementById('modalFormCliente'),
                    icon: 'success',
                    title: '',
                    text: objData.msg,
                    
                  }
                  );
            }
        }
    }

    

}

function fntEditInfo(element,idpersona){

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML="Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            
            if(objData.status)
            {
                
                document.querySelector('#idUsuario').value = objData.data.idpersona;
                document.querySelector('#txtIdentificacion').value = objData.data.identificacion;
                document.querySelector('#txtNombre').value = objData.data.nombres;
                document.querySelector('#txtApellido').value = objData.data.apellidos;
                document.querySelector('#txtTelefono').value = objData.data.telefono;
                document.querySelector('#txtEmail').value = objData.data.email_user;
                document.querySelector('#txtNit').value = objData.data.nit;
                document.querySelector('#txtNombreFiscal').value = objData.data.nombrefiscal;
                document.querySelector('#txtDirFiscal').value = objData.data.direccionfiscal;
               

            }
        }

        $('#modalFormCliente').modal('show');
        
    }

    

}

function fntDelInfo(idpersona) {

    Swal.fire({
        title: "Eliminar Cliente",
        text: "¿Realmente deseas eliminar el Cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, Cancelar!"
    })
        .then(resultado => {
            if (resultado.value) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //validamos que navegador estamos usando
                let ajaxUrl = base_url+'/Clientes/delCliente';
                let strData = "idUsuario=" + idpersona;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire("Eliminado", objData.msg, "success");
                            tableClientes.ajax.reload(); 
                            
                        } else {
                            Swal.fire("Atención!", objData.msg, "error");
                        }
                        
                    }
                    
                }
                

            } else {
                //Hicieron click en no
                
            }
            
        });
        
}

function openModal(){
    rowTable = "";
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector('#formCliente').reset();
    $('#modalFormCliente').modal('show');
}