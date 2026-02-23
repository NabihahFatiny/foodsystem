<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Dashboard') }}
            </h2>
            @if(session('message'))
                <div class="text-green-600">
                    {{ session('message') }}
                </div>
            @endif
            <div>
                <a href="{{ route('contact.show') }}" class="text-gray-600 hover:text-gray-900 text-decoration-none">
                    📱 Contact Support
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        <!-- Menu Categories -->
        <div class="row">
            <!-- Fast Food Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/fast-foods.jpg') }}" class="card-img-top" alt="Fast Foods"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Fast Foods</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group food-items" data-category="fast_food">
                            <!-- Items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desserts Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/desserts.jpg') }}" class="card-img-top" alt="Desserts"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Desserts</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group food-items" data-category="dessert">
                            <!-- Items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drinks Section -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/drinks.jpg') }}" class="card-img-top" alt="Drinks"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Drinks</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group food-items" data-category="drink">
                            <!-- Items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shopping Cart -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Your Cart</h5>
                <span class="badge bg-primary">Total: RM 0.00</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                            <!-- Cart items will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" id="checkoutBtn">Proceed to Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Cart Functionality -->
    <script>
        $(document).ready(function() {
            let cart = [];
            let total = 0;

            // Load food items
            function loadFoodItems() {
                $.get('{{ route('admin.food.index') }}', function(foods) {
                    $('.food-items').each(function() {
                        const category = $(this).data('category');
                        const container = $(this);
                        container.empty();

                        const categoryFoods = foods.filter(food => food.category === category);

                        categoryFoods.forEach(food => {
                            container.append(`
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">${food.name}</h6>
                                            <p class="mb-0 text-muted">RM ${parseFloat(food.price).toFixed(2)}</p>
                                            <small class="text-muted">${food.description}</small>
                                        </div>
                                        <button class="btn btn-sm btn-primary add-to-cart"
                                                data-id="${food.id}"
                                                data-name="${food.name}"
                                                data-price="${food.price}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            `);
                        });
                    });
                });
            }

            // Add to Cart button click handler
            $(document).on('click', '.add-to-cart', function() {
                const button = $(this);
                const name = button.data('name');
                const price = parseFloat(button.data('price'));

                // Check if item already exists in cart
                const existingItem = cart.find(item => item.name === name);

                if (existingItem) {
                    existingItem.quantity += 1;
                    existingItem.subtotal = existingItem.quantity * existingItem.price;
                } else {
                    cart.push({
                        name: name,
                        price: price,
                        quantity: 1,
                        subtotal: price
                    });
                }

                updateCartDisplay();
            });

            // Function to update cart display
            function updateCartDisplay() {
                const cartBody = $('#cartItems');
                cartBody.empty();
                total = 0;

                cart.forEach((item, index) => {
                    total += item.subtotal;
                    cartBody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td>RM ${item.price.toFixed(2)}</td>
                            <td>
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <button class="btn btn-outline-secondary decrease-qty" data-index="${index}">-</button>
                                    <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                                    <button class="btn btn-outline-secondary increase-qty" data-index="${index}">+</button>
                                </div>
                            </td>
                            <td>RM ${item.subtotal.toFixed(2)}</td>
                            <td>
                                <button class="btn btn-sm btn-danger remove-item" data-index="${index}">Remove</button>
                            </td>
                        </tr>
                    `);
                });

                // Update total display
                $('.badge.bg-primary').text(`Total: RM ${total.toFixed(2)}`);

                // Show/hide checkout button based on cart items
                if (cart.length > 0) {
                    $('#checkoutBtn').show();
                } else {
                    $('#checkoutBtn').hide();
                }
            }

            // Quantity increase button handler
            $(document).on('click', '.increase-qty', function() {
                const index = $(this).data('index');
                cart[index].quantity += 1;
                cart[index].subtotal = cart[index].quantity * cart[index].price;
                updateCartDisplay();
            });

            // Quantity decrease button handler
            $(document).on('click', '.decrease-qty', function() {
                const index = $(this).data('index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity -= 1;
                    cart[index].subtotal = cart[index].quantity * cart[index].price;
                    updateCartDisplay();
                }
            });

            // Remove item button handler
            $(document).on('click', '.remove-item', function() {
                const index = $(this).data('index');
                cart.splice(index, 1);
                updateCartDisplay();
            });

            // Checkout button click handler
            $('#checkoutBtn').click(function() {
                if (cart.length > 0) {
                    $.ajax({
                        url: '{{ route('orders.store') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            customer_name: '{{ Auth::user()->name }}',
                            items: JSON.stringify(cart),
                            total_amount: total
                        },
                        success: function(response) {
                            if (response.success) {
                                cart = [];
                                updateCartDisplay();
                            }
                        },
                        error: function() {
                            alert('Error placing order. Please try again.');
                        }
                    });
                }
            });

            // Initially hide checkout button
            $('#checkoutBtn').hide();

            // Load items when page loads
            loadFoodItems();
        });
    </script>
</x-app-layout>
