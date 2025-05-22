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
                                <button class="btn btn-sm btn-info" onclick="viewReservation(<?php echo $reservation['reservation_id']; ?>)">
                                    <i class="fas fa-eye"></i> See Details
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
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentReservationId = null;
const reservationModal = new bootstrap.Modal(document.getElementById('reservationModal'));
const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

function viewReservation(id) {
    currentReservationId = id;
    
    // Update delete button
    document.getElementById('deleteBtn').onclick = () => showDeleteConfirmation(id);
    
    // Fetch and display reservation details
    fetch(`admin_actions.php?action=get_reservation&reservation_id=${id}`)
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
    fetch('admin_actions.php', {
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
            location.reload();
        } else {
            alert('Failed to delete reservation');
        }
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
</style>

<?php include 'includes/footer.php'; ?>