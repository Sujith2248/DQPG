<?php
    include ('header.php');
    include ('connection.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register User</title>
        <style type="text/css">
            .bottom {
                position: inherit;
                background-color: rgb(31, 104, 117);
                color: white;
                padding: 20px;
                padding-left: 60px;
                margin: 10px 0px 0px 0px;
            }
            h1 {
                color: white;
                font-weight: lighter;
            }
            .box {
                border: 2px solid transparent;
                background-color: white;
                border-radius: 19px;
                padding: 20px;
                margin-left: 180px;
                margin-bottom: 50px;
                width: 700px;
                text-align: center;
            }
            .foot {
                letter-spacing: 1px;
                color: white;
                padding: 20px;
                text-align: center;
                background-color: rgb(26, 83, 93);
            }
            input[type=text], input[type=password], select {
                width: 70%;
                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
                border: none;
                border-bottom: 2px solid rgb(26, 83, 93);
                background: transparent;
            }
            #submit, #reset {
                background-color: rgb(31, 104, 117);
                color: white;
                border-radius: 30px;
                width: 100px;
                height: 30px;
                font-size: 1.2em;
                border: 1px solid transparent;
                margin-bottom: 30px;
            }
            #submit:hover, #reset:hover {
                background-color: rgb(26, 83, 93);
                color: white;
                border: none;
            }
            #submit:focus, #reset:focus {
                outline: 0;
            }
        </style>
    </head>
    <body>
        <div class="bottom">
            <h1>Questions</h1>
            <div class="box">
                <form name="register" action="signupscript.php" method="post">
                    
                    <select name="institution" required>
                        <option value="" disabled selected>Select Institution</option>
                        <option value="KIET">KIET</option>
                        <option value="IIT">IIT</option>
                        <option value="NIT">NIT</option>
                    </select><br>
                    
                    <select name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="CSE">CSE</option>
                        <option value="ECE">ECE</option>
                        <option value="MECH">MECH</option>
                    </select><br>
                    
                    <select name="semester" required>
                        <option value="" disabled selected>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select><br>
                    
                    <select name="subject" required>
                        <option value="" disabled selected>Select Subject</option>
                        <option value="Maths">Maths</option>
                        <option value="Physics">Physics</option>
                        <option value="Chemistry">Chemistry</option>
                    </select><br>
                    
                    <div class="buttons">
                        <button type="submit" id="submit">Submit</button>
                        <button type="reset" id="reset">Reset</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="foot">
            Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
        </div>
    </body>
</html>
