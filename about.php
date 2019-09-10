<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$index="";
$about="indicationpage";
$events="";
$resources="";

const MAX_FILE_SIZE = 1000000;
if(isset($_POST['add_eboard_member']) && is_user_logged_in()) {

  $image_info = $_FILES["image_file"];
  $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
  $image_upload = $image_info['error'];

  if ($image_upload === UPLOAD_ERR_OK) {
    $image_name = basename($image_info["name"]);
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION) );

  $sql = "INSERT INTO member (name, position, year, major, fact, `image_name`, `image_ext`, description) VALUES ( :name, :position, :major, :school_year, :fun_fact, :image_name, :image_ext, :description);";
  $params = array(
    ':name' => filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING),
    ':position' => filter_input(INPUT_POST, "position", FILTER_SANITIZE_STRING),
    ':major' => filter_input(INPUT_POST, "major", FILTER_SANITIZE_STRING),
    ':school_year' => filter_input(INPUT_POST, "school_year", FILTER_SANITIZE_STRING),
    ':fun_fact' => filter_input(INPUT_POST, "fun_fact", FILTER_SANITIZE_STRING),
    ':image_name' => $image_name,
    ':image_ext' => $image_ext,
    ':description' => filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING)
  );
  $result = exec_sql_query($db, $sql, $params);
  if ($result) {
    $id = $db ->lastInsertId("id");
    $area = "uploads/images/";
    move_uploaded_file($_FILES["image_file"]["tmp_name"], $area."$id.$image_ext");
  }
} else {
  echo("There is a problem uploading your file");
}
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
<?php include("includes/header.php"); ?>
  <!-- TODO: This should be your main page for your site. -->
  <h1 class="eboard_members">Meet our wonderful 2018-2019 Eboard members!</h1>
  <p class = "text-inline">This is our eboard for the year. As you can see we come from different backgrounds, majors, and interests, but we came together to create a safe space and share our love for the Luso-Brazilian culture and the Portuguese language. We are so excited to meet all of you and for the upcoming events we have. Feel free to say hi when you see us on campus! We can't wait to meet all of you.</p>
  <!--Prints out eboard images-->
  <div class = "info">
<?php
      $records = exec_sql_query($db, "SELECT * FROM member")->fetchAll(PDO::FETCH_ASSOC);
      foreach($records as $record){
      print_eboard_image($record);
       echo '<p class = "eboard">' ."Name: ". htmlspecialchars($record["name"]) . "<br>" . "Position: " . $record["position"] ."<br>" . "Year: " . $record["year"] . "<br>" . "Major: " . $record["major"] . "<br>" . "Fun Fact: " . $record["fact"]. "</p>";

      }
      ?>
</div>

<?php
if (is_user_logged_in()) {
    ?>
  <h3 class="bordersneakpeek"> Add an Eboard Member </h3>
    <form id="add_eboard_member" action="about.php" method="post" enctype="multipart/form-data">

    <ul class="upload">

      <li class="upload_image">
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
          <label for="image_file"> Select an image:</label>
          <input id="image_file" type="file" name="image_file"/>
        </li>

        <li>
          <label for="image_description"> Description:</label>
          <input type="text" id="image_description" name="description" />
        </li>

        <li>
          <label for="name">Name:</label>
          <input id="name" type="text" name="name" required>
        </li>

        <li>
          <label for="position">Position:</label>
          <input id="position" type="text" name="position" required>
        </li>

        <li>
          <label for="year">Year:</label>
          <input id="year" type="text" name="school_year" required>
        </li>

        <li>
          <label for="position">Major:</label>
          <input id="major" type="text" name="major" required>
        </li>

        <li>
          <label for="fun_fact">Fun Fact:</label>
          <input id="fun_fact" type="text" name="fun_fact" required>
        </li>

        <li>
          <button class="submit_button2" name="add_eboard_member" type="submit">Add Eboard Member</button>
        </li>

      </ul>
    </form>
<?php } ?>

<cite><strong><a href = "https://medium.com/personal-growth/the-5-key-ingredients-of-an-authentic-person-259914abf6d5">Image Source for ebord member 3</a></strong></cite>

<p class="avenir_text3">"A vida e o amor que criamos são a vida e o amor que vivemos."</p>

<?php include("includes/footer.php"); ?>

</body>
</html>
