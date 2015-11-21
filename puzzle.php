<?php include_once "split.php"; ?>

<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>JigSaw Puzzle</title>
		<meta name="description" content="">
		<meta name="author" content="Dharmesh">

		<link rel="stylesheet" href="_css/reset.css" />
		<link rel="stylesheet" href="_css/jquery.dialog.min.css" />
		<link rel="stylesheet" href="_css/TimeCircles.css" />
		<link rel="stylesheet" href="_css/main.css" />
		<script src="_js/jquery-1.7.2.min.js"></script>
		<script src="_js/jquery.ui.core.min.js"></script>
        <script src="_js/jquery.ui.widget.min.js"></script>
        <script src="_js/jquery.ui.mouse.min.js"></script>
        <script src="_js/jquery.ui.sortable.min.js"></script>
        <script src="_js/jquery.dialog.js"></script>
		<script src="_js/TimeCircles.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<h1>Advanced Jigsaw Puzzle</h1>
			<h2>Drag and Drop Images and Solve the Puzzle</h2>
			
			
			
			<div id="left_side">
				<div id="puzzle_container">
					<?php             
            
			            echo "<ul id='sortable'>";
			            
			            foreach ($images as $key => $image_name) {
			                echo "<li class='ui-state-default' id='recordArr_$image_name'>
			                            <img src='_split_images/$image_name.jpg' /></li>";
			            }
			            
			            echo "</ul>"; 
        		    ?>

					
				</div> <!-- end of puzzle container -->
				
				
				<div id="control_buttons_container">
					<button class="start control_button">Start</button>
					
					<button class="try_again control_button" disabled>Try again</button>
					<button class="hint control_button" disabled>Hint</button>
					<button class="help control_button">Help</button>
				</div> <!-- end of control button container -->
				
			</div> <!-- end of left side div -->
			
			
			<div id="right_side">
				<div id="timer_container">
					<div class="zero_timer" data-timer="0"></div>
					<div class="timer hidden" data-timer="300"></div>
				</div> <!-- end of timer container -->
				
				<div id="categories_container">
					<h3>Categories</h3>
					<a href="puzzle.php?category_name=animals" class="button_left">Animals</a>
					<a href="puzzle.php?category_name=people" class="button_right">People</a>
					<a href="puzzle.php?category_name=food" class="button_left">Food</a>
					<a href="puzzle.php?category_name=nature" class="button_right">Nature</a>
					<a href="puzzle.php?category_name=sports" class="button_left">Sports</a>
					<a href="puzzle.php?category_name=abstract" class="button_right">Abstract</a>
					<a href="puzzle.php?category_name=gadgets" class="button_left">Gadgets</a>
					<a href="puzzle.php?category_name=nightlife" class="button_right">Nightlife</a>
				</div> <!-- end of categories container -->
				
				<div id="hint_container">
					<img src="_full_size_images/<?php echo $category_name; ?>.jpg" alt="Hint Image" class="hint_image" />
				</div> <!-- end of hint container -->
				
		    </div> <!-- end of right side div -->		
			
			
		</div> <!-- end of wrapper  -->
		
		<script type="text/javascript">
		
		
		$(document).ready(function(){
			var status = 0;
			var clear_timer;		
		
					
					$('.help').on('click', function(){
						$.dialog({
							mask: false,
							height: 'auto',
							title: 'Help',
							html: '<p>1. You have 5 minutes to complete the Puzzle</p><p>2. You can click the Hint Button only "Once" during the Game</p><p>3. You can click the buttons from the Category List to select differenct genre.</p>'
						});
						
					});			

			/* Winning Code */
			
			var winningString = "<?php echo $image_names; ?>";
  
                                     
                       
			
			$('.start').on('click', function(){
                   		$("#sortable").sortable({
                   		
                   		disabled: false,	
	                    opacity: 0.6,
	                    cursor: 'move',
	                    update: function() {                 	
                       
                        var currentString = '';
                        
                        $('#sortable li').each(function(){
                            var imageId = $(this).attr("id");
                            currentString += imageId.replace("recordArr_", "")+",";
                        });
                        
                        currentString = currentString.substr(0,(currentString.length) -1);
                        
                        if(currentString == winningString){
                        	                        	
                        	$('#sortable').sortable({
                        	disabled: true
                        	});
                        	
                            
                            $('.timer').TimeCircles().stop();
                            
                            $('#categories_container').off();
                            
                            $.dialog({
								mask: false,
								height: 'auto',
								title: 'Horray......',
								html: '<p>Congratulation You Won The Puzzle</p>'
							});  
                            
                            $('.timer').TimeCircles().destroy();
							
                                                       
                            $('.timer').addClass('hidden');
                            
                            
                            $('.zero_timer').removeClass('hidden');
                            
                            
                            clearTimeout(clear_timer);
                            
                            
                            $('.try_again').attr('disabled', true);  
                        }
                        
                    }
                });
                
                
                $('.zero_timer').addClass('hidden');

                $('.timer').removeClass('hidden');
                
				$(this).attr('disabled', true);

                if(status === 0){
                
                    
                    $('#categories_container').on('click', 'a', function(event){
                		event.preventDefault();
                	});
                	
                	
                    $('.hint').attr('disabled', false);                
                    
                    status = 1;             
                
                    
                    var clear_timer = setTimeout(function(){
                        $('.timer').TimeCircles().destroy();
                
                        
                        $('.timer').addClass('hidden');
                
                        
                        $('.zero_timer').removeClass('hidden');
                
                        
                        $('#sortable').sortable({
                        	disabled: true
                        })
                
                        
                        $('.try_again').attr('disabled', false);
                
                        
                        $('.hint').attr('disabled', true);
                
                    	
                        status = 0;
                
                        
                        hint_counter = 0;
                
                        
                        $('#categories_container').off();
                
                        
                        $.dialog({
								mask: false,
								height: 'auto',
								title: 'Alas......',
								html: '<p>You Lost ! Go Ahead and Click The Try Again Button</p>'
							});
				
                    },300000);


                    $('.timer').TimeCircles({
                        count_past_zero: true,
						circle_bg_color: "#33363c",

                        time: {

                            Hours: {
                                show: false
                            },

                            Days: {
                                show: false
                            },

                            Minutes:{
                                color: "#fcba37"
                            },

                            Seconds:{
                                color: "#378bfd"
                            }
                        }

                    }).start();

                }
    	
           });
           
           
           /* Timer Code */
          						
			$('.try_again').on('click', function(){
				$("#sortable").sortable({
                   		
                   		disabled: false,	
	                    opacity: 0.6,
	                    cursor: 'move',
	                    update: function() {    
                      
                       
                        var currentString = '';
                        
                        $('#sortable li').each(function(){
                            var imageId = $(this).attr("id");
                            currentString += imageId.replace("recordArr_", "")+",";
                        });
                        
                        currentString = currentString.substr(0,(currentString.length) -1);
                        
                        if(currentString == winningString){
                            $('#sortable').sortable({
                        	disabled: true
                        	});
                        	
                            
                            $('.timer').TimeCircles().stop();
                            
                            $('#categories_container').off();
                            
                            $.dialog({
								mask: false,
								height: 'auto',
								title: 'Horray......',
								html: '<p>Congratulation You Won The Puzzle</p>'
							});  
                            
                            $('.timer').TimeCircles().destroy();
							
                                                       
                            $('.timer').addClass('hidden');
                            
                            
                            $('.zero_timer').removeClass('hidden');
                            
                            
                            clearTimeout(clear_timer);
                            
                            
                            $('.try_again').attr('disabled', true);                            
                            							
                        }
                        
                    }
                });
                
                $('.zero_timer').addClass('hidden');
                $('.timer').removeClass('hidden');
                

                if(status === 0){
                	$('#categories_container').on('click', 'a', function(event){
                		event.preventDefault();
                	});
                    
                    $('.hint').attr('disabled', false);
                    
                    status = 1;
                    
                    
                    setTimeout(function(){
                        $('.timer').TimeCircles().destroy();
                    
                        $('.timer').addClass('hidden');
                    
                        $('.zero_timer').removeClass('hidden');
                    
                        $('#sortable').sortable({
                        	disabled: true
                        })
                    
                        $('.hint').attr('disabled', true);
                    
                        status = 0;
                    
                        
                        $('#categories_container').off();
                		
                		
                        $.dialog({
								mask: false,
								height: 'auto',
								title: 'Alas......',
								html: '<p>You Lost ! Go Ahead and Click The Try Again Button</p>'
							});
						
                    },300000);


                    $('.timer').TimeCircles({
                        start: true,
                        count_past_zero: true,
						circle_bg_color: "#33363c",

                        time: {

                            Hours: {
                                show: false
                            },

                            Days: {
                                show: false
                            },

                            Minutes:{
                                color: "#fcba37"
                            },

                            Seconds:{
                                color: "#378bfd"
                            }
                        }

                    }).start();


                }

            });
			
			$('.zero_timer').TimeCircles({
				circle_bg_color: "#33363c",
				count_past_zero: false,
			
				time:{
                    Hours: {
                        show: false
                    },

                    Days: {
                        show: false
                    },

                    Minutes:{
                        color: "#fcba37"
                    },

                    Seconds:{
                        color: "#378bfd"
                    }
              }
                
			});	
			
			
			$('.hint').click(function(){
					$(this).attr('disabled', true);					
					$('div#hint_container')
					.slideDown(1000);					
			var timer_id = setTimeout(function(){
						$('div#hint_container')
						.slideUp(3000, function(){
							clearTimeout(timer_id);							
						});
					},20000);

				});			
			
		});	
			
			
		</script>
	</body>
</html>