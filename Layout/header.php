<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[3];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Play soccer</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_path; ?>style/index.css" rel="stylesheet" type="text/css">
    <script src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.9.0.min.js"></script>
    <script src="<?php echo base_path; ?>js/script_v1.js"></script>
</head>
<body>
<div>
        <ul>
            <li>
                <a class="<?php if($first_part == "main.php"){ echo 'active';} ?>"  href="<?php echo base_path; ?>main.php">Main</a>
            </li>
            <li>
                <a class="<?php if($first_part == "tournament.php" || $first_part == "creatTournament.php" || $first_part == "editTournament.php" || $first_part == "viewTournament.php"){ echo 'active';} ?>"  href="<?php echo base_path; ?>tournament.php">Tournament</a>
                <ul class="dropdown">
                    <li><a class="<?php if($first_part == "creatTournament.php"){ echo 'active';} ?>" href="<?php echo base_path; ?>creatTournament.php">Create tournament</a></li>
                    <li><a class="<?php if($first_part == "editTournament.php"){ echo 'active';} ?>" href="<?php echo base_path; ?>editTournament.php">Edit tournament</a></li>
                    <li><a class="<?php if($first_part == "viewTournament.php"){ echo 'active';} ?>" href="<?php echo base_path; ?>viewTournament.php">View tournament</a></li>
                </ul>
            </li>
            <li>
                <a class="<?php if($first_part == "account.php"){ echo 'active';} ?>"  href="<?php echo base_path; ?>account.php">My account</a>
            </li>
            <?php
            if(!isset($_SESSION['user_data'])) {
                ?>
                <li>
                    <a class="<?php if ($first_part == "") {
                        echo 'active';
                    } ?>" href="<?php echo base_path; ?>">Sign in</a>
                </li>
                <?php
            } else {
            ?>
            <li>
                <a style="padding: 0px;"  href="<?php base_path; ?>account.php">
                    <form method="post" action="<?php base_path; ?>controllers/logoutController.php">
                        <input type="hidden" name="log_out" value="log">
                        <button id="l-bottom" type="submit">Log out</button>
                    </form>
                </a>
            </li>
            <?php } ?>

    </ul>
</div>