<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$index="indicationpage";
$about="";
$events="";
$resources="";

$subscriber_name = "";
$subscriber_email = "";
$text_box = "";

//This if statement is so that the viewer of the website can add themselves to the listserve
if (isset($_POST["submit"])) {
        $add_a_user = true;
        $list_name = filter_input(INPUT_POST, 'newsletter_name', FILTER_SANITIZE_STRING);
        $list_email = filter_input(INPUT_POST, 'subscriber_email', FILTER_VALIDATE_EMAIL);
        $list_textbox = filter_input(INPUT_POST, 'subscriber_textbox', FILTER_SANITIZE_STRING);

if ($add_a_user){
        $add_a_user_sql = "INSERT INTO listserve (list_name, list_email, list_textbox) VALUES (:list_name, :list_email, :list_textbox)";
        $listserve_params = array(
          ':list_name' => $list_name,
          ':list_email' => $list_email,
          ':list_textbox' => $list_textbox
        );

        $adding_a_user = exec_sql_query($db, $add_a_user_sql, $listserve_params);
      }
    }


// Letting the user know that they have any errors when trying to submit the listserve & printing out their results

$invalid_email_address = "jourdain1234";
$valid_email_address = "jourdanini4@gmail.com";
$newsletter_name_error = False;
$newsletter_email_error = False;

