<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <label for="userName">Please identify yourself</label>
        <input type="text" name="userName" id="userName" placeholder="Your name (required)" required>
        <br>
        <input type="text" name="operand1" id="operand1" placeholder="First input (required)" required>
        <label>+</label>
        <input type="text" name="operand2" id="operand2" placeholder="Second input (required)" required>
        <label>+</label>
        <input type="text" name="operand3" id="operand3" placeholder="Third input (optional)">
        <button type="submit">=</button>
    </form>
</body>

</html>