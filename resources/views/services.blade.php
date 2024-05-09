<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Services</title>
</head>
<body>
    <h1>Available Services</h1>
    <ul id="services-list"></ul>

    <script>
        
        const token = localStorage.getItem('bearer_token'); // Assuming token is stored in local storage

        async function getServices() {
            const response = await fetch('/api/services', {
                headers: {
                    'Authorization': `Bearer ${token}` 
                    // Include Bearer token in Authorization header
                }
            });

            if (!response.ok) {
                console.error('Error fetching services:', response.statusText);
                return;
            }

            const services = await response.json();
            const serviceList = document.getElementById('services-list');

            services.forEach(service => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                <a href="${service.demoURL}"><h2>${service.name}</h2></a>
                    <p>${service.description}</p>
                    <button data-service-id="${service.id}">Subscribe</button>
                `;

                serviceList.appendChild(listItem);
            });
        }

        getServices(); // Call getServices function on page load

        document.addEventListener('click', async (event) => {
            if (event.target.tagName === 'BUTTON') {
                const serviceId = event.target.dataset.serviceId;

                try {
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
                    //console.log(data);
                    //data = JSON.parse(data);
                    //alert(data.name);
                    if (data.subscribed) {
                        alert(`You've already subscribed to this service.`);
                    }
                    else {
                        alert(`Successfully subscribed to service: ${data.service.name}`); // Display success message
                    }

                   
                } catch (error) {
                    console.error('Error subscribing:', error);
                    alert('Subscription failed. Please try again.'); // Display error message
                }
            }
        });
    </script>
</body>
</html>
