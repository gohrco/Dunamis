<?php 
ob_start("ob_gzhandler");
header("Content-type: text/css; charset: UTF-8");

/*-- Dunamis Inclusion --*/
$path	= dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . DIRECTORY_SEPARATOR . 'dunamis.php';
if ( file_exists( $path ) ) include_once( $path );
/*-- Dunamis Inclusion --*/

if (! array_key_exists( 'm', $_GET ) ) exit();

$m = '#' . $_GET['m'];

?>

<?php echo $m ?> .has-switch {
  display: inline-block;
  cursor: pointer;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  border: 1px solid;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  position: relative;
  text-align: left;
  overflow: hidden;
  line-height: 8px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
  min-width: 160px;
}

<?php echo $m ?> .has-switch.switch-mini {
  min-width: 72px;
}

<?php echo $m ?> .has-switch.switch-small {
  min-width: 80px;
}

<?php echo $m ?> .has-switch.switch-large {
  min-width: 120px;
}

<?php echo $m ?> .has-switch.deactivate {
  opacity: 0.5;
  filter: alpha(opacity=50);
  cursor: default !important;
}

<?php echo $m ?> .has-switch.deactivate label,
<?php echo $m ?> .has-switch.deactivate span {
  cursor: default !important;
}

<?php echo $m ?> .has-switch > div {
  display: inline-block;
  max-height: 32px;
  width: 150%;
  position: relative;
  top: 0;
}

<?php echo $m ?> .has-switch > div.switch-animate {
  -webkit-transition: left 0.5s;
  -moz-transition: left 0.5s;
  -o-transition: left 0.5s;
  transition: left 0.5s;
}

<?php echo $m ?> .has-switch > div.switch-off {
  left: -50%;
}

<?php echo $m ?> .has-switch > div.switch-on {
  left: 0%;
}

<?php echo $m ?> .has-switch input[type=checkbox] {
  display: none;
}

<?php echo $m ?> .has-switch span,
<?php echo $m ?> .has-switch label {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  cursor: pointer;
  position: relative;
  display: inline-block;
  height: 100%;
  padding-bottom: 4px;
  padding-top: 4px;
  font-size: 14px;
  line-height: 20px;
}

<?php echo $m ?> .has-switch span.switch-mini,
<?php echo $m ?> .has-switch label.switch-mini {
  padding-bottom: 4px;
  padding-top: 4px;
  font-size: 10px;
  line-height: 9px;
}

<?php echo $m ?> .has-switch span.switch-small,
<?php echo $m ?> .has-switch label.switch-small {
  padding-bottom: 3px;
  padding-top: 3px;
  font-size: 12px;
  line-height: 18px;
}

<?php echo $m ?> .has-switch span.switch-large,
<?php echo $m ?> .has-switch label.switch-large {
  padding-bottom: 9px;
  padding-top: 9px;
  font-size: 16px;
  line-height: normal;
}

