<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "checkpoint";
$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $db);




$create_Table_1 = mysqli_query($connect ,"CREATE TABLE IF NOT EXISTS Customer(
    customer_id INt PRIMARY KEY,
    cl_name VARCHAR(20) NOT NULL,
    customer_tel INT(8)
);");
$create_Table_2 = mysqli_query($connect ,"CREATE TABLE IF NOT EXISTS Product(
    product_id INt PRIMARY KEY,
    product_name VARCHAR(20) NOT NULL,
    catagory varchar(20),
    Price DECIMAL(10, 2) CHECK (Price > 0)
);");
$create_Table_3 = mysqli_query($connect ,"CREATE TABLE IF NOT EXISTS Orders(
    customer_id INT,
    product_id INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id),
    FOREIGN KEY (product_id) REFERENCES Product(product_id),
    OrderDate DATE,
    quantity INT,
    total_amount INT
);");


$req_1 = mysqli_query($connect, "SELECT* FROM Customer");
//Fecth_Arr($req_1, 'cl_name');

$req_2 = mysqli_query($connect, "SELECT product_name, catagory FROM Product WHERE Price >= 5000 AND Price <= 10000");
//Fecth_Arr($req_2, 'product_name');

$req_3 = mysqli_query($connect, "SELECT* FROM Product ORDER BY Price DESC");
//Fecth_Arr($req_3, 'product_name');

$req_4 = mysqli_query($connect, "SELECT COUNT(*) as total FROM Orders");
//Fecth_Arr($req_4, 'total');

$req_4_2 = mysqli_query($connect, "SELECT AVG(p.Price) AS avg FROM Orders o JOIN Product p ON o.product_id = p.product_id");
//Fecth_Arr($req_4_2, 'avg');

$req_4_3 = mysqli_query($connect, "SELECT SUM(p.Price) AS high FROM Orders o JOIN Product p ON o.product_id = p.product_id ORDER BY high DESC");
//Fecth_Arr($req_4_3, 'high');

$req_4_4 = mysqli_query($connect, "SELECT SUM(p.Price) AS low FROM Orders o JOIN Product p ON o.product_id = p.product_id ORDER BY low ASC");
//Fecth_Arr($req_4_4, 'low');


$req_5 = mysqli_query($connect, "SELECT c.customer_id as id FROM Orders o JOIN Customer c ON o.customer_id = c.customer_id GROUP BY c.customer_id HAVING COUNT(c.customer_id) >= 2");
//Fecth_Arr($req_5, 'id');

$req_6 = mysqli_query($connect, "SELECT YEAR(OrderDate) AS yr, MONTH(OrderDate) AS mn, COUNT(*) AS or_count
    FROM Orders
    WHERE
    YEAR(OrderDate) = 2020
    GROUP BY YEAR(OrderDate), MONTH(OrderDate)
");
//Fecth_Arr($req_6, 'or_count');

$req_7 = mysqli_query($connect, "SELECT DISTINCT p.product_name AS pn, c.cl_name AS cn, o.OrderDate as od
    FROM Orders o JOIN Product p ON o.product_id = p.product_id
    JOIN Customer c ON o.customer_id = c.customer_id    
");
// Fecth_Arr($req_7, 'pn');
// Fecth_Arr($req_7, 'cn');
// Fecth_Arr($req_7, 'od');

$req_8 = mysqli_query($connect, "SELECT COUNT(*) as cn FROM Orders o
    Where o.OrderDate >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND o.OrderDate < CURDATE()
");
//Fecth_Arr($req_8, 'cn');

$req_9 = mysqli_query($connect, "SELECT c.customer_id
    FROM Customer c
    LEFT JOIN Orders o ON c.customer_id = o.customer_id
    WHERE o.customer_id IS NULL");
Fecth_Arr($req_9, 'customer_id');



function Fecth_Arr($req_, $val){
    if ($req_) {
    
        while ($row = mysqli_fetch_assoc($req_)) {        
            echo $row[$val] . "<br>";
        }
    } else {    
        echo "Error executing query: " . mysqli_error($connect);
    }
}

?>

