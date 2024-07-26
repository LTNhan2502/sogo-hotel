<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
spl_autoload_extensions('.php');
spl_autoload_register();

$act = 'admin_rec_list';
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}

switch ($act) {
    case 'admin_rec_list':
        include_once "View/admin/admin_rec_list.php";
        break;
    case "create_rec":
        include_once "View/admin/admin_rec_insert.php";
        break;
    case "create_action":
        if (isset($_POST['new_rec'])) {
            $name = $_POST['new_rec'];
            $rec = new receptionist();
            $result = $rec->createRec($name);
            if ($result) {
                $res = array(
                    'status' => 'success',
                    'message' => 'Tạo mới thành công!'
                );
                // echo '<meta http-equiv="refresh" content="0;url=./admin_index.php?action=admin_room_list&act=room_create"/>';
            } else {
                $res = array(
                    'status' => 'fail',
                    'message' => 'Tạo mới thất bại!'
                );
                // echo '<meta http-equiv="refresh" content="0;url=./admin_index.php?action=admin_room_list&act=room_create"/>';
            }
            echo json_encode($res);
        }
        break;
    case "update_name":
        if (isset($_POST['name_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name_value = $_POST['name_value'];
            $rec = new receptionist();
            $result = $rec->changeRecName($id, $name_value);

            if ($result) {
                $res = array(
                    "status" => "success",
                    "message" => "changed"
                );
            } else {
                $res = array(
                    "status" => "fail",
                    "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                );
            }
            echo json_encode($res);
        }
        break;
    case 'Ca 1 - 06:00 tới 14:00':
        $rec_id = $_POST['rec_id'];
        $rec_shift = $_POST['rec_shift'];
        $rec = new receptionist();
        $result = $rec->changeRecShift1($rec_id);
        $result->execute();
        if ($result !== false) {
            $res = array(
                "status" => "success",
                "message" => "Changed"
            );
        } else {
            $res = array(
                "status" => "fail",
                "message" => "Lenh SQL, kieu du lieu(JSON), json_encode, value view"
            );
        }
        echo json_encode($res);
        break;
    case 'Ca 2 - 14:00 tới 22:00':
        $rec_id = $_POST['rec_id'];
        $rec_shift = $_POST['rec_shift'];
        $rec = new receptionist();
        $result = $rec->changeRecShift2($rec_id);
        $result->execute();
        if ($result !== false) {
            $res = array(
                "status" => "success",
                "message" => "Changed"
            );
        } else {
            $res = array(
                "status" => "fail",
                "message" => "Lenh SQL, kieu du lieu(JSON), json_encode, value view"
            );
        }
        echo json_encode($res);
        break;
    case 'Ca 3 - 22:00 tới 06:00':
        $rec_id = $_POST['rec_id'];
        $rec_shift = $_POST['rec_shift'];
        $rec = new receptionist();
        $result = $rec->changeRecShift3($rec_id);
        $result->execute();
        if ($result !== false) {
            $res = array(
                "status" => "success",
                "message" => "Changed"
            );
        } else {
            $res = array(
                "status" => "fail",
                "message" => "Lenh SQL, kieu du lieu(JSON), json_encode, value view"
            );
        }
        echo json_encode($res);
        break;
    case "update_tel":
        if (isset($_POST['tel_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $tel_value = $_POST['tel_value'];
            $first_zero = substr($tel_value, 0, 1) == "0" ? "yes" : "no";
            if ($first_zero == "no" && strlen($tel_value) == 10) {
                $res = array(
                    'status' => 'tel',
                    'message' => 'Số điện thoại phải bắt đầu bằng số 0!'
                );
            } else if ($tel_value == '') {
                $res = array(
                    'status' => 'tel',
                    'message' => 'Không được để trống!'
                );
            } else if (strlen($tel_value) != 10 && $first_zero == "yes") {
                $res = array(
                    'status' => 'tel',
                    'message' => 'Số điện thoại phải có 10 chữ số!'
                );
            } else if (strlen($tel_value) != 10 && $first_zero == 'no') {
                $res = array(
                    'status' => 'tel',
                    'message' => 'Số điện thoại không hợp lệ!'
                );
            } else if (!is_numeric($tel_value)) {
                $res = array(
                    'status' => 'tel',
                    'message' => 'Số điện thoại phải là số!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecTel($id, $tel_value);
                if ($result) {
                    $res = array(
                        "status" => "success",
                        "message" => "changed"
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_email":
        if (isset($_POST['email_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $email_value = $_POST['email_value'];
            $regex_email = '/^[a-zA-Z0-9._%+-]+@gmail+\.com$/';

            if (!preg_match($regex_email, $email_value)) {
                $res = array(
                    'status' => 'email',
                    'message' => 'Email không đúng định dạng!'
                );
            } else if ($email_value == '') {
                $res = array(
                    'status' => 'email',
                    'message' => 'Không được để trống!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecEmail($id, $email_value);
                if ($result) {
                    $res = array(
                        "status" => "success",
                        "message" => "changed"
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_birthday":
        if (isset($_POST['birthday_value']) && isset($_POST['id']) && isset($_POST['prev_birthday'])) {
            $id = $_POST['id'];
            $birthday_value = $_POST['birthday_value'];
            $prev_birthday = $_POST['prev_birthday'];

            if ($birthday_value == '') {
                $res = array(
                    'status' => 'birthday',
                    'message' => 'Không được để trống!'
                );
            } else if ($birthday_value == $prev_birthday) {
                $res = array(
                    'status' => 'birthday',
                    'message' => 'Nếu muốn thay đổi, hãy chọn ngày khác!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecBirthday($id, $birthday_value);
                if ($result) {
                    $res = array(
                        "status" => "success",
                        "message" => "Thay đổi thành công!"
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view!"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_start-timeWork":
        if (
            isset($_POST['startWork_value']) && isset($_POST['id']) &&
            isset($_POST['prev_startWork']) && isset($_POST["id_timeWork"]) &&
            isset($_POST["now"]) && isset($_POST["rec_timeWork_getTime"])
        ) {

            $id = $_POST['id'];
            $startWork_value = $_POST['startWork_value'];
            $prev_startWork = $_POST['prev_startWork'];
            $id_timeWork = $_POST["id_timeWork"];
            $now = $_POST["now"];
            $rec_timeWork_getTime = $_POST["rec_timeWork_getTime"];

            if ($startWork_value == '') {
                $res = array(
                    'status' => 'startWork',
                    'message' => 'Không được để trống!'
                );
            } else if ($startWork_value == $prev_startWork) {
                $res = array(
                    'status' => 'startWork',
                    'message' => 'Nếu muốn thay đổi, hãy chọn ngày khác!'
                );
            } else {
                $rec = new receptionist();
                $timeWork_getTime = $now - $rec_timeWork_getTime;
                $rec_timeWork = floor($timeWork_getTime / (1000 * 60 * 60 * 24));
                $result_startWork = $rec->changeRecStartWork($id, $startWork_value);
                $result_startWork->execute();

                if ($result_startWork) {
                    $result_timeWork = $rec->changeRecTimeWork($id, $rec_timeWork);
                    $result_timeWork->execute();
                    if ($result_timeWork) {
                        $all_recs = array();
                        $all_rec = $rec->getRecs($id);
                        $all_recs = $all_rec->fetch(PDO::FETCH_ASSOC);
                        $res = array(
                            "status" => "success",
                            "message" => "Thay đổi thành công!",
                            "rec" => $all_recs
                        );
                    } else {
                        $res = array(
                            "status" => "fail_timeWork",
                            "message" => "Kiểm tra lại hàm thay đổi rec_timeWork!",
                            "rec" => $all_recs
                        );
                    }
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Hàm thay đổi rec_startWork không được thực hiện!"
                    );
                }
            }
            echo json_encode($res);
        }
        break;
    case "update_timeWork":
        if (isset($_POST["id_timeWork"]) && isset($_POST["now"]) && isset($_POST["rec_timeWork_getTime"])) {

            $rec = new receptionist();

            if ($result) {

            } else {
                $res = array(
                    "status" => "fail",
                    "message" => "Thay đổi thất bại! Xem lại!"
                );
            }
            echo json_encode($res);
        }
        break;
    case "update_bonus":
        if (isset($_POST['bonus_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $bonus_value = $_POST['bonus_value'];

            if (!is_numeric($bonus_value)) {
                $res = array(
                    'status' => 'bonus',
                    'message' => 'Tiền thưởng phải là một số!'
                );
            } else if ($bonus_value < 0) {
                $res = array(
                    'status' => 'bonus',
                    'message' => 'Tiền thưởng phải là số dương!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecBonus($id, $bonus_value);
                if ($result) {
                    $rec_receives = array();
                    $rec_receive = $rec->getRecs($id);
                    $rec_receives = $rec_receive->fetch(PDO::FETCH_ASSOC);
                    $res = array(
                        "status" => "success",
                        "message" => "changed",
                        "rec_salary" => $rec_receives
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_fine":
        if (isset($_POST['fine_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $fine_value = $_POST['fine_value'];

            if (!is_numeric($fine_value)) {
                $res = array(
                    'status' => 'fine',
                    'message' => 'Tiền phạt phải là một số!'
                );
            } else if ($fine_value < 0) {
                $res = array(
                    'status' => 'fine',
                    'message' => 'Tiền phạt phải là số dương!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecFine($id, $fine_value);
                if ($result) {
                    $rec_receives = array();
                    $rec_receive = $rec->getRecs($id);
                    $rec_receives = $rec_receive->fetch(PDO::FETCH_ASSOC);
                    $res = array(
                        "status" => "success",
                        "message" => "changed",
                        "rec_salary" => $rec_receives
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_salary":
        if (isset($_POST['salary_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $salary_value = $_POST['salary_value'];

            if (!is_numeric($salary_value)) {
                $res = array(
                    'status' => 'salary',
                    'message' => 'Lương phải là một số!'
                );
            } else if ($salary_value < 0) {
                $res = array(
                    'status' => 'salary',
                    'message' => 'Lương phải là số dương!'
                );
            } else {
                $rec = new receptionist();
                $result = $rec->changeRecSalary($id, $salary_value);
                if ($result) {
                    $rec_receives = array();
                    $rec_receive = $rec->getRecs($id);
                    $rec_receives = $rec_receive->fetch(PDO::FETCH_ASSOC);
                    $res = array(
                        "status" => "success",
                        "message" => "changed",
                        "rec_salary" => $rec_receives
                    );
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                    );
                }
            }

            echo json_encode($res);
        }
        break;
    case "update_factor":
        $id = $_POST["id"];
        $factor_value = $_POST["factor_value"];
        $regex_factor = '/^[0-9]+(\.[0-9]{1,2})?$/';
        $rec = new receptionist();

        if (!preg_match($regex_factor, $factor_value)) {
            $res = array(
                'status' => 'factor',
                'message' => 'Hệ số chỉ bao gồm số nguyên và số thập phân!'
            );
        } else if ($factor_value == '') {
            $res = array(
                'status' => 'factor',
                'message' => 'Không được để trống!'
            );
        } else {
            $result = $rec->changeRecFactor($id, $factor_value);
            if ($result) {
                //Lấy ra dữ liệu từ mysql
                $rec_receives = array();
                $rec_receive = $rec->getRecs($id);
                $rec_receives = $rec_receive->fetch(PDO::FETCH_ASSOC);
                $res = array(
                    "status" => "success",
                    "message" => "changed",
                    "rec_salary" => $rec_receives
                );
            } else {
                $res = array(
                    "status" => "fail",
                    "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                );
            }
        }

        echo json_encode($res);
        break;

    case "claim_salary":
        if (isset($_POST['rec_id'])) {
            $id = $_POST['rec_id'];

            $rec = new receptionist();
            $result = $rec->claimSalary($id);
            if ($result) {
                $res = array(
                    "status" => "success",
                    "message" => "Thời điểm nhận lương đã cập nhật!"
                );
            } else {
                $res = array(
                    "status" => "fail",
                    "message" => "Thay đổi thất bại! Kiểm tra lại!"
                );
            }
            echo json_encode($res);
        }
        break;
    case "un_claim_salary":
        if (isset($_POST['rec_id'])) {
            $id = $_POST['rec_id'];

            $rec = new receptionist();
            $result = $rec->unClaimSalary($id);
            if ($result) {
                $res = array(
                    "status" => "success",
                    "message" => "Thay đổi thành công!"
                );
            } else {
                $res = array(
                    "status" => "fail",
                    "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                );
            }

            echo json_encode($res);
        }
        break;
    case 'admin_rec_restore':
        include_once 'View/admin/admin_rec_restore.php';
        break;
    case 'soft_delete':
        if (isset($_POST['rec_code'])) {
            $rec_code = $_POST['rec_code'];
            $rec = new receptionist();
            $result = $rec->deleteRec($rec_code);

            if ($result) {
                $res = array(
                    'status' => 200,
                    'message' => 'Xoá đối tượng thành công!'
                );
            } else {
                $res = array(
                    'status' => 403,
                    'message' => 'Xoá thất bại!'
                );
            }
            echo json_encode($res);
        }
        break;
    case 'cpl_delete':
        if (isset($_POST['rec_code'])) {
            $rec_code = $_POST['rec_code'];
            $rec = new receptionist();
            $result = $rec->cplDeleteRec($rec_code);

            if ($result) {
                $res = array(
                    'status' => 200,
                    'message' => 'Xoá đối tượng thành công!'
                );
            } else {
                $res = array(
                    'status' => 403,
                    'message' => 'Xoá thất bại!'
                );
            }
            echo json_encode($res);
        }
        break;
    case 'restore_rec':
        if (isset($_POST['rec_code'])) {
            $rec_code = $_POST['rec_code'];
            $rec = new receptionist();
            $result = $rec->restoreRec($rec_code);

            if ($result) {
                $res = array(
                    'status' => 200,
                    'message' => 'Đối tượng đã được khôi phục!'
                );
            } else {
                $res = array(
                    'status' => 403,
                    'message' => 'Khôi phục thất bại!'
                );
            }
            echo json_encode($res);
        }
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
                echo '<tr id="rec_list">';
                echo '<td><div id="rec_id" data-id="' . $set['rec_id'] . '">' . $count . '</div></td>';
                echo '<td><h3><span class="badge badge-primary fs-6" id="rec_code">' . $set['rec_code'] . '</span></h3></td>';
                echo '<td><input type="text" class="form-control" name="rec_name" id="rec_name" value="' . $set['rec_name'] . '" data-rec_id="' . $set['rec_id'] . '" data-rec_value="' . $set['rec_name'] . '"></td>';
                echo '<td><select name="part" class="form-control" id="part">';
                $part = $rec->getAllPart();
                while ($set_part = $part->fetch()) {
                    echo '<option value="' . $set_part['part_id'] . '"' . ($set['rec_part'] == $set_part['part_id'] ? 'selected' : '') . ' data-rec_id="' . $set['rec_id'] . '" data-part_act="' . $set_part['part_id'] . '">' . $set_part['part_name'] . '</option>';
                }
                echo '</select></td>';
                echo '<td><select name="shift" class="form-control" id="shift">';
                $shift = $rec->getAllShift();
                while($set_shift = $shift->fetch()){
                    $shift_selected = $set['rec_shift'] == $set_shift['shift_id'] ? 'selected' : '';
                    echo '<option value="' . $set_shift['shift_id'] . '" ' . $shift_selected . ' data-rec_id="' . $set['rec_id'] . '" data-shift_act="' . $set_shift['shift_name'] . '">' . $set_shift['shift_name'] . '</option>';                
                }
                echo '</select></td>';
                echo '<td class="text-end"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal' . $set['rec_id'] . '"><i class="far fa-eye"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-trash"></i></button></td>';
                echo '</tr>';             

                // Modal xem chi tiết
                echo '<div class="modal fade" id="exampleModal' . $set['rec_id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xem thông tin cá nhân <span class="detail_rec_name">' . $set['rec_name'] . '</span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <div class="d-none rec_id_raw" data-rec_id_raw="' . $set['rec_id'] . '"></div>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Số điện thoại -->
                                    <div class="col">
                                        <label for="#rec_tel">Số điện thoại</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-phone-alt"></i></span>
                                            <input type="text" class="form-control" name="rec_tel" id="rec_tel"
                                                value="' . $set['rec_tel'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_tel'] . '">
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col">
                                        <label for="#rec_email">Email</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-envelope"></i></span>
                                            <input type="text" class="form-control" name="rec_email" id="rec_email"
                                                value="' . $set['rec_email'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_email'] . '">
                                        </div>
                                    </div>

                                    <!-- Ngày sinh -->
                                    <div class="col">
                                        <label for="#rec_birthday">Ngày sinh</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="far fa-calendar-alt"></i></span>
                                            <input type="datetime" id="birthday' . $set['rec_id'] . '" class="form-control birthday" aria-describedby="addon-wrapping"
                                                value="' . $set['rec_birthday'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_birthday'] . '">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mm mt-4">
                                    <input type="hidden" value="' . $set['rec_id'] . '" id="rec_timeWork_id">
                                    <!-- Ngày bắt đầu làm việc -->
                                    <div class="col">
                                        <label for="#rec_startWork">Ngày bắt đầu làm việc</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-clock"></i></span>
                                            <input type="datetime" id="rec_startWork' . $set['rec_id'] . '" class="form-control rec_startWork"
                                                value="' . $set['rec_startWork'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_startWork'] . '">
                                        </div>
                                    </div>

                                    <!-- Số ngày làm việc -->
                                    <div class="col">
                                        <label for="#rec_timeWork">Thời gian làm việc (ngày)</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-clock"></i></span>
                                            <input type="text" class="form-control rec_timeWork" name="rec_timeWork" id="rec_timeWork' . $set['rec_id'] . '" disabled
                                                value="' . $set['rec_timeWork'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_timeWork'] . '">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <!-- Thưởng -->
                                    <div class="col">
                                        <label for="#rec_bonus">Thưởng</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-check-alt"></i></span>
                                            <input type="text" class="form-control" name="rec_bonus" id="rec_bonus"
                                                value="' . $fmt->formatCurrency($set['rec_bonus']) . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_bonus'] . '">
                                        </div>
                                    </div>

                                    <!-- Phạt -->
                                    <div class="col">
                                        <label for="#rec_fine">Phạt</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-check-alt"></i></span>
                                            <input type="text" class="form-control" name="rec_fine" id="rec_fine"
                                                value="' . $fmt->formatCurrency($set['rec_fine']) . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_fine'] . '">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <!-- Lương -->
                                    <div class="col">
                                        <label for="#rec_salary">Lương</label>
                                        <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-bill-alt"></i></span>
                                            <input type="text" class="form-control" name="rec_salary" id="rec_salary"
                                                value="' . $fmt->formatCurrency($set['rec_salary']) . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_salary'] . '">
                                        </div>
                                    </div>

                                    <!-- Thời điểm nhận lương -->
                                    <div class="col">
                                        <label for="#rec_timeSalary">Thời điểm nhận lương</label>';
                            if ($set['rec_timeSalary'] == null) {
                                echo '<div class="badge badge-secondary fs-7 mr-1" id="badge">Chưa nhận</div>
                                                <button class="btn btn-primary btn-sm" id="claimSalary">Nhận lương</button>
                                                <button class="btn btn-danger btn-sm d-none" id="unClaimSalary">Huỷ nhận</button>';
                            } else {
                                echo '<div class="badge badge-secondary fs-7 mr-1" id="badge">Đã nhận</div>
                                                <button class="btn btn-primary btn-sm d-none" id="claimSalary">Nhận lương</button>
                                                <button class="btn btn-danger btn-sm" id="unClaimSalary">Huỷ nhận</button>';
                            }
                            echo '<div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="addon-wrapping"><i class="fas fa-business-time"></i></span>
                                            <input type="text" class="form-control" name="rec_timeSalary" id="rec_timeSalary" disabled
                                                value="' . $set['rec_timeSalary'] . '"
                                                data-rec_id="' . $set['rec_id'] . '"
                                                data-rec_value="' . $set['rec_timeSalary'] . '">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                $count++;
            }
        }
        break;


}
//Chỉnh sửa chức vụ
$recParts = array(1, 2, 3, 4, 5, 6, 7, 8);
if (in_array($act, $recParts)) { // Check if act is a valid rec_part
    $rec_id = $_POST['rec_id'];
    $rec_part = $_POST['rec_part'];

    $rec = new receptionist();
    $result = $rec->changeRecPart($rec_id, $rec_part);
    $result->execute();
    if ($result !== false) {
        $res = array(
            "status" => "success",
            "message" => "Changed"
        );
    } else {
        $res = array(
            "status" => "fail",
            "message" => "Lenh SQL, kieu du lieu(JSON), json_encode, value view"
        );
    }
    echo json_encode($res);
}
;
?>