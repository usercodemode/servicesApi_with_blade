<!DOCTYPE html>
<html>

<head>
    <title>Calculator</title>
</head>

<body>
    <h1>Calculator (Add Number)</h1>
        <div class="form-group">
            <label for="firstNumber">First Number:</label>
            <input type="number" id="firstNumber" name="firstNumber" required>
        </div>
        <div class="form-group">
            <label for="password">Second Number:</label>
            <input type="number" id="secondNumber" name="secondNumber" required>
        </div>
        <button type="submit" onclick="calculator()">Calculate</button>
        <p id="output"></p>
    

    <script>
        const form = document.getElementById('Calculator-form');
            
        function calculator(){
            //const email = document.getElementById('email').value;
            //const password = document.getElementById('password').value;
            const firstNumber = Math.floor(document.getElementById('firstNumber').value);
            const secondNumber = Math.floor(document.getElementById('secondNumber').value);

            let output = firstNumber + secondNumber;

            document.getElementById('output').innerText = output;
        };

    </script>
</body>

</html>
