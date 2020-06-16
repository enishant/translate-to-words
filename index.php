<?php
function translateToWords($number) {
/*****
* A recursive function to turn digits into words
* Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.    
*
*  (C) 2010 Peter Ajtai
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    See the GNU General Public License: <http://www.gnu.org/licenses/>.
*
*/
// zero is a special case, it cause problems even with typecasting if we don't deal with it here
  $max_size = pow(10,18);
  if (!$number) return "Zero";
  if (is_int($number) && $number < abs($max_size)) {
    switch ($number) {
      // set up some rules for converting digits to words
      case $number < 0:
        $prefix = "Negative";
        $suffix = translateToWords(-1*$number);
        $string = $prefix . " " . $suffix;
        break;
      case 1:
        $string = "One";
        break;
      case 2:
        $string = "Two";
        break;
      case 3:
        $string = "Three";
        break;
      case 4: 
        $string = "Four";
        break;
      case 5:
        $string = "Five";
        break;
      case 6:
        $string = "Six";
        break;
      case 7:
        $string = "Seven";
        break;
      case 8:
        $string = "Eight";
        break;
      case 9:
        $string = "Nine";
        break;    
      case 10:
        $string = "Ten";
        break;
      case 11:
        $string = "Eleven";
        break;
      case 12:
        $string = "Twelve";
        break;
      case 13:
        $string = "Thirteen";
        break;
        // fourteen handled later
        /*case 14:
          $string = "Fourteen";
          break;*/
      case 15:
        $string = "Fifteen";
        break;
      case $number < 20:
        $string = translateToWords($number%10);
        // eighteen only has one "t"
        if ($number == 18) {
          $suffix = "een";
        } else {
          $suffix = "teen";
        }
        $string .= $suffix;
        break;
      case 20:
        $string = "Twenty";
        break;
      case 30:
        $string = "Thirty";
        break;
      case 40:
        $string = "Forty";
        break;
      case 50:
        $string = "Fifty";
        break;
      case 60:
        $string = "Sixty";
        break;
      case 70:
        $string = "Seventy";
        break;
      case 80:
        $string = "Eighty";
        break;
      case 90:
        $string = "Ninety";
        break;
      case $number < 100:
        $prefix = translateToWords($number-$number%10);
        $suffix = translateToWords($number%10);
        $string = $prefix . " " . $suffix;
        break;
      // handles all number 100 to 999
      case $number < pow(10,3):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,2)))) . " Hundred";
        if ($number%pow(10,2)) $suffix = " and " . translateToWords($number%pow(10,2));
        $string = $prefix . $suffix;
        break;
      case $number < pow(10,6):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,3)))) . " Thousand";
        if ($number%pow(10,3)) $suffix = translateToWords($number%pow(10,3));
        $string = $prefix . " " . $suffix;
        break;
      case $number < pow(10,9):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,6)))) . " Million";
        if ($number%pow(10,6)) $suffix = translateToWords($number%pow(10,6));
        $string = $prefix . " " . $suffix;
        break;
      case $number < pow(10,12):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,9)))) . " Billion";
        if ($number%pow(10,9)) $suffix = translateToWords($number%pow(10,9));
        $string = $prefix . " " . $suffix;    
        break;
      case $number < pow(10,15):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,12)))) . " Trillion";
        if ($number%pow(10,12)) $suffix = translateToWords($number%pow(10,12));
        $string = $prefix . " " . $suffix;    
        break;
        // Be careful not to pass default formatted numbers in the quadrillions+ into this function
        // Default formatting is float and causes errors
      case $number < pow(10,18):
        // floor return a float not an integer
        $prefix = translateToWords(intval(floor($number/pow(10,15)))) . " quadrillion";
        if ($number%pow(10,15)) $suffix = translateToWords($number%pow(10,15));
        $string = $prefix . " " . $suffix;    
        break;
    }
  } else {
    echo "ERROR with - $number<br/> Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
  }
  return $string;
}
if(isset($_REQUEST['n'])) {
  header('Content-Type: application/json');
  echo json_encode(array('number' => (int)($_REQUEST['n']),'words' => translateToWords((int)($_REQUEST['n']))));
} else { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Translate To Words</title>
  <meta name="Description" content="Translate To Words">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/css/mdb.min.css" rel="stylesheet">
  <style type="text/css">
    .with-love {
      color: #ff0000;
      font-size: 1.4rem;
    }
    .with-love a {
      color: #FF9800;
    }
    .with-love a:hover {
      color: #03A9F4;
    }
    .md-form input[type=text],.md-form input[type=text]+label {
      font-size: 1.2rem;
    }
    .md-form input[type=text]:focus:not([readonly]),
    .md-form input[type=password]:focus:not([readonly]),
    .md-form input[type=email]:focus:not([readonly]),
    .md-form input[type=url]:focus:not([readonly]),
    .md-form input[type=time]:focus:not([readonly]),
    .md-form input[type=date]:focus:not([readonly]),
    .md-form input[type=datetime-local]:focus:not([readonly]),
    .md-form input[type=tel]:focus:not([readonly]),
    .md-form input[type=number]:focus:not([readonly]),
    .md-form input[type=search-md]:focus:not([readonly]),
    .md-form input[type=search]:focus:not([readonly]),
    .md-form textarea.md-textarea:focus:not([readonly]) {
      -webkit-box-shadow: 0 1px 0 0 #4caf50!important;
      box-shadow: 0 1px 0 0 #4caf50!important;
      border-bottom: 1px solid #4caf50!important; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="col-md-12">
      <h1 class="animated fadeInLeft mb-4">Translate To Words</h1>
      <div class="md-form animated fadeInRight mt-5">
        <input type="text" id="number" class="form-control p-2">
        <label for="number">Please Enter Number</label>
      </div>
      <div class="md-form">
        <h5 class="animated bounceIn delay-1s mb-3" id="response">Result Here</h5>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('#number').on('keyup',function(){
    var number = $(this).val();
    var final_number = '';
    var limit = 5;
    if(number != undefined && number.length > 0) {    
      for(var i=0;i<number.length;i++) {
        if(final_number.length == limit) {
          //continue;
        }
        var num_at = number.charAt(i);
        if(!isNaN(num_at)) {
          final_number = final_number + '' + num_at;
        }
      }
      if(final_number != undefined && final_number != '' && typeof(final_number) == 'string') {
        final_number = parseInt(final_number);
      } else {
        final_number = 0;
      }
      $(this).val(final_number);
      if(final_number > 0 && !$('#response').hasClass('loading')) {
        $('#response').html('<span class="fa fa-cog fa-spin">').addClass('loading').removeClass('animated bounceIn delay-1s');
        $.ajax({
          method: "POST",
          //url: "<?php echo $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']; ?>",
          url: "<?php echo $_SERVER['SCRIPT_URI']; ?>",
          data: { n: final_number },
          success: function( response ) {
            if(response.words != undefined && response.words != '') {
              $('#response').html(response.words).addClass('animated bounceIn').removeClass('loading');
            }
          },
          error: function( response ) {
            if(response.statusText != undefined && response.statusText == 'error' && response.readyState != undefined && response.readyState == 0) {
              $('#response').html('No Internet Connection! Cannot Process Your Request').addClass('animated bounceIn').removeClass('loading');
            }
          }
        });
      }
    }
  });
});
</script>
</html>
<?php } ?>
