// Menu Toggle
const menuToggle = document.querySelector('.menuToggle');
const header = document.querySelector('header');
const section = document.querySelector('section');

menuToggle.onclick = function () {
    header.classList.toggle('active');
    section.classList.toggle('active');
};

// Testimonial Slider
const testimonialSlides = document.querySelectorAll('.testimonial-card');
let testimonialCounter = 0;

testimonialSlides.forEach((slide, index) => {
    slide.style.left = `${index * 100}%`;
});

const goPrevTestimonial = () => {
    testimonialCounter = (testimonialCounter > 0) ? testimonialCounter - 1 : testimonialSlides.length - 1;
    updateTestimonialSlider();
};

const goNextTestimonial = () => {
    testimonialCounter = (testimonialCounter < testimonialSlides.length - 1) ? testimonialCounter + 1 : 0;
    updateTestimonialSlider();
};

const updateTestimonialSlider = () => {
    testimonialSlides.forEach(slide => {
        slide.style.transform = `translateX(-${testimonialCounter * 100}%)`;
    });
};

document.querySelector('.prev-btn').addEventListener('click', goPrevTestimonial);
document.querySelector('.next-btn').addEventListener('click', goNextTestimonial);

// Services Carousel
const services = [
    {
        name: "Shiatsu Massage",
        image: "./img/shiatsu.jpg",
        description: "Relieve tension and improve energy flow with finger pressure.",
        price: "₱400",
    },
    {
        name: "Signature Massage",
        image: "./img/signature.jpg",
        description: "Experience a personalized blend of techniques for ultimate relaxation.",
        price: "₱600",
    },
    {
        name: "Ventosa",
        image: "./img/ventosa.jpg",
        description: "Promote healing with heated cups creating suction on your skin.",
        price: "₱500",
    },
    {
        name: "Body Scrub",
        image: "./img/scrub.jpg",
        description: "Exfoliate and rejuvenate your skin for a smooth, refreshed feel.",
        price: "₱500",
    },
    {
        name: "Hand and Foot Reflex",
        image: "./img/hand.jpg",
        description: "Relieve stress by targeting pressure points on your hands and feet.",
        price: "₱500",
    },
    {
        name: "Aroma Massage",
        image: "./img/aroma.jpg",
        description: "Enhance relaxation with massage and essential oils.",
        price: "₱500",
    },
    {
        name: "Swedish Massage",
        image: "./img/swedish.jpg",
        description: "Relax and rejuvenate with a classic Swedish massage.",
        price: "₱500",
    },
];

const carousel = document.querySelector(".carousel");

// Create service cards and append to carousel
services.forEach((service) => {
    const card = document.createElement("div");
    card.className = "service-card";
    card.innerHTML = `
        <img src="${service.image}" alt="${service.name}">
        <h3>${service.name}</h3>
        <p>${service.description}</p>
        <div class="price">${service.price}</div>
        <button class="book-now" data-service="${service.name}">Book Now</button>
    `;
    carousel.appendChild(card);
});

// Add event listener for "Book Now" buttons
const bookNowButtons = document.querySelectorAll('.book-now');
bookNowButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default button behavior
        const serviceName = e.target.getAttribute('data-service');
        // Redirect to booking.php with the service name as a query parameter
        window.location.href = `booking.php?service=${encodeURIComponent(serviceName)}`;
    });
});

// Carousel Navigation
const prevServiceBtn = document.querySelector(".carousel-btn.prev");
const nextServiceBtn = document.querySelector(".carousel-btn.next");

prevServiceBtn.addEventListener("click", () => {
    carousel.scrollLeft -=  300; // Adjust scrolling distance
});

nextServiceBtn.addEventListener("click", () => {
    carousel.scrollLeft += 300;
});