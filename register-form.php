<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>회원가입폼</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <style>
            body{
                    background-image: url('../pictures/ssg.png');
                    background-position: bottom bottom;
                    background-attachment: local;
                    background-repeat: no-repeat;
            }
        </style>
        <script>
            function check_data(){
                var email=
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                var userid=/^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i//이메일 형식 제대로 되었는지 확인하는 코드
            
                if (document.getElementById("userid").value ==""){
                    alert("사용자ID를 입력하세요.");
                    doucument.getElementById("userid").focus();
                    return false;
                }

                if (document.getElementById("password").value ==""){
                    alert("비밀번호를 입력하세요");
                    document.getElementById("password").focus();
                    return false;
                }

                if (document.getElementById("email".)value==""){
                    alert("사용자 이메일 주소를 입력하세요");
                    document.getElementById("email").focus();
                    return false;
                }

                if (document.getElementById("phone").value==""){
                    alert("사용자 연락처를 입력하세요");
                    document.getElementById("phone").focus();
                    return false;
                }

                if (document.getElementById("password").value!=documnet.getElementById("repassword").value){
                    alert("입력하신 두 개의 비밀번호가 일치하지 않습니다.");
                    document.getElementById("password").focus();
                    return false;
                }

                if (!documnet.getElementById("userid").value.match(userid)){
                    alert("아이디는 4-16자의 영문 숫자로만 구성이 가능하며 첫 글자는 영문으로 시작해야 합니다.");
                    document.getElementById("userid").focus();
                    return false;
                }

                if (!document.getElemmentById("email").value.match(email)){
                    alert("이메일 주소 형식에 맞지 않습니다.");
                    document.getElementById("email").focus();
                    return false;
                }
                return true;
                
            }
        </script>
    </head>
    <body>
        <div>
            <h1>회원가입</h1>
        </div>
        <nav>
            <span class="active"><a href="register-form.php">회원가입</a></span>
            <span><a href="login-form.php">로그인</a></span>
        </nav>
        <div>
            <form action="register.php" method="post" onsubmit="return check_data();">
                <table>
                    <tr>
                        <td class="form-label">
                            <label>아이디</label>
                        </td>
                        <td class="form-data">
                            <input type="text" name="userid" id="userid"
                            class="input-text"
                            placeholder="예)hong1234">
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <label>비밀번호</label>
                        </td>
                        <td class="form-data">
                            <input type="password" name="password"
                            id="password" class="input-text"
                            placeholder="비밀번호를 입력하세요."
                            >
                            <input type="password" name="repassword"
                            id="repassword" class="input-text"
                            placeholder="비밀번호를 다시 한번 입력하세요.">
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label"><lable>성명</label></td>
                        <td class="form-data">
                            <input type="text" name="username"
                            id="username" class="input-text"
                            placeholder="예)홍길동">
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <label>이메일</label>
                        </td>
                        <td class="form-data">
                            <input type="text" name="email" id="email"
                            class="input-text"
                            placeholder="예)hong1234@test.com">
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <label>연락처</label>
                        </td>
                        <td class="form-data">
                            <input type="text" name="phone" id="phone"
                            class="input-text"
                            placeholder="예)010-1234-5678">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="form-data">
                            <input type="reset" value="초기화" class="form-button" id="reset">
                                <input type="submit" value="회원가입" class="form-button" id="submit">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>