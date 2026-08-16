<?php
$name = "Nguyễn Quỳnh";
$major = "Công nghệ thông tin";
$school = "Đại học Thủ đô Hà Nội";
$email = "nguyenquynh@example.com";

$skills = [
    "HTML & CSS",
    "JavaScript",
    "PHP",
    "MySQL",
    "Git & GitHub"
];

$projects = [
    [
        "name" => "Website bán hàng",
        "description" => "Xây dựng website bán hàng với giao diện thân thiện, hiển thị sản phẩm và thông tin chi tiết.",
        "technology" => "HTML, CSS, JavaScript"
    ],
    [
        "name" => "Website quản lý sinh viên",
        "description" => "Xây dựng hệ thống quản lý thông tin sinh viên với các chức năng thêm, sửa, xóa và hiển thị dữ liệu.",
        "technology" => "PHP, MySQL, HTML, CSS"
    ],
    [
        "name" => "Website giới thiệu cá nhân",
        "description" => "Thiết kế website giới thiệu bản thân, kỹ năng và các dự án đã thực hiện trong quá trình học tập.",
        "technology" => "PHP, HTML, CSS"
    ]
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $name; ?> - About Me</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
            line-height: 1.6;
        }

        /* HEADER */

        header {
            background: #111827;
            color: white;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
        }

        nav a:hover {
            color: #60a5fa;
        }

        /* HERO */

        .hero {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
        }

        .hero-text {
            flex: 1;
        }

        .hello {
            color: #2563eb;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 15px;
            color: #111827;
        }

        .hero h1 span {
            color: #2563eb;
        }

        .hero p {
            color: #6b7280;
            font-size: 17px;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .button:hover {
            background: #1d4ed8;
        }

        /* AVATAR */

        .avatar-box {
            width: 280px;
            height: 280px;
            flex-shrink: 0;
        }

        .avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;

            border-radius: 50%;

            border: 8px solid white;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.15);
        }

        /* SECTION */

        section {
            max-width: 1100px;
            margin: 80px auto;
            padding: 0 30px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 32px;
            color: #111827;
        }

        .section-title p {
            color: #6b7280;
            margin-top: 8px;
        }

        /* ABOUT */

        .about-box {
            background: white;
            padding: 35px;
            border-radius: 15px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 25px;
        }

        .info-item {
            background: #f8fafc;
            padding: 18px;
            border-radius: 10px;
        }

        .info-item strong {
            display: block;
            color: #2563eb;
            margin-bottom: 5px;
        }

        /* SKILLS */

        .skills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .skill {
            background: white;
            padding: 12px 22px;
            border-radius: 30px;

            color: #2563eb;
            font-weight: bold;

            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        }

        /* PROJECT */

        .projects {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .project {
            background: white;
            padding: 25px;
            border-radius: 15px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);

            transition: 0.3s;
        }

        .project:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .project-number {
            color: #2563eb;
            font-weight: bold;
            font-size: 14px;
        }

        .project h3 {
            margin: 10px 0;
            color: #111827;
        }

        .project p {
            color: #6b7280;
            font-size: 15px;
        }

        .technology {
            margin-top: 15px;
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
        }

        /* FOOTER */

        footer {
            background: #111827;
            color: #9ca3af;
            text-align: center;
            padding: 30px;
            margin-top: 80px;
        }

        footer strong {
            color: white;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            header {
                flex-direction: column;
                gap: 15px;
            }

            nav a {
                margin: 0 8px;
            }

            .hero {
                flex-direction: column-reverse;
                text-align: center;
            }

            .hero h1 {
                font-size: 36px;
            }

            .avatar-box {
                width: 220px;
                height: 220px;
            }

            .info {
                grid-template-columns: 1fr;
            }

            .projects {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>

<body>

    <!-- HEADER -->

    <header>

        <div class="logo">
            My Portfolio
        </div>

        <nav>
            <a href="#about">Giới thiệu</a>
            <a href="#skills">Kỹ năng</a>
            <a href="#projects">Dự án</a>
        </nav>

    </header>


    <!-- HERO -->

    <div class="hero">

        <div class="hero-text">

            <div class="hello">
                XIN CHÀO 👋
            </div>

            <h1>
                Mình là <span><?php echo $name; ?></span>
            </h1>

            <p>
                Sinh viên <?php echo $major; ?> với niềm yêu thích
                lập trình, thiết kế website và khám phá những công nghệ mới.
            </p>

            <a href="#projects" class="button">
                Xem dự án
            </a>

        </div>


        <div class="avatar-box">

            <img src="avatar.jpg" alt="Ảnh đại diện">

        </div>

    </div>


    <!-- ABOUT -->

    <section id="about">

        <div class="section-title">

            <h2>Về mình</h2>

            <p>Một chút thông tin về bản thân</p>

        </div>


        <div class="about-box">

            <p>
                Xin chào! Mình là <strong><?php echo $name; ?></strong>,
                hiện đang học ngành <?php echo $major; ?> tại
                <?php echo $school; ?>.
            </p>

            <p style="margin-top: 15px;">
                Mình đang tập trung phát triển các kỹ năng lập trình
                website và xây dựng các sản phẩm phục vụ cho học tập
                cũng như thực tế.
            </p>


            <div class="info">

                <div class="info-item">
                    <strong>Họ và tên</strong>
                    <?php echo $name; ?>
                </div>

                <div class="info-item">
                    <strong>Ngành học</strong>
                    <?php echo $major; ?>
                </div>

                <div class="info-item">
                    <strong>Trường</strong>
                    <?php echo $school; ?>
                </div>

                <div class="info-item">
                    <strong>Email</strong>
                    <?php echo $email; ?>
                </div>

            </div>

        </div>

    </section>


    <!-- SKILLS -->

    <section id="skills">

        <div class="section-title">

            <h2>Kỹ năng</h2>

            <p>Những công nghệ mình đang học tập</p>

        </div>


        <div class="skills">

            <?php foreach ($skills as $skill): ?>

                <div class="skill">
                    <?php echo $skill; ?>
                </div>

            <?php endforeach; ?>

        </div>

    </section>


    <!-- PROJECTS -->

    <section id="projects">

        <div class="section-title">

            <h2>Dự án đã thực hiện</h2>

            <p>Một số dự án trong quá trình học tập</p>

        </div>


        <div class="projects">

            <?php foreach ($projects as $index => $project): ?>

                <div class="project">

                    <div class="project-number">
                        PROJECT 0<?php echo $index + 1; ?>
                    </div>

                    <h3>
                        <?php echo $project["name"]; ?>
                    </h3>

                    <p>
                        <?php echo $project["description"]; ?>
                    </p>

                    <div class="technology">
                        <?php echo $project["technology"]; ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>


    <!-- FOOTER -->

    <footer>

        <p>
            © 2026 <strong><?php echo $name; ?></strong>.
            All rights reserved.
        </p>

    </footer>

</body>

</html>
