<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">

          <?php 


            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);

          ?>


          <li class="nav-item">
            <a class="nav-link <?php echo ($page == '' || $page == 'index.php') ? 'active' : ''; ?>" href="index.php">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customer_orders.php') ? 'active' : ''; ?>" href="customer_orders.php">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'products.php') ? 'active' : ''; ?>" href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'brands.php') ? 'active' : ''; ?>" href="brands.php">
              <span data-feather="shopping-cart"></span>
              Main Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
              <span data-feather="shopping-cart"></span>
              Categories
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customers.php') ? 'active' : ''; ?>" href="customers.php">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'time_slot.php') ? 'active' : ''; ?>" href="time_slot.php">
              <span data-feather="users"></span>
              Time Slot
            </a>
          </li>
		  <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'delivery_charge.php') ? 'active' : ''; ?>" href="delivery_charge.php">
              <span data-feather="users"></span>
              Town & Delivery Charge
            </a>
          </li>

      <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'additional_item.php') ? 'active' : ''; ?>" href="additional_item.php">
              <span data-feather="users"></span>
              Additional Items
            </a>
     </li>

     <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'assign_subcat.php') ? 'active' : ''; ?>" href="assign_subcat.php">
              <span data-feather="users"></span>
              Assign Sub Category
            </a>
     </li>

     <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'add_mail.php') ? 'active' : ''; ?>" href="add_mail.php">
              <span data-feather="users"></span>
              Assign E-mail
            </a>
     </li>

     <li class="nav-item">
          <a class="nav-link <?php echo ($page == 'add_coupon.php') ? 'active' : ''; ?>" href="add_coupon.php">
              <span data-feather="users"></span>
              Add Coupon
            </a>
     </li>

   </ul>

       
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hello <?php if(isset($_SESSION["admin_name"])) {echo $_SESSION["admin_name"];} ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>