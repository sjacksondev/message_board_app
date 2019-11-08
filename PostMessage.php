<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Board Exercise</title>
</head>
  <style>

        /* Header Styles */
        h1 {
            color: white;           
            font-size: 45px;
            padding-bottom: 12px;
            font-family: Impact;      
        }

        /* Body Styles */

        body {
           
           background-color: black;
           color: white;
           font-family: Arial;
        }

        /* Table Styles */
        
        table {
            border: white 3px;
        }

        /* Form Styles */

        form {
             padding-left: 12px;  
        }

        textarea {
            background-color: #FFB166
        }

        /* Paragraph Styles */

        p {
            color: white;
            font-size: 17px;
            font-family: Arial;
        }
        
        a {
            padding-left: 12px;
            color: white;
            font-size: 15px;
            font-family: Tahoma;   
        }

        a:hover {
            color: red;
        }

    </style>

<body>
    <?php
        if(isset($_POST['submit'])){
            $Subject = stripslashes($_POST['subject']);
            $Name = stripslashes($_POST['name']);
            $Message = stripslashes($_POST['message']);
            // Replace any '~' with '-' characters
            $Subject = str_replace("~", "-", $Subject);
            $Name = str_replace("~", "-", $Name);
            $Message = str_replace("~", "-", $Message);

            $ExistingSubjects = array();

            if(file_exists("MessageBoard/messages.txt") && filesize("MessageBoard/messages.txt") > 0) {
                $MessageArray = file("MessageBoard/messages.txt");
                $count = count($MessageArray);
                for ($i=0; $i < $count; $i++) { 
                    $CurrMsg = explode("~", $MessageArray[$i]);
                    $ExistingSubjects[] = $CurrMsg[0];
                }
            }
            
                if (in_array($Subject, $ExistingSubjects)) {
                    echo "<p>The subject you entered already exists!<br />\n";
                    echo "Please enter a new subject and try again.<br />\n";
                    echo "Your message was not saved.</p>";
                    $Subject = "";
                } 
                else {
                    $MessageRecord = "$Subject~$Name~$Message\n";
                    $MessageFile = fopen("MessageBoard/messages.txt", "ab");
                    if ($MessageFile === false) {
                        echo "There was an error saving your message!\n";
                    }
                    else {
                        fwrite($MessageFile, $MessageRecord);
                        fclose($MessageFile);
                        echo "Your message has been saved.\n";
                        $Subject = "";
                        $Message = "";
                    }
                }
            }
            else {
                $Subject = "";
                $Name = "";
                $Message = "";   
            }
            ?>
  
    <h1>Post New Message</h1>
    <hr/>
    <form action="PostMessage.php" method="POST">
        <p><span style="font-weight: bold">Subject:</span>
           <input style="background-color: #FFB166" type="text" name="subject" value="<?php echo $Subject; ?>" /></p>
        <p><span style="font-weight: bold">Name:</span>
           <input style="background-color: #FFB166" type="text" name="name" value="<?php echo $Name; ?>"/></p>
        <textarea name="message" rows="6" cols="80"><?php echo $Message; ?></textarea><br/>
        <input style="background-color: black;border-radius: 30px 50px;font-size: 14px;color: white;" type="submit" name="submit" value="Post Message"/>
        <input class="button" style="background-color: black;border-radius: 30px 50px;font-size: 14px;color: white;" type="reset" name="reset" value="Reset Form"/>
    </form>
    <hr/>
    <p><a href="MessageBoard.php">View Messages</a></p>  
</body>
</html>