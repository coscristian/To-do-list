<?php
session_start();

function validateDates($task_info){

    $day_start = $task_info['day_start'];
    $month_start = $task_info['month_start'];
    $year_start = $task_info['year_start'];

    $day_finish = $task_info['day_finish'];
    $month_finish = $task_info['month_finish'];
    $year_finish = $task_info['year_finish'];

    if ($day_start >= 1 && $day_start <= 31 &&  $day_finish >= 1 && $day_finish <= 31 && ($day_start <= $day_finish)){

        if ( $month_start >= 1 && $month_start <= 12 && $month_finish >= 1 && $month_finish <= 12 && ($month_start <= $month_finish) ){

            if ( $year_start >= 2001 && ($year_start <= $year_finish) ){

                return true;

            }else{

                return false;

            }

        }else{

            return false;

        }

    }else{

        return false;
    }

}

 function validateTask($task_info){

    $flag = true;
    
    foreach( $task_info as $item => $value ){

        if (empty($value) || !validateDates($task_info)){

            return false;

        }else{

            $flag = true;

        }
    }

    if ($flag == true){
        return true;
    }
 }

function date_name_month()
{
    date_default_timezone_set('America/Bogota');
    echo date("l") . ", " . date("F")  . " " . date("j");
}

$nameTask = $_POST['name'];
$tag = $_POST['tag'];
$description = $_POST['description'];

$day_start = $_POST['day-start'];
$month_start = $_POST['month-start'];
$year_start = $_POST['year-start'];

$day_finish = $_POST['day-finish'];
$month_finish = $_POST['month-finish'];
$year_finish = $_POST['year-finish'];

if($_SESSION['task-information'] == null){

    $_SESSION['task-information'] = array();

}

if (isset($_POST['save-task'])) {

    $task_info = array("name" => $nameTask, "tag" => $tag, "description" => $description,
    "day_start" => $day_start, "month_start" => $month_start, "year_start" => $year_start,
    "day_finish" => $day_finish, "month_finish" => $month_finish, "year_finish" => $year_finish);

    if ( validateTask($task_info) ){

        array_push($_SESSION['task-information'] , $task_info);
    
    }else{  ?>
        <div class="alert alert-danger" role="alert"> Incorrect Data, try again </div>
<?php
    }
}

if ( !isset($task_array) ){

    $task_array = array();

}

