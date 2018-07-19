<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    
    <head>
        <script language="javascript" type="text/javascript">
            function loadXMLDoc(url) {
                if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.open("GET", url, false);
                xmlhttp.send(null);
                document.getElementById("content").innerHTML = xmlhttp.responseText;
            }
        </script>
        <!-- Nivo Slideshow and JQuery, credits to Gilbert Pellegrom -->
        <link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
        <!-- Calendar -->
        <link rel="stylesheet" href="css/master.css" type="text/css" media="screen" charset="utf-8" />
        <script src="js/calendar.js" type="text/javascript"></script> 

        <!-- Smooth Menu -->
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
        <script src="js/animated-menu.js" type="text/javascript"></script>
        <title>iBookUnion (iBU) A Non-Profit, Student-Run Bookstore at UBC</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta name="description" content="iBU is a non-profit student-run bookstore that leads a fair secondhand textbooks market in UBC.">
        <meta name="keywords" content="textbooks, books, secondhand, second hand, ubc, ibookunion, i book union, ibu">
        <meta name="author" content="iBU IT Team">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    
    <body>
        <div id="container">
            <div id="header">
                	<h2>a non-profit student-run consignment bookstore</h2>

                	<h1>iBookUnion</h1>

                <div id="navigation_field">
                    <div id="navigation">
                        <ul>
                            <li class="green">
                                <p><a href="index.php">Home</a>

                                </p>
                                <p class="subtext">The front page</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('operations.php')">Operation</a>

                                </p>
                                <p class="subtext">Operation flow</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('partners.php')">Partners</a>

                                </p>
                                <p class="subtext">Our friends</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('about.php')">About</a>

                                </p>
                                <p class="subtext">Who we are</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('contact.php')">Contact</a>

                                </p>
                                <p class="subtext">Get in touch</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('joinus.php')">Join</a>

                                </p>
                                <p class="subtext">Come with passion</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('faq.php')">FAQ</a>

                                </p>
                                <p class="subtext">Common questions</p>
                            </li>
                            <li class="green">
                                <p><a onclick="loadXMLDoc('inventory.php')">Inventory</a>

                                </p>
                                <p class="subtext">Come with passion</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="sidecontainer">
                	<h3>Why iBU?</h3>

                <div class="why_ibu">
                    <div class="why_ibu_top"></div>
                    <div class="why_ibu_contents">	<em>Cheap!</em>

                        <p>Low commisson rate!</p>
                    </div>
                    <div class="why_ibu_footer"></div>
                </div>
                <div class="why_ibu">
                    <div class="why_ibu_top"></div>
                    <div class="why_ibu_contents">	<em>Non-Profit!</em>

                        <p>Proceeds donated to BC Children's Hospital!</p>
                    </div>
                    <div class="why_ibu_footer"></div>
                </div>
                <div class="why_ibu">
                    <div class="why_ibu_top"></div>
                    <div class="why_ibu_contents"> <em>Set Your Own Price!</em>

                        <p>&amp; we'll sell it for you!</p>
                    </div>
                    <div class="why_ibu_footer"></div>
                </div>
                	<h3>Upcoming Sessions</h3>
                	
				<!-- Dynamically create today's calendar -->
                <script type="text/javascript">
                	var calendar = new Calendar();
                    calendar.generateHTML();
                    document.write(calendar.getHTML());
                </script>
                
                <!-- Social media buttons -->
                <br>
                <div align="center"><a href="https://www.facebook.com/ibookunion.ubc" target="_blank">Add us on Facebook!</a>
                </div>
                <br>
                <div align="center"><a href="https://twitter.com/iBookUnion" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @iBookUnion</a>
                </div>
                <script>
                    ! function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }
                    (document, "script", "twitter-wjs");
                </script>
                
            </div>
            
            
            <!--The closing tag for the container div is intentionally left out -->
            <div id="content">
                <script type="text/javascript">
                    $(window).load(function () {
                        $('#slider').nivoSlider({
                            effect: 'random',
                            pauseTime: 5000,
                            animSpeed: 500,
                            controlNav: false
                        });
                    });
                </script>