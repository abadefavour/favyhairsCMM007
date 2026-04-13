<?php
session_start();
include "db_connect.php";

$success = "";

if(isset($_POST['send'])){

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    if(empty($name) || empty($email) || empty($message)){
        $success = "Please fill in all fields.";
        $success_type = "error";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $success = "Invalid email format.";
        $success_type = "error";
    } else {

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        $stmt->execute();
        $stmt->close();

        $success = "Thank you! Your message has been sent successfully.";
        $success_type = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | FavyHairs</title>
<link rel="stylesheet" href="css/style_3.css">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

<?php include_once 'include/header.php'; ?>
<div class="container">

    <h2>Contact FavyHairs</h2>

    <p class="intro">
        If you have questions about renting our hair equipment or our services,
        send us a message below.
    </p>

    <?php if($success != ""): ?>
        <div class="log-box <?php echo $success_type; ?>">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="contact-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit" name="send">Send Message</button>
    </form>

    <div class="contact-info">
        <h3>Our Contact Details</h3>
        <p><strong>Business:</strong> FavyHairs</p>
        <p><strong>Email:</strong> support@favyhairs.com</p>
        <p><strong>Phone:</strong> +44 7000 123456</p>
        <p><strong>Location:</strong> Aberdeen, UK</p>
    </div>

</div>
<?php include_once 'include/footer.php'; ?>

</body>
</html>