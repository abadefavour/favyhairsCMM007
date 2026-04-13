<header class="bg-gray-900 text-white shadow-md">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-16">
      <a href="admin_dashboard.php" class="text-xl font-semibold tracking-wide">
        Admin Panel
      </a>
      <nav class="hidden md:flex space-x-6 text-sm font-medium">
        <a href="admin_dashboard.php" class="hover:text-pink-400 transition">Dashboard</a>
        <a href="add_equipment.php" class="hover:text-pink-400 transition">Add Equipment</a>
        <a href="manage_equipment.php" class="hover:text-pink-400 transition">Manage Equipment</a>
        <a href="approve_rentals.php" class="hover:text-pink-400 transition">Approve Rentals</a>
        <a href="approve_returns.php" class="hover:text-pink-400 transition">Approve Returns</a>
        <a href="manage_users.php" class="hover:text-pink-400 transition">Manage Users</a>
      </nav>

      <form method="POST" action="../User/logout.php">
        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow">
          Logout
        </button>
      </form>

    </div>
  </div>
</header>