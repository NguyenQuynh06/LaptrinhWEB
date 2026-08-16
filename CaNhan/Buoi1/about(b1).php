<?php
/**
 * about.php — Trang giới thiệu bản thân
 * Chỉnh các biến bên dưới cho đúng thông tin của bạn.
 */

$hoTen      = "Nguyễn Thu Quỳnh";
$lop        = "CNTT D2024A";
$mssv       = "224001827"; // ← thay bằng mã sinh viên thật
$truong     = "Trường Đại học Thủ đô Hà Nội"; // ← thay bằng tên trường thật
$email      = "quynh@example.com"; // ← thay bằng email của bạn
$vaiTro     = "Sinh viên ngành Công nghệ thông tin";
$avatarPath = "assets/avatar.jpg"; // ← để ảnh thật của bạn vào thư mục assets rồi đổi tên file cho khớp

$duAnCaNhan = [
    "ten"    => "Quản lý Slot — Khung giờ tư vấn giảng viên",
    "vaiTro" => "Dự án cá nhân",
    "moTa"   => "Ứng dụng web cho phép giảng viên tạo, xem, chỉnh sửa và xoá (CRUD) các khung giờ rảnh để tư vấn sinh viên. Dữ liệu khung giờ được lưu trữ và quản lý theo ngày, tránh trùng lịch.",
    "congNghe" => ["PHP", "MySQL", "HTML/CSS", "JavaScript"],
    "link" => "https://github.com/NguyenQuynh06/LaptrinhWEB.git",
    "diem" => [
        "Thêm / sửa / xoá khung giờ tư vấn theo ngày",
        "Kiểm tra và cảnh báo trùng khung giờ",
        "Giao diện quản trị trực quan, thao tác nhanh",
    ],
];

$duAnNhom = [
    "ten"    => "Hệ thống đặt lịch tư vấn — Hẹn gặp giảng viên",
    "vaiTro" => "Dự án nhóm",
    "moTa"   => "Nền tảng giúp sinh viên xem khung giờ trống của giảng viên và đặt lịch hẹn tư vấn trực tuyến. Giảng viên duyệt hoặc từ chối yêu cầu, hệ thống gửi thông báo cho cả hai bên.",
    "congNghe" => ["PHP", "MySQL", "Bootstrap", "AJAX"],
    "link" => "https://github.com/Tanh-Mun/BTLNhom.git",
    "diem" => [
        "Sinh viên tra cứu và đặt lịch hẹn theo khung giờ trống",
        "Giảng viên duyệt / từ chối / huỷ lịch hẹn",
        "Thông báo trạng thái lịch hẹn theo thời gian thực",
    ],
];

