<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
spl_autoload_extensions('.php');
spl_autoload_register();

$act = "admin_rec_salary";
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}

switch ($act) {
    case 'admin_rec_salary':
        include_once "View/admin/admin_rec_salary.php";
        break;
    case "pages":
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page']) && isset($_GET['limit'])) {
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            $items_per_page = $_GET['limit'];
            $start = ($page - 1) * $items_per_page;

            $rec = new receptionist();
            $fmt = new formatter();
            $result = $rec->getAllRecPage($start, $items_per_page);
            $count = $start + 1; // Bắt đầu đếm từ trang hiện tại

            while ($set = $result->fetch()) {
                echo '<tr id="currency">';
                // STT
                echo '<td><div id="rec_id" data-id="' . $set['rec_id'] . '">' . $count . '</div></td>';
                // Mã nhân viên
                echo '<td><h3><span class="badge badge-primary fs-6" id="rec_code">' . $set['rec_code'] . '</span></h3></td>';
                // Tên nhân viên
                echo '<td style="min-width: 160px;">
                    <input type="text" class="form-control" name="rec_name" id="rec_name" 
                        value="' . $set['rec_name'] . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $set['rec_name'] . '">
                </td>';
                // Lương
                echo '<td>
                    <input type="text" class="form-control" name="rec_salary" id="rec_salary" 
                        value="' . $fmt->formatCurrency($set['rec_salary']) . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $fmt->formatCurrency($set['rec_salary']) . '">
                </td>';
                // Thưởng
                echo '<td>
                    <input type="text" class="form-control" name="rec_bonus" id="rec_bonus" 
                        value="' . $fmt->formatCurrency($set['rec_bonus']) . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $fmt->formatCurrency($set['rec_bonus']) . '">
                </td>';
                // Phạt
                echo '<td>
                    <input type="text" class="form-control" name="rec_fine" id="rec_fine" 
                        value="' . $fmt->formatCurrency($set['rec_fine']) . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $fmt->formatCurrency($set['rec_fine']) . '">
                </td>';
                // Hệ số
                echo '<td width="80px">
                    <input type="text" class="form-control" name="rec_factor" id="rec_factor" 
                        value="' . $set['rec_factor'] . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $set['rec_factor'] . '">
                </td>';
                // Thực nhận
                echo '<td>
                    <input type="text" class="form-control" name="rec_receive" id="rec_receive" disabled
                        value="' . $fmt->formatCurrency(($set['rec_salary'] * $set['rec_factor']) + $set['rec_bonus']) . '"
                        data-rec_id="' . $set['rec_id'] . '"
                        data-rec_value="' . $fmt->formatCurrency(($set['rec_salary'] * $set['rec_factor']) + $set['rec_bonus']) . '">
                </td>';
                // Actions
                echo '<td class="text-end" width="110px">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-hand-holding-usd"></i>
                    </button>
                </td>';
                echo '</tr>';

                $count++;
            }
        }
        break;
}
?>