<?php
session_start();

// Khởi tạo mảng lưu danh sách slot
if (!isset($_SESSION['slots'])) {
    $_SESSION['slots'] = [];
}

// Hàm kiểm tra dữ liệu slot
function validateSlot($giangVien, $ngay, $batDau, $ketThuc)
{
    if (empty($giangVien) || empty($ngay) || empty($batDau) || empty($ketThuc)) {
        return "Vui lòng nhập đầy đủ thông tin!";
    }

    if ($batDau >= $ketThuc) {
        return "Giờ kết thúc phải lớn hơn giờ bắt đầu!";
    }

    return "";
}

// ================= THÊM / CẬP NHẬT =================
if (isset($_POST['save'])) {

    $giangVien = $_POST['giangVien'];
    $ngay = $_POST['ngay'];
    $batDau = $_POST['batDau'];
    $ketThuc = $_POST['ketThuc'];
    $trangThai = $_POST['trangThai'];

    $error = validateSlot(
        $giangVien,
        $ngay,
        $batDau,
        $ketThuc
    );

    if ($error == "") {

        // Nếu có ID thì cập nhật
        if (isset($_POST['id']) && $_POST['id'] !== "") {

            $id = $_POST['id'];

            foreach ($_SESSION['slots'] as &$slot) {
                if ($slot['id'] == $id) {
                    $slot['giangVien'] = $giangVien;
                    $slot['ngay'] = $ngay;
                    $slot['batDau'] = $batDau;
                    $slot['ketThuc'] = $ketThuc;
                    $slot['trangThai'] = $trangThai;
                }
            }

        } else {

            // Thêm slot mới
            $slot = [
                'id' => time(),
                'giangVien' => $giangVien,
                'ngay' => $ngay,
                'batDau' => $batDau,
                'ketThuc' => $ketThuc,
                'trangThai' => $trangThai
            ];

            $_SESSION['slots'][] = $slot;
        }
    }
}

// ================= XÓA =================
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    foreach ($_SESSION['slots'] as $key => $slot) {
        if ($slot['id'] == $id) {
            unset($_SESSION['slots'][$key]);
        }
    }

    $_SESSION['slots'] = array_values($_SESSION['slots']);
}

// ================= LẤY DỮ LIỆU ĐỂ SỬA =================
$editSlot = null;

if (isset($_GET['edit'])) {

    $id = $_GET['edit'];

    foreach ($_SESSION['slots'] as $slot) {
        if ($slot['id'] == $id) {
            $editSlot = $slot;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Slot tư vấn</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .full {
            grid-column: 1 / 3;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        .edit {
            color: #007bff;
            text-decoration: none;
        }

        .delete {
            color: red;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>QUẢN LÝ SLOT TƯ VẤN GIẢNG VIÊN</h1>

    <form method="POST">

        <input type="hidden"
               name="id"
               value="<?= $editSlot ? $editSlot['id'] : '' ?>">

        <div>
            <label>Giảng viên</label>
            <input type="text"
                   name="giangVien"
                   placeholder="Nhập tên giảng viên"
                   value="<?= $editSlot ? $editSlot['giangVien'] : '' ?>">
        </div>

        <div>
            <label>Ngày tư vấn</label>
            <input type="date"
                   name="ngay"
                   value="<?= $editSlot ? $editSlot['ngay'] : '' ?>">
        </div>

        <div>
            <label>Giờ bắt đầu</label>
            <input type="time"
                   name="batDau"
                   value="<?= $editSlot ? $editSlot['batDau'] : '' ?>">
        </div>

        <div>
            <label>Giờ kết thúc</label>
            <input type="time"
                   name="ketThuc"
                   value="<?= $editSlot ? $editSlot['ketThuc'] : '' ?>">
        </div>

        <div>
            <label>Trạng thái</label>

            <select name="trangThai">
                <option value="Trống"
                    <?= ($editSlot && $editSlot['trangThai'] == 'Trống')
                        ? 'selected' : '' ?>>
                    Trống
                </option>

                <option value="Đã đặt"
                    <?= ($editSlot && $editSlot['trangThai'] == 'Đã đặt')
                        ? 'selected' : '' ?>>
                    Đã đặt
                </option>
            </select>
        </div>

        <div class="full">
            <button type="submit" name="save">
                <?= $editSlot ? 'Cập nhật Slot' : 'Thêm Slot' ?>
            </button>
        </div>

    </form>


    <h2>Danh sách khung giờ tư vấn</h2>

    <table>

        <tr>
            <th>STT</th>
            <th>Giảng viên</th>
            <th>Ngày</th>
            <th>Giờ bắt đầu</th>
            <th>Giờ kết thúc</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>

        <?php
        $stt = 1;

        // Vòng lặp duyệt mảng
        foreach ($_SESSION['slots'] as $slot):
        ?>

        <tr>
            <td><?= $stt++ ?></td>

            <td><?= htmlspecialchars($slot['giangVien']) ?></td>

            <td><?= $slot['ngay'] ?></td>

            <td><?= $slot['batDau'] ?></td>

            <td><?= $slot['ketThuc'] ?></td>

            <td><?= $slot['trangThai'] ?></td>

            <td>
                <a class="edit"
                   href="?edit=<?= $slot['id'] ?>">
                    Sửa
                </a>

                |

                <a class="delete"
                   href="?delete=<?= $slot['id'] ?>"
                   onclick="return confirm('Bạn có chắc muốn xóa slot này?')">
                    Xóa
                </a>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>