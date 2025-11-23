<!-- sidebar.php -->
<div class="sidebar">
  <h2>Dashboard</h2>
  <ul class="menu">

    <li class="menu-item">
      <button class="dropdown-btn">Inventory ▾</button>
      <div class="dropdown-container">
        <a href="inventory.php">List View</a>
        <a href="add_item.php">Add Item</a>
      </div>
    </li>

    <li class="menu-item">
      <button class="dropdown-btn">Retailer ▾</button>
      <div class="dropdown-container">
        <a href="retailers.php">List View</a>
        <a href="add_retailer.php">Add Retailer</a>
      </div>
    </li>

    <li class="menu-item">
      <button class="dropdown-btn">Orders ▾</button>
      <div class="dropdown-container">
        <a href="orders_list.php">List View</a>
        <a href="order.php">Place Order</a>
      </div>
    </li>

    <li class="menu-item">
      <a href="manufacturer.php">Manufacturer</a>
    </li>

    <li class="menu-item logout-link">
      <a href="logout.php">Logout</a>
    </li>
  </ul>
</div>

<script>
  // Toggle dropdowns
  document.querySelectorAll(".dropdown-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      btn.classList.toggle("active");
      const container = btn.nextElementSibling;
      const isOpen = container.style.display === "block";
      container.style.display = isOpen ? "none" : "block";
      btn.textContent = btn.textContent.replace(isOpen ? "▴" : "▾", isOpen ? "▾" : "▴");
    });
  });

  // Highlight current link
  const current = location.pathname.split("/").pop();
  document.querySelectorAll(".dropdown-container a, .menu-item > a").forEach(link => {
    if (link.getAttribute("href") === current) {
      link.classList.add("active");
      const container = link.closest(".dropdown-container");
      if (container) {
        container.style.display = "block";
        const btn = container.previousElementSibling;
        btn.classList.add("active");
        btn.textContent = btn.textContent.replace("▾", "▴");
      }
    }
  });
  
</script>
