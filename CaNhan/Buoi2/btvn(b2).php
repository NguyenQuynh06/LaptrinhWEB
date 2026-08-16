<?php
/**
 * CHỨC NĂNG: QUẢN LÝ SLOT (KHUNG GIỜ TƯ VẤN CỦA GIẢNG VIÊN)
 * - CRUD: Thêm / Sửa / Xóa / Xem danh sách slot
 * - Dữ liệu được tổ chức bằng mảng, lưu tạm trong SESSION (không cần cài đặt database)
 * - Có hàm tự định nghĩa xử lý nghiệp vụ, có điều kiện phân loại trạng thái,
 *   có vòng lặp để duyệt & hiển thị dữ liệu dạng bảng.
 */

session_start();

// Khởi tạo mảng lưu danh sách slot nếu chưa có (dữ liệu mẫu ban đầu)
if (!isset($_SESSION['slots'])) {
    $_SESSION['slots'] = [
        [
            'id' => 1,
            'giang_vien'   => 'Nguyễn Văn A',
            'ngay'         => date('Y-m-d'),
            'gio_bat_dau'  => '08:00',
            'gio_ket_thuc' => '09:00',
            'trang_thai'   => 'Trống',
        ],
        [
            'id' => 2,
            'giang_vien'   => 'Trần Thị B',
            'ngay'         => date('Y-m-d', strtotime('+1 day')),
            'gio_bat_dau'  => '13:00',
            'gio_ket_thuc' => '14:30',
            'trang_thai'   => 'Đã đặt',
        ],
    ];
    $_SESSION['next_id'] = 3;
}

/* =========================================================
 * CÁC HÀM TỰ ĐỊNH NGHĨA (business functions)
 * ========================================================= */

// 1) Tính thời lượng (phút) của 1 slot dựa trên giờ bắt đầu - giờ kết thúc
function tinhThoiLuongPhut(string $gioBatDau, string $gioKetThuc): int
{
    $bd = DateTime::createFromFormat('H:i', $gioBatDau);
    $kt = DateTime::createFromFormat('H:i', $gioKetThuc);
    if (!$bd || !$kt) {
        return 0;
    }
    $diff = $kt->getTimestamp() - $bd->getTimestamp();
    return (int) max(0, $diff / 60);
}

// 2) Phân loại slot theo thời gian thực tế: Sắp diễn ra / Đang diễn ra / Đã kết thúc
function phanLoaiTheoThoiGian(string $ngay, string $gioBatDau, string $gioKetThuc): string
{
    $now   = new DateTime();
    $start = DateTime::createFromFormat('Y-m-d H:i', $ngay . ' ' . $gioBatDau);
    $end   = DateTime::createFromFormat('Y-m-d H:i', $ngay . ' ' . $gioKetThuc);

    if (!$start || !$end) {
        return 'Không xác định';
    }

    if ($now < $start) {
        return 'Sắp diễn ra';
    } elseif ($now >= $start && $now <= $end) {
        return 'Đang diễn ra';
    } else {
        return 'Đã kết thúc';
    }
}

// 3) Kiểm tra trùng khung giờ của cùng 1 giảng viên trong cùng 1 ngày (khi thêm/sửa)
function kiemTraTrungGio(array $slots, string $giangVien, string $ngay, string $gioBatDau, string $gioKetThuc, ?int $boQuaId = null): bool
{
    $moiBD = DateTime::createFromFormat('H:i', $gioBatDau);
    $moiKT = DateTime::createFromFormat('H:i', $gioKetThuc);

    foreach ($slots as $slot) {
        if ($boQuaId !== null && $slot['id'] == $boQuaId) {
            continue; // bỏ qua chính slot đang sửa
        }
        if ($slot['giang_vien'] !== $giangVien || $slot['ngay'] !== $ngay) {
            continue;
        }
        $cuBD = DateTime::createFromFormat('H:i', $slot['gio_bat_dau']);
        $cuKT = DateTime::createFromFormat('H:i', $slot['gio_ket_thuc']);

        // Điều kiện trùng khung giờ: khoảng mới giao nhau với khoảng cũ
        if ($moiBD < $cuKT && $moiKT > $cuBD) {
            return true;
        }
    }
    return false;
}

// 4) Sinh badge màu theo trạng thái do người dùng đặt (Trống / Đã đặt / Đã hủy)
function mauTrangThai(string $trangThai): string
{
    switch ($trangThai) {
        case 'Trống':
            return '#2e7d32';   // xanh lá
        case 'Đã đặt':
            return '#1565c0';   // xanh dương
        case 'Đã hủy':
            return '#c62828';   // đỏ
        default:
            return '#616161';
    }
}

/* =========================================================
 * XỬ LÝ DỮ LIỆU NGƯỜI DÙNG NHẬP (tiếp nhận & xử lý)
 * ========================================================= */

$loi = '';
$dangSua = null; // slot đang được sửa (nếu có)

