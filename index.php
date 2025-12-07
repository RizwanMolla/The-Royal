<?php
$page_title = 'The Royal - Luxury Hotel';
$body_class = 'homepage';
require_once 'config/database.php';
require_once 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Experience Luxury at The Royal</h1>
        <p>Indulge in premium comfort and world-class service at our exclusive hotel</p>
        <?php if (is_logged_in()): ?>
            <a href="/app/rooms.php" class="btn btn-primary btn-large">Browse Rooms</a>
        <?php else: ?>
            <a href="/app/register.php" class="btn btn-primary btn-large">Book Your Stay</a>
        <?php endif; ?>
    </div>
</section>

<!-- Accommodations Section -->
<section class="section accommodations-section">
    <div class="container">
        <h2 class="section-title fade-in">Luxury Accommodations</h2>
        <p class="section-subtitle fade-in">Discover your perfect sanctuary</p>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&h=400&fit=crop" alt="Deluxe Rooms">
                </div>
                <div class="feature-content">
                    <h3>Deluxe Rooms</h3>
                    <p>Elegantly appointed rooms with modern amenities and stunning city views for the discerning traveler</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600&h=400&fit=crop" alt="Premium Suites">
                </div>
                <div class="feature-content">
                    <h3>Premium Suites</h3>
                    <p>Spacious suites featuring separate living areas, premium furnishings, and exclusive butler service</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600&h=400&fit=crop" alt="Royal Suites">
                </div>
                <div class="feature-content">
                    <h3>Royal Suites</h3>
                    <p>The pinnacle of luxury with panoramic views, private terraces, and bespoke concierge services</p>
                </div>
            </div>
        </div>

        <div class="text-center" style="margin-top: 3rem;">
            <a href="/app/rooms.php" class="btn btn-primary btn-large">View All Rooms</a>
        </div>
    </div>
</section>

<!-- Dining Section -->
<section class="section dining-section">
    <div class="container">
        <h2 class="section-title fade-in">Signature Dining</h2>
        <p class="section-subtitle fade-in">Embark on a journey of exquisite culinary experiences</p>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=600&h=400&fit=crop" alt="Fine Dining Restaurant">
                </div>
                <div class="feature-content">
                    <h3>The Royal Court</h3>
                    <p>Experience world-class fine dining with innovative cuisine crafted by Michelin-starred chefs</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=600&h=400&fit=crop" alt="Rooftop Bar">
                </div>
                <div class="feature-content">
                    <h3>Sky Lounge</h3>
                    <p>Savor handcrafted cocktails and panoramic city views at our exclusive rooftop bar</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=400&fit=crop" alt="Cafe">
                </div>
                <div class="feature-content">
                    <h3>Garden Café</h3>
                    <p>Enjoy artisanal pastries and specialty coffees in our serene garden setting</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Wellness Section -->
<section class="section wellness-section">
    <div class="container">
        <h2 class="section-title fade-in">Wellness & Recreation</h2>
        <p class="section-subtitle fade-in">Rejuvenate your mind, body, and soul</p>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=600&h=400&fit=crop" alt="Luxury Spa">
                </div>
                <div class="feature-content">
                    <h3>Royal Spa</h3>
                    <p>Indulge in holistic treatments and therapies inspired by ancient wellness traditions</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1576610616656-d3aa5d1f4534?w=600&h=400&fit=crop" alt="Infinity Pool">
                </div>
                <div class="feature-content">
                    <h3>Infinity Pool</h3>
                    <p>Relax in our temperature-controlled infinity pool with breathtaking skyline views</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&h=400&fit=crop" alt="Fitness Center">
                </div>
                <div class="feature-content">
                    <h3>Fitness Center</h3>
                    <p>State-of-the-art equipment and personal training services available 24/7</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="section events-section">
    <div class="container">
        <h2 class="section-title fade-in">Events & Celebrations</h2>
        <p class="section-subtitle fade-in">Create unforgettable moments in our grand venues</p>

        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1745685962285-1e58456871ff?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Grand Ballroom">
                </div>
                <div class="feature-content">
                    <h3>Grand Ballroom</h3>
                    <p>Host magnificent weddings and galas in our opulent ballroom accommodating up to 500 guests</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&h=400&fit=crop" alt="Conference Rooms">
                </div>
                <div class="feature-content">
                    <h3>Conference Suites</h3>
                    <p>Modern meeting spaces equipped with cutting-edge technology for successful business events</p>
                </div>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-image">
                    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=600&h=400&fit=crop" alt="Garden Venue">
                </div>
                <div class="feature-content">
                    <h3>Garden Terrace</h3>
                    <p>Intimate outdoor venue perfect for cocktail receptions and private celebrations</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>