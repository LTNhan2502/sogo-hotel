$(document).ready(function() {
    function updatePermissions() {
        var employeeId = $('#selectEmployee').val();
        var role = $('#selectRole').val();

        // Dữ liệu giả lập - bạn sẽ thay thế phần này bằng dữ liệu thực từ server
        var permissionsData = {
            1: { admin: [{ name: 'Quyền 1', description: 'Miêu tả quyền 1', status: 'Đã kích hoạt' }],
                 manager: [{ name: 'Quyền 2', description: 'Miêu tả quyền 2', status: 'Đã kích hoạt' }],
                 staff: [{ name: 'Quyền 3', description: 'Miêu tả quyền 3', status: 'Chưa kích hoạt' }] },
            2: { admin: [{ name: 'Quyền 4', description: 'Miêu tả quyền 4', status: 'Đã kích hoạt' }],
                 manager: [{ name: 'Quyền 5', description: 'Miêu tả quyền 5', status: 'Chưa kích hoạt' }],
                 staff: [{ name: 'Quyền 6', description: 'Miêu tả quyền 6', status: 'Đã kích hoạt' }] },
            3: { admin: [{ name: 'Quyền 7', description: 'Miêu tả quyền 7', status: 'Chưa kích hoạt' }],
                 manager: [{ name: 'Quyền 8', description: 'Miêu tả quyền 8', status: 'Đã kích hoạt' }],
                 staff: [{ name: 'Quyền 9', description: 'Miêu tả quyền 9', status: 'Đã kích hoạt' }] }
        };

        var permissions = permissionsData[employeeId][role];
        var tableBody = $('#permissionsTable');
        tableBody.empty();

        permissions.forEach(function(permission) {
            var row = '<tr>' +
                      '<td>' + permission.name + '</td>' +
                      '<td>' + permission.description + '</td>' +
                      '<td>' + permission.status + '</td>' +
                      '</tr>';
            tableBody.append(row);
        });
    }

    // $('#selectEmployee, #selectRole').change(updatePermissions);

    // Gọi hàm cập nhật bảng lần đầu tiên
    // updatePermissions();
    $('#selectEmployee').change(function() {
        var selectedPerId = $(this).find(':selected').data('per_id');
        $('#selectRole').val(selectedPerId);
        var user_id = $("#user_id").data('user_id')
        var user_type = $("#user_type").data("user_type")
        var tableBody = $('#permissionsTable');

        $.ajax({
            url: 'Controller/admin/admin_authority.php?act=get_permission_detail',
            method: "POST",
            data: {user_id, user_type},
            dataType: "JSON",
            success: function(res){
                if(res.status == 200){
                    var auth_arr = res.data
                    tableBody.empty()
                    var row = '<tr>' +
                          '<td>' + res.data.name + '</td>' +
                          '<td>' + res.data.actions + '</td>' +
                          '<td>' + res.data.checks + '</td>' +
                          '</tr>';
                    tableBody.append(row);
                }
            },
            error: function(){
                console.log('Lỗi!');
            }
        })
    });
});