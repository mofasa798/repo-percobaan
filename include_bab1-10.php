<?php

session_start();

// Login sederhana
if (!isset($_SESSION['username'])) {
    if (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['progress'] = [];
    } else {
        echo '<form method="post">
                <h2>Login</h2>
                <label>Masukkan Username:</label>
                <input type="text" name="username" required>
                <button type="submit">Login</button>
              </form>';
        exit();
    }
}

$bab_list = [
    'Bab 1' => 'bab1.php',
    'Bab 2' => 'bab2.php',
    'Bab 3' => 'bab3.php',
    'Bab 4' => 'bab4.php',
    'Bab 5' => 'bab5.php',
    'Bab 6' => 'bab6.php',
    'Bab 7' => 'bab7.php',
    'Bab 8' => 'bab8.php',
    'Bab 9' => 'bab9.php',
    'Bab 10' => 'bab10.php',
    'Bab 11' => 'bab11.php',
    'Bab 12' => 'bab12.php',
    'Bab 13' => 'bab13.php',
    'Bab 14' => 'bab14.php',
    'Bab 15' => 'bab15.php',
    'Bab 16' => 'bab16.php',
    'Bab 17' => 'bab17.php',
    'Bab 18' => 'bab18.php',
    'Bab 19' => 'bab19.php',
    'Bab 20' => 'bab20.php',
];

$bab_keys = array_keys($bab_list);
$current_page = isset($_GET['page']) ? $_GET['page'] : '';
$current_index = array_search($current_page, array_values($bab_list));

$previous_page = $current_index > 0 ? array_values($bab_list)[$current_index - 1] : null;
$next_page = $current_index !== false && $current_index < count($bab_list) - 1 ? array_values($bab_list)[$current_index + 1] : null;

if (!isset($_SESSION['progress'])) {
    $_SESSION['progress'] = [];
}

if (isset($_GET['reset'])) {
    $_SESSION['progress'] = [];
    header('Location: index.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if ($current_page && in_array($current_page, $bab_list)) {
    $_SESSION['progress'][$current_page] = true;
}

$completed = count($_SESSION['progress']);
$total = count($bab_list);
$progress_percentage = ($completed / $total) * 100;

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Modul Belajar JavaScript</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f9f9f9;
        }

        h1 {
            color: #2c3e50;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            background-color: #4285f4;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }

        a:hover {
            background-color: #3367d6;
        }

        .content {
            margin-top: 30px;
        }

        .navigation {
            margin-top: 20px;
        }

        .navigation a {
            margin-right: 10px;
        }

        .progress {
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            background-color: #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 20px;
            background-color: #4caf50;
            width: <?php echo $progress_percentage; ?>%;
            text-align: center;
            color: white;
            line-height: 20px;
        }

        .top-links a {
            margin-right: 10px;
            background-color: #e74c3c;
        }
    </style>
</head>

<body>
    <h1>Index Modul Belajar JavaScript</h1>
    <p>Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <div class="top-links">
        <a href="?reset=1">Reset Progress</a>
        <a href="?logout=1">Logout</a>
    </div>

    <div class="progress">
        <strong>Progress Belajar: <?php echo round($progress_percentage); ?>%</strong>
        <div class="progress-bar">
            <div class="progress-bar-fill"><?php echo round($progress_percentage); ?>%</div>
        </div>
    </div>

    <ul>
        <?php foreach ($bab_list as $bab => $file): ?>
            <li>
                <a href="?page=<?php echo $file; ?>"><?php echo $bab; ?></a>
                <?php if (isset($_SESSION['progress'][$file])) echo '✅'; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="content">
        <?php
        if ($current_page && in_array($current_page, $bab_list)) {
            include $current_page;
            echo '<div class="navigation">';
            if ($previous_page) {
                echo '<a href="?page=' . $previous_page . '">Bab Sebelumnya</a>';
            }
            if ($next_page) {
                echo '<a href="?page=' . $next_page . '">Bab Selanjutnya</a>';
            }
            echo '</div>';
        } else {
            echo '<p>Silakan pilih bab dari daftar di atas untuk mulai belajar.</p>';
        }
        ?>
    </div>

</body>

</html>
