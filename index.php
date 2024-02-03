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

    <?php

    $userName = "";

    $operand_1 = "";
    $operand_2 = "";
    $operand_3 = "";
    $result = "";
    $finalResult= "";

    $error = false;
    $errorMessage = "";

    $sum = true; //by default we sum 

    $historyArray = [];
    $OperationFound = false;
    $previousUser = "";
    $historyMessage = "This operation has been already done by " . $previousUser;





    // Check if the form has been submited and all the required values are present, then proceeds to assign it to the corresponding variables and execute the app logic.
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userName']) && isset($_GET['operand1']) && isset($_GET['operand2'])) {
        $userName = $_GET["userName"];
        $operand_1 = $_GET["operand1"];
        $operand_2 = $_GET["operand2"];

        if (isset($_GET["operand3"])) {
            $operand_3 = $_GET["operand3"];
        }


        if (empty($userName) || empty($operand_1) || empty($operand_2)) {
            $error = true;
            $errorMessage = "A username and the first two values are needed";
        }

        // check inputs contain only numbers or letters
        else if (!preg_match('/^[a-zA-Z0-9]+$/', $operand_1) || !preg_match('/^[a-zA-Z0-9]+$/', $operand_2) || (!empty($operand_3) && !preg_match('/^[a-zA-Z0-9]+$/', $operand_3))) {
            $error = true;
            $errorMessage = "Please, use only numbers and letters, special characters are not allowed.";
        }

        // search for letters
        if (preg_match('/[a-zA-Z]/', $operand_1) || preg_match('/[a-zA-Z]/', $operand_2) || preg_match('/[a-zA-Z]/', $operand_3)) {
            $sum = false;
        }

        // if no error and sum, we add. if not concatenate
        if (!$error && $sum === true) {
            $result = (int)$operand_1 + (int)$operand_2;

            if ($operand_3) {
                $result += (int)$operand_3;
            }

            $finalResult = (int)$result;
        } else if (!$error) {
            $finalResult = $operand_1 . $operand_2 . $operand_3;
        }

        echo $operand_1 . $operand_2 . $operand_3;
        echo "<br>";
        if ($error) {
            echo $errorMessage;
        }else{
            echo $finalResult;
        }
    }
    ?>

</body>

</html>