<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Search</title>
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

<body style="background-color:darkgray">
    <div style="background-color:blueviolet;">
        <nav class="navbar navbar-expand-lg" style="background-color:blueviolet;">
            <a class="navbar-brand text-light text-xl btn" role="button" href="#">CPU Benchmark</a>
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
    <?php
    $server = "localhost";
    $user = "root";
    $passer = "";
    $dbname = "cpu";
    try {
        $conn = new PDO("mysql:host=$server;dbname=$dbname", $user, $passer);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id, name FROM cpu_info");
        $stmt->execute();
        $res = $stmt->fetchAll();
        $row = $stmt->rowCount();
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    ?>
    <div style="padding: 10px; margin:40px 500px 20px 400px;background-color:pink; border-radius:25px">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <table>
                <tr>
                    <td>
                        <label>First Cpu Name:</label>
                    </td>
                    <td>
                        <select name="cpu1">
                            <option value="">Select first CPU</option>
                            <?php
                            if ($row > 0) {
                                foreach ($res as $r) {
                                    echo '<option value='.$r["name"].'>';
                                    echo $r["name"];
                                    echo '</option>';
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Second Cpu Name:</label>
                    </td>
                    <td>
                        <select name="cpu2">
                            <option value="">Select second CPU</option>
                            <?php
                            if ($row > 0) {
                                foreach ($res as $r) {
                                    echo '<option value='.$r["name"].'>';
                                    echo $r["name"];
                                    echo '</option>';
                                }
                            }
                            ?>
                        </select>
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
    <footer style="background-color:blueviolet;margin-top:18%">
    <br>
        <p style="text-align: center;color:white;
            font-weight: bold;"> <i class="fa-regular fa-copyright" style="margin-right:5px"></i>Copyright by Saiful, Sajib, Sudipta</p>
        <br>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <?php
    if (!empty($_POST["cpu1"]) && !empty($_POST["cpu2"])) {
        $_SESSION["cpu1"] = $_POST["cpu1"];
        $_SESSION["cpu2"] = $_POST["cpu2"];
        header("Location: result.php");
    }
    ?>
</body>

</html>