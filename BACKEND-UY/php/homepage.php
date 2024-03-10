<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Foods</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cedarville+Cursive&family=Satisfy&display=swap');
  
    @import url('https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap');

    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

    .welcome-container {
        width: max-content;
        font-family: "Satisfy", cursive;
        font-weight: 400;
        font-style: normal;
        font-size: 3vw;
        text-align: center;
        margin: auto;
        color: white;
        padding-top: 3%;
    }

    .name-container {
        font-family: "Luckiest Guy", cursive;
        font-weight: 400;
        font-style: normal;
        font-size: 5vw;
        text-align: center;
    }

    button {
        background-color: #311712;
        border: none;
        color: white;
        font-family: "Montserrat", sans-serif;
        font-optical-sizing: auto;
        font-weight: 800;
        font-style: normal;
        font-size: 23px;
        padding: 2%;
        transition: all 0.5s;
        cursor: pointer;
    }

    .button-container {
        position: absolute;
        left: 65%;
        bottom: 8%;
        width: 35%;
    }

    button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    button:hover span {
        padding-right: 25px;
    }

    button:hover span:after {
        opacity: 1;
        right: 0;
    }

    body {
        background-image: url("../images/homepage_background.png");
        background-size: cover;
        background-repeat: no-repeat;
    }

</style>
<body>
    <div class="welcome-container">
            Welcome to
        <div class="name-container">
                Healthy Food
        </div>
        <a href="mainmenu.php" class="button-container">
            <button class="button"><span>CLICK HERE TO ORDER </span></button>
        </a>
    </div>
</body>
</html>
