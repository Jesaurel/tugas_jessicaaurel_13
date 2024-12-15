<aside>
    <div class="sidebar">
        <ul>
            <?php if (getUserRole() == 'admin'): ?>
                <!-- Admin Sidebar Links -->
                <li><a href="<?php echo BASE_URL; ?>admin/dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/orders.php">Orders</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/menu.php">Manage Menu</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/users.php">Manage Users</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/reports.php">Reports</a></li>
            <?php else: ?>
                <!-- User Sidebar Links -->
                <li><a href="<?php echo BASE_URL; ?>profile.php">Profile</a></li>
                <li><a href="<?php echo BASE_URL; ?>order_history.php">Order History</a></li>
                <li><a href="<?php echo BASE_URL; ?>cart.php">Cart</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>