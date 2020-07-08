var TableDataTables = function(){
    var handleCustomerTable = function(){
        var manageCustomerTable = $("#manage-customer-datatable");
        var baseURL = window.location.origin;       // "http://localhost:****" or site domain
        var filePath = "/helper/routing.php";
        var oTable = manageCustomerTable.DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "responsive": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_customer"
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
                "searchable": false,
                'orderable': false,
                'targets': [0, -1]
            }],
        });
        manageCustomerTable.on('click', '.delete', function(){
            id = $(this).attr('id');
            $("#record_id").val(id);
            $.ajax({
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "customer_id": id,
                    "fetch": "customer"
                },
                dataType: "json",
                success: function(data){
                    $("#customer_name").val(data[0].name);
                }
            });
        });
    }
    return{
        init: function(){
            handleCustomerTable();
        }
    }
}();
jQuery(document).ready(function(){
    TableDataTables.init();
})
