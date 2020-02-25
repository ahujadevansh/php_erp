var TableDataTables = function(){
    var handleCategoryTable = function(){
        var manageCategoryTable = $("#manage-category-datatable");
        var baseURL = window.location.origin;       // "http://localhost:****" or site domain
        var filePath = "/helper/routing.php";
        var oTable = manageCategoryTable.dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: baseURL + filePath,
                method: "POST",
                data: {
                    "page": "manage_category"
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
    }
    return{
        init: function(){
            handleCategoryTable();
        }
    }
}();
jQuery(document).ready(function(){
    TableDataTables.init();
})
