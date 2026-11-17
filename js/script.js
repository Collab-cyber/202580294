(function () {
    const toggle = document.querySelector(".nav-toggle");
    const nav = document.getElementById("site-nav");
    if (!toggle || !nav) { return; }

    toggle.addEventListener("click", function () {
        const open = nav.classList.toggle("open");
        toggle.classList.toggle("open", open);
        toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });

    
    nav.addEventListener("click", function (event) {
        if (event.target.closest("a")) {
            nav.classList.remove("open");
            toggle.classList.remove("open");
            toggle.setAttribute("aria-expanded", "false");
        }
    });
})();


(function () {
    const form = document.getElementById("searchForm");
    const search = document.getElementById("search");
    if (!form || !search || typeof DESTINATIONS === "undefined") { return; }

    const chipBox = document.getElementById("filterChips");
    const info = document.getElementById("resultInfo");
    const moreGrid = document.getElementById("moreGrid");
    const moreBlock = document.getElementById("moreBlock");
    const featuredBlock = document.getElementById("featuredBlock");
    const noResults = document.getElementById("noResults");
    const clearBtn = document.getElementById("clearSearch");
    const featuredCards = document.querySelectorAll("#featuredBlock .destination-card");

    let category = "All";

    function make(tag, className, text) {
        const el = document.createElement(tag);
        if (className) { el.className = className; }
        if (text) { el.textContent = text; }
        return el;
    }

    function haystack(d) {
        return [d.name, d.area, d.category, d.description, d.keywords]
            .concat(d.activities).join(" ").toLowerCase();
    }

    function matches(d, text) {
        const inCategory = category === "All" || d.category === category;
        // every word typed must appear somewhere in the destination's info
        const words = text.split(/\s+/).filter(Boolean);
        return inCategory && words.every(function (w) { return haystack(d).indexOf(w) !== -1; });
    }

    function buildCard(d) {
        const card = make("article", "destination-card place-card");
        card.dataset.id = d.id;

        const media = make("div", "destination-image place-thumb thumb-" + d.category.toLowerCase());
        if (d.image) {
            const img = make("img");
            img.src = d.image;
            img.alt = d.name + ", Palawan";
            media.appendChild(img);
        } else {
            media.appendChild(make("span", "thumb-emoji", d.emoji));
            media.appendChild(make("span", "thumb-note", "Photo coming soon"));
        }
        media.appendChild(make("span", "badge-category", d.category));
        card.appendChild(media);

        card.appendChild(make("h3", "", d.name));
        card.appendChild(make("p", "", d.description));
        card.appendChild(make("p", "place-area", "📍 " + d.area));

        const tags = make("div", "tag-row");
        d.activities.forEach(function (a) { tags.appendChild(make("span", "tag", a)); });
        card.appendChild(tags);

        return card;
    }

    function render() {
        const text = search.value.trim().toLowerCase();
        const found = DESTINATIONS.filter(function (d) { return matches(d, text); });
        const foundIds = found.map(function (d) { return d.id; });

        
        let featuredShown = 0;
        featuredCards.forEach(function (card) {
            const show = foundIds.indexOf(card.dataset.id) !== -1;
            card.hidden = !show;
            if (show) { featuredShown++; }
        });
        featuredBlock.hidden = featuredShown === 0;

        
        const others = found.filter(function (d) { return !d.featured; });
        moreGrid.innerHTML = "";
        others.forEach(function (d) { moreGrid.appendChild(buildCard(d)); });
        moreBlock.hidden = others.length === 0;

        noResults.hidden = found.length !== 0;

        if (text === "" && category === "All") {
            info.textContent = "Showing all " + DESTINATIONS.length + " destinations.";
        } else {
            info.textContent = found.length + (found.length === 1 ? " destination" : " destinations") + " found.";
        }
    }

    
    const categories = ["All"];
    DESTINATIONS.forEach(function (d) {
        if (categories.indexOf(d.category) === -1) { categories.push(d.category); }
    });

    categories.forEach(function (name) {
        const chip = make("button", "chip" + (name === "All" ? " active" : ""), name);
        chip.type = "button";
        chip.addEventListener("click", function () {
            category = name;
            chipBox.querySelectorAll(".chip").forEach(function (c) {
                c.classList.toggle("active", c === chip);
            });
            render();
        });
        chipBox.appendChild(chip);
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        render();
        document.getElementById("destinations").scrollIntoView({ behavior: "smooth" });
    });

    search.addEventListener("input", render);

    function reset() {
        search.value = "";
        category = "All";
        chipBox.querySelectorAll(".chip").forEach(function (c) {
            c.classList.toggle("active", c.textContent === "All");
        });
        render();
    }
    clearBtn.addEventListener("click", reset);

    // links like index.php?q=Port%20Barton prefill the search
    const q = new URLSearchParams(location.search).get("q");
    if (q) { search.value = q; }

    render();
})();
