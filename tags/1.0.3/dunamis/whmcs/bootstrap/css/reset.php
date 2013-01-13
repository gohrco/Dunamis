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

<?php echo $m; ?> * { margin: 0px; padding: 0px; }

<?php echo $m; ?> html, 
<?php echo $m; ?> body, 
<?php echo $m; ?> div, 
<?php echo $m; ?> span, 
<?php echo $m; ?> applet, 
<?php echo $m; ?> object, 
<?php echo $m; ?> iframe,
<?php echo $m; ?> h1, 
<?php echo $m; ?> h2, 
<?php echo $m; ?> h3, 
<?php echo $m; ?> h4, 
<?php echo $m; ?> h5, 
<?php echo $m; ?> h6, 
<?php echo $m; ?> p, 
<?php echo $m; ?> blockquote, 
<?php echo $m; ?> pre,
<?php echo $m; ?> a, 
<?php echo $m; ?> abbr, 
<?php echo $m; ?> acronym, 
<?php echo $m; ?> address, 
<?php echo $m; ?> big, 
<?php echo $m; ?> cite, 
<?php echo $m; ?> code,
<?php echo $m; ?> del, 
<?php echo $m; ?> dfn, 
<?php echo $m; ?> em, 
<?php echo $m; ?> font, 
<?php echo $m; ?> img, 
<?php echo $m; ?> ins, 
<?php echo $m; ?> kbd, 
<?php echo $m; ?> q, 
<?php echo $m; ?> s, 
<?php echo $m; ?> samp,
<?php echo $m; ?> small, 
<?php echo $m; ?> strike, 
<?php echo $m; ?> strong, 
<?php echo $m; ?> sub, 
<?php echo $m; ?> sup, 
<?php echo $m; ?> tt, 
<?php echo $m; ?> var,
<?php echo $m; ?> b, 
<?php echo $m; ?> u, 
<?php echo $m; ?> i, 
<?php echo $m; ?> center,
<?php echo $m; ?> dl, 
<?php echo $m; ?> dt, 
<?php echo $m; ?> dd, 
<?php echo $m; ?> ol, 
<?php echo $m; ?> ul, 
<?php echo $m; ?> li,
<?php echo $m; ?> fieldset, 
<?php echo $m; ?> form, 
<?php echo $m; ?> label, 
<?php echo $m; ?> legend,
<?php echo $m; ?> table, 
<?php echo $m; ?> caption, 
<?php echo $m; ?> tbody, 
<?php echo $m; ?> tfoot, 
<?php echo $m; ?> thead, 
<?php echo $m; ?> tr, 
<?php echo $m; ?> th, 
<?php echo $m; ?> td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-size: 100%;
	/*)background: transparent;*/
}

<?php echo $m; ?> body {
	line-height: 1;
}

<?php echo $m; ?> ol, 
<?php echo $m; ?> ul {
	list-style: none;
}
<?php echo $m; ?> blockquote, 
<?php echo $m; ?> q {
	quotes: none;
}
<?php echo $m; ?> blockquote:before, 
<?php echo $m; ?> blockquote:after,
<?php echo $m; ?> q:before, 
<?php echo $m; ?> q:after {
	content: '';
	content: none;
}

/* remember to define focus styles! */
<?php echo $m; ?> :focus {
	outline: 0;
}

/* remember to highlight inserts somehow! */
<?php echo $m; ?> ins {
	text-decoration: none;
}
<?php echo $m; ?> del {
	text-decoration: line-through;
}

/* tables still need 'cellspacing="0"' in the markup */
<?php echo $m; ?> table {
	border-collapse: collapse;
	border-spacing: 0;
}


/* Embedded styles to modify */
<?php echo $m; ?> a {
	color:#333;
	text-decoration:underline;
}

<?php echo $m; ?> a:hover {
	background: none repeat scroll 0 0 transparent;
	color:#666;
	text-decoration:none;
}

<?php echo $m; ?> {
	background-color:#369;
	background-image:url(images/bg_background.gif);
	background-repeat:repeat-x;
	margin:0;
	padding:0;
}

<?php echo $m; ?>,
<?php echo $m; ?> td,
<?php echo $m; ?> th {
	color:#666;
	font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;
	font-size:12px;
	padding: 10px;
}

<?php echo $m; ?> form {
	margin:0;
	padding:0;
}

<?php echo $m; ?> h1 {
	border-bottom:1px solid #EBEBEB;
	color:#1a4d80;
	float:none;
	font-size:24px;
	font-weight:400;
	margin:0 0 12px;
	padding:0 0 3px;
	text-transform: inherit;
}

<?php echo $m; ?> h2 {
	border-bottom:1px solid #F5F5F5;
	color:#333;
	font-size:18px;
	font-weight:400;
	margin:0 0 5px;
	padding:10px 0 3px;
}

<?php echo $m; ?> h3 {
	color:#666;
	font-size:16px;
	font-weight:700;
	margin:0;
	padding:10px 0 5px;
}

<?php echo $m; ?> hr {
	background-color:#EBEBEB;
	border:0;
	border-top:1px solid #EBEBEB;
	height:0;
	margin:10px 0;
	overflow:hidden;
}

<?php echo $m; ?> input,
<?php echo $m; ?> select,
<?php echo $m; ?> textarea {
	color:#666;
	font-family:Lucida Sans Unicode, Lucida Grande, sans-serif;
	font-size:12px;
	margin:0;
	padding:2px;
}

