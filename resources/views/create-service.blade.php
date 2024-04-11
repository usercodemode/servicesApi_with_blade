<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Service</title>
</head>
<body>
    <h1>Create New Service</h1>

    <form id="service-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" min="0" id="price" name="price" required> (e.g., 19.99)
        <br>

        <label for="features">Features (Comma separated):</label>
        <textarea id="features" name="features" required></textarea>
        <br>

        <label for="demoURL">Demo URL:</label>
        <input type="text" id="demoURL" name="demoURL" required>
        <br>

        <label for="URL">Main URL:</label>
        <input type="text" id="URL" name="URL" required>
        <br>

        <button type="submit">Create Service</button>
    </form>

    <script>
        const token = localStorage.getItem('bearer_token'); // Assuming token is stored in local storage

        async function createService(serviceData) {
            const response = await fetch('/api/services', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json' // Specify JSON content
                },
                body: JSON.stringify(serviceData)
            });

            if (!response.ok) {
                console.error('Error creating service:', response.statusText);
                return;
            }

            const data = await response.json();
            alert(`Service created successfully`); // : ${data.service.name} Display success message
        }

        document.getElementById('service-form').addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(event.target);
            const serviceData = {
                name: formData.get('name'),
                description: formData.get('description'),
                price: parseFloat(formData.get('price')), // Parse price to a number
                features: formData.get('features'), // Split features into an array
                demoURL: formData.get('demoURL'),
                URL: formData.get('URL')
            };

            createService(serviceData);
        });
    </script>
</body>
</html>