// Bổ sung / chỉnh sửa kỹ năng của bạn tại đây
$kyNang = [
    "Ngôn ngữ & Framework" => ["PHP", "JavaScript", "HTML/CSS", "Bootstrap"],
    "Cơ sở dữ liệu & Công cụ" => ["MySQL", "Git & GitHub", "Postman", "XAMPP"],
    "Kỹ năng mềm" => ["Làm việc nhóm", "Quản lý thời gian", "Giải quyết vấn đề"],
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Giới thiệu — <?php echo htmlspecialchars($hoTen); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg:            #F6F1FE;
    --bg-soft:       #EFE6FC;
    --bg-panel:      #FFFFFF;
    --violet-deep:   #6E45C0;
    --violet:        #8B6BDB;
    --lilac:         #D9C8FA;
    --pink:          #F6C9E4;
    --mint:          #C6EFE0;
    --ink:           #2E2148;
    --ink-dim:       #79699C;
    --line:          rgba(110,69,192,0.14);
    --radius:        18px;
    --font-display:  'Space Grotesk', sans-serif;
    --font-body:     'Inter', sans-serif;
  }

  *{ box-sizing: border-box; }

  html{ scroll-behavior: smooth; }

  body{
    margin:0;
    background:
      radial-gradient(ellipse 900px 500px at 12% -8%, rgba(246,201,228,0.55), transparent 60%),
      radial-gradient(ellipse 700px 500px at 100% 5%, rgba(198,239,224,0.45), transparent 55%),
      var(--bg);
    color: var(--ink);
    font-family: var(--font-body);
    line-height: 1.65;
  }

  a{ color: inherit; }

  .wrap{
    max-width: 880px;
    margin: 0 auto;
    padding: 64px 24px 100px;
  }

  /* ===== Slot-grid decorative strip (signature element) ===== */
  .slot-strip{
    display:flex;
    justify-content:center;
    gap:6px;
    margin-bottom: 40px;
  }
  .slot-strip span{
    width: 26px;
    height: 8px;
    border-radius: 4px;
    background: var(--lilac);
  }
  .slot-strip span.on{ background: var(--violet); }

  /* ===== Hero / thông tin cá nhân ===== */
  .hero{
    text-align: center;
    margin-bottom: 64px;
  }

  .avatar{
    width: 152px;
    height: 152px;
    border-radius: 50%;
    margin: 0 auto 28px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family: var(--font-display);
    font-size: 44px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(150deg, var(--pink), var(--violet) 65%);
    border: 4px solid #fff;
    box-shadow: 0 0 0 8px var(--bg-soft), 0 18px 40px -16px rgba(110,69,192,0.45);
    overflow: hidden;
  }
  .avatar img{
    width:100%; height:100%; object-fit: cover; display:block;
  }

  .hero h1{
    font-family: var(--font-display);
    font-size: clamp(28px, 4vw, 40px);
    font-weight: 700;
    margin: 0 0 8px;
    letter-spacing: -0.01em;
    color: var(--violet-deep);
  }

  .hero .role{
    color: var(--ink-dim);
    font-weight: 500;
    margin: 0 0 32px;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  /* Thông tin cá nhân bố trí dọc */
  .info-list{
    display:flex;
    flex-direction: column;
    align-items: stretch;
    max-width: 500px;
    margin: 0 auto;
    padding: 10px 0;
    text-align: left;
    background: var(--bg-panel);
    border: 1px solid var(--line);
    border-radius: 18px;
  }

  .info-row{
    display:flex;
    justify-content: flex-start;
    align-items:center;
    gap: 16px;
    padding: 10px 20px;
  }
  .info-row .label{
    font-size: 13px;
    color: var(--ink-dim);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
    white-space: nowrap;
  }
  .info-row .value{
    font-size: 15px;
    font-weight: 600;
    color: var(--ink);
    text-align: left;
  }
  .info-row .value.accent{
    color: var(--violet-deep);
  }

  /* ===== Section header ===== */
  .section-head{
    display:flex;
    align-items:baseline;
    gap:14px;
    margin: 0 0 28px;
  }
  .section-head .eyebrow{
    font-family: var(--font-display);
    font-size: 13px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--violet-deep);
    font-weight: 600;
  }
  .section-head h2{
    font-family: var(--font-display);
    font-size: 25px;
    font-weight: 700;
    margin: 0;
    color: var(--ink);
  }
  .section-head::after{
    content:"";
    flex:1;
    height:1px;
    background: var(--line);
  }

  section{ margin-bottom: 60px; }

  /* ===== Project cards ===== */
  .projects{
    display: grid;
    gap: 22px;
  }

  .card{
    position: relative;
    background: var(--bg-panel);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    padding: 30px 32px;
    overflow: hidden;
    box-shadow: 0 12px 30px -22px rgba(110,69,192,0.35);
  }
  .card::before{
    content:"";
    position:absolute;
    top:-45%; right:-12%;
    width: 240px; height: 240px;
    background: radial-gradient(circle, rgba(246,201,228,0.5), transparent 65%);
    pointer-events:none;
  }

  .card-tag{
    display:inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--violet-deep);
    background: var(--lilac);
    padding: 4px 12px;
    border-radius: 999px;
    margin-bottom: 16px;
  }

  .card h3{
    font-family: var(--font-display);
    font-size: 21px;
    margin: 0 0 12px;
    font-weight: 700;
    color: var(--ink);
  }

  .card p.desc{
    color: var(--ink-dim);
    margin: 0 0 20px;
    max-width: 62ch;
  }

  .card ul{
    margin: 0 0 20px;
    padding-left: 0;
    list-style: none;
  }
  .card ul li{
    position: relative;
    padding-left: 22px;
    margin-bottom: 8px;
    font-size: 14.5px;
    color: var(--ink);
  }
  .card ul li::before{
    content:"";
    position:absolute;
    left:0; top:8px;
    width:8px; height:8px;
    border-radius: 2px;
    background: var(--violet);
    transform: rotate(45deg);
  }

  .tech-row{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
  }
  .tech-row span{
    font-size: 12.5px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 8px;
    background: var(--bg-soft);
    border: 1px solid var(--line);
    color: var(--violet-deep);
  }

  .project-link{
    display: inline-block;
    margin-top: 8px;
    padding: 8px 16px;
    border-radius: 8px;
    background: var(--violet);
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
  }

  .project-link:hover{
    background: var(--violet-deep);
    transform: translateY(-1px);
  }

  /* ===== Skills ===== */
  .skills-grid{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
  }

  .skill-card{
    background: var(--bg-panel);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    padding: 22px 24px;
  }

  .skill-card h4{
    font-family: var(--font-display);
    font-size: 15px;
    margin: 0 0 14px;
    color: var(--violet-deep);
  }

  .skill-tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
  }

  .skill-tags span{
    font-size: 13px;
    font-weight: 600;
    padding: 6px 13px;
    border-radius: 999px;
    color: var(--ink);
  }

  /* luân phiên màu pastel cho các nhóm kỹ năng */
  .skill-card:nth-child(3n+1) .skill-tags span{ background: var(--mint); }
  .skill-card:nth-child(3n+2) .skill-tags span{ background: var(--pink); }
  .skill-card:nth-child(3n+3) .skill-tags span{ background: var(--lilac); }

  footer{
    text-align:center;
    color: var(--ink-dim);
    font-size: 13px;
    margin-top: 40px;
  }

  @media (max-width: 560px){
    .wrap{ padding: 44px 18px 72px; }
    .card{ padding: 24px 20px; }
    .info-list{ max-width: 100%; }
    .info-row{ padding: 12px 16px; }
  }
