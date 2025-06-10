<?php
$data = json_decode(file_get_contents('admin/data.json'), true);
$staff = $data['staff'];

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$member = null;
foreach ($staff as $item) {
    if ($item['id'] == $id) {
        $member = $item;
        break;
    }
}

if (!$member) {
    echo "<h3 class='text-center mt-5'>لم يتم العثور على العضو المطلوب.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تفاصيل عضو الكادر - <?= $member['name'] ?></title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f4f6f9;
    }

    .profile-card {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 40px 30px;
      text-align: center;
    }

    .profile-card img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid #f1c40f;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .profile-card h3 {
      margin-top: 20px;
      font-weight: bold;
    }

    .profile-card .title {
      color: #555;
      font-size: 1.1rem;
      margin-bottom: 25px;
    }

    .profile-card .bio {
      text-align:center;
      line-height: 1.8;
      font-size: 1.1rem;
      color: #333;
    }

    .back-btn {
      margin-top: 40px;
    }
  </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="profile-card">
        <img src="admin/<?= $member['image'] ?>" alt="<?= $member['name'] ?>">
        <h3><?= $member['name'] ?></h3>
        <p class="title"><?= $member['title'] ?></p>

        <h5 class="fw-bold mb-3">السيرة الذاتية</h5>
        <p class="bio"><?= nl2br($member['bio']) ?></p>

        <div class="back-btn">
          <a href="index.php#staff" class="btn btn-secondary">⬅ العودة</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
