<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h1>Register</h1>
    <form id="register-form">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>

    <script>
        const form = document.getElementById('register-form');
        const errorMessageElement = document.createElement('div'); // Create error message element dynamically

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const jsonData = {
                name: name,
                email: email,
                password: password,
                password_confirmation: password
            };

            // Set up options for the fetch request
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' // Set content type to JSON
                },
                body: JSON.stringify(jsonData) // Convert JSON data to a string and set it as the request body
            };

            // Make the fetch request with the provided options
            fetch('http://localhost:8000/api/register', options)
                .then(response => {

                    if (response.status != 201) {
                        alert("Login Failed");
                    }

                    // Parse the response as JSON
                    return response.json();
                })
                .then(data => {
                    // Handle the JSON data
                    //var data = JSON.stringify(data)
                    //var user = JSON.parse(data);
                    // console.log(data);
                    // console.log(data.user.email);


                    console.log('Login successful:', data);
                    // Store the bearer token securely (if applicable)
                    localStorage.setItem('bearer_token', data.token); // Consider secure storage mechanisms
                    window.location.href = '/dashboard';
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

        });
    </script>
</body>

</html>
