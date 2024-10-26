<?php
require_once("config.php");

if(isset($_POST['form_submit'])) {
    $name = trim($_POST['name']);
    $fname = trim($_POST['fname']);
    $intermediate_hallticket = trim($_POST['intermediate_hallticket']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $address = trim($_POST['address']);
    $category = trim($_POST['category']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $reg_no = 'TS' . rand(99, 10) . time();
    $folder = "admin_module/uploads/";

    // Check if intermediate hallticket number already exists
    $stmt = $db->prepare("SELECT * FROM registrations WHERE intermediate_hallticket = :intermediate_hallticket");
    $stmt->bindParam(':intermediate_hallticket', $intermediate_hallticket, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count > 0) {
  echo "<script>alert('Roll number already exists.'); window.location.href = 'form.php';</script>";
        exit; // Stop further execution if the hallticket number already exists
    }

    // Photo
    $image_file = $_FILES['image']['name'];
    $file = $_FILES['image']['tmp_name'];
    $new_image_name = 'photo_' . rand() . '.' . pathinfo($image_file, PATHINFO_EXTENSION);
    move_uploaded_file($file, $folder . $new_image_name);

    // Sign
    $simage_file = $_FILES['simage']['name'];
    $sfile = $_FILES['simage']['tmp_name'];
    $snew_image_name = 'sign_' . rand() . '.' . pathinfo($simage_file, PATHINFO_EXTENSION);
    move_uploaded_file($sfile, $folder . $snew_image_name);

    $sql = "INSERT INTO registrations(name, fname, intermediate_hallticket, gender, dob, address, category, email, mobile, reg_no, image, sign) 
            VALUES(:name, :fname, :intermediate_hallticket, :gender, :dob, :address, :category, :email, :mobile, :reg_no, :image, :sign)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':fname', $fname, PDO::PARAM_STR);
    $stmt->bindParam(':intermediate_hallticket', $intermediate_hallticket, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $stmt->bindParam(':reg_no', $reg_no, PDO::PARAM_STR);
    $stmt->bindParam(':image', $new_image_name, PDO::PARAM_STR);
    $stmt->bindParam(':sign', $snew_image_name, PDO::PARAM_STR);
    $stmt->execute();
    $last_id = $db->lastInsertId();
    if($last_id != '') {
        header("location:preview.php?id=" . $reg_no);
    } else {
        echo 'Something went wrong';
    }
}
?>
