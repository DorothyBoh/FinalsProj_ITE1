<?php
class Product
{
    private $pdo;
    private $lastError;

    // Constructor to initialize the PDO connection
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->lastError = '';
    }

    // Method to set last error message
    private function setLastError($message)
    {
        $this->lastError = $message;
    }

    // Method to get last error message
    public function getLastError()
    {
        return $this->lastError;
    }

    // Method to add a new product
    public function addProduct($productName, $price, $seriesNo)
    {
        // Prepare the query to insert a new product into the 'products' table
        $stmt = $this->pdo->prepare("INSERT INTO products (product_name, price, series_no) VALUES (?, ?, ?)");
        if ($stmt->execute([$productName, $price, $seriesNo])) {
            return true;
        } else {
            // Set error if insertion fails
            $this->setLastError('There was an error adding the product.');
            return false;
        }
    }

    // Method to fetch all products from the database
    public function fetchProducts()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns an array of all products
    }

    // Method to fetch a product by its series number
    public function getProductBySeriesNo($seriesNo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE series_no = ?");
        $stmt->execute([$seriesNo]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns a single product
    }

    // Method to check if a product already exists by name
    public function productExists($productName)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE product_name = ?");
        $stmt->execute([$productName]);
        return $stmt->fetchColumn() > 0;
    }

    // Method to check if a series number already exists
    public function seriesNoExists($seriesNo)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE series_no = ?");
        $stmt->execute([$seriesNo]);
        return $stmt->fetchColumn() > 0;
    }
}

?>
