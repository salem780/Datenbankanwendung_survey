<?php

include 'includes/question_class.php';

?>

<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>

<?php
$question1 = new Question();
 $question1->setId("i can die in peace now");
echo $question1->id;


?>

</body>
</html>