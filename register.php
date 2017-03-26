<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/bulma.css" type="text/css">
<div class="container notification">
Hi <?php echo htmlspecialchars($_POST['name']); ?>. 
You are <?php echo (int)$_POST['age']; ?> years old.
<a href="home.html">Go to home</a>
</div>