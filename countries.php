<?php
get_countries();
$result = "";
function get_countries() {
$url = 'https://restcountries.com/v2/all';
$opts = array(
	CURLOPT_URL => $url,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_RETURNTRANSFER => true
);
$c = curl_init();
curl_setopt_array($c, $opts);
$result = json_decode(curl_exec($c));
//var_dump($result);


?>
<!DOCTYPE html>
<!--[if IE 7 ]>
<html class="ie ie7 lte9 lte8 lte7" lang="en-US"><![endif]-->
<!--[if IE 8]>
<html class="ie ie8 lte9 lte8" lang="en-US">  <![endif]-->
<!--[if IE 9]>
<html class="ie ie9 lte9" lang="en-US"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="noIE" lang="en-US">
<!--<![endif]-->
<head>
  <!-- meta -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no"/>
  <title>World Travel</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css">
  <link rel="stylesheet" href="assets/css/owl.theme.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/section.css">
  <link rel="stylesheet" href="assets/css/contact.css">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="assets/js/html5shiv.js"></script>
  <script src="assets/js/respond.js"></script>
  <![endif]-->
  <!--[if IE 8]>
  <script src="assets/js/selectivizr.js"></script>
  <![endif]-->
  <script
    src="http://maps.googleapis.com/maps/api/js">
  </script>
</head>
<body>
<!-- Home -->
<section class="header" id="header">
  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php" title="HOME"><i class="ion-paper-airplane"></i> world
          <span>travel</span></a>
      </div> <!-- /.navbar-header -->
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="countries.php">Countries</a></li>
        </ul> <!-- /.nav -->
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>
</section> <!-- /#header -->
<!-- Section Background -->
<section class="section-background">
  <div class="container">
    <h2 class="page-header">
      Find best country to visit from here
    </h2>
    <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li class="active">Countries</li>
    </ol>
  </div> <!-- /.container -->
</section> <!-- /.section-background -->
<section class="contacts section-wrapper">
  <div class="container">
    <h2 class="section-title">
      Looking for best vacation?
    </h2>
    <p class="section-subtitle">
      Click on the country name and explore cities of the country to find various activities in cities.
    </p>
    <div class="row">
		<?php for ($i = 0; $i < sizeof($result); $i++) {
			if (isset($result[$i]->flags->svg,
				$result[$i]->name,
				$result[$i]->alpha2Code,
				$result[$i]->capital,
				$result[$i]->region,
				$result[$i]->population,
				$result[$i]->languages[0]->name,
				$result[$i]->currencies[0]->name,
				$result[$i]->currencies[0]->symbol)) {
				$flag = $result[$i]->flags->svg;
				$country_name = $result[$i]->name;
				$code = $result[$i]->alpha2Code;
				$capital = $result[$i]->capital;
				$region = $result[$i]->region;
				$population = $result[$i]->population;
				$language = $result[$i]->languages[0]->name;
				$currency = $result[$i]->currencies[0]->name;
				$symbol = $result[$i]->currencies[0]->symbol;
				?>
              <div class="col-sm-4 merbtm">
                <div class="contact">
                  <div class="contact-icon">
                    <img src="<?php echo $flag ?>" alt="Flag of the <?php echo ' ' . $country_name ?>" class="flag">
                  </div>
                  <div class="contact-name">
                    <form action="cities.php" method="POST">
                      <input type="hidden" name="ccode" value="<?php echo $code ?>"/>
                      <input type="hidden" name="countryname" value="<?php echo $country_name ?>"/>
                      <input type="submit" name="getcities" value="<?php echo $country_name ?>"/>
                    </form>
                  </div>
                  <div class="contact-detail">
                    <span class="lb">Capital</span>
					  <?php echo $capital ?><br>
                    <span class="lb">Region</span>
					  <?php echo $region ?><br>
                    <span class="lb">Population</span>
					  <?php echo $population ?><br>
                    <span class="lb">Language</span>
					  <?php echo $language ?><br>
                    <span class="lb">Currency</span>
					  <?php echo $currency . ' (' . $symbol . ')' ?><br>

                  </div>
                </div> <!-- /.contact -->
              </div> <!-- /.col-sm-4 -->
			<?php }
		}
		curl_close($c);
		} ?>
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.contacts -->
<div class="subscribe section-wrapper">
  <a class="brand-logo" href="index.php" title="HOME"><i class="ion-paper-airplane"></i> World <span>Travel</span></a>
  <ul class="social-icon">
    <li><a href="#"><i class="ion-social-twitter"></i></a></li>
    <li><a href="#"><i class="ion-social-facebook"></i></a></li>
    <li><a href="#"><i class="ion-social-linkedin-outline"></i></a></li>
    <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
  </ul>
</div> <!-- /.subscribe -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="text-center">
          &copy; Copyright world Travels
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="assets/js/jquery-1.11.2.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/contact.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>