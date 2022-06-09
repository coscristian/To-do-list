<?php
 session_start();

 $array_index = $_POST['index_task'];

function delete_Task(&$array_index){

    $total_elements = count($array_index);

    $cont = 0;

    for($i = 0; $i < $total_elements; $i++){

        $cont++;
        $index_to_delete = intval( $array_index[$i] );

        if ($cont >= 2){        // after deleting the first element, array_splice orders the indexes starting by cero
            $index_to_delete--;
        }
        
        array_splice( $_SESSION['task-information'] , $index_to_delete, 1);  //Delete the task in the correct index

    }
}

if (isset($_POST['delete_task']) ){

    // var_dump($_SESSION['task-information']);
    // var_dump($array_index);

    if (!empty($_POST['index_task'])){  //If the user has selected more than 1 task

        delete_Task($array_index); 

    }else{

        $index_to_delete = $_POST['delete_task'];

        array_splice( $_SESSION['task-information'] , $index_to_delete, 1);

    } ?>

    <h4><strong>Elemento eliminado correctamente</strong></h4>   

<?php

}
?>

<h5> <a href="<?=$_SERVER["HTTP_REFERER"]?>">Atras</a> </h5>

