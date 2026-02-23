<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-5">
        <div class="row justify-content-center">
            <!-- Contact Information Card -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-3 bg-light">
                    <div class="card-body p-4">
                        <h4 class="text-primary mb-4 border-bottom pb-2">Contact Information</h4>

                        <div class="mb-4">
                            <h5 class="text-dark fw-bold mb-3">Quick Contact</h5>
                            <div class="ps-3">
                                <p class="mb-2">+60195968186</p>
                                <p class="mb-2">foodieExpress@gmail.com</p>
                                <p class="mb-0">10:00 AM - 10:00 PM</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-dark fw-bold mb-3">Delivery Information</h5>
                            <div class="ps-3">
                                <p class="mb-2">Area: Bandar Baru Bangi</p>
                                <p class="mb-2">Estimated Time: 30-45 minutes</p>
                                <p class="mb-0">Minimum Order: RM 10</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="text-dark fw-bold mb-3">Location</h5>
                            <div class="ps-3">
                                <p>123 Bandar Baru Bangi, Selangor, Malaysia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-primary text-white py-3 rounded-top">
                        <h4 class="mb-0">Send Us a Message</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name" required>
                                        <label for="full_name">Full Name *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                        <label for="email">Email Address *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                                        <label for="phone">Phone Number *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Order ID">
                                        <label for="order_id">Order ID (if applicable)</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                        <label for="subject">Subject *</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="message" name="message" placeholder="Message" style="height: 150px" required></textarea>
                                        <label for="message">Message *</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <small class="text-muted">* Required fields</small>
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</x-app-layout>
