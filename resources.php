<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$index="";
$about="";
$events="";
$resources="indicationpage";
?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/head.php'); ?>

<body>
<?php include("includes/header.php"); ?>

  <!-- TODO: This should be your main page for your site. -->
  <h2 id="scrollresources"> Find a Resource for You! </h2>

<p class="explanation1"> Make sure you sign up for the listserve so we can send you information! </p>


<div class="slideshow">
  <div class="resources_slideshow">
    <div class="explanation">
    <p id="fillerresources"> Abroad opportunities can help accelreate your proficiency in Portuguese and further your understanding of Portuguese culture! Click the link to look at some cool abroad opportunities</p>
</div>
    <img id="style" src="images/studyabroadport.jpg">
    <p class="resourcecite"> <cite id="resource"> Source: <a href="https://www.youtube.com/watch?v=jlVd1p2nAIw">YouTube Channel</a> </cite> </p>
    <a id="link" href="https://experience.cornell.edu/opportunities/ciee-lisbon-portugal-language-and-culture-program">Check it Out!</a>
</div>
<div class="resources_slideshow">
<div class="explanation">
<p id="fillerresources"> Looking for a 1 on 1 tutor? Italki is the place you might be looking for. Italki pairs you with a teacher for more intimate, integrate, language lessons</p>
</div>
    <img id="style" src="images/italki.png">
    <p class="resourcecite"> <cite> Source: <a href="https://courses.edx.org/courses/course-v1:TsinghuaX+TM01x+2T2017/89de9bc82da34fc3b1206d6d81bd1189/"> EDX.org</a> </cite> </p>
    <a id="link" href="https://www.italki.com/home">Check it Out!</a>
</div>
<div class="resources_slideshow">
<div class="explanation">
<p id="fillerresources"> Whether it's on your way to work, class, during a workout, or winding down
  at the end of the day, listening to a portugese podcast allows for seamless immersion for user to practice listening proficiency while also being able to multitask and focus on what's directly in front of them.
</p>
</div>
    <img id="style" src="images/portpod101.jpg">
    <p class="resourcecite"> <cite id="resource"> Source: <a href="https://www.youtube.com/watch?v=5en7I8hNtM4">PortPod YouTube Channel</a> </cite> </p>
    <a id="link" href="https://www.portuguesepod101.com/">Check it Out!</a>
</div>
<div class="resources_slideshow">
  <div class="explanation">
<p id="fillerresources"> Conversation Countdown brings a fresh, innovative way to learning new languages. Instead of burning yourself out with attending class 5 days a week, try doing Conversation Countdown. CC focuses on immersion with conversation. Practice makes perfect: try Conversation Countdown today!
</p>
</div>
<!-- Source: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_slideshow-->
    <img id="style" src="images/ccport.png">
    <div class="resourcecite">
    <p> <cite> Source: <a href=" https://courses.fluentin3months.com/p/conversation-countdown
">Fluent in 3 Months</a> </cite> </p>
</div>
    <a id="link" href="https://courses.fluentin3months.com/p/conversation-countdown">Check it Out!</a>
</div>
<a class="navbuttonprev" onclick="nextpic(-1)">&larr;</a>
<a class="navbuttonnext" onclick="nextpic(1) ">&rarr;</a>

</div>
<div class="follow">
<a href="https://www.facebook.com/Portuguese-Language-Society-at-Cornell-2130866723908273/"><img alt="fb logo" id="fbredirect" src="images/followfb.png"></a>
<p id="fb"> Like us on Facebook!</p>
<p class="resourcecite"> <cite> Source: <a href=facebook.com> Facebook</a> </cite> </p>

</div>
<script>
  var picnumber=1;
  getpic(picnumber);
  function lastpic(index){
    getpic(picnumber-=index)
  }
  function nextpic(index){
    getpic(picnumber+=index)
  }
  function currpic(index){
    getpic(picnumber=index);
  }
  function getpic(index){
    var j;
    var pic= document.getElementsByClassName("resources_slideshow");
    if(index> pic.length){
      picnumber=1;
    }
    if(index < 1){
      picnumber=pic.length;
    }
    for(j=0; j<pic.length; j++){
      pic[j].style.display="none";
    }
    pic[picnumber-1].style.display = "block";

  }
</script>

<?php include("includes/footer.php"); ?>
</body>

</html>
