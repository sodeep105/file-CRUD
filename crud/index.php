<?php

require_once('inc/functions.php');
$info = '';
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? 0;
if ('delete' == $task){
    $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
    if ($id>0){
        deleteStudent($id);
    }
    
    
}
if ('seed' == $task){
    seed();
    $info = 'Seeding is complete';
}
$fname = '';
$lname = '';
$roll = '';
if (isset($_POST['submit'])) {
    $fname = filter_input(INPUT_POST,'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST,'lname', FILTER_SANITIZE_STRING);
    $roll = filter_input(INPUT_POST,'roll', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_STRING);
    if($id) {
        updateStudent($id, $fname, $lname, $roll);
        header('location: /hasin/crud/index.php?task=report');
    } else {
        if ($fname!=='' && $lname!=='' && $roll!==''){
            $add = addStudent($fname,$lname,$roll);
            // TO CHECK WHETHER THE ROLL NUMBER IS UNIQUE
            if($add){
                header('location: /hasin/crud/index.php?task=report');
            } else {
                //IF SAME ROLL EXISTS THEN ERROR WILL BE DISPLAYED
                $error = '1';
                
            }
            
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Example</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2>Project 2 - CRUD</h2>
            <p>A sample project to perform CRUD operations using plain files and PHP</p>
            <?php include_once( 'inc/templates/navbar.php' ); ?>
            <hr/>
            <?php
            if($info != ''){
                echo "<p>{$info}</p>";
            } 
            ?>
        </div>
    </div>
    <?php if('1' == $error): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <blockquote>Please enter unique roll</blockquote>
                </div>
            </div>
        <?php endif; ?>
    <?php if('report' == $task): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <?php generateReport(); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if('add' == $task): ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action='/hasin/crud/index.php?task=add' method='post'>
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $fname; ?>">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $lname; ?>">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $roll; ?>">
                        <button type="submit" name="submit" class="button-primary">Save</button>

                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if('edit' == $task):
            $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_STRING);
            $student = getStudent($id);
            var_dump($student);
            if ($student):
                print("<h2>yo</h2>");
            ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action='' method='post'>
                        <input type="hidden" name="task" value="<?php echo $id; ?>">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?php echo $student['fname']; ?>">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?php echo $student['lname']; ?>">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?php echo $student['roll']; ?>">
                        <button type="submit" name="submit" class="button-primary">Update</button>

                    </form>
                </div>
            </div>
        <?php
        endif;
     endif; ?>
        
       
</div>

</body>
</html>