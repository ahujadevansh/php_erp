<!-- Sidebar -->
<!-- add toggled class to change default to minimized -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Easy ERP <sup></sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= $sidebarSection == 'dashboard' ? 'active' : ''; ?>">
  <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Modules
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'category' ? 'active' : ''; ?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
    <i class="fas fa-fw fa-cog"></i>
    <span>Category</span>
  </a>
  <div id="collapseCategory" class="collapse <?= $sidebarSection == 'category' ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage_category' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>manage-category.php">Manage Category</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add_category' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>add-category.php">Add Category</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'customer' ? 'active' : ''; ?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer" aria-expanded="true" aria-controls="collapseCustomer">
    <i class="fas fa-fw fa-cog"></i>
    <span>Customers</span>
  </a>
  <div id="collapseCustomer" class="collapse <?= $sidebarSection == 'customer' ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage_customer' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>manage-customer.php">Manage Customers</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add_customer' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>add-customer.php">Add Customer</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'employee' ? 'active' : ''; ?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployee" aria-expanded="true" aria-controls="collapseEmployee">
    <i class="fas fa-fw fa-cog"></i>
    <span>Employees</span>
  </a>
  <div id="collapseEmployee" class="collapse <?= $sidebarSection == 'employee' ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage_employee' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>manage-employee.php">Manage Employees</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add_employee' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>add-employee.php">Add Employee</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'product' ? 'active' : ''; ?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProduct">
    <i class="fas fa-fw fa-cog"></i>
    <span>Products</span>
  </a>
  <div id="collapseProduct" class="collapse <?= $sidebarSection == 'product' ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage_product' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>manage-product.php">Manage Products</a>
      <a class="collapse-item <?= $sidebarSubSection == 'check_current_inventory' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>check-current-inventory.php">Check Current Inventory</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add_product' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>add-product.php">Add Product</a>
    </div>
  </div>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?= $sidebarSection == 'supplier' ? 'active' : ''; ?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSupplier" aria-expanded="true" aria-controls="collapseSupplier">
    <i class="fas fa-fw fa-cog"></i>
    <span>Suppliers</span>
  </a>
  <div id="collapseSupplier" class="collapse <?= $sidebarSection == 'supplier' ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item <?= $sidebarSubSection == 'manage_supplier' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>manage-supplier.php">Manage Suppliers</a>
      <a class="collapse-item <?= $sidebarSubSection == 'add_supplier' ? 'active' : ''; ?>" href="<?= BASEPAGES; ?>add-supplier.php">Add Supplier</a>
    </div>
  </div>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Addons
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
    <i class="fas fa-fw fa-folder"></i>
    <span>Pages</span>
  </a>
  <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Login Screens:</h6>
      <a class="collapse-item" href="login.html">Login</a>
      <a class="collapse-item" href="register.html">Register</a>
      <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
      <div class="collapse-divider"></div>
      <h6 class="collapse-header">Other Pages:</h6>
      <a class="collapse-item" href="404.html">404 Page</a>
      <a class="collapse-item" href="blank.html">Blank Page</a>
    </div>
  </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->
