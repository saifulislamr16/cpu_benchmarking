<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>CPU Info</title>
    <script src="https://kit.fontawesome.com/7e03f31473.js" crossorigin="anonymous"></script>
    <style>
        table,
        td,
        form {
            padding: 10px;
            font-weight: bold;
            color: black;
        }
    </style>
</head>
<?php
$server = "localhost";
$user = "root";
$passer = "";
$dbname = "cpu";
try {
    if (!empty($_POST)) {
        $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $passer);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO cpu_info (name, core, thread, clock, cache_type, cache_size, bus_speed, Instruction_count, cycle) 
        VALUES (:name, :core, :thread, :clock, :cache_type, :cache_size, :bus_speed, :instruction_count, :cycle)");

        $stmt->bindParam(':name', $_POST["name"]);
        $stmt->bindParam(':core', $_POST["core"]);
        $stmt->bindParam(':thread', $_POST["thread"]);
        $stmt->bindParam(':clock', $_POST["clk"]);
        $stmt->bindParam(':cache_type', $_POST["type"]);
        $stmt->bindParam(':cache_size', $_POST["cache"]);
        $stmt->bindParam(':bus_speed', $_POST["bus"]);
        $stmt->bindParam(':instruction_count', $_POST["instructions"]);
        $stmt->bindParam(':cycle', $_POST["ins_per_cycle"]);

        $stmt->execute();
        $row = $stmt->rowCount();

        $conn == null;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<body style="background-color:darkgray">
<div style="background-color:blueviolet;">
<nav class="navbar navbar-expand-lg" style="background-color:blueviolet;">
<a class="navbar-brand text-light text-xl btn" role="button" href="#">CPU Information Form</a>
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavAltMarkup">
      <div class="navbar-nav">
      <a class="navbar-brand text-light text-xl btn" role="button" href="home.php"><i class="fa-solid fa-house-user" style="margin-right:5px"></i>Home</a>
      </div>
    </div>
  </div>
</nav>
</div>
    <div style="padding: 10px; margin:20px 500px 20px 400px;background-color:pink; border-radius:25px">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <table>
                <tr>
                    <td>
                        <label>Cpu Name:</label>
                    </td>
                    <td>
                        <input type="text" name="name" placeholder="Enter cpu name" size="25" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Number of Core:</label>
                    </td>
                    <td>
                        <input type="text" name="core" placeholder="Enter number of cores" size="25" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Number of threads:</label>
                    </td>
                    <td>
                        <input type="text" name="thread" placeholder="Enter number of thread" size="25" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Maximum clock speed (Ghz):</label>
                    </td>
                    <td>
                       <select name="clk" >
                        <option value="1.0">1.0Ghz</option>
                        <option value="2.0">2.0Ghz</option>
                        <option value="3.0">3.0Ghz</option>
                       </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Cache Memory type:</label>
                    </td>
                    <td>
                        <input type="checkbox" value="L1" name="type">L1</option>
                        <input type="checkbox" value="L2" name="type">L2</option>
                        <input type="checkbox" value="L3" name="type">L3</option>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Cache Memory:</label>
                    </td>
                    <td>
                        <input type="text" name="cache" placeholder="Enter cache momery size" size="25" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Bus speed:</label>
                    </td>
                    <td>
                        <input type="text" name="bus" placeholder="Enter bus speed" size="25" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Instruction Count(millions):</label>
                    </td>
                    <td>
                        <input type="text" name="instructions" placeholder="Enter instruction count" size="25">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Cycles per instruction:</label>
                    </td>
                    <td>
                        <input type="text" name="ins_per_cycle" placeholder="Enter cycle per instruction" size="25">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <footer style="background-color:blueviolet;margin-top:2%">
        <br>
        <p style="text-align: center;color:white;
            font-weight: bold;"> <i class="fa-regular fa-copyright" style="margin-right:5px"></i>Copyright by Saiful, Sajib, Sudipta</p>
        <br>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>