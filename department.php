<?php
include('header.php');
include('connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register user</title>

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
            height: auto;
            letter-spacing: 1px;
            text-align: center;
        }

        .foot {
            letter-spacing: 1px;
            color: white;
            padding: 20px;
            text-align: center;
            background-color: rgb(26, 83, 93);
        }

        input[type=text],
        input[type=password],
        select {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
            background-color: transparent;
            font-size: 15px;
        }

        select {
            cursor: pointer;
        }

        #submit,
        #reset {
            background-color: rgb(31, 104, 117);
            color: white;
            border-radius: 30px;
            width: 100px;
            height: 30px;
            font-size: 1.2em;
            border: 1px solid transparent;
            margin-bottom: 30px;
        }

        #submit:hover,
        #reset:hover {
            background-color: rgb(26, 83, 93);
            color: white;
            border: none;
        }

        .radio {
            color: black;
            margin-top: 30px;
            margin-right: 330px;
        }

        .buttons {
            margin-top: 30px;
        }

        #reset {
            margin-left: 50px;
        }
    </style>

    <script>
        function validateForm() {
            let fname = document.forms["login"]["Fname"].value.trim();
            let lname = document.forms["login"]["Lname"].value.trim();
            let contact = document.forms["login"]["contact"].value.trim();
            let email = document.forms["login"]["email"].value.trim();
            let password = document.forms["login"]["password"].value.trim();
            let address = document.forms["login"]["address"].value.trim();
            let role = document.querySelector('input[name="role"]:checked');

            if (fname === "") {
                alert("First Name is required");
                return false;
            }
            if (lname === "") {
                alert("Last Name is required");
                return false;
            }
            if (contact === "" || !/^[0-9]{10}$/.test(contact)) {
                alert("Enter a valid 10-digit contact number");
                return false;
            }
            if (email === "" || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                alert("Enter a valid email");
                return false;
            }
            if (password === "" || password.length < 6) {
                alert("Password must be at least 6 characters long");
                return false;
            }
            if (address === "") {
                alert("Address is required");
                return false;
            }
            if (!role) {
                alert("Please select a role");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="bottom">
        <h1>Department</h1>
        <div class="box">
            <form name="department" action="departmentScript.php" method="post" class="form">
                <select name="insId">
                    <option value="">Select instituion</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                </select><br>
                <select name="insId">
                    <option value="">Select subject</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">C</option>
                </select><br>
                <input type="text" name="depName" placeholder="Name"><br>
                <input type="text" name="depCode" placeholder="Department code"><br>
                <input type="text" name="depDescription" placeholder="Description"><br>

                <div class="buttons">
                    <input id="submit" type="submit" value="Submit" />
                    <input id="reset" type="reset" value="Reset" />
                </div>
            </form>
        </div><br>
    </div>
    </div>
    <div class="foot">
        Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
    </div>
</body>

</html>