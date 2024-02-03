<?php
require_once(__DIR__ . "/utils.php");
require_once(__DIR__ . "/config.php");
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
    <script src="https://kit.fontawesome.com/a28e911298.js" crossorigin="anonymous"></script>
</head>

<body class="body">
    <section>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
            <label for="userName" class="label">Please identify yourself</label>
            <input type="text" name="userName" id="userName" placeholder="Your name (required)" class="input" required>
            <br>
            <label class="label"> Introduce only alphanumeric characters</label>
            <input type="text" name="operand1" id="operand1" placeholder="First input (required)" class="input" required>
            <label class="label">+</label>
            <input type="text" name="operand2" id="operand2" placeholder="Second input (required)" class="input" required>
            <label class="label">+</label>
            <input type="text" name="operand3" id="operand3" placeholder="Third input (optional)" class="input">
            <button type="submit" class="calculate button">=</button>
        </form>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
            <button type="submit" name="clean_session" class="clean button">Delete operations history  <i class="fa-solid fa-trash-can"></i></button>
        </form>

    </section>

    <section class="results">
        <?php
        // Check the submission of the form and assign inputs to variables.
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
        </section>
        

</body>

</html>