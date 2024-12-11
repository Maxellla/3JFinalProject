document.addEventListener('DOMContentLoaded', () => {
   const serviceSelect = document.getElementById('service-select');
   const therapistSelect = document.getElementById('therapist-select');
   const datePicker = document.getElementById('date-picker');
   const timeSlots = document.getElementById('time-slots');
   const appointmentDetails = document.getElementById('appointment-details');
   const summaryDetails = document.getElementById('summary-details');
   const nextStep1 = document.getElementById('next-step-1');
   const nextStep2 = document.getElementById('next-step-2');
   const prevStep2 = document.getElementById('prev-step-2');
   const prevStep3 = document.getElementById('prev-step-3');
   const confirmBooking = document.getElementById('confirm-booking');

   let currentStep = 1;

   // Show the first step
   document.getElementById('step-1').style.display = 'block';

   // Update service summary
   serviceSelect.addEventListener('change', () => {
       const selectedService = serviceSelect.value;
       summaryDetails.textContent = `You have selected: ${selectedService}`;
   });

   // Next step from Step 1 to Step 2
   nextStep1.addEventListener('click', () => {
       if (serviceSelect.value && therapistSelect.value) {
           currentStep++;
           updateSteps();
       } else {
           alert('Please select both a service and a therapist.');
       }
   });

   // Next step from Step 2 to Step 3
   nextStep2.addEventListener('click', () => {
       if (datePicker.value) {
           currentStep++;
           updateSteps();
           loadAvailableTimeSlots();
       } else {
           alert('Please select a date.');
       }
   });

   // Previous step from Step 2 to Step 1
   prevStep2.addEventListener('click', () => {
       currentStep--;
       updateSteps();
   });

   // Previous step from Step 3 to Step 2
   prevStep3.addEventListener('click', () => {
       currentStep--;
       updateSteps();
   });

   // Confirm booking
   confirmBooking.addEventListener('click', (e) => {
       e.preventDefault();
       const paymentMethod = document.getElementById('payment-method').value;
       const promoCode = document.getElementById('promo-code').value;

       const appointment = {
           service: serviceSelect.value,
           therapist: therapistSelect.value,
           date: datePicker.value,
           time: timeSlots.value,
           paymentMethod: paymentMethod,
           promoCode: promoCode
       };

       // Save appointment to local storage
       const existingAppointments = JSON.parse(localStorage.getItem('upcomingAppointments')) || [];
       existingAppointments.push(appointment);
       localStorage.setItem('upcomingAppointments', JSON.stringify(existingAppointments));

       appointmentDetails.textContent = `
           Service: ${serviceSelect.value}
           Therapist: ${therapistSelect.value}
           Date: ${datePicker.value}
           Time: ${timeSlots.value}
           Payment Method: ${paymentMethod}
           Promo Code: ${promoCode}
       `;
       alert('Your appointment has been confirmed!');
   });

   // Function to update steps visibility
   function updateSteps() {
       document.querySelectorAll('.step').forEach((step, index) => {
           step.style.display = (index + 1 === currentStep) ? 'block' : 'none';
       });
   }

   // Function to load available time slots based on selected date
   function loadAvailableTimeSlots() {
       const selectedDate = datePicker.value;
       timeSlots.innerHTML = ''; // Clear previous options

       // Simulate loading time slots (replace with actual logic)
       const availableSlots = ['10:00 AM', '11:00 AM', '1:00 PM', '3:00 PM'];
       availableSlots.forEach(slot => {
           const option = document.createElement('option');
           option.value = slot;
           option.textContent = slot;
           timeSlots.appendChild(option);
       });
   }
});