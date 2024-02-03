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
    }
    echo $userName . $operand_1 . $operand_2 . $operand_3;
?>

</body>

</html>