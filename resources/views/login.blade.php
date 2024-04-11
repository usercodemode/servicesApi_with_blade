<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form id="login-form">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <script>
        const form = document.getElementById('login-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            //const email = document.getElementById('email').value;
            //const password = document.getElementById('password').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            //const email = 'jin@xyz.com';
            //const password = '12345678a';
            //alert(email);

            // Your JSON data
            // const jsonData = {
            //     email: 'jin@xyz.com',
            //     password: '12345678a'
            // };

            const jsonData = {
                email: email,
                password: password
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
            fetch('http://localhost:8000/api/login', options)
                .then(response => {

                    if (response.status != 200) {
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
                    window.location.href = '/services'; 
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Fetch error:', error);
                });

        });
    </script>
</body>

</html>
