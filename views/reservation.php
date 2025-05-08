<?php
require_once '../controllers/RoomController.php';
require_once '../controllers/ReservationController.php';

$roomController = new RoomController();
$reservationController = new ReservationController();

// Get all room capacities
$roomCapacities = $roomController->getAllRoomCapacities();

// Get all room types
$roomTypes = $roomController->getAllRoomTypes();

// Get all payment types
$paymentTypes = $reservationController->getAllPaymentTypes();

// Get room rates
$roomRates = $roomController->getRoomRates();

// Initialize variables for reservation process
$reservationSuccess = false;
$reservationData = null;
$errorMessage = '';

// Process reservation form if submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reservation'])) {
    $reservationResult = $reservationController->createReservation($_POST);
    
    if ($reservationResult['status'] === 'success') {
        $reservationSuccess = true;
        $reservationData = $reservationResult;
    } else {
        $errorMessage = $reservationResult['message'];
    }
}

include 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <h1>Reservation</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservation</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Reservation Section -->
<section class="reservation-section py-5">
    <div class="container">
        <?php if ($reservationSuccess): ?>
            <!-- Reservation Success -->
            <div class="reservation-success bg-light p-4 rounded shadow">
                <div class="text-center mb-4">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h2>Reservation Confirmed!</h2>
                    <p>Your booking has been successfully processed. Please check the details below.</p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <h4>Reservation Details</h4>
                        <ul class="list-unstyled">
                            <li><strong>Confirmation Number:</strong> <?php echo $reservationData['reservation_id']; ?></li>
                            <li><strong>Guest Name:</strong> <?php echo $reservationData['customer_name']; ?></li>
                            <li><strong>Room Number:</strong> <?php echo $reservationData['room_number']; ?></li>
                            <li><strong>Room Type:</strong> <?php echo $reservationData['room_type']; ?></li>
                            <li><strong>Capacity:</strong> <?php echo $reservationData['capacity']; ?></li>
                            <li><strong>Check-in Date:</strong> <?php echo date('F d, Y', strtotime($reservationData['date_from'])); ?></li>
                            <li><strong>Check-out Date:</strong> <?php echo date('F d, Y', strtotime($reservationData['date_to'])); ?></li>
                            <li><strong>Number of Nights:</strong> <?php echo $reservationData['num_days']; ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Payment Summary</h4>
                        <ul class="list-unstyled">
                            <li><strong>Payment Method:</strong> <?php echo $reservationData['payment_type']; ?></li>
                            <li><strong>Subtotal:</strong> $<?php echo number_format($reservationData['subtotal'], 2); ?></li>
                            <li><strong>Discount:</strong> $<?php echo number_format($reservationData['discount'], 2); ?></li>
                            <li><strong>Additional Charge:</strong> $<?php echo number_format($reservationData['additional_charge'], 2); ?></li>
                            <li><strong>Total Amount:</strong> $<?php echo number_format($reservationData['total_bill'], 2); ?></li>
                        </ul>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="mb-4">A confirmation email has been sent to your email address. If you have any questions, please contact our customer service.</p>
                    <a href="home.php" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Room Rates Information -->
            <div class="room-rates-info mb-5">
                <h2 class="section-title text-center mb-4">Room Rates & Policies</h2>
                
                <div class="room-rates-table">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title mb-0">Room Rates (per night)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Room Capacity</th>
                                                    <th>Room Type</th>
                                                    <th>Rate/day</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($roomRates as $rate): ?>
                                                <tr>
                                                    <td><?php echo $rate['capacity_name']; ?></td>
                                                    <td><?php echo $rate['room_type']; ?></td>
                                                    <td>$<?php echo number_format($rate['rate_per_day'], 2); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title mb-0">Payment & Discount Policies</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Type of Payment</th>
                                                    <th>Additional Charge</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Cash</td>
                                                    <td>No additional charge</td>
                                                </tr>
                                                <tr>
                                                    <td>Check</td>
                                                    <td>+ 5%</td>
                                                </tr>
                                                <tr>
                                                    <td>Credit Card</td>
                                                    <td>+ 10%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th colspan="2">For Cash Payment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>3-5 days</td>
                                                    <td>10% discount</td>
                                                </tr>
                                                <tr>
                                                    <td>6 days and above</td>
                                                    <td>15% discount</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Reservation Form -->
            <div class="reservation-form-container">
                <h2 class="section-title text-center mb-4">Make a Reservation</h2>
                
                <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $errorMessage; ?>
                </div>
                <?php endif; ?>
                
                <form id="reservationForm" method="post" action="reservation.php" class="needs-validation" novalidate>
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Guest Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback">Please enter your full name.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Reservation Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_from" class="form-label">Check-in Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date_from" name="date_from" min="<?php echo date('Y-m-d'); ?>" required>
                                    <div class="invalid-feedback">Please select a check-in date.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_to" class="form-label">Check-out Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date_to" name="date_to" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                                    <div class="invalid-feedback">Please select a check-out date.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="room_capacity" class="form-label">Room Capacity <span class="text-danger">*</span></label>
                                    <select class="form-select" id="room_capacity" name="room_capacity" required>
                                        <option value="">Select Room Capacity</option>
                                        <?php foreach ($roomCapacities as $capacity): ?>
                                        <option value="<?php echo $capacity['room_capacity_id']; ?>"><?php echo $capacity['capacity_name']; ?> (Max <?php echo $capacity['max_guests']; ?> guests)</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a room capacity.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="room_type" class="form-label">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="room_type" name="room_type" required>
                                        <option value="">Select Room Type</option>
                                        <?php foreach ($roomTypes as $type): ?>
                                        <option value="<?php echo $type['room_type_id']; ?>"><?php echo $type['room_type']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a room type.</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="payment_type" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select" id="payment_type" name="payment_type" required>
                                        <option value="">Select Payment Method</option>
                                        <?php foreach ($paymentTypes as $type): ?>
                                        <option value="<?php echo $type['payment_type_id']; ?>"><?php echo $type['payment_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">Please select a payment method.</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="special_requests" class="form-label">Special Requests</label>
                                <textarea class="form-control" id="special_requests" name="special_requests" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Payment Calculation</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <p>Based on your selections, the estimated price will be calculated when all required fields are filled.</p>
                                <p>Additional charges may apply based on your payment method. Cash payments are eligible for discounts on stays of 3 days or more.</p>
                            </div>
                            <div id="price-estimate" class="d-none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Room Rate per Night:</strong> $<span id="room-rate">0.00</span></p>
                                        <p><strong>Number of Nights:</strong> <span id="num-nights">0</span></p>
                                        <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Additional Charge:</strong> $<span id="additional-charge">0.00</span></p>
                                        <p><strong>Discount:</strong> $<span id="discount">0.00</span></p>
                                        <p><strong>Total Amount:</strong> $<span id="total-amount">0.00</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                        </label>
                        <div class="invalid-feedback">
                            You must agree to the terms and conditions.
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" name="submit_reservation" class="btn btn-primary btn-lg">Complete Reservation</button>
                    </div>
                </form>
            </div>
            
            <!-- Terms and Conditions Modal -->
            <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Reservation Policy</h6>
                            <p>All reservations must be guaranteed with a valid credit card or payment method at the time of booking. The hotel reserves the right to pre-authorize credit cards prior to arrival.</p>
                            
                            <h6>Check-In / Check-Out</h6>
                            <p>Check-in time is from 3:00 PM, and check-out time is until 12:00 PM. Early check-in or late check-out may be available for an additional fee, subject to availability.</p>
                            
                            <h6>Cancellation Policy</h6>
                            <p>Cancellations must be made at least 48 hours prior to the scheduled arrival date to avoid a cancellation fee. Cancellations made less than 48 hours before arrival will be charged the full amount of the first night's stay.</p>
                            
                            <h6>Payment Policy</h6>
                            <p>The full payment for your stay will be processed at check-in. Additional charges such as room service, mini-bar, and other services will be charged at check-out.</p>
                            
                            <h6>Damage Policy</h6>
                            <p>Guests will be held responsible for any damage caused to hotel property during their stay and will be charged accordingly.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
// Array to store room rates
const roomRates = <?php echo json_encode($roomRates); ?>;

// Array to store payment types
const paymentTypes = <?php echo json_encode($paymentTypes); ?>;

// Function to calculate total bill
function calculateBill() {
    const roomCapacity = document.getElementById('room_capacity').value;
    const roomType = document.getElementById('room_type').value;
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = document.getElementById('date_to').value;
    const paymentType = document.getElementById('payment_type').value;
    
    // Check if all required fields are filled
    if (!roomCapacity || !roomType || !dateFrom || !dateTo || !paymentType) {
        document.getElementById('price-estimate').classList.add('d-none');
        return;
    }
    
    // Find the room rate
    let rate = 0;
    for (const room of roomRates) {
        const capacityName = document.getElementById('room_capacity').options[document.getElementById('room_capacity').selectedIndex].text.split(' ')[0];
        const typeName = document.getElementById('room_type').options[document.getElementById('room_type').selectedIndex].text;
        
        if (room.capacity_name === capacityName && room.room_type === typeName) {
            rate = parseFloat(room.rate_per_day);
            break;
        }
    }
    
    // Calculate number of nights
    const start = new Date(dateFrom);
    const end = new Date(dateTo);
    const numNights = Math.round((end - start) / (1000 * 60 * 60 * 24));
    
    // Calculate subtotal
    const subtotal = rate * numNights;
    
    // Find payment type details
    let additionalChargePercentage = 0;
    let paymentName = '';
    for (const type of paymentTypes) {
        if (String(type.payment_type_id) === String(paymentType)) {
            additionalChargePercentage = parseFloat(type.additional_charge_percentage);
            paymentName = type.payment_name;
            break;
        }
    }
    
    // Calculate additional charge
    const additionalCharge = (subtotal * additionalChargePercentage) / 100;
    
    // Calculate discount (only for cash payment)
    let discount = 0;
    if (paymentName === 'Cash') {
        if (numNights >= 3 && numNights <= 5) {
            discount = (subtotal * 10) / 100; // 10% discount
        } else if (numNights >= 6) {
            discount = (subtotal * 15) / 100; // 15% discount
        }
    }
    
    // Calculate total amount
    const totalAmount = subtotal + additionalCharge - discount;
    
    // Update the price estimate section
    document.getElementById('room-rate').textContent = rate.toFixed(2);
    document.getElementById('num-nights').textContent = numNights;
    document.getElementById('subtotal').textContent = subtotal.toFixed(2);
    document.getElementById('additional-charge').textContent = additionalCharge.toFixed(2);
    document.getElementById('discount').textContent = discount.toFixed(2);
    document.getElementById('total-amount').textContent = totalAmount.toFixed(2);
    
    // Show the price estimate section
    document.getElementById('price-estimate').classList.remove('d-none');
}

// Add event listeners to trigger calculation
document.getElementById('room_capacity').addEventListener('change', calculateBill);
document.getElementById('room_type').addEventListener('change', calculateBill);
document.getElementById('date_from').addEventListener('change', calculateBill);
document.getElementById('date_to').addEventListener('change', calculateBill);
document.getElementById('payment_type').addEventListener('change', calculateBill);

// Form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
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