<?php echo $m ?> .has-switch label {
  margin-top: -1px;
  margin-bottom: -1px;
  z-index: 100;
  width: 34%;
  border-left: 1px solid #cccccc;
  border-right: 1px solid #cccccc;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #f5f5f5;
  background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
  background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
  border-color: #e6e6e6 #e6e6e6 #bfbfbf;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #e6e6e6;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch label:hover,
<?php echo $m ?> .has-switch label:focus,
<?php echo $m ?> .has-switch label:active,
<?php echo $m ?> .has-switch label.active,
<?php echo $m ?> .has-switch label.disabled,
<?php echo $m ?> .has-switch label[disabled] {
  color: #ffffff;
  background-color: #e6e6e6;
  *background-color: #d9d9d9;
}

<?php echo $m ?> .has-switch label:active,
<?php echo $m ?> .has-switch label.active {
  background-color: #cccccc \9;
}

<?php echo $m ?> .has-switch span {
  text-align: center;
  z-index: 1;
  width: 33%;
}

<?php echo $m ?> .has-switch span.switch-left {
  -webkit-border-top-left-radius: 4px;
  -moz-border-radius-topleft: 4px;
  border-top-left-radius: 4px;
  -webkit-border-bottom-left-radius: 4px;
  -moz-border-radius-bottomleft: 4px;
  border-bottom-left-radius: 4px;
}

<?php echo $m ?> .has-switch span.switch-right {
  color: #333333;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  background-color: #f0f0f0;
  background-image: -moz-linear-gradient(top, #e6e6e6, #ffffff);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#e6e6e6), to(#ffffff));
  background-image: -webkit-linear-gradient(top, #e6e6e6, #ffffff);
  background-image: -o-linear-gradient(top, #e6e6e6, #ffffff);
  background-image: linear-gradient(to bottom, #e6e6e6, #ffffff);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffe6e6e6', endColorstr='#ffffffff', GradientType=0);
  border-color: #ffffff #ffffff #d9d9d9;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #ffffff;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-right:hover,
<?php echo $m ?> .has-switch span.switch-right:focus,
<?php echo $m ?> .has-switch span.switch-right:active,
<?php echo $m ?> .has-switch span.switch-right.active,
<?php echo $m ?> .has-switch span.switch-right.disabled,
<?php echo $m ?> .has-switch span.switch-right[disabled] {
  color: #333333;
  background-color: #ffffff;
  *background-color: #f2f2f2;
}

<?php echo $m ?> .has-switch span.switch-right:active,
<?php echo $m ?> .has-switch span.switch-right.active {
  background-color: #e6e6e6 \9;
}

<?php echo $m ?> .has-switch span.switch-primary,
<?php echo $m ?> .has-switch span.switch-left {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #005fcc;
  background-image: -moz-linear-gradient(top, #0044cc, #0088cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0044cc), to(#0088cc));
  background-image: -webkit-linear-gradient(top, #0044cc, #0088cc);
  background-image: -o-linear-gradient(top, #0044cc, #0088cc);
  background-image: linear-gradient(to bottom, #0044cc, #0088cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0044cc', endColorstr='#ff0088cc', GradientType=0);
  border-color: #0088cc #0088cc #005580;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #0088cc;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-primary:hover,
<?php echo $m ?> .has-switch span.switch-left:hover,
<?php echo $m ?> .has-switch span.switch-primary:focus,
<?php echo $m ?> .has-switch span.switch-left:focus,
<?php echo $m ?> .has-switch span.switch-primary:active,
<?php echo $m ?> .has-switch span.switch-left:active,
<?php echo $m ?> .has-switch span.switch-primary.active,
<?php echo $m ?> .has-switch span.switch-left.active,
<?php echo $m ?> .has-switch span.switch-primary.disabled,
<?php echo $m ?> .has-switch span.switch-left.disabled,
<?php echo $m ?> .has-switch span.switch-primary[disabled],
<?php echo $m ?> .has-switch span.switch-left[disabled] {
  color: #ffffff;
  background-color: #0088cc;
  *background-color: #0077b3;
}

<?php echo $m ?> .has-switch span.switch-primary:active,
<?php echo $m ?> .has-switch span.switch-left:active,
<?php echo $m ?> .has-switch span.switch-primary.active,
<?php echo $m ?> .has-switch span.switch-left.active {
  background-color: #006699 \9;
}

<?php echo $m ?> .has-switch span.switch-info {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #41a7c5;
  background-image: -moz-linear-gradient(top, #2f96b4, #5bc0de);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#2f96b4), to(#5bc0de));
  background-image: -webkit-linear-gradient(top, #2f96b4, #5bc0de);
  background-image: -o-linear-gradient(top, #2f96b4, #5bc0de);
  background-image: linear-gradient(to bottom, #2f96b4, #5bc0de);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff2f96b4', endColorstr='#ff5bc0de', GradientType=0);
  border-color: #5bc0de #5bc0de #28a1c5;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #5bc0de;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-info:hover,
<?php echo $m ?> .has-switch span.switch-info:focus,
<?php echo $m ?> .has-switch span.switch-info:active,
<?php echo $m ?> .has-switch span.switch-info.active,
<?php echo $m ?> .has-switch span.switch-info.disabled,
<?php echo $m ?> .has-switch span.switch-info[disabled] {
  color: #ffffff;
  background-color: #5bc0de;
  *background-color: #46b8da;
}

<?php echo $m ?> .has-switch span.switch-info:active,
<?php echo $m ?> .has-switch span.switch-info.active {
  background-color: #31b0d5 \9;
}

<?php echo $m ?> .has-switch span.switch-success {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #58b058;
  background-image: -moz-linear-gradient(top, #51a351, #62c462);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#51a351), to(#62c462));
  background-image: -webkit-linear-gradient(top, #51a351, #62c462);
  background-image: -o-linear-gradient(top, #51a351, #62c462);
  background-image: linear-gradient(to bottom, #51a351, #62c462);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff51a351', endColorstr='#ff62c462', GradientType=0);
  border-color: #62c462 #62c462 #3b9e3b;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #62c462;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-success:hover,
<?php echo $m ?> .has-switch span.switch-success:focus,
<?php echo $m ?> .has-switch span.switch-success:active,
<?php echo $m ?> .has-switch span.switch-success.active,
<?php echo $m ?> .has-switch span.switch-success.disabled,
<?php echo $m ?> .has-switch span.switch-success[disabled] {
  color: #ffffff;
  background-color: #62c462;
  *background-color: #4fbd4f;
}

<?php echo $m ?> .has-switch span.switch-success:active,
<?php echo $m ?> .has-switch span.switch-success.active {
  background-color: #42b142 \9;
}

<?php echo $m ?> .has-switch span.switch-warning {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #f9a123;
  background-image: -moz-linear-gradient(top, #f89406, #fbb450);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f89406), to(#fbb450));
  background-image: -webkit-linear-gradient(top, #f89406, #fbb450);
  background-image: -o-linear-gradient(top, #f89406, #fbb450);
  background-image: linear-gradient(to bottom, #f89406, #fbb450);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff89406', endColorstr='#fffbb450', GradientType=0);
  border-color: #fbb450 #fbb450 #f89406;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #fbb450;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-warning:hover,
<?php echo $m ?> .has-switch span.switch-warning:focus,
<?php echo $m ?> .has-switch span.switch-warning:active,
<?php echo $m ?> .has-switch span.switch-warning.active,
<?php echo $m ?> .has-switch span.switch-warning.disabled,
<?php echo $m ?> .has-switch span.switch-warning[disabled] {
  color: #ffffff;
  background-color: #fbb450;
  *background-color: #faa937;
}

<?php echo $m ?> .has-switch span.switch-warning:active,
<?php echo $m ?> .has-switch span.switch-warning.active {
  background-color: #fa9f1e \9;
}

<?php echo $m ?> .has-switch span.switch-danger {
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  background-color: #d14641;
  background-image: -moz-linear-gradient(top, #bd362f, #ee5f5b);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#bd362f), to(#ee5f5b));
  background-image: -webkit-linear-gradient(top, #bd362f, #ee5f5b);
  background-image: -o-linear-gradient(top, #bd362f, #ee5f5b);
  background-image: linear-gradient(to bottom, #bd362f, #ee5f5b);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffbd362f', endColorstr='#ffee5f5b', GradientType=0);
  border-color: #ee5f5b #ee5f5b #e51d18;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  *background-color: #ee5f5b;
  /* Darken IE7 buttons by default so they stand out more given they won't have borders */

  filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
}

<?php echo $m ?> .has-switch span.switch-danger:hover,
<?php echo $m ?> .has-switch span.switch-danger:focus,
<?php echo $m ?> .has-switch span.switch-danger:active,
<?php echo $m ?> .has-switch span.switch-danger.active,
<?php echo $m ?> .has-switch span.switch-danger.disabled,
<?php echo $m ?> .has-switch span.switch-danger[disabled] {
  color: #ffffff;
  background-color: #ee5f5b;
  *background-color: #ec4844;
}

<?php echo $m ?> .has-switch span.switch-danger:active,
<?php echo $m ?> .has-switch span.switch-danger.active {
  background-color: #e9322d \9;
}