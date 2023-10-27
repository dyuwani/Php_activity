<?php
// Define a common interface for transactions.
interface TransactionInterface {
    public function process($amount, $description);
}

// Create a base class (Transaction) and implement the interface.
class Transaction implements TransactionInterface {
    private $amount;
    private $description;

// Encapsulation
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
// Polymorphism
// Abstraction
    public function process($amount, $description) {
        $this->setAmount($amount);
        $this->setDescription($description);
    }
}

// Create a specialized transaction class (BankTransactions)
class BankTransactions extends Transaction {
// Inheritance
// Abstraction
    public function process($amount, $description) {
        parent::process($amount, $description);
        echo "Debit/Credit Transaction: {$this->getDescription()} - {$this->getAmount()}";
    }
}

// Create a specialized transaction class (RetailTransactions)
class RetailTransactions extends Transaction {
// Inheritance
// Abstraction
    public function process($amount, $description) {
        parent::process($amount, $description);
        echo "Sale/Return Transaction: {$this->getDescription()} - {$this->getAmount()}";
    }

    // Polymorphism
}

// Handle transactions based on the HTML form input.
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $transactionType = $_POST['transactionType'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $transaction = null;

// Create a switch based on the selected type, then set the Specific Transaction Class.
    switch ($transactionType) {
        case 'bank':
            $transaction = new BankTransactions();
            break;
        case 'retail':
            $transaction = new RetailTransactions();
            break;
        default:
            die("Invalid transaction type");
    }
// Set the value of each input using the setter method
    $transaction->process($amount, $description);
}
echo '<html><head><style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}
.transaction-box {
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
    margin: 20px;
}
</style></head><body>';

echo '<div class="transaction-box">';
echo '<h2>Transaction Result</h2>';
echo '<p>Transaction Type: ' . htmlspecialchars($transactionType) . '</p>';
echo '<p>Description: ' . htmlspecialchars($description) . '</p>';
echo '<p>Amount: ' . htmlspecialchars($amount) . '</p>';

// Output the specific transaction result
ob_start();
$transaction->process($amount, $description);
$result = ob_get_clean();

echo '<p>Result: ' . $result . '</p>';
echo '</div></body></html>';


?>
