<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
spl_autoload_extensions('.php');
spl_autoload_register();

$act = "admin_cus_list";
if (isset($_GET["act"])) {
    $act = $_GET["act"];
}

switch ($act) {
    case "admin_cus_list":
        include_once "View/admin/admin_cus_list.php";
        break;
    case "create_action":
        if (isset($_POST['new_cus'])) {
            $name = $_POST['new_cus'];
            $rec = new customers();
            $result = $rec->createCus($name);
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

            $rec = new customers();
            $result = $rec->changeCusName($id, $name_value);
            if ($result) {
                $res = array(
                    "status" => 200,
                    "message" => "changed"
                );
            } else {
                $res = array(
                    "status" => 403,
                    "message" => "Lenh SQL, kieu du lieu (JOSN), json_encode, value view"
                );
            }
            echo json_encode($res);
        }
        break;
    case "update_tel":
        if (isset($_POST['tel_value']) && isset($_POST['id'])) {
            $id = $_POST['id'];
            $tel_value = $_POST['tel_value'];

            $rec = new customers();
            $result = $rec->changeCusTel($id, $tel_value);
            if ($result) {
                $res = array(
                    "status" => 200,
                    "message" => "changed"
                );
            } else {
                $res = array(
                    "status" => 403,
                    "message" => "fail"
                );

            }

            echo json_encode($res);
        }
        break;
    case "update_email":
        if (isset($_POST['email']) && isset($_POST['id']) && isset($_POST['act'])) {
            $id = $_POST['id'];
            $email_value = $_POST['email'];
            $act = $_POST['act'];

            $rec = new customers();
            if ($act == 'member') {
                $result = $rec->changeEmailMember($id, $email_value);
            } else {
                $result = $rec->changeEmailGuest($id, $email_value);
            }
            if ($result) {
                $res = array(
                    "status" => 200,
                    "message" => "changed"
                );
            } else {
                $res = array(
                    "status" => 403,
                    "message" => "fail"
                );
            }

            echo json_encode($res);
        }
        break;
    case 'admin_cus_restore':
        include_once 'View/admin/admin_cus_restore.php';
        break;
    case 'soft_delete':
        if (isset($_POST['customer_booked_id'])) {
            $customer_booked_id = $_POST['customer_booked_id'];
            $customers = new customers();
            $result = $customers->deleteCus($customer_booked_id);

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
        if (isset($_POST['customer_booked_id'])) {
            $customer_booked_id = $_POST['customer_booked_id'];
            $customers = new customers();
            $result = $customers->cplDeleteCus($customer_booked_id);

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
    case 'restore_customer':
        if (isset($_POST['customer_booked_id'])) {
            $customer_booked_id = $_POST['customer_booked_id'];
            $customers = new customers();
            $result = $customers->restoreCus($customer_booked_id);

            if ($result) {
                $res = array(
                    'status' => 200,
                    'message' => 'Đối tượng đã được khôi phục!',
                    'data' => '123'
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
    case 'pages':
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page']) && isset($_GET['limit'])) {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $items_per_page = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
            $start = ($page - 1) * $items_per_page;
        
            $cus = new customers();
            $fmt = new formatter();
            $result = $cus->getAllCusNotDeletedPage($start, $items_per_page);
        
            while ($set = $result->fetch()) {
                // echo $set['customer_id'];exit;
                echo '<tr id="currency">';
                // STT/ID
                echo '<td><div id="customer_id" data-id="' . $set['customer_id'] . '">' . $set['customer_id'] . '</div></td>';
                // Tên khách hàng
                echo '<td>
                    <input type="text" class="form-control" name="customer_name" id="customer_name" 
                        value="' . $set['customer_name'] . '"
                        data-customer_id="' . $set['customer_id'] . '"
                        data-customer_value="' . $set['customer_name'] . '">
                </td>';
                // Email thành viên
                echo '<td>
                    <input type="text" class="form-control" name="email" id="email" 
                        value="' . $set['email'] . '"
                        data-customer_id="' . $set['customer_id'] . '"
                        data-email_value="' . $set['email'] . '">
                </td>';
                // Email khách
                echo '<td>
                    <input type="text" class="form-control" name="email_guest" id="email_guest" 
                        value="' . $set['email_guest'] . '"
                        data-customer_id="' . $set['customer_id'] . '"
                        data-email_value="' . $set['email_guest'] . '">
                </td>';
                // Tel
                echo '<td>
                    <input type="text" class="form-control" name="tel" id="tel" 
                        value="' . $set['tel'] . '"
                        data-customer_id="' . $set['customer_id'] . '"
                        data-tel_value="' . $set['tel'] . '">
                </td>';
                // Actions
                echo '<td class="text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal' . $set['customer_id'] . '">
                        <i class="far fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-danger" id="soft_delete_btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>';
                echo '</tr>';
        
                // Modal xem chi tiết
                echo '<div class="modal fade" id="exampleModal' . $set['customer_id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                echo '<div class="modal-dialog modal-dialog-scrollable modal-fullscreen-lg-down">';
                echo '<div class="modal-content" style="min-width: 520px;">';
                echo '<div class="modal-header">';
                echo '<h5 class="modal-title" id="exampleModalLabel">Xem thông tin đặt phòng của <span class="detail_customer_name">' . $set['customer_name'] . '</span></h5>';
                echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                echo '<span aria-hidden="true">&times;</span>';
                echo '<div class="d-none customer_id_raw" data-customer_id_raw="' . $set['customer_id'] . '"></div>';
                echo '</button>';
                echo '</div>';
                echo '<div class="modal-body">';
                if (!$set['email']) {
                    echo '<h5>Khách hàng này chưa đăng kí thành viên.</h5>';
                }
                if ($set['history']) {
                    echo '<div id="room_cards" class="card-container-">';
                    $history_arr = explode(' - ', $set['history']);
                    $history_count = count($history_arr);
                    for ($i = 0; $i < $history_count; $i++) {
                        $result = $room->getHistoryRooms($history_arr[$i]);
                        if ($result) {
                            $history_room = $result->fetch();
                            echo '<div class="card mb-3 room_card_list">';
                            echo '<div class="row g-0">';
                            echo '<div class="col-md-4">';
                            echo '<img src="Content/images/' . $history_room['img'] . '" class="img-fluid rounded-start" alt="...">';
                            echo '</div>';
                            echo '<div class="col-md-8">';
                            echo '<div class="card-body">';
                            echo '<h6 class="card-title pt-2">' . $history_room['name'] . '</h6>';
                            echo '<div class="row">';
                            echo '<div class="col">';
                            echo '<p>' . $history_room['square_meter'] . 'm²</p>';
                            echo '</div>';
                            echo '<div class="col">';
                            echo '<p>' . $history_room['quantity'] . ' khách</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '<p><strong>Tổng: ' . $fmt->formatCurrency($history_room['booked_sum']) . ' VND</strong></p>';
                            echo '<p>Lúc vào: ' . $history_room['booked_arrive'] . '</p>';
                            echo '<p>Lúc ra: ' . $history_room['booked_quit'] . '</p>';
                            echo '<p>Thanh toán: ' . $history_room['booked_left_at'] . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                } else {
                    echo '<h6>Khách hàng này chưa đặt phòng.</h6>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
        
                $count++;
                $_SESSION['count'] = $count;
            }
        }
        break;
}
?>