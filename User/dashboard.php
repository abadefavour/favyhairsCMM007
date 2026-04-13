<?php
session_start();
include "../db_connect.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit();
}

$user_name = $_SESSION['first_name'] ?? "User";


$search = $_GET['search'] ?? "";

$equipment = [
    ["name" => "Alligator Clips Set", "image" => "alligator_clips.jpeg"],
    ["name" => "Applicator Bottle", "image" => "applicator_bottle.jpeg"],
    ["name" => "Bobby Pins Pack", "image" => "bobby_pins.jpeg"],
    ["name" => "Bonnet Dryer", "image" => "bonnet_dryer.jpeg"],
    ["name" => "Cleaning Brush", "image" => "cleaning_brush.jpeg"],
    ["name" => "Curling Iron", "image" => "curling_iron.jpeg"],
    ["name" => "Detailer Clippers", "image" => "detailer_clippers.jpeg"],
    ["name" => "Extension Pliers", "image" => "extension_pliers.jpeg"],
    ["name" => "Flat Iron", "image" => "flat_iron.jpeg"],
    ["name" => "Foil Sheet", "image" => "foil_sheet.jpeg"],
    ["name" => "Hair Clippers", "image" => "hair_clippers.jpeg"],
    ["name" => "Hair processor", "image" => "hair_processor.jpeg"],
    ["name" => "Hair Scissors", "image" => "hair_scissors.jpeg"],
    ["name" => "Hair Steamers", "image" => "hair_steamer.jpeg"],
    ["name" => "Hair Trimmers", "image" => "hair_trimmers.jpeg"],
    ["name" => "Heat Cap", "image" => "heat_cap.jpeg"],
    ["name" => "Hood Dryer", "image" => "hood_dryer.jpeg"],
    ["name" => "Hot Rollers", "image" => "hot_rollers.jpeg"],
    ["name" => "Loop Tool", "image" => "loop_tool.jpeg"],
    ["name" => "Micro Ringbeads", "image" => "micro_ringbeads.jpeg"],
    ["name" => "Mixing Bowl", "image" => "mixing_bowl.jpeg"],
    ["name" => "Paddle Brush", "image" => "paddle_brush.jpeg"],
    ["name" => "Professional HairDryer", "image" => "professional_hairdryer.jpeg"],
    ["name" => "Razor Feather", "image" => "razor_feather.jpeg"],
    ["name" => "Salon Cape", "image" => "salon_cape.jpeg"],
    ["name" => "Sectioning Clips", "image" => "sectioning_clips.jpeg"],
    ["name" => "Shampoo Brush", "image" => "shampoo_brush.jpeg"],
    ["name" => "Spray Bottle", "image" => "spray_bottle.jpeg"],
    ["name" => "Tail Comb", "image" => "tail_comb.jpeg"],
    ["name" => "Tint Comb", "image" => "tint_comb.jpeg"],
    ["name" => "Towels", "image" => "towels.jpeg"],
    ["name" => "Wide Toothcomb", "image" => "wide_toothcomb.jpeg"],
];

if (!empty($search)) {
    $equipment = array_filter($equipment, function ($item) use ($search) {
        return stripos($item['name'], $search) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FavyHairs - Dashboard</title>

<link rel="stylesheet" href="../css/style_3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">FavyHairs</span>

    <div class="ms-auto d-flex align-items-center">
        <span class="text-white me-3">
            Welcome, <?php echo htmlspecialchars($user_name); ?>
        </span>
        
<form method="POST">
    <button type="submit" name="logout" class="btn btn-primary btn-sm" style="width: 76px;">Logout</button>
</form>
    </div>
</nav>

<div class="d-flex">

    


    <div class="sidebar p-3">
        <h5 class="text-white">Menu</h5>

    
        <form method="GET">
            <input type="text" name="search" class="form-control mb-2"
                   placeholder="Search equipment..."
                   value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary w-100">Search</button>
        </form>

        <ul class="nav flex-column mt-4">
            <li class="nav-item"><a class="nav-link" href="../about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="view_equipment.php">Equipment</a></li>
        </ul>
    </div>

    
    <div class="content p-4 w-100">

        <h3>All Equipments</h3>

        <div class="container">
            <div class="row g-4">

                <?php if (empty($equipment)): ?>
                    <p>No equipment found.</p>
                <?php endif; ?>

                <?php foreach ($equipment as $item): ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                        
                        <a href="user_rental.php?item=<?php echo urlencode($item['name']); ?>" 
                           class="text-decoration-none text-dark">

                            <div class="card shadow-sm h-100">

                                <img src="../images/<?php echo $item['image']; ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $item['name']; ?>">

                                <div class="card-body">
                                    <h6 class="card-title">
                                        <?php echo $item['name']; ?>
                                    </h6>
                                    <p class="text-muted small">Rent</p>
                                </div>

                            </div>

                        </a>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>