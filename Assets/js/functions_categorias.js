let tableCategorias;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableCategorias = $('#tableCategorias').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Categorias/getCategorias",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idcategoria" },
            { "data": "nombre" },
            { "data": "descripcion" },
            { "data": "status" },
            { "data": "options" }
         ],

        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Exportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Exportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Exportar a CSV",
                "className": "btn btn-info"
            }
        ],

        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if(document.querySelector("#foto")){  //valida si existe el elemento foto
        let foto = document.querySelector("#foto"); //se crea variable
        foto.onchange = function(e) { //ejecuta todo el evento onchage cuando cambia de valor el input
            let uploadFoto = document.querySelector("#foto").value; //captura el valor
            let fileimg = document.querySelector("#foto").files;
            let nav = window.URL || window.webkitURL; //ruta de la imagen
            let contactAlert = document.querySelector('#form_alert');
            if(uploadFoto !=''){ //verifica si no esta vacio
                let type = fileimg[0].type; //captura el tipo de archivo que se cargo
                let name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){ //se valida si los formatos son diferentes a estos
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>'; //muestra que el archivo no es valido
                    if(document.querySelector('#img')){ //verifica si existe el elemento lo remueve
                        document.querySelector('#img').remove(); //momento donde se remueve
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock"); //lo oculta
                    foto.value=""; //resetea la variable
                    return false; //para que no continue el proceso
                }else{  //si es una imagen valida
                        contactAlert.innerHTML=''; //limpia variable
                        if(document.querySelector('#img')){ //verifica si existe el elemento lo remueve
                            document.querySelector('#img').remove(); //momento donde se remueve
                        }
                        document.querySelector('.delPhoto').classList.remove("notBlock"); //remueve la clase notBlock para que se muestre la x para que la imagen se pueda eliminar
                        let objeto_url = nav.createObjectURL(this.files[0]); //extrae la ruta
                        document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">"; //muestra la imagen que se captura temporal en vista previa
                    }
            }else{ //no se subió foto
                alert("No selecciono foto");
                if(document.querySelector('#img')){ //verifica si existe el elemento lo remueve
                    document.querySelector('#img').remove(); //momento donde se remueve
                }
            }
        }
    }
    
    if(document.querySelector(".delPhoto")){ //valida si existe 
        let delPhoto = document.querySelector(".delPhoto"); //crea variable
        delPhoto.onclick = function(e) { //agrega evento onclick
            document.querySelector('#foto_remove').value = 1;
            removePhoto(); //remueve la foto
        }
    }

}, false);



 //Nueva Categoria
 let formCategoria = document.querySelector("#formCategoria");
 formCategoria.onsubmit = function (e) {
     e.preventDefault();

     let strNombre = document.querySelector('#txtNombre').value;
     let strDescripcion = document.querySelector('#txtDescripcion').value;
     let intStatus = document.querySelector('#listStatus').value;

     if (strNombre == '' || strDescripcion == '' || intStatus == '') {
        Swal.fire({
            target: document.getElementById('modalFormCategorias'),
            icon: 'error',
            title: '',
            text: 'Todos los campos son obligatorios',
            
          }
          );
         return false;
     }

     divLoading.style.display = "flex";
     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
     let ajaxUrl = base_url + '/Categorias/setCategoria';
     let formData = new FormData(formCategoria);
     request.open("POST", ajaxUrl, true);
     request.send(formData);
     request.onreadystatechange = function () {
         if (request.readyState == 4 && request.status == 200) {

             let objData = JSON.parse(request.responseText);
             if (objData.status) {

                if(rowTable == ""){
                    tableCategorias.ajax.reload();
                }else{
                    htmlStatus = intStatus == 1 ?
                    '<span class="me-1 badge bg-success">Activo</span>' :
                    '<span class="me-1 badge bg-danger">Inactivo</span>';
                    rowTable.cells[1].textContent = strNombre;
                    rowTable.cells[2].textContent = strDescripcion;
                    rowTable.cells[3].innerHTML = htmlStatus;
                    
                }
                 //$('#modalFormCategorias').modal("hide");
                 formCategoria.reset();
                 Swal.fire({
                    target: document.getElementById('modalFormCategorias'),
                    icon: 'success',
                    title: '',
                    text: objData.msg,
                    
                  }
                  );
                 removePhoto();
                 //tableCategorias.ajax.reload();
             } else {
                Swal.fire({
                    target: document.getElementById('modalFormCategorias'),
                    icon: 'error',
                    title: '',
                    text: objData.msg,
                    
                  }
                  );
                 
             }
             
         }
         divLoading.style.display = "none";
             return false;

     }

 }

 function fntViewInfo(idcategoria){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {   
                let estado = objData.data.status == 1 ?
                '<span class="me-1 badge bg-success">Activo</span>' :
                '<span class="me-1 badge bg-danger">Inactivo</span>';
                document.querySelector("#celId").innerHTML = objData.data.idcategoria;
                document.querySelector("#celNombre").innerHTML = objData.data.nombre;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#imgCategoria").innerHTML = '<img src="'+objData.data.url_portada+'"></img>';
                
                $('#modalViewCategoria').modal('show');
            }else{
                Swal.fire({
                    target: document.getElementById('modalFormCategorias'),
                    icon: 'error',
                    title: '',
                    text: objData.msg,
                    
                  }
                  );
            }
        }
    }

    

}

function fntEditInfo(element,idcategoria){

    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML="Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {   
                document.querySelector('#idCategoria').value = objData.data.idcategoria;
                document.querySelector('#txtNombre').value = objData.data.nombre;
                document.querySelector('#txtDescripcion').value = objData.data.descripcion;
                document.querySelector('#foto_actual').value = objData.data.portada;
                document.querySelector('#foto_remove').value = 0;

                if(objData.data.status == 1){
                    document.querySelector('#listStatus').value = 1;
                }else{
                    document.querySelector('#listStatus').value = 2;
                }
                $('#listStatus').selectpicker('refresh');

                if(document.querySelector('#img')){
                    document.querySelector('#img').src = objData.data.url_portada;
                }else{
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";
                }

                if(objData.data.portada == 'portada_categoria.png'){
                    document.querySelector('.delPhoto').classList.add("notBlock");
                }else{
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                }

                $('#modalFormCategorias').modal('show');
            }else{
                Swal.fire({
                    target: document.getElementById('modalFormCategorias'),
                    icon: 'error',
                    title: '',
                    text: objData.msg,
                    
                  }
                  );
            }
        }
    }

    

}

function fntDelInfo(idcategoria) {

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
                let ajaxUrl = base_url+'/Categorias/delCategoria';
                let strData = "idcategoria=" + idcategoria;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            Swal.fire("Eliminado", objData.msg, "success");
                            tableCategorias.ajax.reload(); 
                            
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


 function removePhoto(){
    document.querySelector('#foto').value =""; //resetea el valor del input
    document.querySelector('.delPhoto').classList.add("notBlock"); //oculta la x
    if(document.querySelector('#img')){
    document.querySelector('#img').remove(); //elimina la imagen
    }
}


function openModal(){
    rowTable = "";
    document.querySelector('#idCategoria').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
    document.querySelector('#formCategoria').reset();
    $('#modalFormCategorias').modal('show');
    removePhoto();
}