if (isset($_POST['submit'])){
        $user_subscribed = True;
        $subscriber_name = $_POST['newsletter_name'];

        if ($subscriber_name == '') {
                $user_subscribed = False;
                $newsletter_name_error = True;
        } else {

        }

        $text_box = $_POST['subscriber_textbox'];
        if ($text_box == '') {
                $user_subscribed = False;
                $newsletter_textbox_error = True;
        }

        $subscriber_email = $_POST['subscriber_email'];
        if ($subscriber_email == '') {
                $user_subscribed = False;
                $newsletter_email_error = True;
        }
        if (!filter_var($subscriber_email, FILTER_VALIDATE_EMAIL)) {
                $user_subscribed = False;
                $newsletter_email_error = True;
        }
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>
<body>

<?php include("includes/header.php"); ?>

<h1 class="welcome_text"> ¡Bem Vinda! </h1>

<h2 class="welcome_text2"> Welcome to the Portuguese Language Society at Cornell.  </h2>

<div class="banner_aligned">
        <figure>
         <img src="images/banner_option1.png" alt="banner"/>
         <!--Source: Jourdain, Nicole. Chicago, Illinois. 2018-->
        </figure>
</div>

<hr/>

<p class="avenir_text4">  We are a student-run organization... </p> <p class="text_inline"> The Portuguese Language Society Organization was created to provide a fun, non-academic environment for students to learn more about the Luso-Brazilian culture and practice the Portuguese language. Our club was founded in 2017, and we are open to all students from all levels and backgrounds of the  Portuguese language. Our club meets bi-weekly and we always have great food and conversation. One of the goals of the club is to provide Cornell students with the opportunity to really immerse themselves in the Portuguese language, culture, history, and origin. As an organization, we pride ourselves on ensuring that every member of the society feels that they are gaining enough knowledge to take what they have learned in the club and contribute it in some way to the rest of the world. </p>


<p class="text_inline"> Our website depicts more information about us as an organization. Our <strong> Home Page </strong> details more about Portuguese and the Luso-Brazilian culture. Where our <strong> About Us </strong> page provides brief bios for our board members. If you are interested in coming to any of our club events that information will always be displayed on our <strong> Events </strong> page and our <strong> Resources </strong> page provides you with a bit more information about where you can go to practice your Portuguese language skills outside of the organization and the classroom. </p>

<h2 class="avenir_text"> Why learn Portuguese? & What is <q>Luso-Brazilian?</q> </h2>

<div class="background_color">

        <div class="pictures_aligned2">
         <figure>
                <img class="luso-brazilian" src="images/luso_brazilian.jpg" alt="luso"/>
                <p class="citation"> <strong>  <cite> Source:  <a href = "https://rll.fas.harvard.edu/pages/portuguese-and-luso-brazilian"> Luso, Brazilian </a> </cite> </strong> </p>
                <!--Source: https://rll.fas.harvard.edu/pages/portuguese-and-luso-brazilian> Luso, Brazilian  -->
         </figure>

         <figure>
                <img class="luso-brazilian" src="images/propagating_succulents.png" alt="clothes"/>
                <p class="citation"> <strong>  <cite> Source:  <a href = "https://www.canva.com/design/DADMiPHG64E/iHypKCWY7Y9BPGfGdKc6ug/edit"> Canva  </a> </cite> </strong> </p>
                <!--Source: https://www.canva.com/design/DADMiPHG64E/iHypKCWY7Y9BPGfGdKc6ug/edit> Canva  -->
         </figure>
       </div>
</div>

<p class="text_inline"> Right now more than 220 people in the world speak Portuguese. It is the sixth most spoken romance language. The language is beautiful and the culture is extremely rich. Portueguse sets you apart from other languages and is very popular amongst young students. Learning and understanding Portuguese provides you with a cool new language to integrate and communicate in that many people <strong> especially people in the United States </strong> do not use. <strong> Luso-Brazilian </strong> is a word used to introduce the mix of Brazilian and Portuguese culture. Luso come from the term <strong> <q> Lusitania </q> </strong> which was the name of Portugal during the Roman Empire. </p>

<h3 class="bordersneakpeek"> Sign up for the listserve! </h3>

<div class="newsletter_form">

<?php
  if (isset($user_subscribed) && $user_subscribed) {?>

  <p class="avenir"><strong> Here is your subscription details: </strong></p>
  <p class="avenir"><strong> Name: </strong> <?php echo $subscriber_name; ?> </p>
  <p class="avenir"><strong> Email: </strong><?php echo $subscriber_email; ?> </p>
  <p class="avenir"><strong> What would you like to get out of the club? </strong><?php echo $text_box; ?> </p>


<?php } else { ?>
        <div class="newsletter_form">
  <form id="submit" method="post" action="index.php">
        <fieldset>
          <div class="form_name">
                <p class="newsletter_error" <?php if ($newsletter_name_error == False) echo "hidden"?>> Please enter a name. </p>
                <label for="name"> <strong> Name: </strong> </label>
                <input id="name" type="text" name="newsletter_name" value="<?php echo htmlspecialchars($subscriber_name)?>"/>
           </div>

           <div class="email_form">
                <p class="newsletter_error" <?php if ($newsletter_email_error == False) echo "hidden"?>> Please enter a valid email address. </p>
                <label for="email_area"> <strong> Email: </strong> </label>
                <input id="email_area" type="text" name="subscriber_email" value="<?php echo htmlspecialchars($subscriber_email)?>"/>
           </div>


           <div>
                <label for="textbox_area" class="textbox_form"><strong> What would you like to get out of the club?</strong> </label>
                <textarea id="textbox_area" name="subscriber_textbox" class="text_center_box"><?php echo htmlspecialchars($text_box)?></textarea>
                <p class="newsletter_error" <?php if ($newsletter_textbox_error == False) echo "hidden"?>> Please enter some text. </p>
           </div>

                <input class="submit_button" type="submit" name="submit" value="Subcribe"/>

        </fieldset>
   </form>
   </div>


<?php } ?>

        <div class="background_color">
        <div class="pictures_aligned">
          <figure>
            <img  src="images/sergio-souza-973713-unsplash.jpg" alt="city"/>

            <p class="citation"> <strong>  <cite> Source:  <a href = "https://unsplash.com/photos/tncsQE63ENU"> Sergio Souza  </a> </cite> </strong> </p>
            <!--Source: https://unsplash.com/photos/tncsQE63ENU> Sergio Souza -->
          </figure>

          <figure>
                <img  src="images/mauricio-santos-476020-unsplash.jpg" alt="book"/>
                <p class="citation"> <strong>  <cite> Source:  <a href = "https://unsplash.com/photos/HeWi6J5AN8o"> mauRÍCIO santos  </a> </cite> </strong> </p>
                <!--Source: https://unsplash.com/photos/HeWi6J5AN8o> mauRÍCIO santos -->

         </figure>

         <figure>
                <img  src="images/rafaela-biazi-680927-unsplash.jpg" alt="flag"/>
                <p class="citation"> <strong>  <cite> Source:  <a href = "https://unsplash.com/photos/0mfj0jJt0dY"> Rafaela Biazi </a> </cite> </strong>  </p>
                <!--Source: https://unsplash.com/photos/0mfj0jJt0dY> Rafaela Biazi -->

          </figure>

        </div>
        </div>
</div>
        <p class="avenir_text3"> <q> O maior perigo para a maioria de nós não é que nossa meta seja alta demais e nós não a alcancemos, mas que seja baixa demais e nós a atinjamos. </q> </p>

<?php include("includes/footer.php"); ?>
</body>
</html>
