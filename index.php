<?php
include "dbFunctions.php";

$projectsDescription = scandir("Projects");
unset($projectsDescription[0]);
unset($projectsDescription[1]);

$projectsSites = scandir("Websites");
unset($projectsDescription[0]);
unset($projectsDescription[1]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partfolio</title>
    <style>
        @font-face {
            font-family: defaultFont;
            src: url("YuseiMagic-Regular.ttf");
        }

        body {
            font-family: defaultFont;
            background: rgb(241, 249, 249);
            margin: 5px 0px;
            cursor: default;
        }

        li {
            list-style: none;
        }

        header {
            margin: 0px;
            width: 100%;
        }

        header nav {
            width: 50%;
            padding: 0px;
            margin: 0px;
            text-align: center;
        }

        header nav span {
            background: rgb(51, 51, 51);
            padding: 10.5px 0px;
            float: left;
            width: 50%;
            color: white;
        }

        header nav span:hover {
            background: #ddd;
        }

        header .avatar {
            display: flex;
            justify-content: flex-end;
            width: 50%;
            float: right;
            background: rgb(51, 51, 51);
        }

        header .avatar img {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            transition: 0.57s ease-in-out;
            <?php
            if ($isLoggedIn)
                echo "border: 1px solid yellow";
            ?>
        }

        header .avatar img:hover {
            transform: rotate(360deg) scale(1.1);
            box-shadow: 0px 0px 10px rgba(1, 1, 1, 1);

        }

        header .avatar .selMenu:hover .drop-menu {
            opacity: 1;
            visibility: visible;
            transform: translate(0px, 0px);
        }

        .websites {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            /* margin: 0px 20px; */
        }

        .website {
            padding: 30px;
            background: rgba(166, 255, 163, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            margin: 10px 0px;
            border: 2px solid rgb(94, 105, 255);
            border-radius: 10px;
            width: 300px;
        }

        .website .comment {
            display: flex;
            justify-content: flex-start;
            font-size: 16px;
            border-left: 2px solid #444;
            padding: 13px;
            margin-bottom: 10px;
        }

        .comment .authorInfo {
            width: 100%;
        }

        .comment input[name="deleteComment"] {
            color: rgb(200, 10, 10);
            border: none;
            background: none;
        }

        .drop-menu {
            position: absolute;
            top: 60px;
            right: 5px;
            background: rgb(172, 172, 172);
            border-radius: 10px;
            border: 2px solid rgb(120, 120, 230);
            color: rgb(70, 70, 150);
            transition: 0.7s;
            opacity: 0;
            visibility: hidden;
            transform: translate(0px, 30px);
        }

        .drop-menu ul {
            padding: 0px;
            margin: 0px;
        }

        .drop-menu li {
            text-align: center;
            border: 1px solid rgb(120, 120, 230);
            border-radius: 7px;
            padding: 5px;
            transition: 0.2s;
        }

        .drop-menu li:hover {
            background: rgba(120, 120, 230, 0.4);
        }

        .content .contentToContinue {
            /* opacity: 0;
            transition: 1s opacity; */
            display: none;
        }

        .chat {
            position: fixed;
            width: 300px;
            height: 500px;
            right: 0px;
            bottom: -455px;
            margin-right: 10px;
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
            background-color: rgb(200, 200, 200);
            transition: 0.6s;
        }

        .chat .chat-head {
            background: rgb(51, 51, 51);
            border-top-right-radius: 15px;
            border-top-left-radius: 15px;
            padding: 3px;

            color: white;
            font-size: 18px;
            height: 30px;
        }

        .chat #writer {
            position: absolute;
            width: 100%;
            margin: 0px;
            padding: 0px;
            bottom: 0px;
            border: none;
        }

        .chat #writer textarea {
            width: 100%;
            font-size: 17px;
            background-color: rgb(240, 240, 240);
            border: none;
            border-radius: 5px;
            resize: none;
        }

        .chat #writer input[type="button"] {
            width: 100%;
            border: none;
            border-radius: 5px;
            background-color: rgb(130, 130, 130);
        }

        .chat input {
            width: 100%;
            border: none;
            font-size: 16px;
        }

        .chat .message {
            background: rgb(51, 51, 51);
            color: white;
            margin: 4px 0px;
            padding: 5px 1px;
            word-wrap: break-word;
        }

        .chat:hover {
            bottom: 0px;
        }

        .about-author {
            margin: 0px 20px;
        }

        article hr {
            border-color: rgb(51, 51, 51);
            border-width: 2px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
    <header id="header">
        <nav>
            <span onclick="scrollToPart('.about-author')">About author</span>
            <span onclick="scrollToPart('.websites')">Projects</span>
            <!-- <span>Support</span> -->
        </nav>
        <div class="avatar">
            <div class="selMenu">
                <img src="Images/glavnaya-1.jpg" alt="Avatar" />
                <!-- <div class="drop-menu">
                    <ul>
                        <li>Start chat with me</li>
                        <li>Chat with all</li>
                    </ul>
                </div> -->
            </div>
        </div>
    </header><br /><br />
    <script>
        let elementScrollOffset = $("header")[0].offsetTop;
        console.log(elementScrollOffset);
        window.onscroll = (e) => {
            if (window.pageYOffset > elementScrollOffset) {
                $("header").css("position", "fixed");
                $("header").css("top", 0);
            } else {
                $("header").css("position", "static");
            }
        }
    </script>
    <article>
        <div class="about-author">
            <h1>About author</h1>
            <span>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus proin nibh nisl condimentum. Pellentesque diam volutpat commodo sed egestas egestas. Interdum posuere lorem ipsum dolor sit amet consectetur adipiscing elit. Adipiscing diam donec adipiscing tristique risus nec feugiat in fermentum. Lorem donec massa sapien faucibus et. Pulvinar neque laoreet suspendisse interdum. Velit dignissim sodales ut eu sem integer vitae. Non quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor. Duis at tellus at urna condimentum mattis.

                Magnis dis parturient montes nascetur ridiculus mus mauris. In fermentum et sollicitudin ac orci phasellus. Convallis tellus id interdum velit laoreet. Fringilla phasellus faucibus scelerisque eleifend. Lectus arcu bibendum at varius vel pharetra vel turpis. Sed viverra tellus in hac habitasse platea dictumst vestibulum rhoncus. Metus vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Nulla pharetra diam sit amet nisl suscipit adipiscing bibendum est. Eu nisl nunc mi ipsum. Iaculis nunc sed augue lacus viverra vitae congue eu consequat.
            </span>
        </div>
        <hr />
        <h1 style="margin: 0px 20px">Projects</h1>
        <div class="websites">
            <?php
            foreach ($projectsDescription as $project) {
                $name = "Projects/" . $project . "/index.html";
                $code = fopen($name, "r");
                $cont = fread($code, filesize($name));

                $commentsData = [];
                if (!mysqli_query($mainDB, "use `$project`")) {
                    mysqli_query($mainDB, "create database `$project`");
                    mysqli_select_db($mainDB, $project);
                    mysqli_query($mainDB, "create table `Comments` (`id` int not null,`Name` text not null, `Content` text not null, `Date` date not null)");
                } else {
                    mysqli_select_db($mainDB, $project);
                    $commentsData = mysqli_fetch_all(mysqli_query($mainDB, "select * from `comments`"));
                }

                echo <<<EOF
                <div class="website" id="{$project}_website">
                    <span style="align-self: flex-end; margin:0px; padding:0px" onclick="goTowww('Websites/$project/index.html')">Link</span>
                    <div  class="content" id="$project">
                        $cont
                    </div>
                    <span onclick="toggle_{$project}_actions()">↓</span>
                    <script>
                        function toggle_{$project}_actions() {
                            $('#{$project}_website').children('.actions').slideToggle(350);
                            // $('#{$project}_website').toggle(function () { $('#{$project}_website').addClass("active")},
                            //     function () { $('#{$project}_website').removeClass("active")});
                        }
                    </script>
                    <div class="actions" id="$project" style="display:none">
                        <hr width="100%" style="border-width: 1px"/>
                        <div class="comments">
EOF;
                for ($i = 0; is_array($commentsData) && $i < count($commentsData); $i++) {
                    echo <<<EOD
                    <div class="comment" id="deleteComment_$project.{$commentsData[$i][0]}">
                        <div class="authorInfo">
                            <span style="color:rgb(0,77,53); font-size: 20px; letter-spacing: 2px;">{$commentsData[$i][1]}</span> from <span style="color:rgb(0,0,0)">{$commentsData[$i][3]}</span> write:
                            <br/><span style="color: rgb(0,53,95)">- {$commentsData[$i][2]}</span>
                        </div>
EOD;
                    if ($isLoggedIn) {
                        echo <<<EOD
                        <input onclick="$.ajax('dbFunctions.php?commentIdToDelete={$commentsData[$i][0]}&websiteToDeleteComment=$project',{success : function (data) {document.getElementById('deleteComment_$project.{$commentsData[$i][0]}').remove();}});" type="button" name="deleteComment" value="X"/>
                    </div>
EOD;
                    } else {
                        echo "</div>";
                    }
                }
                echo <<<EOF
                        <span>
                            Write comment: 
                        </span><br/>
                        <input id="sendNameOf{$project}" name="senderName" placeholder="Name" style="width: 70%; height: 18px; font-size: 15px;"/><br/>
                        <textarea class="sendValue" name="senderContent" cols="50" rows="5" style="font-size: 14px; width: 90%" placeholder="Comment"></textarea>
                        <br/><input class="send_comment" name="sendComment" type="button" value="Send" style="padding: 10px 20px;"/>
                        <script>
                            $("#sendNameOf{$project}").nextAll(".send_comment").click(()=>{
                                let name = $("#sendNameOf{$project}")[0].value;
                                let content = $("#sendNameOf{$project}").nextAll("textarea")[0].value;
                                let date = new Date();
                                $.ajax('dbFunctions.php?sendComment&websiteName={$project}&senderName='+name+'&senderContent='+content);
                                $('.comments').append(
                                        `<div class="comment" id="deleteComment_$project.{$commentsData[$i][0]}">
                                            <div class="authorInfo">
                                                <span style="color:rgb(0,77,53); font-size: 20px; letter-spacing: 2px;">`+name+`</span> from <span style="color:rgb(0,0,0)">`+date.getFullYear() +"-"+ (date.getMonth()+1)+"-"+date.getDate()+`</span> write:
                                                <br/><span style="color: rgb(0,53,95)">- `+content+`</span>
                                            </div>
                                            <input onclick="$.ajax('dbFunctions.php?commentIdToDelete={$commentsData[$i][0]}&websiteToDeleteComment=$project',{success : function (data) {document.getElementById('deleteComment_$project.{$commentsData[$i][0]}').remove();}});" type="button" name="deleteComment" value="X"/>
                                        </div>`);
                            });
                        </script>
                    </div>
                </div>
                </div>
EOF;
                fclose($code);
            }
            ?>
            <!-- <div class="chat">
                <div class="chat-head" style="padding: 0px 10px">
                    <span style="padding-right: 5px;">Chat | to <?php if (!$isLoggedIn) echo $chatTarget; ?></span>
                </div>
                <div class="chat-content">
                    <div id="messages">
                        <?php

                        // mysqli_select_db($mainDB, "chat");
                        // if ($isLoggedIn) {
                        //     $message = mysqli_query($mainDB, "select * from `toauthor`")->fetch_all();
                        //     for ($i = 0; $i < sizeof($message); $i++) {
                        //         echo "<div class='message'>";
                        //         echo <<<EOT
                        //                             <span style='color: rgb(90,167,143)'>{$message[$i][1]}</span>, send you: <span style='color: rgb(73,126,168)'>{$message[$i][2]}</span>
                        // EOT;
                        //         echo "</div>";
                        //     }
                        // } else {
                        // }
                        ?>
                    </div>
                    <div id="writer">
                        <input placeholder="Name<?php if ($isLoggedIn) {
                                                    echo " (Receiver name or ip)";
                                                } ?>" value=<?php echo "{$SESSION['DefaultName']}" ?> /><br />
                        <textarea placeholder="Message" rows="2" cols="5"></textarea>
                        <input type="button" value="Send" onclick="$.ajax('dbFunctions.php?message_toAuthor&message_name='+$('#writer input')[0].value+'&message='+$('#writer textarea')[0].value,{success : function (data) {}})" />
                    </div>
                </div>
            </div> -->
            <div class="support">
                <hr />
            </div>
    </article>
    <footer>

    </footer>
    <script>
        var contents = document.querySelectorAll(".content");
        contents.forEach(e => {
            let content = e.innerHTML;
            if (content.length > 200) {
                e.innerHTML = content.substr(0, 200);
                content = content.substr(200, content.length);
                e.innerHTML += "<span onclick='$(this).next().slideToggle(1000)'>...</span><span class='contentToContinue'>" + content + "</span>";
            }
        });

        function goTowww(link) {
            window.location.href = link;
        }

        function hide(elem) {
            let state = document.querySelector(elem);
            console.log(state);
            if (state.hidden == true) {
                state.hidden = true;
            } else {
                state.hidden = false;
            }
        }

        // function sendReq(url,request,onResponse) {
        //     let handle = new XMLHttpRequest();
        //     handle.open("get",url+request,true);
        //     handle.send();
        //     handle.onreadystatechange = onResponse;
        //     return handle;
        // }

        var scrollTarget = null;
        var startScrollPos = 0;
        var scrollFrame = 0;

        var scrollSpeed = 0.1;

        function scrollToPart(object, time = 500) {
            $('html, body').animate({
                scrollTop: $(object).offset().top
            }, time);
        }

        function linear(a, b, t) {
            return a + (b - a) * t;
        }

        function render() {
            if (scrollTarget != null) {
                scrollTo(0, linear(startScrollPos, scrollTarget.scrollHeight - scrollTarget.clientHeight / 2, scrollFrame));
                if (scrollFrame >= 1)
                    scrollTarget = null;
            }
            scrollFrame += scrollSpeed
            requestAnimationFrame(render);
        }
        requestAnimationFrame(render);

        function loginAsAdmin(name, password) {
            $.ajax("dbFunctions.php?login&name=" + name + "&password=" + password, {
                success: function(data) {
                    if (data != "false")
                        alert("You successfuly logged in, as " + data);
                }
            });
        }

        function logout() {
            $.ajax("dbFunctions.php?logout", {
                success: function(data) {
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>
<?php
$mainDB->close();
?>