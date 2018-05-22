<?
Header("Content-Type: text/html;charset=UTF-8");
ob_start();
session_start();
define( 'DBHOST', 'localhost' );
define( 'DBUSER', 'CM24' );
define( 'DBPASS', 'L0JFBheG' );
define( 'DBNAME', 'CM24' );
//Подключаемся к базе данных
$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . "";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
try {
    $mysql = new PDO($dsn, DBUSER, DBPASS);
} catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
}
$mysql->exec("SET NAMES utf8 COLLATE utf8_general_ci");
$mysql->exec("SET CHARACTER SET utf8");
include("func.php");
?>
<ul>
    <li><a href="/gm_malacis.php?popl">Пополнения</a></li>
    <li><a href="/gm_malacis.php?vivod">Выводы</a></li>
</ul>
<center>
    <? if (isset($_GET['vivod'])) {

        if ($_POST['vivuid'] and $_POST['vivtxt']) {
            echo '<div><b>UID заявки:</b> ' . $_POST['vivuid'] . '</div>';
            echo '<div><b>TXT вывода:</b> ' . $_POST['vivtxt'] . '</div>';
            $ov = $mysql->exec('UPDATE db_vivod SET Transaction = "' . $_POST['vivtxt'] . '", Status = "1" WHERE Uid = "' . $_POST['vivuid'] . '" LIMIT 1');
        }


        ?>
        <table border="<?= rand(1, 15); ?>">
            <thead>
            <th>UID заявки</th>
            <th>Логин</th>
            <th>Сумма</th>
            <th>Система</th>
            <th>Кошелек</th>
            <th>Состояние</th>
            </thead>
            <?
            $q = $mysql->prepare("SELECT * FROM db_vivod ORDER BY Uid DESC");
            $q->execute();
            while ($row = $q->fetch()) {
                ?>
                <tr>
                    <td><?= $row['Uid']; ?></td>
                    <td><?= $row['UserLogin']; ?></td>
                    <td><?= $row['Summa']; ?></td>
                    <td><?= $row['PaySystem']; ?></td>
                    <td><?= $row['Purse']; ?></td>
                    <td>
                        <? if ($row['Status'] == 1 and !empty($row['Transaction'])) { ?>
                            <a href="http://blockr.io/tx/info/<?= $row['Transaction']; ?>"
                               target="_blank">Обработано</a>
                        <? } else { ?>
                            <form method="post"><input name="vivuid" value="<?= $row['Uid']; ?>" type="hidden"><input
                                    name="vivtxt" placeholder="транзакция"><input name="txt" value="выплатил"
                                                                                  type="submit"></form>
                        <? } ?>
                    </td>
                </tr>
                <!--tr><td colspan="6"><? print_r($row); ?></td></tr-->
                <?
            }
            ?>
        </table>
    <? } elseif (isset($_GET['popl'])) { ?>
        <table border="<?= rand(1, 15); ?>">
            <thead>
            <th>UID заявки</th>
            <th>Логин</th>
            <th>Сумма</th>
            <th>Система</th>
            <th>Транзакция</th>
            </thead>
            <?
            $q = $mysql->prepare("SELECT * FROM db_popl WHERE Status = '1' ORDER BY Uid DESC");
            $q->execute();
            while ($row = $q->fetch()) {
                ?>
                <tr>
                    <td><?= $row['Uid']; ?></td>
                    <td><?= $row['UserLogin']; ?></td>
                    <td><?= $row['Summa']; ?></td>
                    <td><?= $row['PaySystem']; ?></td>
                    <td>
                        <a href="http://blockr.io/tx/info/<?= $row['Transaction']; ?>" target="_blank">Обработано</a>
                    </td>
                </tr>
                <!--tr><td colspan="6"><? print_r($row); ?></td></tr-->
            <? } ?>
        </table>
    <? } ?>


</center> 