<?php
$page_title = 'Our Luxury Rooms - The Royal';
require_once 'config/database.php';
require_once 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM rooms WHERE is_available = 1 ORDER BY type, price_per_night");
$rooms = $stmt->fetchAll();
?>

<section class="page-header">
    <div class="container">
        <h1 class="page-title fade-in">Our Luxury Rooms</h1>
        <p class="page-subtitle fade-in">Discover your perfect sanctuary of comfort and elegance</p>
    </div>
</section>

<section class="section" id="rooms">
    <div class="container">
        <?php if (empty($rooms)): ?>
            <div class="card text-center">
                <p>No rooms available at the moment. Please check back later.</p>
            </div>
        <?php else: ?>
            <div class="room-grid">
                <?php foreach ($rooms as $room): ?>
                    <div class="room-card fade-in">
                        <img src="<?php echo htmlspecialchars($room['image_url']); ?>"
                            alt="<?php echo htmlspecialchars($room['type']); ?> Room">
                        <div class="room-card-content">
                            <div class="room-type"><?php echo htmlspecialchars($room['type']); ?></div>
                            <h3>Room <?php echo htmlspecialchars($room['room_number']); ?></h3>
                            <p>Floor <?php echo htmlspecialchars($room['floor_number']); ?></p>
                            <p class="room-price">
                                ₹<?php echo number_format($room['price_per_night'], 2); ?>
                                <span>/ night</span>
                            </p>
                            <p><?php echo htmlspecialchars(substr($room['description'], 0, 100)); ?>...</p>
                            <a href="booking.php?room_id=<?php echo $room['id']; ?>"
                                class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                                Book Now
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>