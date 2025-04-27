<?php
// Include the model
require_once '../models/Reservation.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['customer_name', 'contact_number', 'date_reserved', 'date_from', 'date_to', 'room_capacity', 'room_type', 'payment_type'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }

    // Check if check-in date is before check-out date
    if (!empty($_POST['date_from']) && !empty($_POST['date_to'])) {
        $date_from = new DateTime($_POST['date_from']);
        $date_to = new DateTime($_POST['date_to']);
        
        if ($date_from >= $date_to) {
            $errors[] = 'Check-out date must be after check-in date.';
        }
    }

    // If there are validation errors, redirect back with error messages
    if (!empty($errors)) {
        // In a real application, you would store errors in session and redirect back
        echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">';
        echo '<h3>Please correct the following errors:</h3>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '<p><a href="../views/reservation.html">Go back to reservation form</a></p>';
        echo '</div>';
        exit;
    }

    // Create a new reservation object
    $reservation = new Reservation($_POST);
    
    // Calculate the bill
    $billing = $reservation->calculateBill();

    // In a real application, you would save this to a database
    // For this front-end demo, we'll just display the confirmation

    // Display confirmation page with billing details
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Five Star Hotel - Reservation Confirmation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Raleway:wght@300;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../public/css/styles.css">
    </head>
    <body>
        <!-- Header -->
        <header class="header header-inner">
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="../index.html">
                        <h1>FIVE STAR HOTEL</h1>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../views/company_profile.html">Company Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../views/reservation.html">Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../views/contacts.html">Contacts</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="page-header">
                <div class="container">
                    <h2>Reservation Confirmation</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="../views/reservation.html">Reservation</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <section class="confirmation-section py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="confirmation-card">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h3 class="mb-0 text-center">RESERVATION: BILLING INFORMATION</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h4>Customer Information</h4>
                                                <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($_POST['customer_name']); ?></p>
                                                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($_POST['contact_number']); ?></p>
                                                <p><strong>Date Reserved:</strong> <?php echo htmlspecialchars($_POST['date_reserved']); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>Reservation Details</h4>
                                                <p><strong>Date of Reservation:</strong></p>
                                                <p>From: <?php echo htmlspecialchars($_POST['date_from']); ?></p>
                                                <p>To: <?php echo htmlspecialchars($_POST['date_to']); ?></p>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <p><strong>Room Type:</strong> <?php echo htmlspecialchars($_POST['room_type']); ?></p>
                                                <p><strong>Room Capacity:</strong> <?php echo htmlspecialchars($_POST['room_capacity']); ?></p>
                                                <p><strong>Payment Type:</strong> <?php echo htmlspecialchars($_POST['payment_type']); ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <h4>BILLING STATEMENTS:</h4>
                                                <p><strong>No. of Days:</strong> <?php echo $billing['num_days']; ?></p>
                                                <p><strong>Rate/Day:</strong> $<?php echo number_format($billing['rate'], 2); ?></p>
                                                <p><strong>Sub-Total:</strong> $<?php echo number_format($billing['subtotal'], 2); ?></p>
                                                <?php if ($billing['discount'] > 0): ?>
                                                <p><strong>Discount:</strong> $<?php echo number_format($billing['discount'], 2); ?></p>
                                                <?php endif; ?>
                                                <?php if ($billing['additional_charge'] > 0): ?>
                                                <p><strong>Additional Charge:</strong> $<?php echo number_format($billing['additional_charge'], 2); ?></p>
                                                <?php endif; ?>
                                                <p><strong>Total Bill:</strong> $<?php echo number_format($billing['total_bill'], 2); ?></p>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <a href="../index.html" class="btn btn-primary me-2">Home</a>
                                            <a href="../views/reservation.html" class="btn btn-outline-primary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h4>Five Star Hotel</h4>
                        <p>Your ultimate luxury destination where comfort meets elegance.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-tripadvisor"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h4>Contact Information</h4>
                        <address>
                            <p><i class="fas fa-map-marker-alt"></i> 123 Luxury Lane, Downtown</p>
                            <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                            <p><i class="fas fa-envelope"></i> info@fivestarshotel.com</p>
                        </address>
                    </div>
                    <div class="col-md-4">
                        <h4>Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="../index.html">Home</a></li>
                            <li><a href="../views/company_profile.html">Company Profile</a></li>
                            <li><a href="../views/reservation.html">Reservation</a></li>
                            <li><a href="../views/contacts.html">Contacts</a></li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="copyright">© 2025 Five Star Hotel. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
} else {
    // If not submitted via POST, redirect to the reservation page
    header('Location: ../views/reservation.html');
    exit;
}
?>