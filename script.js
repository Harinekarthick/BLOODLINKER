
const blood = document.getElementById("blood");
const city = document.getElementById("city");
const results = document.getElementById("results");

async function searchDonors() {

    if (!blood.value) {
        results.innerHTML = "Please select a blood group.";
        return;
    }

    results.innerHTML = "Searching...";

    try {
        const params = new URLSearchParams({
            ajax: "1",
            blood_group: blood.value,
            city: city.value
        });

        const response = await fetch("search.php?" + params);
        if (!response.ok) throw new Error("Search failed");

        const donors = await response.json();

        if (donors.length === 0) {
            results.textContent = "No matching donors found.";
            return;
        }

        results.innerHTML = "";

        donors.forEach(donor => {
            const card = document.createElement("div");
            card.className = "donor-card";

            const name = document.createElement("h3");
            name.textContent = donor.name;

            const details = document.createElement("p");
            details.textContent =
                donor.blood_group + " | " + donor.city;

            card.append(name, details);
            results.appendChild(card);
        });

    } catch (error) {
        results.textContent = "Unable to search. Try again.";
    }
}

blood.addEventListener("change", searchDonors);
city.addEventListener("input", searchDonors);

new Chart(document.getElementById('bloodBarChart'), {
    type: 'bar',

    data: {
        labels: bloodGroups,
        datasets: [{
            label: 'Number of Donors',
            data: donorCounts,
            backgroundColor: '#b51224',
            borderRadius: 8
        }]
    },

    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Blood Group Comparison'
            },
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