</style>
</head>
<body>
<div class="wrap">

  <div class="slot-strip" aria-hidden="true">
    <span></span><span></span><span class="on"></span><span></span>
    <span class="on"></span><span></span><span></span><span class="on"></span>
  </div>

  <section class="hero">
    <div class="avatar">
      <?php if (!empty($avatarPath) && file_exists($avatarPath)): ?>
        <img src="<?php echo htmlspecialchars($avatarPath); ?>" alt="Ảnh đại diện của <?php echo htmlspecialchars($hoTen); ?>">
      <?php else: ?>
        <?php
          // Hiển thị chữ cái đầu nếu chưa có ảnh
          $parts = explode(" ", trim($hoTen));
          echo htmlspecialchars(mb_substr(end($parts), 0, 1, "UTF-8"));
        ?>
      <?php endif; ?>
    </div>

    <h1><?php echo htmlspecialchars($hoTen); ?></h1>
    <p class="role"><?php echo htmlspecialchars($vaiTro); ?></p>

    <div class="info-list">
      <div class="info-row">
        <span class="label">Họ và tên</span>
        <span class="value accent"><?php echo htmlspecialchars($hoTen); ?></span>
      </div>
      <div class="info-row">
        <span class="label">Lớp</span>
        <span class="value"><?php echo htmlspecialchars($lop); ?></span>
      </div>
      <div class="info-row">
        <span class="label">Mã sinh viên</span>
        <span class="value"><?php echo htmlspecialchars($mssv); ?></span>
      </div>
      <div class="info-row">
        <span class="label">Trường</span>
        <span class="value"><?php echo htmlspecialchars($truong); ?></span>
      </div>
      <div class="info-row">
        <span class="label">Email</span>
        <span class="value"><?php echo htmlspecialchars($email); ?></span>
      </div>
    </div>
  </section>

  <section id="ky-nang">
    <div class="section-head">
      <span class="eyebrow">Năng lực</span>
      <h2>Kỹ năng</h2>
    </div>

    <div class="skills-grid">
      <?php foreach ($kyNang as $nhom => $danhSach): ?>
        <div class="skill-card">
          <h4><?php echo htmlspecialchars($nhom); ?></h4>
          <div class="skill-tags">
            <?php foreach ($danhSach as $sk): ?>
              <span><?php echo htmlspecialchars($sk); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="du-an">
    <div class="section-head">
      <span class="eyebrow">Dự án</span>
      <h2>Các dự án đã thực hiện</h2>
    </div>

    <div class="projects">

      <article class="card">
        <span class="card-tag"><?php echo htmlspecialchars($duAnCaNhan['vaiTro']); ?></span>
        <h3><?php echo htmlspecialchars($duAnCaNhan['ten']); ?></h3>
        <p class="desc"><?php echo htmlspecialchars($duAnCaNhan['moTa']); ?></p>
        <ul>
          <?php foreach ($duAnCaNhan['diem'] as $diem): ?>
            <li><?php echo htmlspecialchars($diem); ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="tech-row">
          <?php foreach ($duAnCaNhan['congNghe'] as $tech): ?>
            <span><?php echo htmlspecialchars($tech); ?></span>
          <?php endforeach; ?>
        </div>
        <a class="project-link"
           href="<?php echo htmlspecialchars($duAnCaNhan['link']); ?>"
           target="_blank"
           rel="noopener noreferrer">
          Xem dự án →
        </a>
      </article>

      <article class="card">
        <span class="card-tag"><?php echo htmlspecialchars($duAnNhom['vaiTro']); ?></span>
        <h3><?php echo htmlspecialchars($duAnNhom['ten']); ?></h3>
        <p class="desc"><?php echo htmlspecialchars($duAnNhom['moTa']); ?></p>
        <ul>
          <?php foreach ($duAnNhom['diem'] as $diem): ?>
            <li><?php echo htmlspecialchars($diem); ?></li>
          <?php endforeach; ?>
        </ul>
        <div class="tech-row">
          <?php foreach ($duAnNhom['congNghe'] as $tech): ?>
            <span><?php echo htmlspecialchars($tech); ?></span>
          <?php endforeach; ?>
        </div>
        <a class="project-link"
           href="<?php echo htmlspecialchars($duAnNhom['link']); ?>"
           target="_blank"
           rel="noopener noreferrer">
          Xem dự án →
        </a>
      </article>

    </div>
  </section>

  <footer>
    © <?php echo date("Y"); ?> <?php echo htmlspecialchars($hoTen); ?> — <?php echo htmlspecialchars($truong); ?>
  </footer>

</div>
</body>
</html>