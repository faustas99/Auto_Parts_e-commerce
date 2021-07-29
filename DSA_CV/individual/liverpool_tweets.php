<!-- CSS STYLING -->
<style type="text/css">

/* set colour and styling settings for each printed tweet */
    h1{
    color: #38A1F3;
    }
    #username{
    color: #38A1F3;
    }
    /* Dividing line that separates each tweet */  
    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0;
        }   
   

</style>

<h1>Tweets About Liverpool and Points of Interest</h1>

<?php

        /* use config file contents to set database connection parameters */
        $xml=simplexml_load_file("configUWE.xml") or die("Error: Cannot create object");
        $host = $xml->data->host;
        $user = $xml->data->username;
        $password = $xml->data->password;
        $dbname = $xml->data->databasename;
                
        /* Connect to database and set error message if connection fails */
        $connect= mysqli_connect($host,$user,$password,$dbname);
        if (!$connect)
        {
        die("Unable to connect to the database". mysqli_connect_error());
        }

        /* use file to utilise API connection */
        ini_set('display_errors', 1);
        require_once('TwitterAPIExchange.php');
        
        header('Content-Type: text/html; charset="UTF-8"');
        
        /* API access tokens */
        $settings = array(
            'oauth_access_token' => "3251821983-UzMASrodGGZ1udNCTe02o2Cq1OJUTuhnLWpBJVB",
            'oauth_access_token_secret' => "CU8gwHUPmKLoq28PIhGNbqTdBzzRZ23mnGBdt83jn6c5m",
            'consumer_key' => "iEO3n7UiGROvmmNngIE64Vh9u",
            'consumer_secret' => "ZUHxNOZWdDvCAm29aHzgZDABfj1wIiKiJMOhtR45cVwU6z2QZ8"
        );
        
        /* Perform GET request and echo the response to display tweets that contain the following phrases or hashtags */
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=Liverpool+OR#Liverpool+OR#WorldMuseum+OR#NationalMuseumsofLiverpool+OR#LiverpoolMuseum+OR#MuseumofLiverpool+OR#Anfield+OR#LFC+OR#AnfieldLFC+OR#AnfieldRoad+OR#TheKop+OR#LiverpoolFC+OR#TheReds+OR#Redmen+OR#Sefton+OR#SeftonPark+OR#RoyalAlbertDock+OR#AlbertDock+OR#LiverpoolDock+OR#LiverpoolDocks+OR#TheRoyalAlbertDock+OR#LiverpoolCathedral+OR#StJamesMount+OR#LiverpoolAnglicanCathedral+OR#TheBeatles+OR#BeatlesStory+OR#TheBeatlesStoryExhibition+OR#BeatlesStoryExhibition';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        $data=$twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        /* Read the JSON into a PHP object */
        $phpdata = json_decode($data, true);
        
         /* Loop through the status updates and print out the users profile picture, time and date, name, username and text of each */
        foreach ($phpdata["statuses"] as $status){
            $profilepic=$status['user']['profile_image_url'];
            echo '<img src='.$profilepic.'></img>'."<br/>";
            echo("<p style = 'color: #38A1F3' >" ."Time and Date of Tweet: ".$status['created_at']."<br />"."</p>");
            //Creates paragraph with id of 'username' that will be used to reference paragraph e.g. styling
            echo "<p id='username'> Tweeted by: ". $status['user']['name']."<br/>";
            echo "Username: ". $status['user']['screen_name']."</p>";
            echo("<p>" . $status["text"] . "</p>")."<hr/>";
;           }

?>

<html>

    <h1>Most Recent User Comment From The Database</h1>

</html>

<?php
        /* Select and print only the most recent user comment from the local database and display it in a table format */
        $sql = "SELECT * FROM fet18000990.liverpool_tweets ORDER BY tweet_id DESC LIMIT 1";
        $result = mysqli_query($connect, $sql);
        
        echo "<br>";
        echo "<table border='1'>";
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><th>Comment Number</th><th>Username</th><th>Comment</th></tr>";
            echo "<tr>";
            foreach ($row as $field => $value) {
            echo "<td>" . $value . "</td>";
            }
            
            echo "</tr>";
        }
        echo "</table>";

?>

<html>
    
<style>
    /* CSS for form */
    * {
      box-sizing: border-box;
    }

    input[type=text], select, textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 4px;
      resize: vertical;
    }

    label {
      padding: 12px 12px 12px 0;
      display: inline-block;
    }

    input[type=submit] {
      background-color: #38A1F3;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      float: right;
    }

    input[type=submit]:hover {
      background-color: white;
      color: #38A1F3;
    }

    .container {
      border-radius: 5px;
      background-color: #f2f2f2;
      padding: 20px;
    }

    .col-25 {
      float: left;
      width: 25%;
      margin-top: 6px;
    }

    .col-75 {
      float: left;
      width: 75%;
      margin-top: 6px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    @media screen and (max-width: 600px) {
      .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
      }
    }
</style>

<h1>Add Your Own Comment</h1>

    <!-- Create a form to submit user comments and stay on page once submit has been selected -->
    <form action="liverpool_tweets.php" method="POST">
         <div class="row">
            <div class="col-25">
              <label for="username">Username</label>
            </div>
            <div class="col-50">
              <input type="text" id="username" name="username" required>
            </div>
             </div>
             <div class="row">
                <div class="col-25">
                  <label for="comment">Comment</label>
                </div>
            <div class="col-50">
              <textarea id="comment" name="comment" style="height:100px" required></textarea>
            </div>
          </div>
          <div class="row">
            <input type="submit" value="Submit" name="submit">
          </div>
    </form>

</html>

<?php

    /* set variables to the form inputs */
    $username = $_POST ['username'];
    $comment = $_POST ['comment'];
    $submit = $_POST ['submit'];

    /* if the submit button is pressed, insert the user comments into the local database */
    if (isset($_POST['submit'])) {

        /* insert user comments to the local database */
        $sql = "INSERT INTO fet18000990.liverpool_tweets VALUES  ('fet18000990.liverpool_tweets.tweet_id', '$username', '$comment');";
        $result = mysqli_query($connect,$sql);
    }

?>