// XÓA
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idXoa = (int) $_GET['id'];
    $_SESSION['slots'] = array_values(array_filter(
        $_SESSION['slots'],
        fn($s) => $s['id'] !== $idXoa
    ));
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// LẤY DỮ LIỆU ĐỂ HIỂN THỊ LÊN FORM SỬA
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $idSua = (int) $_GET['id'];
    foreach ($_SESSION['slots'] as $s) {
        if ($s['id'] === $idSua) {
            $dangSua = $s;
            break;
        }
    }
}

// THÊM MỚI / CẬP NHẬT (submit form)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tiếp nhận dữ liệu nhập từ form (tối thiểu 3 trường: giảng viên, ngày, giờ bắt đầu/kết thúc, trạng thái)
    $giangVien   = trim($_POST['giang_vien'] ?? '');
    $ngay        = trim($_POST['ngay'] ?? '');
    $gioBatDau   = trim($_POST['gio_bat_dau'] ?? '');
    $gioKetThuc  = trim($_POST['gio_ket_thuc'] ?? '');
    $trangThai   = trim($_POST['trang_thai'] ?? 'Trống');
    $idDangSua   = isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null;

    // Điều kiện kiểm tra dữ liệu hợp lệ
    if ($giangVien === '' || $ngay === '' || $gioBatDau === '' || $gioKetThuc === '') {
        $loi = 'Vui lòng nhập đầy đủ: Tên giảng viên, Ngày, Giờ bắt đầu, Giờ kết thúc.';
    } elseif ($gioBatDau >= $gioKetThuc) {
        $loi = 'Giờ bắt đầu phải nhỏ hơn giờ kết thúc.';
    } elseif (kiemTraTrungGio($_SESSION['slots'], $giangVien, $ngay, $gioBatDau, $gioKetThuc, $idDangSua)) {
        $loi = 'Khung giờ này bị trùng với một slot khác của cùng giảng viên trong ngày đã chọn.';
    } else {
        if ($idDangSua !== null) {
            // CẬP NHẬT slot đã tồn tại
            foreach ($_SESSION['slots'] as &$s) {
                if ($s['id'] === $idDangSua) {
                    $s['giang_vien']   = $giangVien;
                    $s['ngay']         = $ngay;
                    $s['gio_bat_dau']  = $gioBatDau;
                    $s['gio_ket_thuc'] = $gioKetThuc;
                    $s['trang_thai']   = $trangThai;
                    break;
                }
            }
            unset($s);
        } else {
            // THÊM MỚI slot, tổ chức dữ liệu vào mảng chính
            $_SESSION['slots'][] = [
                'id'           => $_SESSION['next_id']++,
                'giang_vien'   => $giangVien,
                'ngay'         => $ngay,
                'gio_bat_dau'  => $gioBatDau,
                'gio_ket_thuc' => $gioKetThuc,
                'trang_thai'   => $trangThai,
            ];
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$danhSachSlot = $_SESSION['slots'];

// Sắp xếp danh sách theo ngày rồi giờ bắt đầu, để hiển thị khoa học hơn
usort($danhSachSlot, function ($a, $b) {
    return [$a['ngay'], $a['gio_bat_dau']] <=> [$b['ngay'], $b['gio_bat_dau']];
});
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Slot Tư Vấn Của Giảng Viên</title>
<style>
    body { font-family: Arial, Helvetica, sans-serif; background:#fff0f5; margin:0; padding:24px; color:#222; }
    h1 { text-align:center; color:#de3163; margin-bottom:4px; }
    .subtitle { text-align:center; color:#a6265a; font-size:13px; margin:0 0 24px; }
    .container { max-width: 1000px; margin: 0 auto; }
    .card { background:#fff; border-radius:8px; padding:20px; margin-bottom:24px; box-shadow:0 1px 4px rgba(0,0,0,.1); border:1px solid #ffd6e5; }
    .card h2 { margin-top:0; color:#c2185b; font-size:18px; }
    label { display:block; margin-top:10px; font-weight:bold; font-size:14px; color:#a6265a; }
    input, select { width:100%; padding:8px; margin-top:4px; border:1px solid #f3b6cf; border-radius:4px; box-sizing:border-box; font-size:14px; }
    input:focus, select:focus { outline:none; border-color:#de3163; box-shadow:0 0 0 2px rgba(222,49,99,.15); }
    .row { display:flex; gap:16px; flex-wrap:wrap; }
    .row > div { flex:1; min-width:180px; }
    button, .btn { margin-top:16px; background:#de3163; color:#fff; border:none; padding:10px 18px; border-radius:4px; cursor:pointer; font-size:14px; text-decoration:none; display:inline-block; }
    button:hover, .btn:hover { background:#a6265a; }
    .btn-danger { background:#c62828; }
    .btn-danger:hover { background:#8e0000; }
    .btn-secondary { background:#616161; }
    .btn-secondary:hover { background:#404040; }
    .form-actions { display:flex; gap:10px; align-items:center; }
    table { width:100%; border-collapse: collapse; margin-top:10px; }
    th, td { padding:10px; border-bottom:1px solid #ffd6e5; text-align:left; font-size:14px; }
    th { background:#de3163; color:#fff; }
    tr:hover { background:#fff0f5; }
    .badge { color:#fff; padding:3px 10px; border-radius:12px; font-size:12px; }
    .badge.trong { background:#43a047; }
    .badge.da_dat { background:#c2185b; }
    .thoigian { font-size:12px; color:#666; }
    .loi { background:#ffebee; color:#c62828; padding:10px; border-radius:4px; margin-bottom:10px; }
    .thanh-cong { background:#fce4ec; color:#a6265a; padding:10px; border-radius:4px; margin-bottom:10px; border:1px solid #f3b6cf; }
    .rong { text-align:center; padding:20px; color:#999; }
    .thongke { display:flex; justify-content:center; gap:24px; margin-bottom:20px; font-size:14px; color:#a6265a; }
    .thongke b { color:#de3163; }
    .actions-cell a { margin-right:12px; font-size:13px; font-weight:bold; text-decoration:none; }
    .actions-cell a.sua { color:#1565c0; }
    .actions-cell a.xoa { color:#c62828; }
    .actions-cell a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="container">
    <h1>📅 Quản lý Slot Tư Vấn Của Giảng Viên</h1>

    <div class="card">
        <h2><?= $dangSua ? 'Cập nhật Slot' : 'Thêm Slot Mới' ?></h2>

        <?php if ($loi): ?>
            <div class="loi"><?= htmlspecialchars($loi) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php if ($dangSua): ?>
                <input type="hidden" name="id" value="<?= (int) $dangSua['id'] ?>">
            <?php endif; ?>

            <div class="row">
                <div>
                    <label>Tên giảng viên</label>
                    <input type="text" name="giang_vien" required
                           value="<?= htmlspecialchars($dangSua['giang_vien'] ?? '') ?>"
                           placeholder="VD: Nguyễn Văn A">
                </div>
                <div>
                    <label>Ngày tư vấn</label>
                    <input type="date" name="ngay" required
                           value="<?= htmlspecialchars($dangSua['ngay'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>Giờ bắt đầu</label>
                    <input type="time" name="gio_bat_dau" required
                           value="<?= htmlspecialchars($dangSua['gio_bat_dau'] ?? '') ?>">
                </div>
                <div>
                    <label>Giờ kết thúc</label>
                    <input type="time" name="gio_ket_thuc" required
                           value="<?= htmlspecialchars($dangSua['gio_ket_thuc'] ?? '') ?>">
                </div>
                <div>
                    <label>Trạng thái</label>
                    <?php $tt = $dangSua['trang_thai'] ?? 'Trống'; ?>
                    <select name="trang_thai">
                        <option value="Trống"   <?= $tt === 'Trống' ? 'selected' : '' ?>>Trống</option>
                        <option value="Đã đặt"  <?= $tt === 'Đã đặt' ? 'selected' : '' ?>>Đã đặt</option>
                        <option value="Đã hủy"  <?= $tt === 'Đã hủy' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>
            </div>

            <button type="submit"><?= $dangSua ? 'Cập nhật' : 'Thêm slot' ?></button>
            <?php if ($dangSua): ?>
                <a class="btn btn-secondary" href="<?= $_SERVER['PHP_SELF'] ?>">Hủy sửa</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="card">
        <h2>Danh sách Slot (<?= count($danhSachSlot) ?>)</h2>

        <?php if (empty($danhSachSlot)): ?>
            <div class="rong">Chưa có slot nào. Hãy thêm slot mới ở trên.</div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Giảng viên</th>
                    <th>Ngày</th>
                    <th>Giờ</th>
                    <th>Thời lượng</th>
                    <th>Trạng thái</th>
                    <th>Thời điểm</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // VÒNG LẶP: duyệt mảng dữ liệu để hiển thị từng slot ra bảng
                $stt = 0;
                foreach ($danhSachSlot as $slot):
                    $stt++;
                    $phut = tinhThoiLuongPhut($slot['gio_bat_dau'], $slot['gio_ket_thuc']);
                    $phanLoai = phanLoaiTheoThoiGian($slot['ngay'], $slot['gio_bat_dau'], $slot['gio_ket_thuc']);
                    $mau = mauTrangThai($slot['trang_thai']);
                ?>
                <tr>
                    <td><?= $stt ?></td>
                    <td><?= htmlspecialchars($slot['giang_vien']) ?></td>
                    <td><?= htmlspecialchars($slot['ngay']) ?></td>
                    <td><?= htmlspecialchars($slot['gio_bat_dau']) ?> - <?= htmlspecialchars($slot['gio_ket_thuc']) ?></td>
                    <td><?= $phut ?> phút</td>
                    <td><span class="badge" style="background: <?= $mau ?>;"><?= htmlspecialchars($slot['trang_thai']) ?></span></td>
                    <td class="thoigian"><?= $phanLoai ?></td>
                    <td>
                        <a class="btn" href="?action=edit&id=<?= (int) $slot['id'] ?>">Sửa</a>
                        <a class="btn btn-danger" href="?action=delete&id=<?= (int) $slot['id'] ?>"
                           onclick="return confirm('Xác nhận xóa slot này?');">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>