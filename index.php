<?php

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Favy Hair</title>
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
  <div>
    <?php include_once 'include/header.php'; ?>
    <main class="pb-16">
      <section class="relative h-[90vh] flex items-center justify-center text-center">
        <div class="absolute inset-0">
          <img src="images/hero_bg.jpeg" alt="Hair styling tools" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 max-w-2xl px-6 text-white">
          <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
            Rent Premium Hair Equipment with Ease
          </h1>
          <p class="text-lg text-gray-200 mb-6">
            From professional tools to everyday styling essentials — get what you need, when you need it.
          </p>
          <a href="auth/register.php" 
            class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg text-lg font-medium transition shadow-lg">
            Get Started
          </a>
        </div>
      </section>
      <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-6">
          <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
              Browse Our Equipment
            </h2>
            <p class="text-gray-500 mt-3">
              Choose from a wide range of professional hair tools available for rent
            </p>
          </div>
          <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
              <?php foreach ($equipment as $item): ?>

              <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                <img 
                  src="<?php echo "images/" . $item['image']; ?>" 
                  alt="<?php echo $item['name']; ?>" 
                  class="w-full h-48 object-cover"
                >
                <div class="p-4 flex flex-col flex-1">
                  <h3 class="font-semibold text-lg text-gray-800">
                    <?php echo $item['name']; ?>
                  </h3>
                  <p class="text-sm text-gray-500 mt-1">
                    High power, salon-quality results
                  </p>
                  <div class="mt-auto pt-4">
                    <a 
                      href="user/user_rental.php?item=<?php echo urlencode($item['name']); ?>" 
                      class="block w-full text-center bg-pink-500 hover:bg-pink-600 text-white py-2 rounded-lg transition"
                    >
                      Rent Item
                    </a>
                  </div>

                </div>
              </div>

              <?php endforeach; ?>
            </div>
        </div>
      </section>
    </main>
    <?php include_once 'include/footer.php'; ?>
  </div>
</body>
</html>