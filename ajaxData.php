<?php 
// Include the database config file 
require_once("db.php");
 
if(!empty($_POST["country_id"])){ 
    // Fetch state data based on the specific country 
    $query = "SELECT * FROM states WHERE country_id = ".$_POST['country_id']." ORDER BY name ASC"; 
    $result = $conn->query($query); 
     
    // Generate HTML of state options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select State</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['name'].'" data-id='.$row['id'].'>'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">State not available</option>'; 
    } 
}elseif(!empty($_POST["state_id"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT * FROM cities WHERE state_id = ".$_POST['state_id']." ORDER BY name ASC"; 
    $result = $conn->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select City</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['name'].'" data-id='.$row['id'].'>'.$row['name'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">City not available</option>'; 
    } 
} 
?>