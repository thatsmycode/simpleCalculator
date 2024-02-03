<?php
session_start();

// Unset the session variables to clean the operations history.
if (isset($_POST['clean_session'])) {
    session_unset();
}
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="form">
        <label for="userName" class="label">Please identify yourself</label>
        <input type="text" name="userName" id="userName" placeholder="Your name (required)" required class="input">
        <br>
        <label class="label"> Introduce only alphanumeric characters</label>
        <input type="text" name="operand1" id="operand1" placeholder="First input (required)" required class="input">
        <label class="label">+</label>
        <input type="text" name="operand2" id="operand2" placeholder="Second input (required)" required class="input">
        <label class="label">+</label>
        <input type="text" name="operand3" id="operand3" placeholder="Third input (optional)" class="input">
        <button type="submit" class="calculate-button">=</button>
    </form>

    <?php

    $userName = "";

    $operand_1 = "";
    $operand_2 = "";
    $operand_3 = "";
    $result = "";
    $finalResult = "";

    $error = false;
    $errorMessage = "";

    $sum = true; //by default we sum 

    $historyArray = (array) (isset($_SESSION["sessionList"]) ? $_SESSION["sessionList"] : []);
    $OperationFound = false;
    $previousUser = "";
    $historyMessage = "This operation has been already done by " . $previousUser;

    class Operation
    {

        private $user = "";
        private $content = [];
        private $result = "";

        public function __construct($user, $content, $result)
        {
            $this->user = $user;
            $this->content = $content;
            $this->result = $result;
        }
        public function getUser()
        {
            return $this->user;
        }
        public function getContent()
        {
            return implode("+", $this->content);
        }
        public function getResult()
        {
            return $this->result;
        }
    }



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

        //if history array is not empy, search for coincidences
        for ($i = 0; $i < count($historyArray); $i++) {

            $currentContent = $historyArray[$i]->getContent();

            if ($currentContent == implode("+", [$operand_1, $operand_2]) || $currentContent == implode("+", [$operand_1, $operand_2, $operand_3])) {
                $OperationFound = true;
                $previousUser = $historyArray[$i]->getUser();
                $finalResult = $historyArray[$i]->getResult();
                break;
            } else {
                $previousUser = "";
                $OperationFound = false;
            }
        }
        //if its not found we execute the calculations, if not we skip
        if (!$OperationFound) {

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

            // If no error is found, a new Operation instance is stored in the historyArray.
            if (!$error) {

                $operands = [$operand_1, $operand_2];

                if (isset($operand_3)) {
                    array_push($operands, $operand_3);
                }

                $newOperation = new Operation($userName, $operands, $finalResult);

                $historyArray[] = $newOperation;

                $_SESSION["sessionList"] = $historyArray;
            }
        }
    ?>
        

        <section class="results">
        <?php

        if ($error) {
            echo $errorMessage;
        } else {

            if ($OperationFound) {
                echo "This operation was previously submited by: " . $previousUser;
            }
            echo "<br>";
            echo $finalResult;
        }
    }
    
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form">
            <button type="submit" name="clean_session" >Delete operations history</button>
        </form>
        </section>
</body>

</html>