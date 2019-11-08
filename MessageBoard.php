<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Board Data</title>
</head>
      <style>
        h1 {
       
            color: white;
           
            font-size: 45px;
            padding-bottom: 12px;
            font-family: Impact;
        }
        
        body {
           
           background-color: black;
        }

        
        p {
            color: white;
            font-size: 17px;
            font-family: tahoma;
        }
       
        textarea {
          font-size: 15px;
          background-color: #FFB166;    
         }

        a {
            padding-left: 12px;
            color: white;
            font-size: 15px;
            font-family: Tahoma;    
        }

        a:hover {
          color: red;
          font-weight: 10px;
        }

        .button_hover_zoom:hover {
          transition: transform .5s ease;
        }
  
    </style>
<body>
    <h1>Message Board</h1>
    <?php
    
        if(isset($_GET['action'])) {
          if ((file_exists("MessageBoard/messages.txt")) && (filesize("MessageBoard/messages.txt") != 0)) {
              $MessageArray = file("MessageBoard/messages.txt");
              switch ($_GET['action']) {
                  case 'Delete First':
                    array_shift($MessageArray);
                    break;
                  case 'Delete Last':
                    array($MessageArray);
                    break;
                  case 'Delete Message':
                    if (isset($_GET['message'])) 
                      array_splice($MessageArray, $_GET['message'],1);
                    break;
                  case 'Remove Duplicates':
                    $MessageArray = array_unique($MessageArray);
                    $MessageArray = array_values($MessageArray);
                    break;
                  case 'Sort Ascending':
                    sort($MessageArray); 
                    break;
                  case 'Sort Descending':
                    rsort($MessageArray); 
                    break;
              } // End of switch statement
          if (count($MessageArray)>0) {
              $NewMessages = implode($MessageArray);
              $MessageStore = fopen("MessageBoard/messages.txt", "wb");
              if ($MessageStore === false) {
                  echo "There was an error updating the message file.\n";
              }
              else {
                  fwrite($MessageStore, $NewMessages);
                  fclose($MessageStore);
              }
          }
          else
              unlink("MessageBoard/messages.txt");
  }
        }
        // Check if the messages file exists or is empty first
        if((!file_exists("MessageBoard/messages.txt")) || (filesize("MessageBoard/messages.txt") == 0)){
            echo "<p>There are no messages posted.</p>\n";
        }
        else{
            $MessageArray = file("MessageBoard/messages.txt");
            echo "<table style=\"background-color: #FFB166; font-size: 15px; font-family: Tahoma;\" border=\"1\" width=\"100%\">\n";
            $count = count($MessageArray);

            forEach($MessageArray as $Message) { 
              $CurrMsg = explode("~", $Message);
              $KeyMessageArray[] = $CurrMsg;
            
            }

            for($i = 0; $i < $count; ++$i){
                $CurrMsg = explode("~", $MessageArray[$i]);
                echo "<tr>\n";
                echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . ($i + 1) . "</td>\n";
                echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject:</span>" . htmlentities($KeyMessageArray[$i][0]) . "<br/>\n";
                echo "<span style=\"font-weight: bold\">Name:</span> " . htmlentities($KeyMessageArray[$i][1]) . "<br/>\n";
                echo "<span style=\"text-decoration: underline; font-weight: bold\">Message:</span><br/>\n" . htmlentities($KeyMessageArray[$i][2]) . "</td>\n";
                echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=$i'>" . "Delete This Message</a></td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
    ?>
    <p><a href="PostMessage.php">Post New Message</a><br/>
    <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subjects A-Z</a><br/>
    <a href="MessageBoard.php?action=Sort%20Descending">Sort Subjects Z-A</a><br/>
    <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br/>
    <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br/>
    <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicate Messages</a><br/>
    </p>

    
</body>
</html>