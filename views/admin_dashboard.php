<?php 
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once '../controllers/AdminController.php';
$adminController = new AdminController();
$reservations = $adminController->getAllReservations();

$isAdmin = true;
include 'includes/header.php'; 
?>

<!-- Add meta tags for security -->
<meta http-equiv="Content-Security-Policy" content="default-src 'self' https: 'unsafe-inline' 'unsafe-eval';">
<meta http-equiv="X-Content-Type-Options" content="nosniff">

<!-- Update CSS and JS includes -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<div class="page-header">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="text-center">
            <h1>Reservation Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item active">Reservation Management</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Action Buttons -->
    <div class="mb-4 text-end">
        <a href="reservation.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Reservation
        </a>
    </div>

    <!-- Reservations Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">All Reservations</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Guest Name</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Bill</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($reservation = $reservations->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $reservation['reservation_id']; ?></td>
                            <td><?php echo $reservation['customer_name']; ?></td>
                            <td><?php echo $reservation['room_number'] . ' (' . $reservation['room_type'] . ')'; ?></td>
                            <td><?php echo date('M d, Y', strtotime($reservation['date_from'])); ?></td>
                            <td><?php echo date('M d, Y', strtotime($reservation['date_to'])); ?></td>
                            <td>₱<?php echo number_format($reservation['total_bill'], 2); ?></td>
                            <td>
                                <button class="btn btn-sm btn-info me-2" onclick="viewReservation(<?php echo $reservation['reservation_id']; ?>)">
                                    <i class="fas fa-eye"></i> See Details
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="showDeleteConfirmation(<?php echo $reservation['reservation_id']; ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Details Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reservationDetails">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteBtn">
                    <i class="fas fa-trash"></i> Delete Reservation
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this reservation? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Confirm Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="deleteSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Reservation has been successfully deleted.
        </div>
    </div>
</div>

<script>
let currentReservationId = null;
let reservationModal;
let deleteConfirmModal;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize modals
    reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
    deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
    
    // Initialize toast
    const toastEl = document.getElementById('deleteSuccessToast');
    if (toastEl) {
        new bootstrap.Toast(toastEl, {
            autohide: true,
            delay: 3000
        });
    }
});

function viewReservation(id) {
    currentReservationId = id;
    
    // Update delete button
    document.getElementById('deleteBtn').onclick = () => showDeleteConfirmation(id);
    
    // Fetch and display reservation details
    fetch(`../controllers/AdminActionsController.php?action=get_reservation&reservation_id=${id}`)
        .then(response => response.json())
        .then(reservation => {
            document.getElementById('reservationDetails').innerHTML = `
                <div class="reservation-details">
                    <div class="section mb-4">
                        <h5 class="text-primary mb-3">Guest Information</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Name:</strong></div>
                            <div class="col-md-8">${reservation.customer_name}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Email:</strong></div>
                            <div class="col-md-8">${reservation.email}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Phone:</strong></div>
                            <div class="col-md-8">${reservation.contact_number}</div>
                        </div>
                    </div>

                    <div class="section mb-4">
                        <h5 class="text-primary mb-3">Room Details</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Room Number:</strong></div>
                            <div class="col-md-8">${reservation.room_number}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Room Type:</strong></div>
                            <div class="col-md-8">${reservation.room_type}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Capacity:</strong></div>
                            <div class="col-md-8">${reservation.capacity_name}</div>
                        </div>
                    </div>

                    <div class="section mb-4">
                        <h5 class="text-primary mb-3">Stay Information</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Check-in:</strong></div>
                            <div class="col-md-8">${new Date(reservation.date_from).toLocaleDateString()}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Check-out:</strong></div>
                            <div class="col-md-8">${new Date(reservation.date_to).toLocaleDateString()}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Number of Nights:</strong></div>
                            <div class="col-md-8">${reservation.num_days}</div>
                        </div>
                    </div>

                    <div class="section mb-4">
                        <h5 class="text-primary mb-3">Payment Details</h5>
                        <div class="row">
                            <div class="col-md-4"><strong>Subtotal:</strong></div>
                            <div class="col-md-8">₱${parseFloat(reservation.subtotal).toFixed(2)}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Discount:</strong></div>
                            <div class="col-md-8">₱${parseFloat(reservation.discount).toFixed(2)}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Additional Charges:</strong></div>
                            <div class="col-md-8">₱${parseFloat(reservation.additional_charge).toFixed(2)}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><strong>Total Bill:</strong></div>
                            <div class="col-md-8"><strong>₱${parseFloat(reservation.total_bill).toFixed(2)}</strong></div>
                        </div>
                    </div>

                    ${reservation.special_requests ? `
                    <div class="section">
                        <h5 class="text-primary mb-3">Special Requests</h5>
                        <div class="p-3 bg-light rounded">
                            ${reservation.special_requests}
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
            reservationModal.show();
        });
}

function showDeleteConfirmation(id) {
    reservationModal.hide();
    document.getElementById('confirmDeleteBtn').onclick = () => deleteReservation(id);
    deleteConfirmModal.show();
}

function deleteReservation(id) {
    fetch('../controllers/AdminActionsController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete_reservation&reservation_id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            deleteConfirmModal.hide();
            // Show success toast
            const toast = new bootstrap.Toast(document.getElementById('deleteSuccessToast'));
            toast.show();
            // Reload the page after a short delay
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            alert('Failed to delete reservation');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the reservation');
    });
}
</script>

<style>
.reservation-details .row {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}
.reservation-details .section:last-child .row:last-child {
    border-bottom: none;
}

.toast {
    background-color: white;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.toast-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.toast-body {
    padding: 0.75rem;
}
</style>

<?php include 'includes/footer.php'; ?>