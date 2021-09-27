<?php
$lt = "";
$ln = "";
$total = $city = "";
if (isset($_POST['finddetails'])) {
	$lt = $_POST['lat'];
	$ln = $_POST['lng'];
	$city = $_POST['city'];
} else {
	echo "<script>alert(\" Something went wrong!! \")</script>";
}
define('API_URL', 'https://test.api.amadeus.com');
$total = "";
$result = "";
$data = array(
	'client_id' => 'QyMyr0XrwJKaRWlbGUwKE6rrB6NAAKFM',
	'client_secret' => 'ndLjL8GEKeJFpP3u'
);
get_token($data);
get_countries($ln, $lt, $city);
function get_token($config)
{
	$url = API_URL . '/v1/security/oauth2/token';
	$headers = array(
		'Accept: application/x-www-form-urlencoded',
		'Accept-Language: en_US'
	);
	$opts = array(
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_URL => $url,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=" . $config['client_id'] . "&client_secret=" . $config['client_secret'],
		CURLOPT_RETURNTRANSFER => true
	);
	$c = curl_init();
	curl_setopt_array($c, $opts);
	$result = json_decode(curl_exec($c));
	//var_dump($result);
	$_SESSION['API']['token'] = $result->access_token;
	//var_dump($_SESSION['API']['token']);
	curl_close($c);
}

function get_countries($ln, $lt, $city)
{
$url = API_URL . "/v1/shopping/activities?longitude=" . $ln . "&latitude=" . $lt . "&radius=20";
$headers = array(
	"Content-Type: application/json",
	"Authorization: Bearer " . $_SESSION['API']['token']
);
$opts = array(
	CURLOPT_HTTPHEADER => $headers,
	CURLOPT_URL => $url,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_RETURNTRANSFER => true
);
$c = curl_init();
curl_setopt_array($c, $opts);
$result = json_decode(curl_exec($c));
//var_dump($result);
$total = count((array)$result->data);
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
  <title>world Travel</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css">
  <link rel="stylesheet" href="assets/css/owl.theme.css">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/section.css">
  <link rel="stylesheet" href="assets/css/services.css">
  <link rel="stylesheet" href="assets/css/flexslider.css" type="text/css">
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
      Activities
    </h2>
    <ol class="breadcrumb">
      <li><a href="index.php">Home</a></li>
      <li><a href="countries.php">Countries</a></li>
      <li><a href="#">Cities</a></li>
      <li><a href="#">Activities</a></li>
    </ol>
  </div> <!-- /.container -->
</section> <!-- /.section-background -->
<section class="features section-wrapper">
  <div class="container">
    <h2 class="section-title" id="data">
      Popular Activities in <?php echo $city; ?>
    </h2>
	  <?php
	  if ($result->data == null) {
		  echo "
			<script type=\"text/javascript\">
            var data = document.getElementById(\"data\");
            data.innerText=\"Try to search for another city, Data are not available for this city. \";
			</script>
		  ";
	  }
	  for ($i = 0; $i < $total; $i++) {
		  ?>
        <div class="row custom-table" id="sec">
          <div class="grid-50 table-cell">
            <h3 class="features-details">
              <span class="section-title"><?php echo $result->data[$i]->name ?></span>
            </h3>
            <ul class="features-list">
              <p><?php echo $result->data[$i]->shortDescription ?></p>
            </ul>
            <p class="features-details">
				<?php echo $result->data[$i]->price->currencyCode . ' ' . $result->data[$i]->price->amount; ?>
            </p>
            <a href="<?php echo $result->data[$i]->bookingLink ?></p>"
               class="btn btn-default custom-button border-radius">
              Book Ticket
            </a>
          </div>
          <div class="grid-50 table-cell">
			  <?php for ($j = 0; $j < sizeof($result->data[$i]->pictures); $j++) { ?>
                <img src="<?php echo $result->data[$i]->pictures[$j]; ?>" alt=""
                     class="features-img img-responsive _pos-abs">
			  <?php } ?>
          </div>
        </div> <!-- /.row -->
	  <?php }
	  curl_close($c);
	  } ?>
  </div> <!-- /.container -->
</section> <!-- /.features -->
<div class="subscribe section-wrapper">
  <a class="brand-logo" href="index.php" title="HOME"><i class="ion-paper-airplane"></i> world <span>Travel</span></a>
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
<script src="assets/js/jquery.flexslider.js"></script>
</body>
</html>