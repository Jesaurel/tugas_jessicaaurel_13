<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

/* Header Styles */
.header {
  text-align: center;
  padding: 32px;
  background: linear-gradient(to right, #4b0082, #8b0000);
  color: white;
}

.header p {
  margin: 10px 0;
}

/* Button Styles */
.btn {
  border: none;
  outline: none;
  padding: 10px 16px;
  background-color: rgba(218, 165, 32, 0.8);
  color: black;
  cursor: pointer;
  font-size: 18px;
  border-radius: 4px;
  margin: 0 5px;
  transition: background-color 0.3s;
}

.btn:hover {
  background-color: rgba(255, 215, 0, 0.8);
}

.btn.active {
  background-color: #666;
  color: white;
}

/* Photo Grid Styles */
.row {
  display: flex;
  flex-wrap: wrap;
  padding: 0 4px;
}

.column {
  flex: 50%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
  width: 100%;
}

/* Responsive Grid Styles */
@media screen and (max-width: 768px) {
  .column {
    flex: 100%;
  }
}
</style>
</head>
<body>

<!-- Header -->
<div class="header" id="myHeader">
  <h1>Image Grid</h1>
  <p>Click on the buttons to change the grid view.</p>
  <button class="btn" onclick="one()">1</button>
  <button class="btn active" onclick="two()">2</button>
  <button class="btn" onclick="four()">3</button>
</div>

<!-- Photo Grid -->
<div class="row"> 
  <div class="column">
    <img src="../assets/images/prasmanannn.jpeg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
  </div>
  <div class="column">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
  </div>  
  <div class="column">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
  </div>
  <div class="column">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
    <img src="../assets/images/food_background.jpg">
  </div>
</div>

<script>
// Get the elements with class="column"
var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;

// Full-width images
function one() {
    for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "100%";  // IE10
    elements[i].style.flex = "100%";
  }
}

// Two images side by side
function two() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "50%";  // IE10
    elements[i].style.flex = "50%";
  }
}

// Four images side by side
function four() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "25%";  // IE10
    elements[i].style.flex = "25%";
  }
}

// Add active class to the current button (highlight it)
var header = document.getElementById("myHeader");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>

</body>
</html>