<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$index="indicationpage";
$about="";
$events="";
$resources="";


function print_record($record){

    ?>

    <tr>
      <td><?php echo htmlspecialchars($record["list_name"]); ?></td>

      <td><?php echo htmlspecialchars($record["list_email"]); ?></td>

      <td><?php echo htmlspecialchars($record["list_textbox"]); ?></td>
      <td class="submit_button6"> <a href="<?php echo 'listserve.php?' .http_build_query(array('delete'=>htmlspecialchars($record["id"]), 'id'=>htmlspecialchars($record["id"])))?>"> Delete </a></td>
    </tr>

<?php
    }

    if (isset($_GET["delete"])){
        $listserve= filter_input(INPUT_GET, "delete", FILTER_SANITIZE_NUMBER_INT);
        $parameters = array(
            "id" => $listserve
        );
        $sqlite="DELETE FROM listserve WHERE id=:id";
        $execute_sqlite = exec_sql_query($db, $sqlite, $parameters);
    }
?>

<?php
// My search form
// Source: Lab 6 (Harms, Kyle)
const SEARCH_FIELDS = [
    "list_name" => "Name",
    "list_email" => "Email Address",
    "list_textbox" => "Message",
];

if (isset($_GET['search']) && isset($_GET['category']) ){
    $complete_search = TRUE;

    $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);

    if (in_array($category, array_keys(SEARCH_FIELDS))) {
        $search_field = $category;
    } else {
        array_push($sendmessages, "Invalid category for search.");
        $complete_search = FALSE;
    }
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    $search = trim($search);
} else {
    $complete_search = FALSE;
    $category = NULL;
    $search = NULL;
}

?>

<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>

<?php include("includes/header.php"); ?>

<h2 class="welcome_text2"> The Listserve </h2>

<p class="text_inline5"> Please keep all of names and emails for the users in our list serve. We like to keep them to send furture emails to our alumni. </p>


<h3 class="bordersneakpeek">  Search for a person: </h3>

    <?php
//    The messages to my user
    foreach ($sendmessages as $messages){
        echo "<p class=messages><strong>". htmlspecialchars($messages) . "</strong></p>\n";
    }
    ?>

<form id="searchForm" action="listserve.php" method="get">
    <select name="category">
    <option value="" selected disabled class="searchby"> Search By </option>
    <?php
    foreach(SEARCH_FIELDS as $search_name => $the_label){
    ?>
        <option value="<?php echo $search_name;?>"><?php echo $the_label;?></option>

        <?php
    }
        ?>
    </select>

    <input type="text" name="search"/>
    <button type="submit">Search</button>
</form>

<?php

if($complete_search) {
    ?>
    <h3 class="avenir_text"> The Results </h3>
    <?php

    $sqlite = "SELECT * FROM listserve WHERE ".$search_field." LIKE '%' || :search || '%'";
    $parameters = array(
        ':search' => $search
    );
} else {

?>
<?php

$sqlite = "SELECT * FROM listserve";
$parameters = array();
}
?>
<?php

$result = exec_sql_query($db, $sqlite, $parameters);

if ($result){
    $records = $result -> fetchAll();
}
?>

<div id="content-wrap">


<table>
  <tr>
    <th> Name </th>
    <th> Email </th>
    <th> Message</th>
  </tr>

   <?php
   foreach($records as $record){
    print_record($record);

  }
   ?>
</table>

</div>




<?php include("includes/footer.php"); ?>
</body>
</html>
