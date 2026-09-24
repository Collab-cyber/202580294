const form = document.getElementById("searchForm");
const search = document.getElementById("search");
const destinations = document.querySelectorAll(".destination-card");

form.addEventListener("submit", function(event) 
{
    event.preventDefault();

    const text = search.value.toLowerCase();

    destinations.forEach(function(destination) 
    {
        const name = destination.innerText.toLowerCase();

        if (name.includes(text)) 
        {
            destination.style.display = "block";
        } 
        else 
        {
            destination.style.display = "none";
        }
    });
});