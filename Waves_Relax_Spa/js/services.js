document.addEventListener('DOMContentLoaded', () => {
    const serviceCardsContainer = document.getElementById('service-cards');
    const priceRangeInput = document.getElementById('price-range');
    const priceValueDisplay = document.getElementById('price-value');
    const serviceTypeSelect = document.getElementById('service-type');
    const durationSelect = document.getElementById('duration');

    // Sample service data
    const services = [
        {
            name: "Shiatsu Massage",
            image: "./img/shiatsu.jpg",
            description: "Relieve tension and improve energy flow with finger pressure.",
            price: 400,
            duration: "30 mins",
            category: "Therapeutic Massages"
        },
        {
            name: "Signature Massage",
            image: "./img/signature.jpg",
            description: "Experience a personalized blend of techniques for ultimate relaxation.",
            price: 600,
            duration: "60 mins",
            category: "Specialty Massages"
        },
        {
            name: "Ventosa",
            image: "./img/ventosa.jpg",
            description: "Promote healing with heated cups creating suction on your skin.",
            price: 500,
            duration: "50 mins",
            category: "Therapeutic Massages"
        },
        {
            name: "Body Scrub",
            image: "./img/scrub.jpg",
            description: "Exfoliate and rejuvenate your skin for a smooth, refreshed feel.",
            price: 500,
            duration: "50 mins",
            category: "Additional Treatments"
        },
        {
            name: "Hand and Foot Reflex",
            image: "./img/hand.jpg",
            description: "Relieve stress by targeting pressure points on your hands and feet.",
            price: 500,
            duration: "60 mins",
            category: "Additional Treatments"
        },
        {
            name: "Aroma Massage",
            image: "./img/aroma.jpg",
            description: "Enhance relaxation with massage and essential oils.",
            price: 500,
            duration: "60 mins",
            category: "Relaxation Massages"
        },
        {
            name: "Swedish Massage",
            image: "./img/swedish.jpg",
            description: "Relax and rejuvenate with a classic Swedish massage.",
            price: 500,
            duration: "60 mins",
            category: "Relaxation Massages"
        },
        {
            name: "Light and Touch Massage",
            image: "./img/light.jpg",
            description: "Enjoy gentle, light touch for stress relief and relaxation.",
            price: 400,
            duration: "30 mins",
            category: "Relaxation Massages"
        },
        {
            name: "Deep Tissue Massage",
            image: "./img/deep.jpg",
            description: "Relieve chronic pain and tension with deep muscle therapy.",
            price: 700,
            duration: "90 mins",
            category: "Therapeutic Massages"
        },
        {
            name: "Thai Massage",
            image: "./img/thai.jpg",
            description: "Improve flexibility and energy flow with traditional Thai techniques.",
            price: 600,
            duration: "30 mins",
            category: "Therapeutic Massages"
        },
        {
            name: "Twin Massage",
            image: "./img/twin.jpg",
            description: "Experience deep relaxation with a synchronized massage by two therapists.",
            price: 1000,
            duration: "90 mins",
            category: "Specialty Massages"
        },
        {
            name: "Prenatal Massage",
            image: "./img/prenatal.jpg",
            description: "Relieve pregnancy-related discomfort with a soothing massage.",
            price: 1000,
            duration: "60 mins",
            category: "Specialty Massages"
        },
        {
            name: "Kiddie Massage",
            image: "./img/kiddie.jpg",
            description: "Help children relax and unwind with a gentle massage.",
            price: 400,
            duration: "30 mins",
            category: "Specialty Massages"
        },
        {
            name: "Crystal Hands Signature Massage",
            image: "./img/crystal.jpg",
            description: "Balance energy and enhance relaxation with crystal therapy.",
            price: 900,
            duration: "90 mins",
            category: "Specialty Massages"
        },
    ];

    // Function to render service cards
    const renderServiceCards = (services) => {
        serviceCardsContainer.innerHTML = ''; // Clear existing cards
        services.forEach(service => {
            const card = document.createElement('div');
            card.className = 'service-card'; // Add the correct class
            card.innerHTML = `
                <img src="${service.image}" alt="${service.name}">
                <h3>${service.name}</h3>
                <p class="price">₱${service.price}</p>
                <p>${service.description}</p>
                <p>Duration: ${service.duration}</p>
                <button>Book Now</button>
            `;
            serviceCardsContainer.appendChild(card);
        });
    };

    // Update price value display
    priceRangeInput.addEventListener('input', (e) => {
        const value = e.target.value;
        priceValueDisplay.textContent = `₱0 - ₱${value}`;
        filterServices();
    });

    // Filter services based on selected category, price range, and duration
    const filterServices = () => {
        const selectedCategory = serviceTypeSelect.value;
        const maxPrice = parseInt(priceRangeInput.value);
        const selectedDuration = durationSelect.value;

        const filteredServices = services.filter(service => {
            const withinPriceRange = service.price <= maxPrice;
            const matchesCategory = selectedCategory === "All" || service.category === selectedCategory;
            const matchesDuration = selectedDuration === "all" || service.duration.startsWith(selectedDuration);
            return withinPriceRange && matchesCategory && matchesDuration;
        });

        renderServiceCards(filteredServices);
    };

    // Add event listeners for filters
    serviceTypeSelect.addEventListener('change', filterServices);
    durationSelect.addEventListener('change', filterServices);

    // Initial rendering of all services
    renderServiceCards(services);
});