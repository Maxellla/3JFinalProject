// Sample data for bookings and services
let bookings = [];
let services = [];

// Function to render bookings in the table
function renderBookings() {
    const tbody = document.querySelector('#manage-bookings tbody');
    tbody.innerHTML = ''; // Clear existing rows
    bookings.forEach((booking, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${booking.id}</td>
            <td>${booking.customerName}</td>
            <td>${booking.service}</td>
            <td>${booking.status}</td>
            <td>
                <button onclick="approveBooking(${index})">Approve</button>
                <button onclick="cancelBooking(${index})">Cancel</button>
                <button onclick="rescheduleBooking(${index})">Reschedule</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Function to approve a booking
function approveBooking(index) {
    bookings[index].status = 'Confirmed';
    renderBookings();
}

// Function to cancel a booking
function cancelBooking(index) {
    bookings[index].status = 'Cancelled';
    renderBookings();
}

// Function to reschedule a booking (for simplicity, just changing the status)
function rescheduleBooking(index) {
    bookings[index].status = 'Rescheduled';
    renderBookings();
}

// Function to add a new service
function addService(event) {
    event.preventDefault();
    const form = event.target;
    const newService = {
        name: form[0].value,
        description: form[1].value,
        price: form[2].value,
        duration: form[3].value,
    };
    services.push(newService);
    form.reset();
    renderServices();
}

// Function to render services
function renderServices() {
    const serviceList = document.querySelector('.service-list ul');
    serviceList.innerHTML = ''; // Clear existing services
    services.forEach((service, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${service.name} - ${service.description} - $${service.price} - ${service.duration}
            <button onclick="deleteService(${index})">Delete</button>
        `;
        serviceList.appendChild(li);
    });
}

// Function to delete a service
function deleteService(index) {
    services.splice(index, 1);
    renderServices();
}

// Event listeners
document.querySelector('.add-service form').addEventListener('submit', addService);

// Initial render
renderBookings();
renderServices();