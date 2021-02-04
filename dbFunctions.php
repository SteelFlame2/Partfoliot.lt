<?php
$mainDB = mysqli_connect("127.0.0.1:3306", "root", "123456");
// $rows = mysqli_fetch_row(mysqli_query($mainDB, "select * from `comment 1`"));
// foreach ($rows as $row => $value) {
//     echo $value . ", " . $row . "<br/>";
// }
if (isset($_GET['sendComment'])) {
    $currentDate = date('o-m-d');
    mysqli_select_db($mainDB, $_GET['websiteName']);
    $id = mysqli_query($mainDB, "select max(id) from `comments`")->fetch_row()[0];
    ($id == null) ? $id = 0 : $id += 1;
    // echo $id . ", " . $_GET['senderName'] . ", " . $_GET['senderContent'];
    mysqli_query($mainDB, "insert into `comments` values ({$id},'{$_GET['senderName']}','{$_GET['senderContent']}','{$currentDate}')");
}
if (isset($_GET['commentIdToDelete'])) {
    $updateIds = "update `comments` set `id`=`id`-1 where `id`>" . $_GET['commentIdToDelete'];
    mysqli_select_db($mainDB, $_GET['websiteToDeleteComment']);
    mysqli_query($mainDB, "delete from `comments` where `id`=" . $_GET['commentIdToDelete']);
    mysqli_query($mainDB, $updateIds);
    echo $_GET['websiteToDeleteComment'];
}

$chatTarget = "Author";

$adminLogin = "Admin";
$adminPassword = "123456";
$isLoggedIn = false;

// ini_set('session.gc_maxlifetime', 20);
// session_set_cookie_params(20);
// session_destroy();
session_start();

if (isset($_GET['login'])) {
    if ($_GET['name'] == $adminLogin && $_GET['password'] == $adminPassword) {
        echo $_SERVER['REMOTE_ADDR'];
        $_SESSION["Name"] = $adminLogin;
        $_SESSION["Password"] = $adminPassword;
        $_SESSION['IsHaveLoginData'] = true;
        $isLoggedIn = true;
    } else {
        echo "false";
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
}
if ($_SESSION['IsHaveLoginData']) {
    session_start();
    if ($_SESSION['Name'] == $adminLogin && $_SESSION['Password'] == $adminPassword) {
        $isLoggedIn = true;
    } else {
        $isLoggedIn = false;
        $_SESSION['IsHaveLoginData'] = false;
    }
}

if (isset($_GET['message_toAuthor'])) {
    mysqli_select_db($mainDB, "chat");
    $id = mysqli_query($mainDB, "select max(id) from `toauthor`")->fetch_row()[0];
    ($id == null) ? $id = 0 : $id += 1;
    $date = date("Y-n-j");
    mysqli_query($mainDB, "insert into `toauthor` values (\"$id\",\"{$_GET['message_name']}\",\"{$_GET['message']}\",\"{$date}\",\"{$_SERVER['REMOTE_ADDR']}\")");
    $_SESSION['DefaultName'] = $_GET['message_name'];
}
