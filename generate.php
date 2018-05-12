<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$publisher = "";
	$published = "";
	$title = "";
	$pages = "";
	$author = "";
	$image = "";
	$excerpt = "";
	
	if(count($argv)!=3) {
	
		# display a polite message
		echo "Please provide TWO arguments. Example:\n";
		echo "Generate.php < isbn.txt > < index.html >\n";
		
	} else {

		$isbn_file = $argv[1];
		$file_name = $argv[2];
		
		$myfile = fopen($file_name, "w") or die("Unable to open file!");
		
		$line = "<!doctype html>\n";
		$line .= "<html lang='en'>\n";
			
			$line  .= "<head>\n";
				
				$line .= "<title>CSUF Sample</title>\n";
				
				$line .= "<meta charset='utf-8'>\n";
				$line .= "<meta name='viewport' content='width=device-width, initial-scale=1'>\n";
				$line .= "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>\n";
				$line .= "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>\n";
				$line .= "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>\n";
				
				$line .= "<style>\n";
				
					$line .= "#book_detail_1, #book_detail_2, #book_detail_3, #book_detail_4 {\n";
						$line .= "padding: 10px 10px 10px 10px;\n";
						$line .= "text-align: left;\n";
						$line .= "background-color: lightblue;\n";
						$line .= "margin-top: 20px;\n";
					$line .= "}\n";
				
					$line .= "* {box-sizing: border-box}\n";
					$line .= "body {font-family: Verdana, sans-serif; margin:0}\n";
					$line .= ".mySlides {display: none}\n";
					$line .= "img {vertical-align: middle;}\n";

					$line .= ".slideshow-container {\n";
						$line .= "max-width: 500px;\n";
						$line .= "position: relative;\n";
						$line .= "margin: auto;\n";
					$line .= "}\n";

					$line .= ".prev, .next {\n";
						$line .= "cursor: pointer;\n";
						$line .= "position: absolute;\n";
						$line .= "top: 50%;\n";
						$line .= "width: auto;\n";
						$line .= "padding: 16px;\n";
						$line .= "margin-top: -22px;\n";
						$line .= "color: white;\n";
						$line .= "font-weight: bold;\n";
						$line .= "font-size: 18px;\n";
						$line .= "transition: 0.6s ease;\n";
						$line .= "border-radius: 0 3px 3px 0;\n";
					$line .= "}\n";

					$line .= ".next {\n";
						$line .= "right: 0;\n";
						$line .= "border-radius: 3px 0 0 3px;\n";
					$line .= "}\n";

					$line .= ".prev:hover, .next:hover {\n";
						$line .= "background-color: rgba(0,0,0,0.8);\n";
					$line .= "}\n";

					$line .= ".text {\n";
						$line .= "color: #f2f2f2;\n";
						$line .= "font-size: 15px;\n";
						$line .= "padding: 8px 12px;\n";
						$line .= "position: absolute;\n";
						$line .= "bottom: 8px;\n";
						$line .= "width: 100%;\n";
						$line .= "text-align: center;\n";
					$line .= "}\n";

					$line .= ".numbertext {\n";
						$line .= "color: #f2f2f2;\n";
						$line .= "font-size: 12px;\n";
						$line .= "padding: 8px 12px;\n";
						$line .= "position: absolute;\n";
						$line .= "top: 0;\n";
					$line .= "}\n";

					$line .= ".dot {\n";
						$line .= "cursor: pointer;\n";
						$line .= "height: 15px;\n";
						$line .= "width: 15px;\n";
						$line .= "margin: 0 2px;\n";
						$line .= "background-color: #bbb;\n";
						$line .= "border-radius: 50%;\n";
						$line .= "display: inline-block;\n";
						$line .= "transition: background-color 0.6s ease;\n";
					$line .= "}\n";

					$line .= ".active, .dot:hover {\n";
						$line .= "background-color: #717171;\n";
					$line .= "}\n";

					$line .= ".fade {\n";
						$line .= "-webkit-animation-name: fade;\n";
						$line .= "-webkit-animation-duration: 1.5s;\n";
						$line .= "animation-name: fade;\n";
						$line .= "animation-duration: 1.5s;\n";
					$line .= "}\n";

					$line .= "@-webkit-keyframes fade {\n";
						$line .= "from {opacity: .4}\n";
						$line .= "to {opacity: 1}\n";
					$line .= "}\n";

					$line .= "@keyframes fade {\n";
						$line .= "from {opacity: .4}\n";
						$line .= "to {opacity: 1}\n";
					$line .= "}\n";

					$line .= "@media only screen and (max-width: 300px) {\n";
						$line .= ".prev, .next,.text {font-size: 11px}\n";
					$line .= "}\n";
					
				$line .= "</style>\n";
				
			$line .= "</head>\n";
			
			# construct body
			$line .= "<body>\n";
				
				$line .= "<div class='slideshow-container'>\n";

					$isbns = fopen($isbn_file, "r") or exit("Unable to open file!");
					
					$book = 1;
					while(!feof($isbns)) {
					
						# set JSON url
						$isbn = fgets($isbns);
						$isbn = str_replace(" ", '', $isbn);
						$isbn = str_replace("\n", '', $isbn);
						$isbn = str_replace("\r", '', $isbn);
						$url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . $isbn . "&jscmd=data&format=json";
						
						# get book details
						$result = file_get_contents($url);
						$set1 = json_decode($result, true);
						
						foreach ($set1 as $key1 => $value1) {
							
							foreach ($value1 as $key2 => $value2) {
							
								if($key2=="publishers") {
									$publisher = $value2[0]["name"];
								}
								
								if($key2=="publish_date") {
									$published = $value2;
								}
								
								if($key2=="title") {
									$title = $value2;
								}
							
								if($key2=="number_of_pages") {
									$pages = $value2;
								}

								if($key2=="authors") {
									$author = $value2[0]["name"];
								}
			
								if($key2=="cover") {
									$image = $value2["large"];
								}
								
								if($key2=="excerpts") {
									$excerpt = $value2[0]["text"];
								}
								
							}
						
						}
					
						$line .= "<div class='mySlides'>\n";
							
							$line .= "<div class='numbertext'>" . $book . " ~ " . $title . "</div>\n";
							$line .= "<img onclick='ShowHideDetail(" . $book . ")' src='" . $image . "' title='Click For Details...' style='width:100%'>\n";
							
							$line .= "<br/><div id='book_detail_" . $book . "' >\n";
								$line .= "<strong>ISBN:</strong> " . $isbn . "<br/>";
								$line .= "<strong>Title:</strong> " . $title . "<br/>";
								$line .= "<strong>Author:</strong> " . $author . "<br/>";
								$line .= "<strong>Excerpt:</strong> " . $excerpt;
							$line .= "</div>\n";							
							
						$line .= "</div>\n";
							
						$book++;
						
					}
					
					fclose($isbns);

					$line .= "<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>\n";
					$line .= "<a class='next' onclick='plusSlides(1)'>&#10095;</a>\n";

				$line .= "</div>\n";
				$line .= "<br/>\n";
				
				$line .= "<div style='text-align:center'>\n";
					for ($x = 1; $x < $book; $x++) {
						$line .= "<span class='dot' onclick='currentSlide(" . $x . ")'></span>\n";
					}
				$line .= "</div>\n";
				
				$line .= "<script>\n";

					$line .= "$(document).ready(function(){\n";
						$line .= "var x = document.getElementById('book_detail_1');\n";
						$line .= "x.style.display = 'none';\n";
						$line .= "var x = document.getElementById('book_detail_2');\n";
						$line .= "x.style.display = 'none';\n";
						$line .= "var x = document.getElementById('book_detail_3');\n";
						$line .= "x.style.display = 'none';\n";
						$line .= "var x = document.getElementById('book_detail_4');\n";
						$line .= "x.style.display = 'none';\n";						
					$line .= "})\n";
				
					$line .= "function ShowHideDetail(n) {\n";
						$line .= "var x = document.getElementById('book_detail_'+n);\n";
						$line .= "if (x.style.display === 'none') {\n";
							$line .= "x.style.display = 'block';\n";
						$line .= "} else {\n";
							$line .= "x.style.display = 'none';\n";
						$line .= "}\n";
					$line .= "}\n";

					$line .= "var slideIndex = 1;\n";
					$line .= "showSlides(slideIndex);\n";

					$line .= "function plusSlides(n) {\n";
					    $line .= "showSlides(slideIndex += n);\n";
					$line .= "}\n";

					$line .= "function currentSlide(n) {\n";
						$line .= "var x = document.getElementById('book_detail_'+n);\n";
						$line .= "x.style.display = 'none';\n";
					    $line .= "showSlides(slideIndex = n);\n";
					$line .= "}\n";

					$line .= "function showSlides(n) {\n";
					    $line .= "var i;\n";
					    $line .= "var slides = document.getElementsByClassName('mySlides');\n";
					    $line .= "var dots = document.getElementsByClassName('dot');\n";
					    $line .= "if (n > slides.length) {slideIndex = 1} \n";   
					    $line .= "if (n < 1) {slideIndex = slides.length}\n";
					    $line .= "for (i = 0; i < slides.length; i++) {\n";
						    $line .= "slides[i].style.display = 'none';\n";  
					    $line .= "}\n";
					    $line .= "for (i = 0; i < dots.length; i++) {\n";
						    $line .= "dots[i].className = dots[i].className.replace(' active', '');\n";
					    $line .= "}\n";
					    $line .= "slides[slideIndex-1].style.display = 'block';\n";
					    $line .= "dots[slideIndex-1].className += ' active';\n";
					$line .= "}\n";

				$line .= "</script>\n";
				
			$line .= "</body>\n";
			
		$line .= "</html>";

		# render html
		fwrite($myfile, $line);
	
	}

?>