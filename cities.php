<?php
$lat = $lng = $response = $countryName = $country = $count = $img = "";
function getCities()
{
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_URL => "https://spott.p.rapidapi.com/places?limit=100&country=" . $GLOBALS["country"] . "&skip=0&type=CITY",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => [
			"x-rapidapi-host: spott.p.rapidapi.com",
			"x-rapidapi-key: 8bdacfc3eamsh5efe1bb230baba4p1f7eccjsn020c20bb1c6a"
		],
	]);
	$GLOBALS["response"] = json_decode(curl_exec($curl));
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$GLOBALS["count"] = count($GLOBALS["response"]);
	}

}

function getImage($city)
{
	$url = "https://api.teleport.org/api/urban_areas/slug:" . $city . "/images/";
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
	//var_dump($result->photos[0]->image->mobile);
	if (isset($result->photos[0]->image)) {
		$GLOBALS["img"] = $result->photos[0]->image->mobile;
	} else {
		$GLOBALS["img"] = 'assets/images/NA.jpg';
	}
	//echo "<img src='" . $result->photos[0]->image->mobile . "'>";
	curl_close($c);
}

if (isset($_POST['getcities'])) {
	$country = $_POST['ccode'];
	$countryName = $_POST['getcities'];
} else {
	echo "<script>alert(\" Something went wrong!! \")</script>";
}
getCities();
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
  <link rel="stylesheet" href="assets/css/about.css">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="assets/js/html5shiv.js"></script>
  <script src="assets/js/respond.js"></script>
  <![endif]-->
  <!--[if IE 8]>
  <script src="assets/js/selectivizr.js"></script>
  <![endif]-->
</head>
<body>
<!-- Home -->
<section class="header">
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
          <li><a href="countries.php">Countries</a></li>
        </ul> <!-- /.nav -->
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>
</section> <!-- /#header -->
<!-- Section Background -->
<section class="section-background">
  <div class="container">
    <h2 class="page-header">
      Cities
    </h2>
    <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li><a href="countries.php">Countries</a></li>
      <li class="active">Cities</li>
    </ol>
  </div> <!-- /.container -->
</section> <!-- /.section-background -->
<section class="wwa section-wrapper">
  <div class="container">
    <h2 class="section-title">
      Cities of <?php echo $countryName; ?>
    </h2>
    <p class="section-subtitle">
      Here you can find your destination city out of &nbsp;<?php echo $count + 1; ?> cities
      of <?php echo $countryName; ?>
    </p>
    <div class="row">
		<?php for ($i = 0; $i < sizeof($response); $i++) { ?>
          <div class="col-sm-3 col-xs-6">
            <div class="who">
				<?php
				getImage(strtolower($response[$i]->name));
				?>
              <img src="<?php echo $img; ?>" alt="Image of the City" class="img-responsive who-img"
                   style="height: 200px" ;>

              <div>
                <p class="who-detail">
                  Population: <?php echo $response[$i]->population; ?>
                </p>
				  <?php
				  $lat = $response[$i]->coordinates->latitude;
				  $lng = $response[$i]->coordinates->longitude;
				  ?>
                <form action="details.php" method="POST">
                  <input type="hidden" name="lat" value="<?php echo $lat ?>"/>
                  <input type="hidden" name="lng" value="<?php echo $lng ?>"/>
                  <input type="hidden" name="city" value="<?php echo $response[$i]->name ?>"/>
                  <input type="submit" name="finddetails" value="<?php echo $response[$i]->name; ?>"
                         class="btn btn-default custom-button border-radius"/>
                </form>
              </div>
            </div>
          </div> <!-- /.col-sm-3 -->
		<?php } ?>
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.wwa -->
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
