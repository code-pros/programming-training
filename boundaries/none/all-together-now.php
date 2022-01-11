<?php

$title = "My Employees";

$pdo = new PDO('dsn');

?>
<html>
    <head>
        <title><?= $title?></title>
    </head>
    <body>
        <h1>List of all my employees</h1>
        <table>
            <tbody>
                <?php
                $sth = $pdo->prepare("SELECT name FROM employees WHERE manager = ? AND active = 1");
                $sth->execute([$mySessionId]);
                foreach ($sth->fetch() as $row) { ?>
                <tr><td><?=$row['name']?></td></tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>
