<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to Service</title>
</head>
<body>
    <h1>Subscribe to Service</h1>

    <select id="service-select">
        </select>

    <button id="subscribe-btn">Subscribe</button>

    <script>
        const token = localStorage.getItem('access_token'); // Assuming token is stored in local storage

        async function getServices() {
            const response = await fetch('/api/services', {
                headers: {
                    'Authorization': `Bearer ${token}` // Include Bearer token
                }
            });

            if (!response.ok) {
                console.error('Error fetching services:', response.statusText);
                return;
            }

            const services = await response.json();
            const serviceSelect = document.getElementById('service-select');

            services.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.name;
                serviceSelect.appendChild(option);
            });
        }

        async function checkSubscription(serviceId) {
            const response = await fetch(`/api/user/subscriptions/check/${serviceId}`, {
                headers: {
                    'Authorization': `Bearer ${token}` // Include Bearer token
                }
            });

            if (!response.ok) {
                console.error('Error checking subscription:', response.statusText);
                return;
            }

            const data = await response.json();
            return data.subscribed; // Returns true if already subscribed
        }

        async function subscribeToService(serviceId) {
            const response = await fetch(`/api/subscriptions/subscribe/${serviceId}`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}` // Include Bearer token
                }
            });

            if (!response.ok) {
                console.error('Error subscribing to service:', response.statusText);
                return;
            }

            const data = await response.json();
            alert(`Successfully subscribed to service: ${data.service.name}`); // Display success message
        }

        document.addEventListener('DOMContentLoaded', getServices); // Fetch services on page load

        document.getElementById('subscribe-btn').addEventListener('click', async () => {
            const selectedServiceId = document.getElementById('service-select').value;

            const isSubscribed = await checkSubscription(selectedServiceId);
            if (isSubscribed) {
                alert('You are already subscribed to this service.');
                return;
            }

            subscribeToService(selectedServiceId);
        });
    </script>
</body>
</html>
