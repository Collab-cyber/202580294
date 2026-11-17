<?php
require_once 'includes/init.php';

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

                    <article class="destination-card featured" data-id="el-nido">

                        <div class="destination-image">
                            <img src="images/el-nido.jpg" alt="El Nido, Palawan">
                            <span class="badge-popular">&#9733; Popular</span>
                        </div>

                        <h3>El Nido</h3>

                        <p>Known for its beautiful lagoons,
                            beaches, limestone cliffs, and
                            island-hopping activities.</p>

                        <p class="place-area">&#128205; Northern Palawan</p>

                    </article>

                    <article class="destination-card featured" data-id="coron">

                        <div class="destination-image">
                            <img src="images/coron.jpg" alt="Coron, Palawan">
                            <span class="badge-popular">&#9733; Popular</span>
                        </div>

                        <h3>Coron</h3>

                        <p>A popular destination known for its
                            clear waters, islands, lagoons,
                            and diving spots.</p>

                        <p class="place-area">&#128205; Busuanga Island, Palawan</p>

                    </article>

                    <article class="destination-card featured" data-id="puerto-princesa">

                        <div class="destination-image">
                            <img src="images/puerto-princesa.jpg" alt="Puerto Princesa, Palawan">
                            <span class="badge-popular">&#9733; Popular</span>
                        </div>

                        <h3>Puerto Princesa</h3>

                        <p>The capital city of Palawan and home
                            to the famous Underground River.</p>

                        <p class="place-area">&#128205; Puerto Princesa, Palawan</p>

                    </article>

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

                    <div class="activity-image act-cave" aria-hidden="true">&#128758;</div>

                    <div class="activity-content">

                        <h3>Puerto Princesa Underground River</h3>

                        <p>Explore one of Palawan's famous natural
                            attractions and enjoy a river tour inside
                            the underground cave.</p>

                        <p class="place-area">&#128205; Puerto Princesa, Palawan</p>

                        <p class="rating">&#11088; 4.8 / 5</p>

                        <a href="index.php?q=Puerto%20Princesa#destinations">
                            View Details
                        </a>

                    </div>

                </article>

                <article class="activity-card">

                    <div class="activity-image act-island" aria-hidden="true">&#127965;</div>

                    <div class="activity-content">

                        <h3>
                            Island Hopping
                        </h3>

                        <p>Visit beautiful islands, beaches,
                            lagoons, and other amazing places
                            around Palawan.</p>

                        <p class="place-area">&#128205; El Nido, Palawan</p>

                        <p class="rating">&#11088; 4.9 / 5</p>

                        <a href="index.php?q=El%20Nido#destinations">
                            View Details
                        </a>

                    </div>

                </article>

                <article class="activity-card">

                    <div class="activity-image act-snorkel" aria-hidden="true">&#129343;</div>

                    <div class="activity-content">

                        <h3>
                            Snorkeling
                        </h3>

                        <p>Discover colorful marine life and
                            enjoy the clear waters of Palawan.</p>

                        <p class="place-area">&#128205; Coron, Palawan</p>

                        <p class="rating">&#11088; 4.7 / 5</p>

                        <a href="index.php?q=Coron#destinations">
                            View Details
                        </a>

                    </div>

                </article>

            </div>

        </section>

    </main>

<?php include 'includes/footer.php'; ?>
