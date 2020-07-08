var TableDataTables = function(){
    var handleProductTable = function(){
        var manageProductTable = $("#manage-product-datatable");
        var baseURL = window.location.origin;       // "http://localhost:****" or site domain
        var filePath = "/helper/routing.php";
        var oTable = manageProductTable.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_product"
                }
            },
            "lengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"]
            ],
            "order": [
                // can also be managed in serverside
                [1, "ASC"]
            ],
            "columnDefs": [{
                'orderable': false,
                'targets': [0, -1, -2]
            }],
        });
        manageProductTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "product_id": id,
                    "fetch": "product"
                },
                dataType: "json",
                success: function(data){
                    $("#product_name").val(data[0].name);
                }
            });
        });
    }
    return{
        init: function(){
            handleProductTable();
        }
    }
}();
jQuery(document).ready(function(){
    TableDataTables.init();
})
