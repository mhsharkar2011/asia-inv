 <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
     <div class="position-sticky pt-3">
         <ul class="nav flex-column">
             <li class="nav-item">
                 <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                     <i class="bi bi-speedometer2 me-2"></i>Dashboard
                 </a>
             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}" href="#inventorySubmenu"
                     data-bs-toggle="collapse">
                     <i class="bi bi-boxes me-2"></i>Inventory
                 </a>
                 <ul class="nav flex-column collapse" id="inventorySubmenu">
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('inventory.products.index') }}">
                             <i class="bi bi-box me-2"></i>Products
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('inventory.categories.index') }}">
                             <i class="bi bi-tags me-2"></i>Categories
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('inventory.stock.index') }}">
                             <i class="bi bi-clipboard-data me-2"></i>Stock View
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->is('purchase*') ? 'active' : '' }}" href="#purchaseSubmenu"
                     data-bs-toggle="collapse">
                     <i class="bi bi-cart-plus me-2"></i>Purchase
                 </a>
                 <ul class="nav flex-column collapse" id="purchaseSubmenu">
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('purchase.suppliers.index') }}">
                             <i class="bi bi-people me-2"></i>Suppliers
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('purchase.purchase-orders.index') }}">
                             <i class="bi bi-file-text me-2"></i>Purchase Orders
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item">
                 <a class="nav-link {{ request()->is('sales*') ? 'active' : '' }}" href="#salesSubmenu"
                     data-bs-toggle="collapse">
                     <i class="bi bi-cart-check me-2"></i>Sales
                 </a>
                 <ul class="nav flex-column collapse" id="salesSubmenu">
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('sales.customers.index') }}">
                             <i class="bi bi-people me-2"></i>Customers
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('sales.sales-orders.index') }}">
                             <i class="bi bi-receipt me-2"></i>Sales Orders
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link ms-4" href="{{ route('sales.invoices.index') }}">
                             <i class="bi bi-receipt me-2"></i>Sales Invoices
                         </a>
                     </li>
                 </ul>
             </li>

             @if (Auth::user()->role === 'admin')
                 <li class="nav-item">
                     <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="#adminSubmenu"
                         data-bs-toggle="collapse">
                         <i class="bi bi-gear me-2"></i>Administration
                     </a>
                     <ul class="nav flex-column collapse" id="adminSubmenu">
                         <li class="nav-item">
                             <a class="nav-link ms-4" href="{{ route('admin.users.index') }}">
                                 <i class="bi bi-person-badge me-2"></i>Users
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link ms-4" href="{{ route('admin.companies.index') }}">
                                 <i class="bi bi-building me-2"></i>Companies
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link ms-4" href="{{ route('admin.branches.index') }}">
                                 <i class="bi bi-building me-2"></i>Branches
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link ms-4" href="{{ route('admin.departments.index') }}">
                                 <i class="bi bi-building me-2"></i>Departments
                             </a>
                         </li>
                     </ul>
                 </li>
             @endif
         </ul>
     </div>
 </nav>
