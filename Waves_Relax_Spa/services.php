<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List - Waves Relax Spa</title>

    <!-- Adding CSS -->
    <link rel="stylesheet" href="./css/style-services.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/7a6c6b42a6.js" crossorigin="anonymous"></script>
</head>

<body>
    <main>
        <section class="service-list">
            <h2>Our Services</h2>
            <div class="filters">
                <h3>Filters</h3>
                <label for="service-type">Service Type:</label>
                <select id="service-type">
                    <option value="All">All</option>
                    <option value="Relaxation Massages">Relaxation Massages</option>
                    <option value="Therapeutic Massages">Therapeutic Massages</option>
                    <option value="Specialty Massages">Specialty Massages</option>
                    <option value="Additional Treatments">Additional Treatments</option>
                </select>

                <label for="price-range">Price Range:</label>
                <input type="range" id="price-range" min="400" max="1000" step="100" value="1000">
                <span id="price-value">₱400 - ₱1000</span>

                <label for="duration">Duration:</label>
                <select id="duration">
                    <option value="all">All</option>
                    <option value="30">30 minutes</option>
                    <option value="60">60 minutes</option>
                    <option value="90">90 minutes</option>
                </select>
            </div>

            <div class="service-cards" id="service-cards">
                <!-- Service cards will be dynamically generated here -->
            </div>
        </section>
    </main>

    <script src="./js/services.js"></script>
</body>

</html>
