<?php
   $category_name = "";
   	if(isset($_GET['category_name'])){
   		$category_name = $_GET['category_name'];
   	} else{
   		$category_name = "default";
   	}
	
	
	$image_file = "";
	
	switch($category_name){
		
 	case "abstract": $image_file = "_full_size_images/abstract.jpg";
	 				 break;
	
	case "animals": $image_file = "_full_size_images/animals.jpg";
	 				 break;	
	
	case "food": $image_file = "_full_size_images/food.jpg";
	 				 break;
	
	case "sports": $image_file = "_full_size_images/sports.jpg";
					 break;
	
	case "nature": $image_file = "_full_size_images/nature.jpg";
					 break;
	
	case "people": $image_file = "_full_size_images/people.jpg";
					 break;
	
	case "gadgets": $image_file = "_full_size_images/gadgets.jpg";
					 break;
	
	case "nightlife": $image_file = "_full_size_images/nightlife.jpg";
					 break;	
	
    default: 	   $image_file = "_full_size_images/default.jpg";
				   $category_name = "default";
					 break;
	
 }

    $src = imagecreatefromjpeg($image_file);
	
	
    list($width, $height, $type, $attr) = getimagesize($image_file);

    $split_size = '150';

	
 	$new_width = $width;
	$new_height = $height;

    $x_comp = intval($new_width / $split_size);
	
	
    $y_comp = intval($new_height / $split_size);
	



    $winning_string = '';
    $image_names = '';

 
   
    $dest = imagecreatetruecolor($split_size, $split_size);

    for ($y = 0; $y < $y_comp; $y++) {
			
        for ($i = 0; $i < $x_comp; $i++) {

			
            $characters = 'abcdefghijklmnopqrstuvwxyz';
            $ran_string = '';
            for ($p = 0; $p < 4; $p++) {
            					
                $ran_string .= $characters[mt_rand(0, strlen($characters) - 1)];
				
            }		
			
			
            imagecopy($dest, $src, 0, 0, $i * $split_size, $y * $split_size, $split_size, $split_size);
			$temp_i_value = $i * $split_size;
			$temp_y_value = $y * $split_size;
			
			
			
            imagejpeg($dest, "_split_images/$ran_string.jpg");

            
            $image_names .= $ran_string . ",";
        }
    }

    
    $image_names = substr($image_names, 0, -1);
    
    $images = explode(',', $image_names);
    shuffle($images);
    
    $shuffled_images = implode(",",$images);
       
?>