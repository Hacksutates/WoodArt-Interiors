<?php
// Initialize session and include database connection
session_start();
include("connection.php");

// ============================================================================
// CUSTOMER REGISTRATION
// ============================================================================
if (isset($_POST["registration"])) {
    $name = $_POST["name"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $rep_password = $_POST["rep_password"];
    $phone = $_POST["phone"];

    $valid = true;

    if (strlen($name) < 3) {
        $_SESSION['reg'] = "Minimum length of name is 3";
        $valid = false;
    } else if (strlen($login) < 8) {
        $_SESSION['reg'] = "Minimum length of login is 8";
        $valid = false;
    } else if (strlen($password) < 8) {
        $_SESSION['reg'] = "Minimum length of password is 8";
        $valid = false;
    } else if (strlen($phone) != 12 || $phone[0] != '+') {
        $_SESSION['reg'] = "Phone number is incorrect";
        $valid = false;
    } else if ($rep_password != $password) {
        $_SESSION['reg'] = "Passwords do not match";
        $valid = false;
    }

    if (!$valid) {
        header("Location:../../registration.php");
        exit;
    }

    $hashed_password = md5($password);
    mysqli_query(
        $connect,
        "INSERT INTO `customers` (`full_name`, `login`, `pass`, `phone_num`) VALUES ('$name', '$login', '$hashed_password', '$phone')"
    );

    header("Location:../../login.php");
    exit;
}

// ============================================================================
// MANAGER/CRAFTSMAN REGISTRATION
// ============================================================================
if (isset($_POST["registration_m"])) {
    $name = $_POST["name"];
    $login = $_POST["login"];
    $password = $_POST["password"];
    $rep_password = $_POST["rep_password"];
    $phone = $_POST["phone"];
    $type = $_POST["type"];

    $valid = true;

    if (strlen($name) < 3) {
        $_SESSION['reg'] = "Minimum length of name is 3";
        $valid = false;
    } else if (strlen($login) < 8) {
        $_SESSION['reg'] = "Minimum length of login is 8";
        $valid = false;
    } else if (strlen($password) < 8) {
        $_SESSION['reg'] = "Minimum length of password is 8";
        $valid = false;
    } else if (strlen($phone) != 12 || $phone[0] != '+') {
        $_SESSION['reg'] = "Phone number is incorrect";
        $valid = false;
    } else if ($rep_password != $password) {
        $_SESSION['reg'] = "Passwords do not match";
        $valid = false;
    }

    if (!$valid) {
        header("Location:../../registration_m.php");
        exit;
    }

    $hashed_password = md5($password);
    mysqli_query(
        $connect,
        "INSERT INTO `$type` (`full_name`, `login`, `pass`, `phone_num`) VALUES ('$name', '$login', '$hashed_password', '$phone')"
    );

    header("Location:../../login.php");
    exit;
}

// ============================================================================
// USER LOGIN / SIGN IN
// ============================================================================
if (isset($_POST["sign_in"])) {
    $login = mysqli_real_escape_string($connect, $_POST["login"]);
    $password = $_POST["password"];

    $tables = [
        'customers' => 'customer_ID',
        'managers' => 'manager_ID',
        'craftmen' => 'craftman_ID'
    ];

    $found = false;

    foreach ($tables as $table => $id_key) {
        $query = mysqli_query(
            $connect,
            "SELECT * FROM `$table` WHERE `login` = '$login'"
        );

        if ($data = mysqli_fetch_assoc($query)) {
            $hashed_password = md5($password);
            if ($data['pass'] === $hashed_password) {
                $found = true;
                $data['id'] = $data[$id_key];
                $data['role'] = $table;
                $_SESSION['ses_data'] = $data;
                break;
            }
        }
    }

    if ($found) {
        header("Location:../../profile.php");
        exit;
    }

    $_SESSION['message'] = "No login";
    header("Location:../../login.php");
    exit;
}

// ============================================================================
// SELECT FURNITURE
// ============================================================================
if (isset($_POST["select"])) {
    if (!isset($_SESSION['ses_data']['id'])) {
        header("Location:../../login.php");
        exit;
    }

    $_SESSION["furniture_ID"] = $_POST["furniture_ID"];
    header("Location:../../furniture.php");
    exit;
}

// ============================================================================
// PLACE NEW ORDER
// ============================================================================
if (isset($_POST["order"])) {
    if (!isset($_SESSION['ses_data']['id'])) {
        header("Location:../../login.php");
        exit;
    } else if($_SESSION['ses_data']['role'] !== 'customers'){
        $_SESSION["message"] = "Only customers can place orders!";
        header("Location:../../profile.php");
        exit;
    }

    $user_id = $_SESSION['ses_data']["id"];
    $furniture_id = $_POST['furniture_ID'];
    $address = $_POST['address'];
    $return_date = $_POST['return_date'];
    $material = $_POST['material'];

    $query_text = "INSERT INTO `requests` (`customer_ID`, `furniture_ID`, `material_ID`, `address`, `return_date`, `status`) VALUES ('$user_id', '$furniture_id', '$material', '$address', '$return_date', 'checking')";
    $query = mysqli_query($connect, $query_text);

    if ($query) {
        $_SESSION["message"] = "Заказ успешно создан!";
        header("Location:../../profile.php");
        exit;
    }

    echo "Ошибка: " . mysqli_error($connect);
    exit;
}

// ============================================================================
// MANAGER: ACCEPT OR REJECT CUSTOMER REQUEST
// ============================================================================
if (isset($_POST["accept_request"]) || isset($_POST["reject_request"])) {
    if (!isset($_SESSION['ses_data']['id']) || $_SESSION['ses_data']['role'] !== 'managers') {
        header("Location:../../login.php");
        exit;
    }

    $request_ID = intval($_POST["request_ID"]);

    if (isset($_POST["accept_request"])) {
        $craftman_ID = intval($_POST["craftman_ID"]);
        if (!$craftman_ID) {
            $_SESSION["message"] = "Please choose a craftsman before accepting the request.";
            header("Location:../../manager_requests.php");
            exit;
        }

        $request_query = mysqli_query($connect, "SELECT * FROM `requests` WHERE `request_ID` = $request_ID AND `status` = 'checking'");
        $request_data = mysqli_fetch_assoc($request_query);

        if (!$request_data) {
            $_SESSION["message"] = "Request not found or already processed.";
            header("Location:../../manager_requests.php");
            exit;
        }

        $customer_ID = intval($request_data['customer_ID']);
        $furniture_ID = intval($request_data['furniture_ID']);
        $material_ID = intval($request_data['material_ID']);
        $address = mysqli_real_escape_string($connect, $request_data['address']);
        $return_date = $request_data['return_date'];
        $order_date = date('Y-m-d');

        $create_order = mysqli_query(
            $connect,
            "INSERT INTO `orders` (`customer_ID`, `furniture_ID`, `material_ID`, `craftman_ID`, `address`, `request_id`) VALUES ($customer_ID, $furniture_ID, $material_ID, $craftman_ID, '$address', $request_ID)"
        );

        if (!$create_order) {
            echo "Ошибка записи заказа: " . mysqli_error($connect);
            exit;
        }

        $order_ID = mysqli_insert_id($connect);
        $create_solving = mysqli_query(
            $connect,
            "INSERT INTO `solvings` (`order_ID`, `order_date`, `deadline`, `status`) VALUES ($order_ID, '$order_date', '$return_date', 'new')"
        );

        if (!$create_solving) {
            echo "Ошибка записи solvings: " . mysqli_error($connect);
            exit;
        }

        $update_request = mysqli_query($connect, "UPDATE `requests` SET `status` = 'accepted' WHERE `request_ID` = $request_ID");
        if (!$update_request) {
            echo "Ошибка обновления запроса: " . mysqli_error($connect);
            exit;
        }

        $_SESSION["message"] = "Request accepted. Order and solving records created.";
        header("Location:../../manager_requests.php");
        exit;
    }

    $query = mysqli_query($connect, "UPDATE `requests` SET `status` = 'rejected' WHERE `request_ID` = $request_ID");
    if ($query) {
        $_SESSION["message"] = "Request rejected.";
        header("Location:../../manager_requests.php");
        exit;
    }

    echo "Ошибка обновления запроса: " . mysqli_error($connect);
    exit;
}

// ============================================================================
// EDIT ORDER
// ============================================================================
if (isset($_POST["edit"])) {
    $_SESSION['order_ID'] = $_POST['order_ID'];
    header("Location:../../a_edit.php");
    exit;
}

// ============================================================================
// DELETE ORDER
// ============================================================================
if (isset($_POST["delete"])) {
    $order_id = intval($_POST['order_ID']);

    $query = mysqli_query($connect, "DELETE FROM `solvings` WHERE order_ID = $order_id");
    if ($query) {
        $query = mysqli_query($connect, "DELETE FROM `orders` WHERE order_ID = $order_id");
        if ($query) {
            $_SESSION["message"] = "Заказ успешно удален";
            header("Location:../../admin.php");
            exit;
        }

        echo "Ошибка: " . mysqli_error($connect);
        exit;
    }

    echo "Ошибка: " . mysqli_error($connect);
    exit;
}

// ============================================================================
// UPDATE ORDER DETAILS
// ============================================================================
if (isset($_POST["update"])) {
    $order_id = intval($_SESSION['order_ID']);
    $order_date = $_POST['order_date'];
    $deadline = $_POST['deadline'];
    $solving_date = $_POST['solving_date'];
    $status = $_POST['status'];

    $query = mysqli_query(
        $connect,
        "UPDATE `solvings` SET `order_date`='$order_date', `deadline`='$deadline', `solving_date`='$solving_date', `status`='$status' WHERE order_ID=$order_id"
    );

    if ($query) {
        $_SESSION["message"] = "Заказ успешно изменен!";
        header("Location:../../admin.php");
        exit;
    }

    echo "Ошибка: " . mysqli_error($connect);
    exit;
}

// ============================================================================
// ADD NEW FURNITURE TO CATALOG
// ============================================================================
if (isset($_POST["add_furniture"])) {
    if (!isset($_SESSION['ses_data']['id'])) {
        header("Location:../../login.php");
        exit;
    }

    $name = mysqli_real_escape_string($connect, $_POST['furniture_name']);
    $price = floatval($_POST['price']);
    $length = floatval($_POST['length']);
    $width = floatval($_POST['width']);
    $height = floatval($_POST['height']);

    if (empty($name) || $price <= 0 || $length <= 0 || $width <= 0 || $height <= 0) {
        $_SESSION['message'] = "All fields are required and must have valid values.";
        header("Location:../../add_furniture.php");
        exit;
    }

    $query = mysqli_query(
        $connect,
        "INSERT INTO `furnitures` (`name`, `price`, `length`, `width`, `height`) 
         VALUES ('$name', $price, $length, $width, $height)"
    );

    if ($query) {
        $_SESSION["message"] = "Furniture added successfully!";
        header("Location:../../furniture.php");
        exit;
    } else {
        $_SESSION['message'] = "Error adding furniture: " . mysqli_error($connect);
        header("Location:../../add_furniture.php");
        exit;
    }
}

// ============================================================================
// ADD NEW MATERIAL TO CATALOG
// ============================================================================
if (isset($_POST["add_material"])) {
    if (!isset($_SESSION['ses_data']['id'])) {
        header("Location:../../login.php");
        exit;
    }

    $name = mysqli_real_escape_string($connect, $_POST['material_name']);
    $cost = floatval($_POST['cost']);

    if (empty($name) || $cost <= 0) {
        $_SESSION['message'] = "All fields are required and must have valid values.";
        header("Location:../../add_material.php");
        exit;
    }

    $query = mysqli_query(
        $connect,
        "INSERT INTO `materials` (`name`, `price`) 
         VALUES ('$name', $cost)"
    );

    if ($query) {
        $_SESSION["message"] = "Material added successfully!";
        header("Location:../../material.php");
        exit;
    } else {
        $_SESSION['message'] = "Error adding material: " . mysqli_error($connect);
        header("Location:../../add_material.php");
        exit;
    }
}

// ============================================================================
// CRAFTSMAN: UPDATE ORDER STATUS
// ============================================================================
if (isset($_POST["update_status"])) {
    if (!isset($_SESSION['ses_data']['id'])) {
        header("Location:../../login.php");
        exit;
    }

    $order_ID = intval($_POST['order_ID']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    $solving_date = !empty($_POST['solving_date']) ? mysqli_real_escape_string($connect, $_POST['solving_date']) : 'NULL';

    if (empty($status)) {
        $_SESSION['message'] = "Status is required.";
        header("Location:../../craftman_status.php");
        exit;
    }

    if ($solving_date !== 'NULL') {
        $solving_date = "'$solving_date'";
    }

    $query = mysqli_query(
        $connect,
        "UPDATE `solvings` SET `status` = '$status', `solving_date` = $solving_date WHERE `order_ID` = $order_ID"
    );

    if ($query) {
        $_SESSION["message"] = "Order status updated successfully!";
        header("Location:../../craftman_status.php");
        exit;
    } else {
        $_SESSION['message'] = "Error updating status: " . mysqli_error($connect);
        header("Location:../../craftman_status.php");
        exit;
    }
}

// ============================================================================
// HANDLE CONTACT FORM SUBMISSIONS
// ============================================================================
if (isset($_POST["contact"])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $subject = mysqli_real_escape_string($connect, $_POST['subject']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    // For now, just set a success message. In a real application, you might send an email or store in database
    $_SESSION['message'] = "Thank you for your message, $name! We will get back to you soon.";
    header("Location:../../contacts.php");
    exit;
}
?>
