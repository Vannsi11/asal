<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-header text-center bg-primary text-white">
                <h4>Kalkulator Analog</h4>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <label class="form-check-label form-switch d-inline-block" for="themeToggle">Mode Gelap</label>
                    <input class="form-check-input" type="checkbox" id="themeToggle">
                </div>
                <form method="post">
                    <input type="text" class="form-control mb-3 display" name="display" id="display" readonly 
                        value="<?php echo isset($_POST['display']) ? $_POST['display'] : ''; ?>">


                        <!--bagian tomol-->


                    <div class="row g-2 mb-3">
                        <?php
                        $buttons = [
                            ['7', '8', '9', '/'],
                            ['4', '5', '6', '*'],
                            ['1', '2', '3', '-'],
                            ['0', 'C', '=', '+']
                        ];
                        foreach ($buttons as $row) {
                            foreach ($row as $btn) {
                                $class = is_numeric($btn) ? 'btn-number' : ($btn === 'C' || $btn === '=' ? 'btn-clear' : 'btn-operator');
                                echo '<div class="col-3">';
                                echo '<button type="submit" name="button" value="' . $btn . '" class="btn ' . $class . ' w-100">' . $btn . '</button>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>


                    <!--history hitung-->


                    <textarea class="form-control mb-3" name="history" rows="5" readonly><?php 
                        echo isset($_POST['history']) ? $_POST['history'] : ''; 
                        ?></textarea>
                    <button type="submit" name="clear_history" class="btn btn-danger w-100">Clear History</button>
                </form>
            </div>
        </div>
    </div>

                    <!--input-->

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current = $_POST['display'] ?? '';
        $button = $_POST['button'] ?? '';
        $history = $_POST['history'] ?? '';
        if (isset($_POST['clear_history'])) {
            $history = '';
        } elseif ($button === 'C') {
            $current = '';
        } elseif ($button === '=') {
            try {
                $result = eval("return $current;");
                $history .= $current . ' = ' . $result . PHP_EOL;
                $current = $result;
            } catch (Exception $e) {
                $current = 'Error';
            }
        } else {
            $current .= $button;
        }
        echo "<script>
        document.getElementById('display').value = '$current';
        document.getElementsByName('history')[0].value = `$history`;</script>";
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
