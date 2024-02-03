<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

/**
 * This function checks if all the characters in the parameter are alphanumeric.
 * @param string $value the name parameter.
 * @return boolean true if all characters are valid.
 */
function isValidAlphanumeric($value)
{
    return preg_match('/^[a-zA-Z0-9]+$/', $value);
}

/**
 * This is function search for an alphabetic character.
 * @param string $value corresponding to a form input.
 * @return boolean true if a letter is found.
 */
function containsLetters($value)
{
    return preg_match('/[a-zA-Z]/', $value);
}

/**
 * This is function contains all the logic of the app.
 * @param string $userName The user's name input.
 * @param string $operand1 The first operand input.
 * @param string $operand2 The second operand input.
 * @param string $operand3 The optional third operand input.
 * @return $returnContent The result of the sum/concatenation, includes a message if the same operand arguments have been introduced before. 
 */
function processOperation($userName, $operand_1, $operand_2, $operand_3)
{
    $sum = true;
    $result = "";
    $finalResult = "";
    $error = false;
    $errorMessage = "";
    $historyArray = (array) (isset($_SESSION["sessionList"]) ? $_SESSION["sessionList"] : []);
    $OperationFound = false;
    $historyMessage = "";

    // Check if all required values are assigned.
    if (empty($userName) || empty($operand_1) || empty($operand_2)) {
        $error = true;
        $errorMessage = "A username and the first two values are needed";
    }

    // Check if any not allowed characters has been submited.
    else if (!isValidAlphanumeric($operand_1) || !isValidAlphanumeric($operand_2) || (!empty($operand_3) && !isValidAlphanumeric($operand_3))) {
        $error = true;
        $errorMessage = "Please, use only numbers and letters, special characters are not allowed. (Decimals aren't allowed either)";
    }

    if ($errorMessage) {
        return $errorMessage;
    }

    // Check if any of the inputs contains alphabetical characters to select if it is a sum or a concatenation.
    if (containsLetters($operand_1) || containsLetters($operand_2) || containsLetters($operand_3)) {
        $sum = false;
    }

    /*
    *   Check if this operation has been registered in the historyArray,
    *   if it does, the result and previous user who submited the same operation are accessible.
    *   If any operation is stored on the session, no search will be done.
    */
    for ($i = 0; $i < count($historyArray); $i++) {

        $currentContent = $historyArray[$i]->getContent();

        if ($currentContent == implode("+", [$operand_1, $operand_2]) || $currentContent == implode("+", [$operand_1, $operand_2, $operand_3])) {

            $OperationFound = true;
            $historyMessage = "This operation has been already done by " . $historyArray[$i]->getUser();
            $finalResult = $historyArray[$i]->getResult();

            break;
        } else {

            $OperationFound = false;
        }
    }

    // If the same operation has ben found in the historyArray, the calculation or concatenation will be skipped.
    if (!$OperationFound) {

        // Check for errors and perform addition if it's a sum, or concatenate if not.
        if (!$error && $sum === true) {
            $result = (int)$operand_1 + (int)$operand_2;

            if ($operand_3) {
                $result += (int)$operand_3;
            }

            $finalResult = (int)$result;
        } else if (!$error) {
            $finalResult = $operand_1 . $operand_2 . $operand_3;
        }

        //If no error is found, a new Operation instance is stored in the historyArray.
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
    $returnContent = $OperationFound ?  $historyMessage . " and the result is : " . $finalResult : $finalResult;

    return $returnContent;
}
