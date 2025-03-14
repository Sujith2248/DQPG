<?php
include('header.php');
include('connection.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register Institution</title>

    <style type="text/css">
        .bottom {
            /* height :500px; */
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
        input[type=password] {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
        }

        #submit,
        #reset,
        #cancel {
            background-color: rgb(31, 104, 117);
            color: white;
            border-radius: 30px;
            width: 100px;
            height: 30px;
            font-size: 1.2em;
            border: 1px solid transparent;
            /* margin: 30px; */
            margin-bottom: 30px;
        }

        #submit:hover,
        #reset:hover,
        #cancel:hover {
            background-color: rgb(26, 83, 93);
            color: white;
            border: none;
        }

        #submit:focus,
        #reset:focus,
        #cancel:focus {
            outline: 0;
        }

        form>a:link,
        form>a:visited {
            text-decoration: none !important;
        }

        form>a:hover {
            color: rgb(26, 83, 93);
            font-size: 1.1em;
            background-color: ghostwhite;
        }

        #input2 {
            font-size: 15px;
            font-weight: lighter;
            width: 470px;
            height: 50px;
            border-bottom: 2px solid rgb(26, 83, 93);
            ;
            background-color: transparent;
            color: black;
            padding-left: 20px;
            margin-top: 10px;
        }

        input,
        textarea:focus {
            outline: 0;
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
            let insName = document.forms["institution"]["insName"].value.trim();
            let insAddress = document.forms["institution"]["insAddress"].value.trim();
            let insContact = document.forms["institution"]["insContact"].value.trim();

            if (insName === "") {
                alert("Institution Name is required");
                return false;
            }

            if (insContact === "" || !/^[0-9]{10}$/.test(insContact)) {
                alert("Enter a valid 10-digit contact number");
                return false;
            }

            if (insAddress === "") {
                alert("Address is required");
                return false;
            }

        }
    </script>
</head>

<body>
    <div class="bottom">
        <h1>Institution</h1>
        <div class="box">
            <form name="institution" action="institutionScript.php" method="post" class="form" onsubmit="return validateForm()">
                <input type="text" name="insName" placeholder="institution name"><br>
                <input type="text" name="insAddress" placeholder="Address"><br>
                <input type="text" name="insContact" placeholder="Contact"><br>
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