if ( isset($_POST['search-word']) ){

    $flag = false;

    $searched_word = $_POST['key-word'];

    for ($i = 0; $i < count($_SESSION['task-information']) ; $i++ ){

        if ( $searched_word == $_SESSION['task-information'][$i]['name'] ){

            echo "La palabra " . $searched_word . " está" . "<br>";

            $task_array[] = $_SESSION['task-information'][$i];
            $flag = true;
        }

    }

    if ( !$flag ){ 
        
        $task_array = $_SESSION['task-information']; ?>

        <div class="alert alert-danger" role="alert"> Tarea no encontrada </div>
        
    <?php
    }

}else{

    $task_array = $_SESSION['task-information'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    
</head>

<body>

<form action="todolist.php" method="POST">
    <div class="modal fade" id="miModal" tabindex="-1" aria-hidden="true" aria-labelledby="modalTitle" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Adding a Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">

                    <label for="name" class="form-label">Name Task</label>
                    <input type="text" class="form-control" name="name" placeholder="">

                    <label for="tag" class="form-label mt-2">Tag (s) </label>
                    <input type="text" class="form-control" name="tag" placeholder="">

                    <label for="description" class="form-label mt-2">Description</label>

                    <textarea class="form-control" placeholder="Describe your task" name="description"></textarea>

                    <div class="accordion mt-3" id="accordion_date_start">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_accordion_date_start" aria-expanded="true" aria-controls="collapseOne">
                                    Date to Start the Task
                                </button>
                            </h2>
                            <div id="collapse_accordion_date_start" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion_date_start">
                                <div class="accordion-body">

                                <label for="day-start" class="form-label mt-1">Day</label><br>
                                <input type="number" name="day-start" class="form-control">

                                <label for="month-start" class="form-label mt-1">Month</label><br>
                                <input type="number" name="month-start" class="form-control">

                                <label for="year-start" class="form-label mt-1">Year</label><br>
                                <input type="number" name="year-start" class="form-control">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion mt-3" id="accordion_date_finish">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_accordion_date_finish" aria-expanded="true" aria-controls="collapseOne">
                                    Date to Finish the Task
                                </button>
                            </h2>
                            <div id="collapse_accordion_date_finish" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion_date_finish">
                                <div class="accordion-body">

                                <label for="day-finish" class="form-label mt-1">Day</label><br>
                                <input type="number" name="day-finish" class="form-control">

                                <label for="month-start" class="form-label mt-1">Month</label><br>
                                <input type="text" name="month-finish" class="form-control">

                                <label for="year-start" class="form-label mt-1">Year</label><br>
                                <input type="number" name="year-finish" class="form-control">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary menu-color" style="border: none;"  name="save-task">Save
                        </button>
                </div>
            </div>
        </div>
    </div>
</form>

    <div class="container padding menu-color" style="background-color:#5C6BC0;">
        <h2 style="color: white;">My Day</h2>
        <p style="color: white;">
            <?php

            date_name_month();

            ?>
        </p>

    </div>

    <div class="container border border-1 text-center">

        <?php

            if ( !empty($_SESSION['task-information']) ){  ?>

                <form action="todolist.php" method="POST">

                    <label for="key-word">Palabra clave</label>

                        <input type="text"  id="key-word" name="key-word">
                        <button type="submit" name="search-word">Buscar</button>
                </form>
        <?php
            }
        ?>

        <button type="button" class="btn btn-primary p-2 ml-2 mt-2 " data-bs-toggle="modal" data-bs-target="#miModal">

            <h6 style="color: white;" class="m-0 " > + Add Task</h6>

        </button> 

        <!-- <form action="todolist.php" method="POST">
            <button type="button" class="btn btn-secondary p-2 ml-2 mt-2 " name="order-by-date">

                <h6 style="color: white;" class="m-0 " > Order by  Date</h6>

            </button> -->

            <?php

            if (!isset($_SESSION['selected_task'])){
                $_SESSION['selected_task'] = array();
            }

            if (isset($_POST['index_task'])){
                foreach($_POST['index_task'] as $value){
                    array_push($_SESSION['selected_task'], $value);
                }
            }

            ?>

        </form>

            <hr>                
            
            <form action= " <?php
            
                if ( isset( $_POST['delete_task']) ) {

                    echo "delete_task.php";

                }else if ( isset( $_POST['mark-as-done'] ) ){

                    echo "todolist.php";

                } ?> "  method="post" >

            <?php for($i = 0; $i < count($task_array); $i++ ){ ?>

                    <div class="form-check mb-3 text-center rounded" style="color: <?php 
                        
                        if ( isset($_SESSION['selected_task']) && isset($_POST['mark-as-done'])){

                            if( in_array( $i, $_SESSION['selected_task'] ) ){

                                echo "green; font-weight: bold;";
                            }
                        }

                        ?>">

                        <label>  <input class="form-check-input" type="checkbox" value="<?php echo $i; ?>" name="index_task[]" > 

                        <?php        for($j = 0; $j < count($task_array[$i]) ; $j++) ?>
                                        <h5>
                                            <?php  echo $task_array[$i]['name'];  ?>
                                        </h5>
                                        <p>
                                            <?php 
                                            
                                            echo $task_array[$i]['tag'] . "<br>"; 

                                            echo $task_array[$i]['description'] . "<br>";

                                            echo "Fecha de Inicio: " . $task_array[$i]['day_start'] . " / " 
                                            . $task_array[$i]['month_start'] . " / " . $task_array[$i]['year_start'] . "<br>". 
                                            $_SESSION['task-information'][$i]['time_start'] . "<br>";

                                            echo "Fecha Final: " . $task_array[$i]['day_finish'] . " / " 
                                            . $task_array[$i]['month_finish'] . " / " . $task_array[$i]['year_finish'] . "<br>". 
                                            $task_array[$i]['time_finish'] ;

                                            ?>
                                            <br>

                                        </p>
                                        <button type="submit" name="delete_task" class="btn btn-danger" value="<?php echo $i; ?>">Eliminar</button>
                                        <button type="submit" name="mark-as-done" class="btn btn-success" >Mark as Done</button>

                        </label>

                    </div>
                <hr>
        <?php } ?>

        </form>

</body>
<script type="text/javascript" src="evitar_reenvio.js"> </script>

</html>
<style>
    .padding {
        padding-top: 150px;
        padding-bottom: 8px;
    }

    .paddingb {
        padding-bottom: 8px;
    }

    .margin {
        margin-top: 50;
    }

    .menu-color {
        background-image: linear-gradient(-90deg, #6646f1, #8d39a7);
    }
</style>

