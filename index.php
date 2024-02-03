<?php
require_once(__DIR__ . "/utils.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <link rel="icon" type="image/png" href="assets/calc.png">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="body">
    <section>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
            <label for="userName" class="form-label">Please identify yourself</label>
            <input type="text" name="userName" id="userName" placeholder="Your name (required)" class="input" required>
            <br>
            <br>
            <input type="text" name="operand1" id="operand1" placeholder="First input (required)" class="input" required>
            <label class="operator-label">+</label>
            <input type="text" name="operand2" id="operand2" placeholder="Second input (required)" class="input" required>
            <label class="operator-label">+</label>
            <input type="text" name="operand3" id="operand3" placeholder="Third input (optional)" class="input">
            <button type="submit" class="calculate-button">=</button>
        </form>

        <?php
        // Check the submission of the form and assing inputs to variables.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["operand1"]) && isset($_POST["operand2"])) {
            $userName = $_POST["userName"];
            $operand_1 = $_POST["operand1"];
            $operand_2 = $_POST["operand2"];
            $operand_3 = isset($_POST["operand3"]) ? $_POST["operand3"] : "";

            // Process the operation and obtain the result.
            $result = processOperation($userName, $operand_1, $operand_2, $operand_3);

            // Display the result.
            echo  $result;
        }
        // Unset the session variables to clean the operations history if button is pressed.
        if (isset($_POST['clean_session'])) {
            session_unset();
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
            <button type="submit" name="clean_session" class="delete-history-button">Delete operations history</button>
        </form>

    </section>
</body>

</html>