<?php
require_once 'includes/init.php';

$pageTitle = 'PalaTrip | Explore Palawan';
$active    = 'landing';
include 'includes/header.php';
?>

    <main id="main">

    <section class="hero">

        <div class="hero-content">

            <p class="hero-subtitle">DISCOVER PALAWAN</p>

            <h1>Explore the Beauty of Palawan</h1>

            <p>
                Discover breathtaking destinations, beautiful beaches,
                and unforgettable experiences across Palawan with PalaTrip.
            </p>

            <div class="hero-buttons">
                <a href="index.php" class="btn primary-btn">
                    Get Started
                </a>

                <a href="#destinations" class="btn secondary-btn">
                    Explore Destinations
                </a>
            </div>

        </div>

    </section>

    <section class="destinations" id="destinations">

        <div class="section-heading">
            <p class="section-label">EXPLORE PALAWAN</p>
            <h2>Popular Destinations in Palawan</h2>
            <p>The three most-visited places in the province.</p>
        </div>

        <div class="destination-container">

            <article class="destination-card featured">

                <div class="destination-image">
                    <img src="images/el-nido.jpg" alt="El Nido, Palawan">
                    <span class="badge-popular">&#9733; Popular</span>
                </div>

                <div class="destination-content">

                    <h3>El Nido</h3>

                    <p>
                        Explore crystal-clear waters, beautiful lagoons,
                        and stunning island scenery.
                    </p>

                    <a href="index.php?q=El%20Nido#destinations">
                        Explore El Nido &rarr;
                    </a>

                </div>

            </article>

            <article class="destination-card featured">

                <div class="destination-image">
                    <img src="images/coron.jpg" alt="Coron, Palawan">
                    <span class="badge-popular">&#9733; Popular</span>
                </div>

                <div class="destination-content">

                    <h3>Coron</h3>

                    <p>
                        Discover beautiful islands, beaches, and
                        breathtaking natural attractions.
                    </p>

                    <a href="index.php?q=Coron#destinations">
                        Explore Coron &rarr;
                    </a>

                </div>

            </article>

            <article class="destination-card featured">

                <div class="destination-image">
                    <img src="images/puerto-princesa.jpg" alt="Puerto Princesa, Palawan">
                    <span class="badge-popular">&#9733; Popular</span>
                </div>

                <div class="destination-content">

                    <h3>Puerto Princesa</h3>

                    <p>
                        Experience exciting adventures and explore
                        the natural wonders of Palawan's capital.
                    </p>

                    <a href="index.php?q=Puerto%20Princesa#destinations">
                        Explore Puerto Princesa &rarr;
                    </a>

                </div>

            </article>

        </div>

        <div class="more-places">
            <p>Also worth a visit:</p>
            <div class="chip-row">
                <a class="chip" href="index.php?q=Port%20Barton#destinations">Port Barton</a>
                <a class="chip" href="index.php?q=Nacpan#destinations">Nacpan Beach</a>
                <a class="chip" href="index.php?q=Honda%20Bay#destinations">Honda Bay</a>
                <a class="chip" href="index.php?q=Kayangan#destinations">Kayangan Lake</a>
                <a class="chip" href="index.php?q=Calauit#destinations">Calauit Safari Park</a>
                <a class="chip" href="index.php?q=Tubbataha#destinations">Tubbataha Reefs</a>
                <a class="chip" href="index.php#destinations">See all &rarr;</a>
            </div>
        </div>

    </section>

    <section class="about">

        <div class="about-content">

            <p class="section-label">ABOUT PALATRIP</p>

            <h2>Your Guide to Exploring Palawan</h2>

            <p>
                PalaTrip is a web-based travel platform designed
                to help travelers discover and explore the beautiful
                destinations of Palawan.
            </p>

            <p>
                Browse destinations, learn more about places to visit,
                and discover where your next Palawan adventure could take you.
            </p>

        </div>

    </section>

    <section class="cta">

        <div class="cta-content">

            <h2>Ready to Explore Palawan?</h2>

            <p>
                Discover your next destination and start
                your Palawan adventure today.
            </p>

            <a href="index.php" class="btn primary-btn">
                Explore Palawan
            </a>

            <?php if (!is_logged_in()): ?>
                <a href="register.php" class="btn secondary-btn">
                    Create a Free Account
                </a>
            <?php endif; ?>

        </div>

    </section>

    </main>

<?php include 'includes/footer.php'; ?>
