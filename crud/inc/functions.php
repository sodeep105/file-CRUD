<?php
define( 'DB', '/c/xampp/htdocs/hasin/crud/data/db.txt');
 function seed() {
     $data = array(
         array(
                'id' => '1',
                'fname' => 'Sudip',
                'lname' =>'Sengupta',
                'roll' => '12'
            ),
                array(
                'id' => '2',
                'fname' => 'Amalesh',
                'lname' =>'Sengupta',
                'roll' => '13'
            ),
                array(
                'id' => '3',
                'fname' => 'Anannya',
                'lname' =>'Sengupta',
                'roll' => '14'
            ),
                array(
                'id' => '4',
                'fname' => 'Falguni',
                'lname' =>'Sengupta',
                'roll' => '15'
            ),
                array(
                'id' => '5',
                'fname' => 'Tulip',
                'lname' =>'Sengupta',
                'roll' => '1'
                )
     );
    $serializedData = serialize($data);
    file_put_contents('DB',$serializedData,LOCK_EX);
 }

 function generateReport() {
     $serializedData = file_get_contents('DB');
     $students = unserialize($serializedData);
     ?>
     <table>
        <tr>
            <th>Name</th>
            <th>Roll</th>
            <th width="25%">Action</th>
        </tr>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php printf('%s %s', $student['fname'], $student['lname']);?></td>
                <td><?php printf('%s', $student['roll']);?></td>
                <td><?php printf('<a href="/hasin/crud/index.php?task=edit&id=%s">Edit</a> || <a href="<a href="/hasin/crud/index.php?task=delete&id=%s">Delete</a>',$student['id'],$student['id']);?></td>
            </tr>
            <?php endforeach; ?>

     </table>
     <?php
     
     
     
 }

 function addStudent($fname,$lname,$roll) {
    $found = false;
    $serializedData = file_get_contents('DB');
    $students = unserialize($serializedData);
    foreach($students as $_student) {
        if($_student['roll']==$roll) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $newId = count($students)+1;
        $student = array(
        "id" => $newId,
        "fname" => $fname,
        "lname" => $lname,
        "roll" => $roll
    );
    array_push($students,$student);
    $serializedData = serialize($students);
    file_put_contents('DB',$serializedData,LOCK_EX);
    return true;
    }
    return false;
    

 }
 function getStudent($id) {
    $serializedData = file_get_contents('DB');
    $students = unserialize($serializedData);
    foreach($students as $student) {
        if($student['id']==$id) {
            return $student;
            
        }
        return False;
    }

 }

 function updateStudent($id, $fname, $lname, $roll) {
    $found = False;
    $serializedData = file_get_contents('DB');
    $students = unserialize($serializedData);
    foreach($students as $_student) {
        if($_student['roll']==$roll && $_student['id'] != $id) {
            $found = true;
            break; 
        }
    }
    if (!$found) {
        $students[ $id - 1 ]['fname'] = $fname;
        $students[ $id - 1 ]['lname'] = $lname;
        $students[ $id - 1 ]['roll'] = $roll;
        $serializedData = serialize($students);
        file_put_contents('DB',$serializedData,LOCK_EX);
    }
    

 }

 function deleteStudent($id) {
    $serializedData = file_get_contents('DB');
    $students = unserialize($serializedData);
    unset($students[$id-1]);
    $serializedData = serialize($students);
    file_put_contents('DB',$serializedData,LOCK_EX);

 }

 ?>
