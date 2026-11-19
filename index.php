<?php
require_once 'includes/init.php';

$destinations = get_destinations();
$featured     = array_values(array_filter($destinations, function ($d) { return $d['featured']; }));

$pageTitle = 'PalaTrip | Home';
$active    = 'home';
include 'includes/header.php';
?>

    <main id="main">

        <section class="home-intro">

            <p class="section-label">EXPLORE PALAWAN</p>

            <h1>Discover Your Next Destination</h1>

            <p>
                Explore popular places and activities in Palawan.
                Find information about destinations before your trip.
            </p>

        </section>

        <section class="search-section" id="search-section">

            <h2>Search for a Destination</h2>

            <form id="searchForm" role="search" autocomplete="off">

                <input
                    type="search"
                    id="search"
                    placeholder="Try &quot;Port Barton&quot;, &quot;beach&quot; or &quot;diving&quot;..."
                    aria-label="Search a destination"
                >

                <button type="submit">Search</button>

            </form>

            <div class="chip-row filter-chips" id="filterChips" aria-label="Filter by category"></div>

            <p class="result-info" id="resultInfo" aria-live="polite"></p>

        </section>

        <section class="destination-info" id="destinations">

            <div id="featuredBlock">

                <div class="section-heading">

                    <p class="section-label">
                        DESTINATION INFORMATION
                    </p>

                    <h2>
                        Popular Destinations
                    </h2>

                    <p>
                        The three most-visited places in Palawan.
                    </p>

                </div>

                <div class="info-container">

                    <?php foreach ($featured as $place): ?>
                        <article class="destination-card featured" data-id="<?= e($place['id']) ?>">

                            <div class="destination-image">
                                <img src="<?= e($place['image']) ?>" alt="<?= e($place['name']) ?>, Palawan">
                                <span class="badge-popular">&#9733; Popular</span>
                            </div>

                            <h3><?= e($place['name']) ?></h3>

                            <p><?= e($place['description']) ?></p>

                            <p class="place-area">&#128205; <?= e($place['area']) ?></p>

                        </article>
                    <?php endforeach; ?>

                </div>

            </div>

            <div id="moreBlock">

                <div class="section-heading">

                    <p class="section-label">
                        MORE TO EXPLORE
                    </p>

                    <h2>
                        More Destinations in Palawan
                    </h2>

                    <p>
                        Beaches, islands, wildlife and history beyond the big three.
                    </p>

                </div>

                
                <div class="info-container" id="moreGrid"></div>

            </div>

            <div class="no-results" id="noResults" hidden>
                <p class="no-results-icon" aria-hidden="true">&#128269;</p>
                <h3>No destinations found</h3>
                <p>Try a different name, a place in Palawan, or pick a category above.</p>
                <button type="button" class="btn primary-btn" id="clearSearch">Show all destinations</button>
            </div>

        </section>

        <section class="activities">

            <div class="section-heading">

                <p class="section-label">
                    POPULAR ACTIVITIES
                </p>

                <h2>
                    Things to do in Palawan
                </h2>

                <p>
                    Discover some activities you can enjoy
                    during your trip.
                </p>

            </div>

            <div class="activity-container">

                <article class="activity-card">

                    <div class="activity-image act-cave">
                        <img src="images/underground-river.jpg" alt="Boat tour inside the Puerto Princesa Underground River">
                    </div>

                    <div class="activity-content">

                        <h3>Puerto Princesa Underground River</h3>

                        <p>Explore one of Palawan's famous natural
                            attractions and enjoy a river tour inside
                            the underground cave.</p>

                        <p class="place-area">&#128205; Puerto Princesa, Palawan</p>

                        <a href="index.php?q=Puerto%20Princesa#destinations">
                            View Details
                        </a>

                    </div>

                </article>

                <article class="activity-card">

                    <div class="activity-image act-island">
                        <img src="images/island-hopping.jpg" alt="Island hopping boats in Palawan">
                    </div>

                    <div class="activity-content">

                        <h3>
                            Island Hopping
                        </h3>

                        <p>Visit beautiful islands, beaches,
                            lagoons, and other amazing places
                            around Palawan.</p>

                        <p class="place-area">&#128205; El Nido, Palawan</p>

                        <a href="index.php?q=El%20Nido#destinations">
                            View Details
                        </a>

                    </div>

                </article>

                <article class="activity-card">

                    <div class="activity-image act-snorkel">
                        <img src="images/snorkeling.jpg" alt="Snorkeling in the clear waters of Palawan">
                    </div>

                    <div class="activity-content">

                        <h3>
                            Snorkeling
                        </h3>

                        <p>Discover colorful marine life and
                            enjoy the clear waters of Palawan.</p>

                        <p class="place-area">&#128205; Coron, Palawan</p>

                        <a href="index.php?q=Coron#destinations">
                            View Details
                        </a>

                    </div>

                </article>

            </div>

        </section>

    </main>

    <script>
        const DESTINATIONS = <?= json_encode($destinations, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    </script>

<?php include 'includes/footer.php'; ?>
