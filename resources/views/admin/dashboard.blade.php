<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <a href="{{ route('admin.reviews') }}" class="text-gray-600 hover:text-gray-900">⭐ Reviews</a>
        </div>
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

        <!-- Incoming Orders (real-time) -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Incoming Orders <span class="badge bg-success ms-2" id="liveBadge">Live</span></h5>
                <small class="opacity-75">Refreshes every 5 sec</small>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Address / Phone</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="recentOrders">
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
        const receiptBaseUrl = '{{ route("orders.receipt", ["order" => "__ID__"]) }}';
        $(document).ready(function() {
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

            function loadOrders() {
                $.ajax({
                    url: '{{ route("orders.index") }}',
                    method: 'GET',
                    success: function(orders) {
                        const ordersBody = $('#recentOrders');
                        ordersBody.empty();
                        if (orders && orders.length > 0) {
                            const statusBadge = (s) => {
                                const cls = s === 'pending' ? 'bg-warning text-dark' : s === 'rejected' ? 'bg-danger' : s === 'delivered' ? 'bg-success' : 'bg-info';
                                return `<span class="badge ${cls}">${(s || 'pending').replace(/_/g, ' ')}</span>`;
                            };
                            orders.forEach(order => {
                                const items = JSON.parse(order.items || '[]');
                                const itemsList = items.map(item =>
                                    `${item.name} (${item.quantity})${item.remark ? ' — ' + item.remark : ''}`
                                ).join(', ');
                                const addr = (order.delivery_address || '—').substring(0, 25) + (order.delivery_address && order.delivery_address.length > 25 ? '…' : '');
                                const phone = order.phone || '—';
                                const isPending = (order.status || 'pending') === 'pending';
                                const statuses = ['accepted', 'preparing', 'out_for_delivery', 'delivered'];
                                const acceptReject = isPending
                                    ? `<button class="btn btn-success btn-sm accept-order" data-id="${order.id}">Accept</button>
                                       <button class="btn btn-outline-danger btn-sm reject-order" data-id="${order.id}">Reject</button>`
                                    : '';
                                const statusSelect = !isPending && order.status !== 'rejected' && order.status !== 'cancelled'
                                    ? `<select class="form-select form-select-sm order-status" data-id="${order.id}" style="width:auto;">
                                        ${['accepted','preparing','out_for_delivery','delivered'].map(s => `<option value="${s}" ${(order.status || '') === s ? 'selected' : ''}>${s.replace(/_/g,' ')}</option>`).join('')}
                                       </select>`
                                    : '';
                                const printBtn = `<a href="${receiptBaseUrl.replace('__ID__', order.id)}" target="_blank" class="btn btn-outline-secondary btn-sm">Print</a>`;
                                ordersBody.append(`
                                    <tr>
                                        <td>${order.id}</td>
                                        <td>${order.customer_name}</td>
                                        <td><small>${addr}<br>${phone}</small></td>
                                        <td><small>${itemsList}</small></td>
                                        <td>RM ${parseFloat(order.total_amount).toFixed(2)}</td>
                                        <td>${statusBadge(order.status)}</td>
                                        <td>
                                            ${acceptReject}
                                            ${statusSelect}
                                            ${printBtn}
                                            <button class="btn btn-danger btn-sm delete-order" data-id="${order.id}">Delete</button>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            ordersBody.append(`<tr><td colspan="7" class="text-center">No orders yet</td></tr>`);
                        }
                    }
                });
            }

            $(document).on('click', '.accept-order', function() {
                const id = $(this).data('id');
                $.ajax({ url: `/orders/${id}/accept`, method: 'PUT', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, success: function() { loadOrders(); } });
            });
            $(document).on('click', '.reject-order', function() {
                const id = $(this).data('id');
                if (!confirm('Reject this order?')) return;
                $.ajax({ url: `/orders/${id}/reject`, method: 'PUT', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, success: function() { loadOrders(); } });
            });
            $(document).on('change', '.order-status', function() {
                const id = $(this).data('id');
                const status = $(this).val();
                $.ajax({ url: `/orders/${id}/status`, method: 'PUT', data: { status: status, _token: '{{ csrf_token() }}' }, headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, success: function() { loadOrders(); } });
            });

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

            loadOrders();
            setInterval(loadOrders, 5000);
        });
    </script>
</x-app-layout>
