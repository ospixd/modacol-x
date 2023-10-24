document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableProductos;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");

// Prevent Bootstrap dialog from blocking focusin
document.addEventListener('focusin', (e) => {
    if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
      e.stopImmediatePropagation();
    }
  });

  window.addEventListener('load', function(){
    tableProductos = $('#tableProductos').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
      },
      "ajax": {
          "url": " " + base_url + "/Productos/getProductos",
          "dataSrc": ""
      },
      "columns": [
          { "data": "idproducto" },
          { "data": "codigo" },
          { "data": "nombre" },
          { "data": "stock" },
          { "data": "precio" },
          { "data": "status" },
          { "data": "options" }
       ],

       'columnDefs':[
                      { 'className': 'textcenter', 'targets': [ 3 ] },
                      { 'className': 'textright', 'targets': [ 4 ] },
                      { 'className': 'textcenter', 'targets': [ 5 ] }
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


  if(this.document.querySelector("#formProductos")){
    let formProductos = this.document.querySelector("#formProductos");
    formProductos.onsubmit = function(e) {
      e.preventDefault();
      let strNombre = document.querySelector('#txtNombre').value;
      let intCodigo = document.querySelector('#txtCodigo').value;
      let strPrecio = document.querySelector('#txtPrecio').value;
      let intStock = document.querySelector('#txtStock').value;
      let intStatus = document.querySelector('#listStatus').value;
  
      if(strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '')
      {
        Swal.fire({
          target: document.getElementById('modalFormProductos'),
          icon: 'error',
          title: 'Atención',
          text: 'Todos los campos son obligatorios.',
          
        }
        );
        return false;
      }
      if(intCodigo.length < 5){
        Swal.fire({
          target: document.getElementById('modalFormProductos'),
          icon: 'error',
          title: 'Atención',
          text: 'El codigo debe ser mayor de 5 digitos.',
          
        }
        );
        return false;
      }

      divLoading.style.display = "flex"; 
      tinyMCE.triggerSave();

      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url+'Productos/setProducto';
      let formData = new FormData(formProductos);
      request.open("POST",ajaxUrl,true);
      request.send(formData);
      request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
          let objData = JSON.parse(request.responseText);
          if(objData.status)
          {
            //Swal.fire("", objData.msg, "success");
            Swal.fire({
              target: document.getElementById('modalFormProductos'),
              icon: 'success',
              title: 'Completado',
              text: objData.msg,
              
            }
            );
            document.querySelector('#idProducto').value = objData.idproducto;
            document.querySelector("#containerGallery").classList.remove("notblock");

            if(rowTable == ""){
              tableProductos.ajax.reload();
          }else{
              htmlStatus = intStatus == 1 ?
              '<span class="me-1 badge bg-success">Activo</span>' :
              '<span class="me-1 badge bg-danger">Inactivo</span>';
              rowTable.cells[1].textContent = intCodigo;
              rowTable.cells[2].textContent = strNombre;
              rowTable.cells[3].textContent = intStock;
              rowTable.cells[4].textContent = smony+strPrecio;
              rowTable.cells[5].innerHTML = htmlStatus;
              rowTable = "";
          }
            
          }else{
            Swal.fire({
              target: document.getElementById('modalFormProductos'),
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
  }

  if(this.document.querySelector(".btnAddImage")){
    let btnAddImage = document.querySelector(".btnAddImage");
    btnAddImage.onclick = function(e){
      let key = Date.now();
      let newElement = document.createElement("div");
      newElement.id= "div"+key;
      newElement.innerHTML = `
      <div class="prevImage"></div>
      <input type="file" name="foto" id="img${key}" class="inputUploadfile">
      <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload"></i></label>
      <button class="btnDeleteImage notblock" type="button" onClick="fntDelItem('#div${key}');"><i class="fas fa-trash-alt"></i></button>`

      document.querySelector("#containerImages").appendChild(newElement);
      document.querySelector("#div"+key+" .btnUploadfile").click();
      fntInputFile();
    }
  }
    fntInputFile();
    fntCategorias();
  }, false);

  if(document.querySelector("#txtCodigo")){
    let inputCodigo = document.querySelector('#txtCodigo');
    inputCodigo.onkeyup = function () {
      if(inputCodigo.value.length >= 5){
        document.querySelector('#divBarCode').classList.remove("notblock");
        fntBarcode();
      }else{
        document.querySelector('#divBarCode').classList.add("notblock");
      }
    }
  }

  function fntGenerateCode(){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'Productos/generateCode';
    let formData = new FormData(formProductos);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
        let objData = JSON.parse(request.responseText);
          if(objData.status)
          {
            document.querySelector("#txtCodigo").value = objData.codigo;
            let inputCodigo = document.querySelector('#txtCodigo');
            if(inputCodigo.value.length >= 5){
              document.querySelector("#txtNombre").required = true;
              document.querySelector("#txtPrecio").required = true;
              document.querySelector("#txtStock").required = true;
              document.querySelector("#listCategoria").required = true;
              document.querySelector("#listStatus").required = true;
              document.querySelector('#divBarCode').classList.remove("notblock");
              fntBarcode();
            }else{
              document.querySelector('#divBarCode').classList.add("notblock");
            }
          }
      }
    }


   

  }
  

tinymce.init({
	selector: '#txtDescripcion',
  promotion: false,
	width: "100%",
    height: 400,    
    statubar: true,
    plugins:
    "advlist autolink link image lists charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality emoticons Advanced Template paste",
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

function fntInputFile(){
  let inputUploadfile = document.querySelectorAll(".inputUploadfile");
  inputUploadfile.forEach(function(inputUploadfile){
    inputUploadfile.addEventListener('change', function(){
      let idProducto = document.querySelector('#idProducto').value;
      let parentId = this.parentNode.getAttribute("id");
      let idFile = this.getAttribute("id");
      let uploadFoto = document.querySelector("#"+idFile).value;
      let fileimg = document.querySelector("#"+idFile).files;
      let prevImg = document.querySelector("#"+parentId+" .prevImage");
      let nav = window.URL || window.webkitURL;

      if(uploadFoto != '')
      {
        let type = fileimg[0].type;
        let name = fileimg[0].name;
        if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
        {
          prevImg.innerHTML = "Archivo no valido";
          uploadFoto.value = "";
          return false;
        }else
        {
          let objeto_url = nav.createObjectURL(this.files[0]);
          prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/puff.svg" >`;

          let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          let ajaxUrl = base_url+'/Productos/setImage';
          let formData = new FormData();
          formData.append('idproducto',idProducto);
          formData.append("foto", this.files[0]);
          request.open("POST",ajaxUrl,true);
          request.send(formData);
          request.onreadystatechange = function(){
            if(request.readyState !=4) return;
            if(request.status == 200)
            {
              let objData = JSON.parse(request.responseText);
              if(objData.status){
              prevImg.innerHTML = `<img src="${objeto_url}">`;
              document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
              document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
              document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
              }else{
                Swal.fire("Error", objData.msg, "error");
              }
            }
          }


        }
      }
    });
  });
}

function fntDelItem(element)
{
  let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
  let idProducto = document.querySelector("#idProducto").value;
  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'Productos/delFile';
  
  let formData = new FormData();
  formData.append('idproducto',idProducto);
  formData.append("file",nameImg);
  request.open("POST",ajaxUrl,true);
  request.send(formData);
  request.onreadystatechange = function(){
    if(request.readyState != 4)return;
    if(request.status == 200){
      let objData = JSON.parse(request.responseText);
      if(objData.status)
      {
        let itemRemove = document.querySelector(element);
        itemRemove.parentNode.removeChild(itemRemove);
        Swal.fire("", objData.msg,"success");
      }else{
        Swal.fire("", objData.msg,"error");
      }
    }
  }
}

function fntViewInfo(idproducto)
{

  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'Productos/getProducto/'+idproducto;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200)
    {
      let objData = JSON.parse(request.responseText);
      if(objData.status)
      {
        let htmlImage = "";
        let objProducto = objData.data;
        let estadoProducto = objProducto.status == 1 ?
                    '<span class="me-1 badge bg-success">Activo</span>' :
                    '<span class="me-1 badge bg-danger">Inactivo</span>';
        document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
        document.querySelector("#celNombre").innerHTML = objProducto.nombre;
        document.querySelector("#celPrecio").innerHTML = objProducto.precio;
        document.querySelector("#celStock").innerHTML = objProducto.stock;
        document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
        document.querySelector("#celStatus").innerHTML = estadoProducto;
        document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

        if(objProducto.images.length > 0)
        {
          let objProductos = objProducto.images;
          for (let p = 0; p < objProductos.length; p++){
            htmlImage +=`<img src="${objProductos[p].url_image}"></img>`;
          }
        }
        document.querySelector("#celFotos").innerHTML = htmlImage;
        $('#modalViewProducto').modal('show');
      }
      else{
        Swal.fire("Error", objData.msg,"error");
      }

    }
  }




  
}

function fntEditInfo(element,idproducto)
{
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

  let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url+'Productos/getProducto/'+idproducto;
  request.open("GET",ajaxUrl,true);
  request.send();
  request.onreadystatechange = function(){
    if(request.readyState == 4 && request.status == 200)
    {
      let objData = JSON.parse(request.responseText);
      if(objData.status)
      {
        let htmlImage = "";
        let objProducto = objData.data;

        document.querySelector("#idProducto").value = objProducto.idproducto;
        document.querySelector("#txtNombre").value = objProducto.nombre;
        document.querySelector("#txtDescripcion").value = objProducto.descripcion;
        document.querySelector("#txtCodigo").value = objProducto.codigo;
        document.querySelector("#txtPrecio").value = objProducto.precio;
        document.querySelector("#txtStock").value = objProducto.stock;
        document.querySelector("#listCategoria").value = objProducto.categoriaid;
        document.querySelector("#listStatus").value = objProducto.status;

        tinymce.activeEditor.setContent(objProducto.descripcion);
        $('#listCategoria').selectpicker('refresh');
        $('#listStatus').selectpicker('refresh');
        fntBarcode();

        if(objProducto.images.length > 0)
        {
          let objProductos = objProducto.images;
          for (let p = 0; p < objProductos.length; p++){
            let key = Date.now()+p;
            htmlImage += `<div id="div${key}">
            <div class="prevImage">
            <img src="${objProductos[p].url_image}"></img>
            </div>
            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
            <i class="fas fa-trash-alt"></i></button></div>`;
          }
        }
        document.querySelector("#containerImages").innerHTML = htmlImage;
        document.querySelector("#divBarCode").classList.remove("notblock");
        document.querySelector("#containerGallery").classList.remove("notblock");

        $('#modalFormProductos').modal('show');
      }
      else{
        Swal.fire({
          target: document.getElementById('modalFormProductos'),
          icon: 'error',
          title: '',
          text: objData.msg,
          
        }
        );
      }

    }
  }

    
}

function fntDelInfo(idproducto) {
 
  Swal.fire({
      title: "Eliminar producto",
      text: "¿Realmente deseas eliminar el producto?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "No, Cancelar!"
  })
      .then(resultado => {
          if (resultado.value) {
              let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP'); //validamos que navegador estamos usando
              let ajaxUrl = base_url+'/Productos/delProducto';
              let strData = "idproducto=" + idproducto;
              request.open("POST", ajaxUrl, true);
              request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
              request.send(strData);
              request.onreadystatechange = function () {
                  if (request.readyState == 4 && request.status == 200) {
                      let objData = JSON.parse(request.responseText);
                      if (objData.status) {
                          Swal.fire("Eliminado", objData.msg, "success");
                          tableProductos.ajax.reload(); 
                          
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


function fntCategorias()
{
  if(document.querySelector('#listCategoria')){
    let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
      if(request.readyState == 4 && request.status == 200){
        document.querySelector('#listCategoria').innerHTML = request.responseText;
        $('#listCategoria').selectpicker('render');
      }
    }
  }
}


function fntBarcode()
{
  let codigo = document.querySelector("#txtCodigo").value;
  JsBarcode("#barcode", codigo);
}

function fntPrintBarcode(area)
{
  let elementArea = document.querySelector(area);
  let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
  vprint.document.write(elementArea.innerHTML);
  vprint.document.close();
  vprint.print();
  vprint.close();
}



function openModal(){
    rowTable = "";
    document.querySelector('#idProducto').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector('#formProductos').reset();

    document.querySelector('#divBarCode').classList.add("notblock");
    document.querySelector('#containerGallery').classList.add("notblock");
    document.querySelector('#containerImages').innerHTML = "";
    $('#modalFormProductos').modal('show');
}