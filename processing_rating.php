<?php
include 'question_class.php';

?>

<!DOCTYPE html>
<html lang=2en dir="ltr">
<head>
<meta charset = "utf-8">
<title></title>
</head>
<body>



<?php

$question1 = new Question();
$question1->setId("123");
echo $question1->id;
?>


</body>
</html>