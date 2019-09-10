<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$index="";
$about="";
$events="indicationpage";
$resources="";

if(isset($_POST['addEvent']) && is_user_logged_in()) {
  $newEventDate = $_POST["eventDate"];
  $sql = "INSERT INTO events (name, month, day, year, time) VALUES (:name, :month, :day, :year, :time);";
  $params = array(
    ':name' => filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING),
    ':month' => substr($newEventDate, 0, 2),
    ':day' => substr($newEventDate, 3, 2),
    ':year' => substr($newEventDate, 6, 4),
    ':time' => ($_POST[eventHour] . ":" . $_POST[eventMin] . $_POST[eventAMPM])
  );
  $result = exec_sql_query($db, $sql, $params);
}

function deleteEvent($db, $record){
  $record_id = $record[0]['id'];
  $sql = "DELETE FROM events WHERE events.id = :record_id;";
  $params = array(
    ":record_id" => $record_id
  );
  $result = exec_sql_query($db, $sql, $params);
  header("location: events.php");
}

if(isset($_POST['deleteEvent']) && is_user_logged_in())
  {
    $currentRecord_id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM events WHERE events.id = :currentRecord";
    $params = array(
      ':currentRecord' => $currentRecord_id
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    deleteEvent($db, $result);
  }

/* draws a calendar */
function draw_calendar($month, $year, $db){

	/* draw table */
	$calendar = '<table class="calendar center">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++){
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
  }

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++){
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

      /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
      $sql = "SELECT events.name, events.time FROM events WHERE events.month = :month AND events.day = :day AND events.year = :year ORDER BY events.time;";
      //ORDER EVENTS PER DAY FROM EARLIEST TO LATEST IN THE DAY... SO ORDER BY TIME OF DAY
      $params = array(
        ':month' => $month,
        ':day' => $list_day,
        ':year' => $year
      );
      $result = exec_sql_query($db, $sql, $params)-> fetchAll();
      foreach ($result as $event){
        $calendar.= $event[0] . " " . $event[1];
        $calendar.= str_repeat('<p> </p>',2);
      }


		$calendar.= '</td>';
		if($running_day == 6){
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month){
				$calendar.= '<tr class="calendar-row">';
      }
			$running_day = -1;
			$days_in_this_week = 0;
    }
		$days_in_this_week++; $running_day++; $day_counter++;
  }

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8){
		for($x = 1; $x <= (8 - $days_in_this_week); $x++){
			$calendar.= '<td class="calendar-day-np"> </td>';
    }
  }

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	/* all done, return result */
	return $calendar;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body>
<?php include("includes/header.php"); ?>
  <!-- TODO: This should be the Events page for your site. -->
  <h1 class="eboard_members2"><u>Event Calendar</u></h1>
  <br>
  <p class = "text-inline"> Check out our events page every month for newly added events. We try to keep this page updated regularly; however, any last minute changes will be posted on our Facebook page. Please reach out to me if you have any questions about events or have new event ideas. We always welcome new ideas. Vejo vocês na próxima reunião!</p>

  <h1 class="welcome_text2"><?php echo(date("m") . "/" . date("Y"));?></h1>
  <?php echo(draw_calendar(date("m"), date("Y"), $db)); ?>
  <!-- EVENTUALLY ADD FORWARD ARROW AND BACK ARROW TO NAVIGATE TO DIFFERENT MONTHS (RATHER THAN JUST LOOK AT CURRENT MONTH)-->
  <br>
  <?php if (!is_user_logged_in()) { ?>

    <h3 class="bordersneakpeek"> Login to Update the calendar </h3>

        <div id = "login">
            <form id="loginForm" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

            <ul>
                <li class="form_name3">
                    <label for="username">Username:</label>
                    <input id="username" type="text" name="username" required/>
                </li>
                <li class="email_form3">
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" required/>
                </li>
                <li class="email_form2 form_error">
                <?php
                  foreach ($session_messages as $message) {
                   echo ("<strong>" . $message . "</strong>");
                  }
                ?>
                </li>
                <li>
                    <button class="submit_button" name="login" type="submit">Sign In</button>
                </li>
            </ul>
            </form>
        </div>

        <?php } else { ?>
        <div id = "logout">
        <?php
        // Log Out link
        //if ( is_user_logged_in() ) {
        // Add a logout query string parameter
            $logout_url = htmlspecialchars( $_SERVER['PHP_SELF'] ) . '?' . http_build_query( array( 'logout' => '' ) );

            echo '<h3 class="signout" id="nav-last"><a href="' . $logout_url . '">Sign Out ' . htmlspecialchars($current_user['username']) . '</a></h3>';
        }

  if (is_user_logged_in()) {
    ?>
    </div>
    <h3 class="bordersneakpeek"> Add an Event </h3>
    <form id="addEvent" action="events.php" method="post">
      <ul>

        <li class="form_name2">
          <label> Event Name:</label>
          <input id="name" type="text" name="name" required>
        </li>


        <li class="email_form2">
          <label>Date & Time:</label>
          <input type="text" name="eventDate" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" title="Date and Time must be in the format: mm/dd/yyyy" required>
          <div class="time_input">
            <input type="text" name="eventHour" pattern="(0[1-9]|1[012])" title="Hour must be two digits and <= 12" required>
            <label>:</label>
            <input type="text" name="eventMin" pattern="[0-5][0-9]" title="Minutes must be two digits and <= 59" required>
            <input type="text" name="eventAMPM" pattern="(AM|PM)" title="Must be 'AM' or 'PM'" required>

          <h5>format: "05/01/2019 05:05 PM"</h5>

  </div>
  </li>
        <li>
          <button class="submit_button" name="addEvent" type="submit">Add Event</button>
        </li>
      </ul>
    </form>

    <br>

    <h3 class="bordersneakpeek"> Event List</h3>
    <!-- IMPLEMENT EVENT LIST WITH DELETE BUTTONS NEXT TO THEM, JUST LIKE P3 -->
    <ul>
        <?php
        $records = exec_sql_query(
          $db,
          "SELECT * FROM events;",
          array()
          )->fetchAll();

        if (count($records) > 0) {
          foreach($records as $record){
            echo "<li>" . htmlspecialchars($record["name"]) . "  (Date: " . $record["month"]. "/" . $record["day"] . "/" . $record["year"] . "  " . $record["time"] . ")</li>";
            echo ("<li><form action='events.php' method='post'>
            <input type='hidden' name='id' value='" . $record["id"] . "'/>
            <input class='submit_button4' type='submit' name='deleteEvent' value='Delete'/>
            </form></li>");
          }
        } else {
          echo '<p><strong>No events added yet. Try adding an event!</strong></p>';
        }
        ?>
      </ul>

    <?php
  }
  ?>

<?php include("includes/footer.php"); ?>
</body>
</html>
