<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Result</title>
    <script src="https://kit.fontawesome.com/7e03f31473.js" crossorigin="anonymous"></script>
    <style>
        table,
        td,
        form {
            border:1px solid black;
            padding: 10px;
            font-weight: bold;
            color: black;
            margin:10px;
        }
    </style>
    
</head>
<?php
$server = "localhost";
$user = "root";
$passer = "";
$dbname = "cpu";
try {
    $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $passer);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT * FROM cpu_info WHERE name = :name");
    $stmt->bindParam(':name', $_SESSION["cpu1"]);
    $stmt->execute();
    $row1 = $stmt->rowCount();
    $res1 = $stmt->fetch();

    $stmt->bindParam(':name', $_SESSION["cpu2"]);
    $stmt->execute();
    $row2 = $stmt->rowCount();
    $res2 = $stmt->fetch();
    $conn = null;
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<body style="background-color:darkgray">
    <div style="background-color:blueviolet;">
        <nav class="navbar navbar-expand-lg" style="background-color:blueviolet;">
            <a class="navbar-brand text-light text-xl btn" role="button" href="#">Result</a>
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="navbar-brand text-light text-xl btn" role="button" href="home.php"><i class="fa-solid fa-house-user" style="margin-right:5px"></i>Home</a>
                        <a class="navbar-brand text-light text-xl btn" role="button" href="search.php"><i class="fa-solid fa-magnifying-glass"style="margin-right:5px"></i>Search</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div>
        <?php
        $max_core = 20;
        $max_thread = 32;
        $max_clock = 10.0;
        $max_cache = 50;
        $max_score = 100;
        $core_weight = 70;
        $thread_weight = 90;
        $clock_weight = 60;
        $cache_weight = 80;
        $max = $core_weight * $max_score + $thread_weight * $max_score + $clock_weight * $max_score + $cache_weight * $max_score;

        $cpu1_core_score = $core_weight * $max_score * $res1["core"] / $max_core;
        $cpu2_core_score = $core_weight * $max_score * $res2["core"] / $max_core ;

        $cpu1_thread_score = $thread_weight * $max_score * $res1["thread"] / $max_thread; 
        $cpu2_thread_score = $thread_weight * $max_score * $res2["thread"] / $max_thread;

        $cpu1_clock_score = $clock_weight * $max_score * $res1["clock"] / $max_clock;
        $cpu2_clock_score = $clock_weight * $max_score * $res2["clock"] /  $max_clock ;

        $cpu1_cache_score = $cache_weight * $max_score * $res1["cache_size"] / $max_cache;
        $cpu2_cache_score = $cache_weight * $max_score * $res2["cache_size"] / $max_cache;

        $cpu1_total = $cpu1_cache_score + $cpu1_clock_score + $cpu1_thread_score + $cpu1_core_score;
        $cpu2_total = $cpu2_cache_score + $cpu2_clock_score + $cpu2_thread_score + $cpu2_core_score;

        $cpu1_par = $cpu1_total / $max * 100;
        $cpu2_par = $cpu2_total / $max * 100;

        $CPI1 = $res1["Instruction_count"] * $res1["cycle"] / $res1["Instruction_count"];
        $CPI2 = $res2["Instruction_count"] * $res1["cycle"] / $res1["Instruction_count"];

        $CPU1 = $res1["Instruction_count"] * pow(10,6) * $CPI1 / $res1["clock"] * pow(10,9);
        $CPU2 = $res2["Instruction_count"] * pow(10,6) * $CPI2 / $res2["clock"] * pow(10,9);

        $MIPS1 = $res1["clock"] * pow(10,9) / $CPI1 * pow(10,6);
        $MIPS2 = $res1["clock"] * pow(10,9) / $CPI2 * pow(10,6);

        ?>
        
        <h2 style="margin:10px 0px 10px 20px;">CPU Specification Comparison:</h2>
        <div style="display:grid;grid-template-columns: 2fr 2fr;padding:10px">
            <table>
                <tr>
                    <th colspan="2" style="text-align:center;border-right:1px solid black">CPU-1</th>
                    <th style="text-align:center">Scors</th>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>CPU Name:</td>
                    <td><?php echo $res1["name"];?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>Number of cores:</td>
                    <td><?php echo $res1["core"];?></td>
                    <td><?php echo $cpu1_core_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>Number of threads:</td>
                    <td><?php echo $res1["thread"];?></td>
                    <td><?php echo $cpu1_thread_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-gauge" style="margin-right:10px;"></i>CPU Clock Speed (Ghz):</td>
                    <td><?php echo $res1["clock"];?></td>
                    <td><?php echo $cpu1_clock_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-memory" style="margin-right:10px;"></i>Cache memory type:</td>
                    <td><?php echo $res1["cache_type"];?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-memory" style="margin-right:10px;"></i>Cache memory size:</td>
                    <td><?php echo $res1["cache_size"];?></td>
                    <td><?php echo $cpu1_cache_score;?></td>
                </tr>
                <tr>
                    <td colspan="2">Total Score:</td>
                    <td><?php echo $cpu1_total;?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th colspan="2" style="text-align:center;border-right:1px solid black">CPU-2</th>
                    <th style="text-align:center">Scors</th>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>CPU Name:</td>
                    <td><?php echo $res2["name"];?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>Number of cores:</td>
                    <td><?php echo $res2["core"];?></td>
                    <td><?php echo $cpu2_core_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-microchip" style="margin-right:10px;"></i>Number of threads:</td>
                    <td><?php echo $res2["thread"];?></td>
                    <td><?php echo $cpu2_thread_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-gauge" style="margin-right:10px;"></i>CPU Clock Speed (Ghz):</td>
                    <td><?php echo $res2["clock"];?></td>
                    <td><?php echo $cpu2_clock_score;?></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-memory" style="margin-right:10px;"></i>Cache memory type:</td>
                    <td><?php echo $res2["cache_type"];?></td>
                    <td></td>
                </tr>
                <tr>
                    <td><i class="fa-solid fa-memory" style="margin-right:10px;"></i>Cache memory size:</td>
                    <td><?php echo $res2["cache_size"];?></td>
                    <td><?php echo $cpu2_cache_score;?></td>
                </tr>
                <tr>
                    <td colspan="2">Total Score:</td>
                    <td><?php echo $cpu2_total;?></td>
                </tr>
            </table>
        </div>
        <div style="display:grid;grid-template-columns: 2fr 2fr;padding:10px">
        <ul>
            <li>
            <h4>CPU-1 Score Parcentage: <span style="color:red"><?php echo $cpu1_par; ?> % </span></h4>
            </li>
        </ul>
        <ul>
            <li>
            <h4>CPU-2 Score Parcentage: <span style="color:red"><?php echo $cpu2_par; ?> % </span></h4>
            </li>
        </ul>
        </div>
        <hr style="border: 2px solid black;">
        <h2 style="margin:10px 0px 10px 20px;">CPU Performance Comparison:</h2>
        <div style="display:grid;grid-template-columns: 2fr 2fr;padding:10px">
        <table>
                <tr>
                    <th style="text-align:center;border-right:1px solid black">CPU-1</th>
                    <th style="text-align:center">Value</th>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>CPI:</td>
                    <td><?php echo $CPI1;?></td>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>CPU:</td>
                    <td><?php echo $CPU1;?></td>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>MIPS:</td>
                    <td><?php echo $MIPS1;?></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th style="text-align:center;border-right:1px solid black">CPU-2</th>
                    <th style="text-align:center">Value</th>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>CPI:</td>
                    <td><?php echo $CPI2;?></td>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>CPU:</td>
                    <td><?php echo $CPU2;?></td>
                </tr>
                <tr>
                    <td><i class="fa-sharp fa-solid fa-infinity" style="margin-right:10px;"></i>MIPS:</td>
                    <td><?php echo $MIPS2;?></td>
                </tr>
            </table>
        </div>
        <h2 style="margin:10px 0px 10px 20px;">Final Result:</h2>
        <ul style="color:red">
            <li>
                <h4 >
                    <?php 
                        if($CPU1 == $CPU2){
                            if($MIPS1 == $MIPS2)
                                echo "Both".$res1["name"]."and ".$res2["name"]." are equal.";
                            else if($MIPS1 > $MIPS2)
                                echo $res1["name"]." is better than ".$res2["name"];
                            else
                                echo $res2["name"]." is better than ". $res1["name"];
                        }
                        else if($CPU1> $CPU2){
                            echo $res1["name"]." is better than ".$res2["name"];
                        }
                        else{
                            echo $res2["name"]." is better than ".$res1["name"];
                        }
                    ?>
                </h4>
            </li>
        </ul>
    </div>
    <footer style="background-color:blueviolet;margin-top:18%">
    <br>
        <p style="text-align: center;color:white;
            font-weight: bold;"> <i class="fa-regular fa-copyright" style="margin-right:5px"></i>Copyright by Saiful, Sajib, Sudipta</p>
        <br>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
<?php
session_destroy();
?>