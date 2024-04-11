<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Subscriptions</title>
</head>
<body>
    <h1>My Subscriptions</h1>
    <ul id="services-list"></ul>

    <script>
        const token = localStorage.getItem('bearer_token'); // Assuming token is stored in local storage

        async function getUserServices() {
            const response = await fetch('/api/mySubscriptions/active', {
                headers: {
                    'Authorization': `Bearer ${token}` // Include Bearer token
                }
            });

            if (!response.ok) {
                console.error('Error fetching user services:', response.statusText);
                return;
            }

            const subscriptions = await response.json();
            const serviceList = document.getElementById('services-list');

            subscriptions.forEach(subscription => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    <a href="${subscription.service.URL}"><h2>${subscription.service.name}</h2></a>
                    <p>${subscription.service.description}</p>
                    <button data-service-id="${subscription.id}">Unsubscribe</button>
                `;

                serviceList.appendChild(listItem);
            });
        }

        getUserServices(); // Call getUserServices function on page load

        document.addEventListener('click', async (event) => {
            if (event.target.tagName === 'BUTTON') {
                const serviceId = event.target.dataset.serviceId;

                try {
                    const response = await fetch(`/api/subscriptions/cancel/${serviceId}`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}` // Include Bearer token
                        }
                    });

                    if (!response.ok) {
                        console.error('Error unsubscribing from service:', response.statusText);
                        return;
                    }

                    const data = await response.json();
                    alert(`Successfully unsubscribed from service`); // : ${data.service.name}` Display success message
                    getUserServices(); // Re-fetch services to update list
                    window.location.reload();
                } catch (error) {
                    console.error('Error unsubscribing:', error);
                    alert('Unsubscription failed. Please try again.'); // Display error message
                }
            }
        });
    </script>
</body>
</html>
