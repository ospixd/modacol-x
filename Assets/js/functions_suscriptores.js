let tableSuscriptores;
tableSuscriptores = $('#tableSuscriptores').DataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Suscriptores/getSuscriptores",
        "dataSrc": ""
    },
    "columns": [
        { "data": "idsuscripcion" },
        { "data": "nombre" },
        { "data": "email" },
        { "data": "fecha" }
        
        
        

    ],

    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": {
                "columns": [0,1,2,3,4,5,6,7]
              }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": {
                "columns": [0,1,2,3,4,5,6,7]
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": {
                "columns": [0,1,2,3,4,5,6,7]
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": {
                "columns": [0,1,2,3,4,5,6,7]
            }
        }
    ],

    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});