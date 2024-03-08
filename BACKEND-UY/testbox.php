<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Counter</title>
    <style>
        .counter {
            display: inline-block;
            position: relative;
            font-size: 24px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .counter input[type="radio"] {
            display: none;
        }

        .counter span {
            margin: 0 10px;
        }

        .minus,
        .plus {
            font-weight: bold;
        }

        .minus:hover,
        .plus:hover {
            color: blue;
        }

        .number {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .minus + .number,
        .plus + .number {
            pointer-events: none;
        }

        .minus + .number:before {
            content: "-";
        }

        .plus + .number:before {
            content: "+";
        }

        input[type="radio"]:checked + .number:after {
            content: attr(data-value);
        }

        .number:before, .number:after {
            content: "";
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="counter">
        <input type="radio" id="decrement" name="counter" />
        <span class="minus" for="decrement"></span>
        <span class="number" data-value="0"></span>
        <input type="radio" id="increment" name="counter" />
        <span class="plus" for="increment"></span>
    </div>
</body>
</html>
