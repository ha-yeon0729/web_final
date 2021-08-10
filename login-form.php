<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>로그인폼</title>
        <link href ="style.css" rel="stylesheet" type="text/css">
        <style>
            body{
                    background-image: url('../pictures/ssg.png');
                    background-position: bottom bottom;
                    background-attachment: local;
                    background-repeat: no-repeat;
            }
        </style>
    </head>
    <body>
        <div>
            <center>
                <h1>로그인</h1>
            </center>
        </div>
        <nav>
            <span><a href="register-form.php">회원가입</a></span>
            <span><a href="login-form.php">로그인</a></span>
        </nav>
        <div>
            <form action="login.php" method="post">
                <table>
                    <tr>
                        <td class="form-label">
                            <label>아이디</label>
                        </td>
                        <td class="form-data">
                            <input type="text" name="userid" id="userid" class="input-text">                           
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <label>비밀번호</label>
                        </td>
                        <td class="form-data">
                            <input type="password" name="password" id="password" class="input-text">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="form-data">
                            <input type="submit" value="로그인" class="form-button" id="submit">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>


        