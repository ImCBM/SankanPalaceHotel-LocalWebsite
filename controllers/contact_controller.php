<?php
// Include the model
require_once '../models/Contact.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['name', 'email', 'subject', 'message'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . ' is required.';
        }
    }

    // Validate email format
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
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
        echo '<p><a href="../views/contacts.html">Go back to contact form</a></p>';
        echo '</div>';
        exit;
    }

    // Create a new contact object
    $contact = new Contact($_POST);
    
    // In a real application, you would save this to a database
    // For this front-end demo, we'll just display the confirmation

    // Display confirmation page
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Five Star Hotel - Message Sent</title>
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
                                <a class="nav-link" href="../views/reservation.html">Reservation</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="../views/contacts.html">Contacts</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <div class="page-header">
                <div class="container">
                    <h2>Message Sent</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="../views/contacts.html">Contacts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Message Sent</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <section class="thank-you-section py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body text-center p-5">
                                    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                                    <h2>Thank You for Contacting Us!</h2>
                                    <p class="lead mb-4">Your message has been received. We appreciate your interest in Five Star Hotel and will get back to you shortly.</p>
                                    <div class="message-details mb-4 text-start">
                                        <h4>Message Details:</h4>
                                        <p><strong>Name:</strong> <?php echo htmlspecialchars($_POST['name']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_POST['email']); ?></p>
                                        <?php if (!empty($_POST['phone'])): ?>
                                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($_POST['phone']); ?></p>
                                        <?php endif; ?>
                                        <p><strong>Subject:</strong> <?php echo htmlspecialchars($_POST['subject']); ?></p>
                                        <p><strong>Date Submitted:</strong> <?php echo date('F j, Y, g:i a'); ?></p>
                                    </div>
                                    <div class="text-center">
                                        <a href="../index.html" class="btn btn-primary me-2">Return to Home</a>
                                        <a href="../views/contacts.html" class="btn btn-outline-primary">Back to Contact</a>
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
    // If not submitted via POST, redirect to the contacts page
    header('Location: ../views/contacts.html');
    exit;
}
?>