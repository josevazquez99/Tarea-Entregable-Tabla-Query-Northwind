<?php

function connection(){
    $host = "localhost:3306";
    $user = "root";
    $pass = "root";

    $bd = "northwind";

    $connect=mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $bd);

    return $connect;
}

$con = connection();

$sql = "SELECT p.ProductName, c.CategoryName, p.UnitPrice 
        FROM Products p INNER JOIN Categories c ON p.CategoryID = c.CategoryID
        WHERE p.UnitPrice > ( SELECT AVG(UnitPrice)
                            FROM Products 
                            WHERE CategoryID = p.CategoryID )";
$query = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a datos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                    <tr>
                        <td><?= $row['ProductName'] ?></td>
                        <td><?= $row['CategoryName'] ?></td>
                        <td><?= $row['UnitPrice'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
