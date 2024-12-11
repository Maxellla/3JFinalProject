// Sample data for appointments and promotions
let upcomingAppointments = [
    { id: 1, date: '2023-10-15', time: '10:00 AM', service: 'Massage Therapy', status: 'Upcoming' },
    { id: 2, date: '2023-10-20', time: '2:00 PM', service: 'Facial Treatment', status: 'Upcoming' }
];

let pastAppointments = [
    { id: 3, date: '2023-09-10', time: '11:00 AM', service: 'Yoga Class', review: '' },
    { id: 4, date: '2023-09-15', time: '1:00 PM', service: 'Acupuncture', review: '' }
];

let promotions = [
    { id: 1, description: '10% off your next appointment!', validUntil: '2023-12-31' },
    { id: 2, description: 'Loyalty Reward: Get a free service after 5 appointments!', validUntil: '2023-12-31' }
];

// Function to render upcoming appointments
function renderUpcomingAppointments() {
    const appointmentList = document.querySelector('#upcoming-appointments .appointment-list');
    appointmentList.innerHTML = ''; // Clear existing appointments
    upcomingAppointments.forEach(appointment => {
        const div = document.createElement('div');
        div.className = 'appointment';
        div.innerHTML = `
            <strong>${appointment.service}</strong> on ${appointment.date} at ${appointment.time}
            <button onclick="cancelAppointment(${appointment.id})">Cancel</button>
            <button onclick="showRescheduleModal(${appointment.id})">Reschedule</button>
        `;
        appointmentList.appendChild(div);
    });
}

// Function to render past appointments
function renderPastAppointments() {
    const appointmentList = document.querySelector('#past-appointments .appointment-list');
    appointmentList.innerHTML = ''; // Clear existing appointments
    pastAppointments.forEach(appointment => {
        const div = document.createElement('div');
        div.className = 'appointment';
        div.innerHTML = `
            <strong>${appointment.service}</strong> on ${appointment.date} at ${appointment.time}
            <textarea placeholder="Leave a review" oninput="updateReview(${appointment.id}, this.value)">${appointment.review}</textarea>
        `;
        appointmentList.appendChild(div);
    });
}

// Function to update review for past appointments
function updateReview(id, review) {
    const appointment = pastAppointments.find(app => app.id === id);
    if (appointment) {
        appointment.review = review;
    }
}

// Function to cancel an appointment
function cancelAppointment(id) {
    upcomingAppointments = upcomingAppointments.filter(app => app.id !== id);
    renderUpcomingAppointments();
    alert('Appointment canceled successfully.');
}

// Function to show reschedule modal
function showRescheduleModal(id) {
    const appointment = upcomingAppointments.find(app => app.id === id);
    if (appointment) {
        const newDate = prompt('Enter new date (YYYY-MM-DD):', appointment.date);
        const newTime = prompt('Enter new time (HH:MM AM/PM):', appointment.time);
        if (newDate && newTime) {
            appointment.date = newDate;
            appointment.time = newTime;
            renderUpcomingAppointments();
            alert('Appointment rescheduled successfully.');
        } else {
            alert('Rescheduling canceled.');
        }
    }
}

// Function to update profile
function updateProfile(event) {
    event.preventDefault();
    const form = event.target;
    const name = form[0].value;
    const email = form[1].value;
    const phone = form[2].value;

    // Simple validation
    if (!name || !email || !phone) {
        alert('All fields are required.');
        return;
    }

    // Here you would typically send this data to the server
    alert(`Profile updated: ${name}, ${email}, ${phone}`);
    // Store in local storage for demonstration
    localStorage.setItem('userProfile', JSON.stringify({ name, email, phone }));
}

// Function to change password
function changePassword(event) {
    event.preventDefault();
    const form = event.target;
 const currentPassword = form[0].value;
    const newPassword = form[1].value;
    const confirmPassword = form[2].value;

    // Simple validation
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('All fields are required.');
        return;
    }

    if (newPassword === confirmPassword) {
        // Here you would typically send this data to the server
        alert('Password changed successfully!');
        // Store new password in local storage for demonstration
        localStorage.setItem('userPassword', newPassword);
    } else {
        alert('New passwords do not match.');
    }
}

// Function to render promotions
function renderPromotions() {
    const promotionList = document.querySelector('#promotions .promotion-list');
    promotionList.innerHTML = ''; // Clear existing promotions
    promotions.forEach(promotion => {
        const div = document.createElement('div');
        div.className = 'promotion';
        div.innerHTML = `
            <p>${promotion.description} (Valid until: ${promotion.validUntil})</p>
        `;
        promotionList.appendChild(div);
    });
}

// Event listeners
document.getElementById('profile-form').addEventListener('submit', updateProfile);
document.getElementById('password-form').addEventListener('submit', changePassword);

// Initial render
renderUpcomingAppointments();
renderPastAppointments();
renderPromotions();