<!DOCTYPE html>
<html lang="en">
<head>
    <style>
       body {
  font-family: Arial, sans-serif;
}

.counter {
  display: flex;
  align-items: center;
}

input[type="radio"] {
  display: none;
}

label {
  padding: 5px 10px;
  font-size: 1.2em;
  cursor: pointer;
}

#count {
  margin: 0 10px;
}

#decrement:checked ~ #count {
  content: attr(data-count);
}

#increment:checked ~ #count {
  content: attr(data-count);
}

</style>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Counter</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="counter">
    <input type="radio" name="counter" id="decrement">
    <label for="decrement">-</label>
    <span id="count">0</span>
    <input type="radio" name="counter" id="increment">
    <label for="increment">+</label>
  </div>
  <script src="script.js"></script>
</body>
</html>
        
