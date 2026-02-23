<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        <!-- Food Categories -->
        <div class="row">
            <!-- Fast Food Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/fast-foods.jpg') }}" class="card-img-top" alt="Fast Foods"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Fast Foods</h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addFastFoodModal">Add Item</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="fastFoodList">
                            <!-- Items will be added here dynamically -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Desserts Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/desserts.jpg') }}" class="card-img-top" alt="Desserts"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Desserts</h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addDessertModal">Add Item</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="dessertList">
                            <!-- Items will be added here dynamically -->
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Drinks Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/drinks.jpg') }}" class="card-img-top" alt="Drinks"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Drinks</h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addDrinkModal">Add
                            Item</button>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="drinkList">
                            <!-- Items will be added here dynamically -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="recentOrders">
                            <!-- Orders will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Fast Food Modal -->
    <div class="modal fade" id="addFastFoodModal" tabindex="-1" aria-labelledby="addFastFoodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addFastFoodModalLabel">Add Fast Food Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addFastFoodForm" action="{{ route('admin.food.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category" value="fast_food">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Food Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.10"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Dessert Modal -->
    <div class="modal fade" id="addDessertModal" tabindex="-1" aria-labelledby="addDessertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addDessertModalLabel">Add Dessert Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDessertForm" action="{{ route('admin.food.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category" value="dessert">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="dessert_name" class="form-label">Dessert Name</label>
                            <input type="text" class="form-control" id="dessert_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="dessert_price" class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" id="dessert_price" name="price"
                                step="0.10" required>
                        </div>
                        <div class="mb-3">
                            <label for="dessert_description" class="form-label">Description</label>
                            <textarea class="form-control" id="dessert_description" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Drink Modal -->
    <div class="modal fade" id="addDrinkModal" tabindex="-1" aria-labelledby="addDrinkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="addDrinkModalLabel">Add Drink Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDrinkForm" action="{{ route('admin.food.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category" value="drink">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="drink_name" class="form-label">Drink Name</label>
                            <input type="text" class="form-control" id="drink_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="drink_price" class="form-label">Price (RM)</label>
                            <input type="number" class="form-control" id="drink_price" name="price"
                                step="0.10" required>
                        </div>
                        <div class="mb-3">
                            <label for="drink_description" class="form-label">Description</label>
                            <textarea class="form-control" id="drink_description" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Replace the entire script section with this: -->
    <script>
        $(document).ready(function() {
            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load existing items
            loadFoodItems();

            function loadFoodItems() {
                $.get('{{ route("admin.food.index") }}', function(foods) {
                    // Clear existing items
                    $('#fastFoodList, #dessertList, #drinkList').empty();

                    // Add items to appropriate lists
                    foods.forEach(function(food) {
                        const list = food.category === 'fast_food' ? '#fastFoodList' :
                                   food.category === 'dessert' ? '#dessertList' : '#drinkList';
                        $(list).append(createListItem(food));
                    });
                });
            }

            function createListItem(food) {
                return `
                    <li class="list-group-item" data-id="${food.id}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${food.name}</h6>
                                <p class="mb-0 text-muted">RM ${parseFloat(food.price).toFixed(2)}</p>
                                <small class="text-muted">${food.description}</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary edit-btn">Edit</button>
                                <button class="btn btn-sm btn-outline-danger delete-btn">Delete</button>
                            </div>
                        </div>
                    </li>
                `;
            }

            // Form submit handlers
            $('#addFastFoodForm, #addDessertForm, #addDrinkForm').submit(function(e) {
                e.preventDefault();
                const form = $(this);
                const modal = form.closest('.modal');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            modal.modal('hide');
                            form[0].reset();
                            loadFoodItems();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error adding item. Please try again.');
                    }
                });
            });

            // Delete button handler
            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are you sure you want to delete this item?')) {
                    const item = $(this).closest('.list-group-item');
                    const id = item.data('id');

                    $.ajax({
                        url: `/admin/food/${id}`,
                        method: 'DELETE',
                        success: function() {
                            loadFoodItems(); // Reload all items
                        },
                        error: function() {
                            alert('Error deleting item. Please try again.');
                        }
                    });
                }
            });

            // Edit button handler
            $(document).on('click', '.edit-btn', function() {
                const item = $(this).closest('.list-group-item');
                const id = item.data('id');
                const name = item.find('h6').text();
                const price = item.find('p').text().replace('RM ', '');
                const description = item.find('small').text();

                item.html(`
                    <div class="edit-form p-2">
                        <input type="text" class="form-control mb-2 edit-name" value="${name}">
                        <input type="number" class="form-control mb-2 edit-price" value="${price}" step="0.10">
                        <input type="text" class="form-control mb-2 edit-description" value="${description}">
                        <div>
                            <button class="btn btn-sm btn-success save-btn" data-id="${id}">Save</button>
                            <button class="btn btn-sm btn-secondary cancel-btn">Cancel</button>
                        </div>
                    </div>
                `);
            });

            // Save button handler
            $(document).on('click', '.save-btn', function() {
                const item = $(this).closest('.list-group-item');
                const id = $(this).data('id');
                const data = {
                    name: item.find('.edit-name').val(),
                    price: item.find('.edit-price').val(),
                    description: item.find('.edit-description').val()
                };

                $.ajax({
                    url: `/admin/food/${id}`,
                    method: 'PUT',
                    data: data,
                    success: function() {
                        loadFoodItems(); // Reload all items
                    },
                    error: function() {
                        alert('Error updating item. Please try again.');
                    }
                });
            });

            // Cancel button handler
            $(document).on('click', '.cancel-btn', function() {
                loadFoodItems(); // Reload all items
            });

            // Function to load orders
            function loadOrders() {
                $.ajax({
                    url: '{{ route("orders.index") }}',
                    method: 'GET',
                    success: function(orders) {
                        const ordersBody = $('#recentOrders');
                        ordersBody.empty();

                        if (orders && orders.length > 0) {
                            orders.forEach(order => {
                                const items = JSON.parse(order.items);
                                const itemsList = items.map(item =>
                                    `${item.name} (${item.quantity})`
                                ).join(', ');

                                ordersBody.append(`
                                    <tr>
                                        <td>${order.id}</td>
                                        <td>${order.customer_name}</td>
                                        <td>${itemsList}</td>
                                        <td>RM ${parseFloat(order.total_amount).toFixed(2)}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm delete-order" data-id="${order.id}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            ordersBody.append(`
                                <tr>
                                    <td colspan="5" class="text-center">No orders found</td>
                                </tr>
                            `);
                        }
                    }
                });
            }

            // Add delete order handler
            $(document).on('click', '.delete-order', function() {
                if (confirm('Are you sure you want to delete this order?')) {
                    const orderId = $(this).data('id');

                    $.ajax({
                        url: `/orders/${orderId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                loadOrders(); // Refresh the orders list
                            } else {
                                alert('Error deleting order');
                            }
                        },
                        error: function() {
                            alert('Error deleting order');
                        }
                    });
                }
            });

            // Initial load and refresh
            loadOrders();
            setInterval(loadOrders, 30000);
        });
    </script>
</x-app-layout>
