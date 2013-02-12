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

<?php echo $m ?> article,
<?php echo $m ?> aside,
<?php echo $m ?> details,
<?php echo $m ?> figcaption,
<?php echo $m ?> figure,
<?php echo $m ?> footer,
<?php echo $m ?> header,
<?php echo $m ?> hgroup,
<?php echo $m ?> nav,
<?php echo $m ?> section { display: block;}
<?php echo $m ?> audio,
<?php echo $m ?> canvas,
<?php echo $m ?> video { display: inline-block; *display: inline; *zoom: 1;}
<?php echo $m ?> audio:not([controls]) { display: none;}
<?php echo $m ?> html { font-size: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
<?php echo $m ?> a:focus { outline: thin dotted #333; outline: 5px auto -webkit-focus-ring-color; outline-offset: -2px;}
<?php echo $m ?> a:hover,
<?php echo $m ?> a:active { outline: 0;}
<?php echo $m ?> sub,
<?php echo $m ?> sup { position: relative; font-size: 75%; line-height: 0; vertical-align: baseline;}
<?php echo $m ?> sup { top: -0.5em;}
<?php echo $m ?> sub { bottom: -0.25em;}
<?php echo $m ?> img { max-width: 100%; vertical-align: middle; border: 0; -ms-interpolation-mode: bicubic;}
<?php echo $m ?> #map_canvas img { max-width: none;}
<?php echo $m ?> button,
<?php echo $m ?> input,
<?php echo $m ?> select,
<?php echo $m ?> textarea { margin: 0; font-size: 100%; vertical-align: middle;}
<?php echo $m ?> button,
<?php echo $m ?> input { *overflow: visible; line-height: normal;}
<?php echo $m ?> button::-moz-focus-inner,
<?php echo $m ?> input::-moz-focus-inner { padding: 0; border: 0;}
<?php echo $m ?> button,
<?php echo $m ?> input[type="button"],
<?php echo $m ?> input[type="reset"],
<?php echo $m ?> input[type="submit"] { cursor: pointer; -webkit-appearance: button;}
<?php echo $m ?> input[type="search"] { -webkit-box-sizing: content-box; -moz-box-sizing: content-box; box-sizing: content-box; -webkit-appearance: textfield;}
<?php echo $m ?> input[type="search"]::-webkit-search-decoration,
<?php echo $m ?> input[type="search"]::-webkit-search-cancel-button { -webkit-appearance: none;}
<?php echo $m ?> textarea { overflow: auto; vertical-align: top;}
<?php echo $m ?> .clearfix { *zoom: 1;}
<?php echo $m ?> .clearfix:before,
<?php echo $m ?> .clearfix:after { display: table; content: "";}
<?php echo $m ?> .clearfix:after { clear: both;}
<?php echo $m ?> .hide-text { font: 0/0 a; color: transparent; text-shadow: none; background-color: transparent; border: 0;}
<?php echo $m ?> .input-block-level { display: block; width: 100%; min-height: 28px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;}
<?php echo $m ?> { margin: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; line-height: 18px; color: #333333; background-color: #ffffff;}
<?php echo $m ?> a { color: #0088cc; text-decoration: none;}
<?php echo $m ?> a:hover { color: #005580; text-decoration: underline;}
<?php echo $m ?> .row { margin-left: -20px; *zoom: 1;}
<?php echo $m ?> .row:before,
<?php echo $m ?> .row:after { display: table; content: "";}
<?php echo $m ?> .row:after { clear: both;}
<?php echo $m ?> [class*="span"] { float: left; margin-left: 20px;}
<?php echo $m ?> .container,
<?php echo $m ?> .navbar-fixed-top .container,
<?php echo $m ?> .navbar-fixed-bottom .container { width: 940px;}
.formError .span12,
<?php echo $m ?> .span12 { width: 940px;}
.formError .span11,
<?php echo $m ?> .span11 { width: 860px;}
.formError .span10,
<?php echo $m ?> .span10 { width: 780px;}
.formError .span9,
<?php echo $m ?> .span9 { width: 700px;}
.formError .span8,
<?php echo $m ?> .span8 { width: 620px;}
.formError .span7,
<?php echo $m ?> .span7 { width: 540px;}
.formError .span6,
<?php echo $m ?> .span6 { width: 460px;}
.formError .span5,
<?php echo $m ?> .span5 { width: 380px;}
.formError .span4,
<?php echo $m ?> .span4 { width: 300px;}
.formError .span3,
<?php echo $m ?> .span3 { width: 220px;}
.formError .span2,
<?php echo $m ?> .span2 { width: 140px;}
.formError .span1,
<?php echo $m ?> .span1 { width: 60px;}
<?php echo $m ?> .offset12 { margin-left: 980px;}
<?php echo $m ?> .offset11 { margin-left: 900px;}
<?php echo $m ?> .offset10 { margin-left: 820px;}
<?php echo $m ?> .offset9 { margin-left: 740px;}
<?php echo $m ?> .offset8 { margin-left: 660px;}
<?php echo $m ?> .offset7 { margin-left: 580px;}
<?php echo $m ?> .offset6 { margin-left: 500px;}
<?php echo $m ?> .offset5 { margin-left: 420px;}
<?php echo $m ?> .offset4 { margin-left: 340px;}
<?php echo $m ?> .offset3 { margin-left: 260px;}
<?php echo $m ?> .offset2 { margin-left: 180px;}
<?php echo $m ?> .offset1 { margin-left: 100px;}
<?php echo $m ?> .row-fluid { width: 100%; *zoom: 1;}
<?php echo $m ?> .row-fluid:before,
<?php echo $m ?> .row-fluid:after { display: table; content: "";}
<?php echo $m ?> .row-fluid:after { clear: both;}
<?php echo $m ?> .row-fluid [class*="span"] { display: block; float: left; width: 100%; min-height: 28px; margin-left: 2.127659574%; *margin-left: 2.0744680846382977%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;}
<?php echo $m ?> .row-fluid [class*="span"]:first-child { margin-left: 0;}
<?php echo $m ?> .row-fluid .span12 { width: 99.99999998999999%; *width: 99.94680850063828%;}
<?php echo $m ?> .row-fluid .span11 { width: 91.489361693%; *width: 91.4361702036383%;}
<?php echo $m ?> .row-fluid .span10 { width: 82.97872339599999%; *width: 82.92553190663828%;}
<?php echo $m ?> .row-fluid .span9 { width: 74.468085099%; *width: 74.4148936096383%;}
<?php echo $m ?> .row-fluid .span8 { width: 65.95744680199999%; *width: 65.90425531263828%;}
<?php echo $m ?> .row-fluid .span7 { width: 57.446808505%; *width: 57.3936170156383%;}
<?php echo $m ?> .row-fluid .span6 { width: 48.93617020799999%; *width: 48.88297871863829%;}
<?php echo $m ?> .row-fluid .span5 { width: 40.425531911%; *width: 40.3723404216383%;}
<?php echo $m ?> .row-fluid .span4 { width: 31.914893614%; *width: 31.8617021246383%;}
<?php echo $m ?> .row-fluid .span3 { width: 23.404255317%; *width: 23.3510638276383%;}
<?php echo $m ?> .row-fluid .span2 { width: 14.89361702%; *width: 14.8404255306383%;}
<?php echo $m ?> .row-fluid .span1 { width: 6.382978723%; *width: 6.329787233638298%;}
<?php echo $m ?> .container { margin-right: auto; margin-left: auto; *zoom: 1;}
<?php echo $m ?> .container:before,
<?php echo $m ?> .container:after { display: table; content: "";}
<?php echo $m ?> .container:after { clear: both;}
<?php echo $m ?> .container-fluid { padding-right: 20px; padding-left: 20px; *zoom: 1;}
<?php echo $m ?> .container-fluid:before,
<?php echo $m ?> .container-fluid:after { display: table; content: "";}
<?php echo $m ?> .container-fluid:after { clear: both;}
<?php echo $m ?> p { margin: 0 0 9px;}
<?php echo $m ?> p small { font-size: 11px; color: #999999;}
<?php echo $m ?> .lead { margin-bottom: 18px; font-size: 20px; font-weight: 200; line-height: 27px;}
<?php echo $m ?> h1,
<?php echo $m ?> h2,
<?php echo $m ?> h3,
<?php echo $m ?> h4,
<?php echo $m ?> h5,
<?php echo $m ?> h6 { margin: 0; font-family: inherit; font-weight: bold; color: inherit; text-rendering: optimizelegibility;}
<?php echo $m ?> h1 small,
<?php echo $m ?> h2 small,
<?php echo $m ?> h3 small,
<?php echo $m ?> h4 small,
<?php echo $m ?> h5 small,
<?php echo $m ?> h6 small { font-weight: normal; color: #999999;}
<?php echo $m ?> h1 { font-size: 30px; line-height: 36px;}
<?php echo $m ?> h1 small { font-size: 18px;}
<?php echo $m ?> h2 { font-size: 24px; line-height: 36px;}
<?php echo $m ?> h2 small { font-size: 18px;}
<?php echo $m ?> h3 { font-size: 18px; line-height: 27px;}
<?php echo $m ?> h3 small { font-size: 14px;}
<?php echo $m ?> h4,
<?php echo $m ?> h5,
<?php echo $m ?> h6 { line-height: 18px;}
<?php echo $m ?> h4 { font-size: 14px;}
<?php echo $m ?> h4 small { font-size: 12px;}
<?php echo $m ?> h5 { font-size: 12px;}
<?php echo $m ?> h6 { font-size: 11px; color: #999999; text-transform: uppercase;}
<?php echo $m ?> .page-header { padding-bottom: 17px; margin: 18px 0; border-bottom: 1px solid #eeeeee;}
<?php echo $m ?> .page-header h1 { line-height: 1;}
<?php echo $m ?> ul,
<?php echo $m ?> ol { padding: 0; margin: 0 0 9px 25px;}
<?php echo $m ?> ul ul,
<?php echo $m ?> ul ol,
<?php echo $m ?> ol ol,
<?php echo $m ?> ol ul { margin-bottom: 0;}
<?php echo $m ?> ul { list-style: disc;}
<?php echo $m ?> ol { list-style: decimal;}
<?php echo $m ?> li { line-height: 18px;}
<?php echo $m ?> ul.unstyled,
<?php echo $m ?> ol.unstyled { margin-left: 0; list-style: none;}
<?php echo $m ?> dl { margin-bottom: 18px;}
<?php echo $m ?> dt,
<?php echo $m ?> dd { line-height: 18px;}
<?php echo $m ?> dt { font-weight: bold; line-height: 17px;}
<?php echo $m ?> dd { margin-left: 9px;}
<?php echo $m ?> .dl-horizontal dt { float: left; width: 120px; overflow: hidden; clear: left; text-align: right; text-overflow: ellipsis; white-space: nowrap;}
<?php echo $m ?> .dl-horizontal dd { margin-left: 130px;}
<?php echo $m ?> hr { margin: 18px 0; border: 0; border-top: 1px solid #eeeeee; border-bottom: 1px solid #ffffff;}
<?php echo $m ?> strong { font-weight: bold;}
<?php echo $m ?> em { font-style: italic;}
<?php echo $m ?> .muted { color: #999999;}
<?php echo $m ?> abbr[title] { cursor: help; border-bottom: 1px dotted #999999;}
<?php echo $m ?> abbr.initialism { font-size: 90%; text-transform: uppercase;}
<?php echo $m ?> blockquote { padding: 0 0 0 15px; margin: 0 0 18px; border-left: 5px solid #eeeeee;}
<?php echo $m ?> blockquote p { margin-bottom: 0; font-size: 16px; font-weight: 300; line-height: 22.5px;}
<?php echo $m ?> blockquote small { display: block; line-height: 18px; color: #999999;}
<?php echo $m ?> blockquote small:before { content: '\2014 \00A0';}
<?php echo $m ?> blockquote.pull-right { float: right; padding-right: 15px; padding-left: 0; border-right: 5px solid #eeeeee; border-left: 0;}
<?php echo $m ?> blockquote.pull-right p,
<?php echo $m ?> blockquote.pull-right small { text-align: right;}
<?php echo $m ?> q:before,
<?php echo $m ?> q:after,
<?php echo $m ?> blockquote:before,
<?php echo $m ?> blockquote:after { content: "";}
<?php echo $m ?> address { display: block; margin-bottom: 18px; font-style: normal; line-height: 18px;}
<?php echo $m ?> small { font-size: 100%;}
<?php echo $m ?> cite { font-style: normal;}
<?php echo $m ?> code,
<?php echo $m ?> pre { padding: 0 3px 2px; font-family: Menlo, Monaco, Consolas, "Courier New", monospace; font-size: 12px; color: #333333; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;}
<?php echo $m ?> code { padding: 2px 4px; color: #d14; background-color: #f7f7f9; border: 1px solid #e1e1e8;}
<?php echo $m ?> pre { display: block; padding: 8.5px; margin: 0 0 9px; font-size: 12.025px; line-height: 18px; word-break: break-all; word-wrap: break-word; white-space: pre; white-space: pre-wrap; background-color: #f5f5f5; border: 1px solid #ccc; border: 1px solid rgba(0, 0, 0, 0.15); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> pre.prettyprint { margin-bottom: 18px;}
<?php echo $m ?> pre code { padding: 0; color: inherit; background-color: transparent; border: 0;}
<?php echo $m ?> .pre-scrollable { max-height: 340px; overflow-y: scroll;}
<?php echo $m ?> form { margin: 0 0 18px;}
<?php echo $m ?> fieldset { padding: 0; margin: 0; border: 0;}
<?php echo $m ?> legend { display: block; width: 100%; padding: 0; margin-bottom: 27px; font-size: 19.5px; line-height: 36px; color: #333333; border: 0; border-bottom: 1px solid #e5e5e5;}
<?php echo $m ?> legend small { font-size: 13.5px; color: #999999;}
<?php echo $m ?> label,
<?php echo $m ?> input,
<?php echo $m ?> button,
<?php echo $m ?> select,
<?php echo $m ?> textarea { font-size: 13px; font-weight: normal; line-height: 18px;}
<?php echo $m ?> input,
<?php echo $m ?> button,
<?php echo $m ?> select,
<?php echo $m ?> textarea { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;}
<?php echo $m ?> label { display: block; margin-bottom: 5px;}
<?php echo $m ?> select,
<?php echo $m ?> textarea,
<?php echo $m ?> input[type="text"],
<?php echo $m ?> input[type="password"],
<?php echo $m ?> input[type="datetime"],
<?php echo $m ?> input[type="datetime-local"],
<?php echo $m ?> input[type="date"],
<?php echo $m ?> input[type="month"],
<?php echo $m ?> input[type="time"],
<?php echo $m ?> input[type="week"],
<?php echo $m ?> input[type="number"],
<?php echo $m ?> input[type="email"],
<?php echo $m ?> input[type="url"],
<?php echo $m ?> input[type="search"],
<?php echo $m ?> input[type="tel"],
<?php echo $m ?> input[type="color"],
<?php echo $m ?> .uneditable-input { display: inline-block; height: 18px; padding: 4px; margin-bottom: 9px; font-size: 13px; line-height: 18px; color: #555555;}
<?php echo $m ?> input,
<?php echo $m ?> textarea { width: 210px;}
<?php echo $m ?> textarea { height: auto;}
<?php echo $m ?> textarea,
<?php echo $m ?> input[type="text"],
<?php echo $m ?> input[type="password"],
<?php echo $m ?> input[type="datetime"],
<?php echo $m ?> input[type="datetime-local"],
<?php echo $m ?> input[type="date"],
<?php echo $m ?> input[type="month"],
<?php echo $m ?> input[type="time"],
<?php echo $m ?> input[type="week"],
<?php echo $m ?> input[type="number"],
<?php echo $m ?> input[type="email"],
<?php echo $m ?> input[type="url"],
<?php echo $m ?> input[type="search"],
<?php echo $m ?> input[type="tel"],
<?php echo $m ?> input[type="color"],
<?php echo $m ?> .uneditable-input { background-color: #ffffff; border: 1px solid #cccccc; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075); -webkit-transition: border linear 0.2s, box-shadow linear 0.2s; -moz-transition: border linear 0.2s, box-shadow linear 0.2s; -ms-transition: border linear 0.2s, box-shadow linear 0.2s; -o-transition: border linear 0.2s, box-shadow linear 0.2s; transition: border linear 0.2s, box-shadow linear 0.2s;}
<?php echo $m ?> textarea:focus,
<?php echo $m ?> input[type="text"]:focus,
<?php echo $m ?> input[type="password"]:focus,
<?php echo $m ?> input[type="datetime"]:focus,
<?php echo $m ?> input[type="datetime-local"]:focus,
<?php echo $m ?> input[type="date"]:focus,
<?php echo $m ?> input[type="month"]:focus,
<?php echo $m ?> input[type="time"]:focus,
<?php echo $m ?> input[type="week"]:focus,
<?php echo $m ?> input[type="number"]:focus,
<?php echo $m ?> input[type="email"]:focus,
<?php echo $m ?> input[type="url"]:focus,
<?php echo $m ?> input[type="search"]:focus,
<?php echo $m ?> input[type="tel"]:focus,
<?php echo $m ?> input[type="color"]:focus,
<?php echo $m ?> .uneditable-input:focus { border-color: rgba(82, 168, 236, 0.8); outline: 0; outline: thin dotted \9;   -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(82, 168, 236, 0.6);}
<?php echo $m ?> input[type="radio"],
<?php echo $m ?> input[type="checkbox"] { margin: 3px 0; *margin-top: 0;   line-height: normal; cursor: pointer;}
<?php echo $m ?> input[type="submit"],
<?php echo $m ?> input[type="reset"],
<?php echo $m ?> input[type="button"],
<?php echo $m ?> input[type="radio"],
<?php echo $m ?> input[type="checkbox"] { width: auto;}
<?php echo $m ?> .uneditable-textarea { width: auto; height: auto;}
<?php echo $m ?> select,
<?php echo $m ?> input[type="file"] { height: 28px;   *margin-top: 4px;   line-height: 28px;}
<?php echo $m ?> select { width: 220px; border: 1px solid #bbb;}
<?php echo $m ?> select[multiple],
<?php echo $m ?> select[size] { height: auto;}
<?php echo $m ?> select:focus,
<?php echo $m ?> input[type="file"]:focus,
<?php echo $m ?> input[type="radio"]:focus,
<?php echo $m ?> input[type="checkbox"]:focus { outline: thin dotted #333; outline: 5px auto -webkit-focus-ring-color; outline-offset: -2px;}
<?php echo $m ?> .radio,
<?php echo $m ?> .checkbox { min-height: 18px; padding-left: 18px;}
<?php echo $m ?> .radio input[type="radio"],
<?php echo $m ?> .checkbox input[type="checkbox"] { float: left; margin-left: -18px;}
<?php echo $m ?> .controls > .radio:first-child,
<?php echo $m ?> .controls > .checkbox:first-child { padding-top: 5px;}
<?php echo $m ?> .radio.inline,
<?php echo $m ?> .checkbox.inline { display: inline-block; padding-top: 5px; margin-bottom: 0; vertical-align: middle;}
<?php echo $m ?> .radio.inline + .radio.inline,
<?php echo $m ?> .checkbox.inline + .checkbox.inline { margin-left: 10px;}
<?php echo $m ?> .input-mini { width: 60px;}
<?php echo $m ?> .input-small { width: 90px;}
<?php echo $m ?> .input-medium { width: 150px;}
<?php echo $m ?> .input-large { width: 210px;}
<?php echo $m ?> .input-xlarge { width: 270px;}
<?php echo $m ?> .input-xxlarge { width: 530px;}
<?php echo $m ?> input[class*="span"],
<?php echo $m ?> select[class*="span"],
<?php echo $m ?> textarea[class*="span"],
<?php echo $m ?> .uneditable-input[class*="span"],
<?php echo $m ?> .row-fluid input[class*="span"],
<?php echo $m ?> .row-fluid select[class*="span"],
<?php echo $m ?> .row-fluid textarea[class*="span"],
<?php echo $m ?> .row-fluid .uneditable-input[class*="span"] { float: none; margin-left: 0;}
<?php echo $m ?> .input-append input[class*="span"],
<?php echo $m ?> .input-append .uneditable-input[class*="span"],
<?php echo $m ?> .input-prepend input[class*="span"],
<?php echo $m ?> .input-prepend .uneditable-input[class*="span"],
<?php echo $m ?> .row-fluid .input-prepend [class*="span"],
<?php echo $m ?> .row-fluid .input-append [class*="span"] { display: inline-block;}
<?php echo $m ?> input,
<?php echo $m ?> textarea,
<?php echo $m ?> .uneditable-input { margin-left: 0;}
<?php echo $m ?> input.span12,
<?php echo $m ?> textarea.span12,
<?php echo $m ?> .uneditable-input.span12 { width: 930px;}
<?php echo $m ?> input.span11,
<?php echo $m ?> textarea.span11,
<?php echo $m ?> .uneditable-input.span11 { width: 850px;}
<?php echo $m ?> input.span10,
<?php echo $m ?> textarea.span10,
<?php echo $m ?> .uneditable-input.span10 { width: 770px;}
<?php echo $m ?> input.span9,
<?php echo $m ?> textarea.span9,
<?php echo $m ?> .uneditable-input.span9 { width: 690px;}
<?php echo $m ?> input.span8,
<?php echo $m ?> textarea.span8,
<?php echo $m ?> .uneditable-input.span8 { width: 610px;}
<?php echo $m ?> input.span7,
<?php echo $m ?> textarea.span7,
<?php echo $m ?> .uneditable-input.span7 { width: 530px;}
<?php echo $m ?> input.span6,
<?php echo $m ?> textarea.span6,
<?php echo $m ?> .uneditable-input.span6 { width: 450px;}
<?php echo $m ?> input.span5,
<?php echo $m ?> textarea.span5,
<?php echo $m ?> .uneditable-input.span5 { width: 370px;}
<?php echo $m ?> input.span4,
<?php echo $m ?> textarea.span4,
<?php echo $m ?> .uneditable-input.span4 { width: 290px;}
<?php echo $m ?> input.span3,
<?php echo $m ?> textarea.span3,
<?php echo $m ?> .uneditable-input.span3 { width: 210px;}
<?php echo $m ?> input.span2,
<?php echo $m ?> textarea.span2,
<?php echo $m ?> .uneditable-input.span2 { width: 130px;}
<?php echo $m ?> input.span1,
<?php echo $m ?> textarea.span1,
<?php echo $m ?> .uneditable-input.span1 { width: 50px;}
<?php echo $m ?> input[disabled],
<?php echo $m ?> select[disabled],
<?php echo $m ?> textarea[disabled],
<?php echo $m ?> input[readonly],
<?php echo $m ?> select[readonly],
<?php echo $m ?> textarea[readonly] { cursor: not-allowed; background-color: #eeeeee; border-color: #ddd;}
<?php echo $m ?> input[type="radio"][disabled],
<?php echo $m ?> input[type="checkbox"][disabled],
<?php echo $m ?> input[type="radio"][readonly],
<?php echo $m ?> input[type="checkbox"][readonly] { background-color: transparent;}
<?php echo $m ?> .control-group.warning > label,
<?php echo $m ?> .control-group.warning .help-block,
<?php echo $m ?> .control-group.warning .help-inline { color: #c09853;}
<?php echo $m ?> .control-group.warning .checkbox,
<?php echo $m ?> .control-group.warning .radio,
<?php echo $m ?> .control-group.warning input,
<?php echo $m ?> .control-group.warning select,
<?php echo $m ?> .control-group.warning textarea { color: #c09853; border-color: #c09853;}
<?php echo $m ?> .control-group.warning .checkbox:focus,
<?php echo $m ?> .control-group.warning .radio:focus,
<?php echo $m ?> .control-group.warning input:focus,
<?php echo $m ?> .control-group.warning select:focus,
<?php echo $m ?> .control-group.warning textarea:focus { border-color: #a47e3c; -webkit-box-shadow: 0 0 6px #dbc59e; -moz-box-shadow: 0 0 6px #dbc59e; box-shadow: 0 0 6px #dbc59e;}
<?php echo $m ?> .control-group.warning .input-prepend .add-on,
<?php echo $m ?> .control-group.warning .input-append .add-on { color: #c09853; background-color: #fcf8e3; border-color: #c09853;}
<?php echo $m ?> .control-group.error > label,
<?php echo $m ?> .control-group.error .help-block,
<?php echo $m ?> .control-group.error .help-inline { color: #b94a48;}
<?php echo $m ?> .control-group.error .checkbox,
<?php echo $m ?> .control-group.error .radio,
<?php echo $m ?> .control-group.error input,
<?php echo $m ?> .control-group.error select,
<?php echo $m ?> .control-group.error textarea { color: #b94a48; border-color: #b94a48;}
<?php echo $m ?> .control-group.error .checkbox:focus,
<?php echo $m ?> .control-group.error .radio:focus,
<?php echo $m ?> .control-group.error input:focus,
<?php echo $m ?> .control-group.error select:focus,
<?php echo $m ?> .control-group.error textarea:focus { border-color: #953b39; -webkit-box-shadow: 0 0 6px #d59392; -moz-box-shadow: 0 0 6px #d59392; box-shadow: 0 0 6px #d59392;}
<?php echo $m ?> .control-group.error .input-prepend .add-on,
<?php echo $m ?> .control-group.error .input-append .add-on { color: #b94a48; background-color: #f2dede; border-color: #b94a48;}
<?php echo $m ?> .control-group.success > label,
<?php echo $m ?> .control-group.success .help-block,
<?php echo $m ?> .control-group.success .help-inline { color: #468847;}
<?php echo $m ?> .control-group.success .checkbox,
<?php echo $m ?> .control-group.success .radio,
<?php echo $m ?> .control-group.success input,
<?php echo $m ?> .control-group.success select,
<?php echo $m ?> .control-group.success textarea { color: #468847; border-color: #468847;}
<?php echo $m ?> .control-group.success .checkbox:focus,
<?php echo $m ?> .control-group.success .radio:focus,
<?php echo $m ?> .control-group.success input:focus,
<?php echo $m ?> .control-group.success select:focus,
<?php echo $m ?> .control-group.success textarea:focus { border-color: #356635; -webkit-box-shadow: 0 0 6px #7aba7b; -moz-box-shadow: 0 0 6px #7aba7b; box-shadow: 0 0 6px #7aba7b;}
<?php echo $m ?> .control-group.success .input-prepend .add-on,
<?php echo $m ?> .control-group.success .input-append .add-on { color: #468847; background-color: #dff0d8; border-color: #468847;}
<?php echo $m ?> input:focus:required:invalid,
<?php echo $m ?> textarea:focus:required:invalid,
<?php echo $m ?> select:focus:required:invalid { color: #b94a48; border-color: #ee5f5b;}
<?php echo $m ?> input:focus:required:invalid:focus,
<?php echo $m ?> textarea:focus:required:invalid:focus,
<?php echo $m ?> select:focus:required:invalid:focus { border-color: #e9322d; -webkit-box-shadow: 0 0 6px #f8b9b7; -moz-box-shadow: 0 0 6px #f8b9b7; box-shadow: 0 0 6px #f8b9b7;}
<?php echo $m ?> .form-actions { padding: 17px 20px 18px; margin-top: 18px; margin-bottom: 18px; background-color: #f5f5f5; border-top: 1px solid #e5e5e5; *zoom: 1;}
<?php echo $m ?> .form-actions:before,
<?php echo $m ?> .form-actions:after { display: table; content: "";}
<?php echo $m ?> .form-actions:after { clear: both;}
<?php echo $m ?> .uneditable-input { overflow: hidden; white-space: nowrap; cursor: not-allowed; background-color: #ffffff; border-color: #eee; -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025);}
<?php echo $m ?> :-moz-placeholder { color: #999999;}
<?php echo $m ?> :-ms-input-placeholder { color: #999999;}
<?php echo $m ?> ::-webkit-input-placeholder { color: #999999;}
<?php echo $m ?> .help-block,
<?php echo $m ?> .help-inline { color: #555555;}
<?php echo $m ?> .help-block { display: block; margin-bottom: 9px;}
<?php echo $m ?> .help-inline { display: inline-block; *display: inline; padding-left: 5px; vertical-align: middle; *zoom: 1;}
<?php echo $m ?> .input-prepend,
<?php echo $m ?> .input-append { margin-bottom: 5px;}
<?php echo $m ?> .input-prepend input,
<?php echo $m ?> .input-append input,
<?php echo $m ?> .input-prepend select,
<?php echo $m ?> .input-append select,
<?php echo $m ?> .input-prepend .uneditable-input,
<?php echo $m ?> .input-append .uneditable-input { position: relative; margin-bottom: 0; *margin-left: 0; vertical-align: middle; -webkit-border-radius: 0 3px 3px 0; -moz-border-radius: 0 3px 3px 0; border-radius: 0 3px 3px 0;}
<?php echo $m ?> .input-prepend input:focus,
<?php echo $m ?> .input-append input:focus,
<?php echo $m ?> .input-prepend select:focus,
<?php echo $m ?> .input-append select:focus,
<?php echo $m ?> .input-prepend .uneditable-input:focus,
<?php echo $m ?> .input-append .uneditable-input:focus { z-index: 2;}
<?php echo $m ?> .input-prepend .uneditable-input,
<?php echo $m ?> .input-append .uneditable-input { border-left-color: #ccc;}
<?php echo $m ?> .input-prepend .add-on,
<?php echo $m ?> .input-append .add-on { display: inline-block; width: auto; height: 18px; min-width: 16px; padding: 4px 5px; font-weight: normal; line-height: 18px; text-align: center; text-shadow: 0 1px 0 #ffffff; vertical-align: middle; background-color: #eeeeee; border: 1px solid #ccc;}
<?php echo $m ?> .input-prepend .add-on,
<?php echo $m ?> .input-append .add-on,
<?php echo $m ?> .input-prepend .btn,
<?php echo $m ?> .input-append .btn { margin-left: -1px; -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;}
<?php echo $m ?> .input-prepend .active,
<?php echo $m ?> .input-append .active { background-color: #a9dba9; border-color: #46a546;}
<?php echo $m ?> .input-prepend .add-on,
<?php echo $m ?> .input-prepend .btn { margin-right: -1px;}
<?php echo $m ?> .input-prepend .add-on:first-child,
<?php echo $m ?> .input-prepend .btn:first-child { -webkit-border-radius: 3px 0 0 3px; -moz-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;}
<?php echo $m ?> .input-append input,
<?php echo $m ?> .input-append select,
<?php echo $m ?> .input-append .uneditable-input { -webkit-border-radius: 3px 0 0 3px; -moz-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;}
<?php echo $m ?> .input-append .uneditable-input { border-right-color: #ccc; border-left-color: #eee;}
<?php echo $m ?> .input-append .add-on:last-child,
<?php echo $m ?> .input-append .btn:last-child { -webkit-border-radius: 0 3px 3px 0; -moz-border-radius: 0 3px 3px 0; border-radius: 0 3px 3px 0;}
<?php echo $m ?> .input-prepend.input-append input,
<?php echo $m ?> .input-prepend.input-append select,
<?php echo $m ?> .input-prepend.input-append .uneditable-input { -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;}
<?php echo $m ?> .input-prepend.input-append .add-on:first-child,
<?php echo $m ?> .input-prepend.input-append .btn:first-child { margin-right: -1px; -webkit-border-radius: 3px 0 0 3px; -moz-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;}
<?php echo $m ?> .input-prepend.input-append .add-on:last-child,
<?php echo $m ?> .input-prepend.input-append .btn:last-child { margin-left: -1px; -webkit-border-radius: 0 3px 3px 0; -moz-border-radius: 0 3px 3px 0; border-radius: 0 3px 3px 0;}
<?php echo $m ?> .search-query { padding-right: 14px; padding-right: 4px \9; padding-left: 14px; padding-left: 4px \9;   margin-bottom: 0; -webkit-border-radius: 14px; -moz-border-radius: 14px; border-radius: 14px;}
<?php echo $m ?> .form-search input,
<?php echo $m ?> .form-inline input,
<?php echo $m ?> .form-horizontal input,
<?php echo $m ?> .form-search textarea,
<?php echo $m ?> .form-inline textarea,
<?php echo $m ?> .form-horizontal textarea,
<?php echo $m ?> .form-search select,
<?php echo $m ?> .form-inline select,
<?php echo $m ?> .form-horizontal select,
<?php echo $m ?> .form-search .help-inline,
<?php echo $m ?> .form-inline .help-inline,
<?php echo $m ?> .form-horizontal .help-inline,
<?php echo $m ?> .form-search .uneditable-input,
<?php echo $m ?> .form-inline .uneditable-input,
<?php echo $m ?> .form-horizontal .uneditable-input,
<?php echo $m ?> .form-search .input-prepend,
<?php echo $m ?> .form-inline .input-prepend,
<?php echo $m ?> .form-horizontal .input-prepend,
<?php echo $m ?> .form-search .input-append,
<?php echo $m ?> .form-inline .input-append,
<?php echo $m ?> .form-horizontal .input-append { display: inline-block; *display: inline; margin-bottom: 0; *zoom: 1;}
<?php echo $m ?> .form-search .hide,
<?php echo $m ?> .form-inline .hide,
<?php echo $m ?> .form-horizontal .hide { display: none;}
<?php echo $m ?> .form-search label,
<?php echo $m ?> .form-inline label { display: inline-block;}
<?php echo $m ?> .form-search .input-append,
<?php echo $m ?> .form-inline .input-append,
<?php echo $m ?> .form-search .input-prepend,
<?php echo $m ?> .form-inline .input-prepend { margin-bottom: 0;}
<?php echo $m ?> .form-search .radio,
<?php echo $m ?> .form-search .checkbox,
<?php echo $m ?> .form-inline .radio,
<?php echo $m ?> .form-inline .checkbox { padding-left: 0; margin-bottom: 0; vertical-align: middle;}
<?php echo $m ?> .form-search .radio input[type="radio"],
<?php echo $m ?> .form-search .checkbox input[type="checkbox"],
<?php echo $m ?> .form-inline .radio input[type="radio"],
<?php echo $m ?> .form-inline .checkbox input[type="checkbox"] { float: left; margin-right: 3px; margin-left: 0;}
<?php echo $m ?> .control-group { margin-bottom: 9px;}
<?php echo $m ?> legend + .control-group { margin-top: 18px; -webkit-margin-top-collapse: separate;}
<?php echo $m ?> .form-horizontal .control-group { margin-bottom: 18px; *zoom: 1;}
<?php echo $m ?> .form-horizontal .control-group:before,
<?php echo $m ?> .form-horizontal .control-group:after { display: table; content: "";}
<?php echo $m ?> .form-horizontal .control-group:after { clear: both;}
<?php echo $m ?> .form-horizontal .control-label { float: left; width: 140px; padding-top: 5px; text-align: right;}
<?php echo $m ?> .form-horizontal .controls { *display: inline-block; *padding-left: 20px; margin-left: 160px; *margin-left: 0;}
<?php echo $m ?> .form-horizontal .controls:first-child { *padding-left: 160px;}
<?php echo $m ?> .form-horizontal .help-block { margin-top: 9px; margin-bottom: 0;}
<?php echo $m ?> .form-horizontal .form-actions { padding-left: 160px;}
<?php echo $m ?> table { max-width: 100%; background-color: transparent; border-collapse: collapse; border-spacing: 0;}
<?php echo $m ?> .table { width: 100%; margin-bottom: 18px;}
<?php echo $m ?> .table th,
<?php echo $m ?> .table td { padding: 8px; line-height: 18px; text-align: left; vertical-align: top; border-top: 1px solid #dddddd;}
<?php echo $m ?> .table th { font-weight: bold;}
<?php echo $m ?> .table thead th { vertical-align: bottom;}
<?php echo $m ?> .table caption + thead tr:first-child th,
<?php echo $m ?> .table caption + thead tr:first-child td,
<?php echo $m ?> .table colgroup + thead tr:first-child th,
<?php echo $m ?> .table colgroup + thead tr:first-child td,
<?php echo $m ?> .table thead:first-child tr:first-child th,
<?php echo $m ?> .table thead:first-child tr:first-child td { border-top: 0;}
<?php echo $m ?> .table tbody + tbody { border-top: 2px solid #dddddd;}
<?php echo $m ?> .table-condensed th,
<?php echo $m ?> .table-condensed td { padding: 4px 5px;}
<?php echo $m ?> .table-bordered { border: 1px solid #dddddd; border-collapse: separate; *border-collapse: collapsed; border-left: 0; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .table-bordered th,
<?php echo $m ?> .table-bordered td { border-left: 1px solid #dddddd;}
<?php echo $m ?> .table-bordered caption + thead tr:first-child th,
<?php echo $m ?> .table-bordered caption + tbody tr:first-child th,
<?php echo $m ?> .table-bordered caption + tbody tr:first-child td,
<?php echo $m ?> .table-bordered colgroup + thead tr:first-child th,
<?php echo $m ?> .table-bordered colgroup + tbody tr:first-child th,
<?php echo $m ?> .table-bordered colgroup + tbody tr:first-child td,
<?php echo $m ?> .table-bordered thead:first-child tr:first-child th,
<?php echo $m ?> .table-bordered tbody:first-child tr:first-child th,
<?php echo $m ?> .table-bordered tbody:first-child tr:first-child td { border-top: 0;}
<?php echo $m ?> .table-bordered thead:first-child tr:first-child th:first-child,
<?php echo $m ?> .table-bordered tbody:first-child tr:first-child td:first-child { -webkit-border-top-left-radius: 4px; border-top-left-radius: 4px; -moz-border-radius-topleft: 4px;}
<?php echo $m ?> .table-bordered thead:first-child tr:first-child th:last-child,
<?php echo $m ?> .table-bordered tbody:first-child tr:first-child td:last-child { -webkit-border-top-right-radius: 4px; border-top-right-radius: 4px; -moz-border-radius-topright: 4px;}
<?php echo $m ?> .table-bordered thead:last-child tr:last-child th:first-child,
<?php echo $m ?> .table-bordered tbody:last-child tr:last-child td:first-child { -webkit-border-radius: 0 0 0 4px; -moz-border-radius: 0 0 0 4px; border-radius: 0 0 0 4px; -webkit-border-bottom-left-radius: 4px; border-bottom-left-radius: 4px; -moz-border-radius-bottomleft: 4px;}
<?php echo $m ?> .table-bordered thead:last-child tr:last-child th:last-child,
<?php echo $m ?> .table-bordered tbody:last-child tr:last-child td:last-child { -webkit-border-bottom-right-radius: 4px; border-bottom-right-radius: 4px; -moz-border-radius-bottomright: 4px;}
<?php echo $m ?> .table-striped tbody tr:nth-child(odd) td,
<?php echo $m ?> .table-striped tbody tr:nth-child(odd) th { background-color: #f9f9f9;}
<?php echo $m ?> .table tbody tr:hover td,
<?php echo $m ?> .table tbody tr:hover th { background-color: #f5f5f5;}
<?php echo $m ?> table .span1 { float: none; width: 44px; margin-left: 0;}
<?php echo $m ?> table .span2 { float: none; width: 124px; margin-left: 0;}
<?php echo $m ?> table .span3 { float: none; width: 204px; margin-left: 0;}
<?php echo $m ?> table .span4 { float: none; width: 284px; margin-left: 0;}
<?php echo $m ?> table .span5 { float: none; width: 364px; margin-left: 0;}
<?php echo $m ?> table .span6 { float: none; width: 444px; margin-left: 0;}
<?php echo $m ?> table .span7 { float: none; width: 524px; margin-left: 0;}
<?php echo $m ?> table .span8 { float: none; width: 604px; margin-left: 0;}
<?php echo $m ?> table .span9 { float: none; width: 684px; margin-left: 0;}
<?php echo $m ?> table .span10 { float: none; width: 764px; margin-left: 0;}
<?php echo $m ?> table .span11 { float: none; width: 844px; margin-left: 0;}
<?php echo $m ?> table .span12 { float: none; width: 924px; margin-left: 0;}
<?php echo $m ?> table .span13 { float: none; width: 1004px; margin-left: 0;}
<?php echo $m ?> table .span14 { float: none; width: 1084px; margin-left: 0;}
<?php echo $m ?> table .span15 { float: none; width: 1164px; margin-left: 0;}
<?php echo $m ?> table .span16 { float: none; width: 1244px; margin-left: 0;}
<?php echo $m ?> table .span17 { float: none; width: 1324px; margin-left: 0;}
<?php echo $m ?> table .span18 { float: none; width: 1404px; margin-left: 0;}
<?php echo $m ?> table .span19 { float: none; width: 1484px; margin-left: 0;}
<?php echo $m ?> table .span20 { float: none; width: 1564px; margin-left: 0;}
<?php echo $m ?> table .span21 { float: none; width: 1644px; margin-left: 0;}
<?php echo $m ?> table .span22 { float: none; width: 1724px; margin-left: 0;}
<?php echo $m ?> table .span23 { float: none; width: 1804px; margin-left: 0;}
<?php echo $m ?> table .span24 { float: none; width: 1884px; margin-left: 0;}
<?php echo $m ?> [class^="icon-"],
<?php echo $m ?> [class*=" icon-"] { display: inline-block; width: 14px; height: 14px; *margin-right: .3em; line-height: 14px; vertical-align: text-top; background-image: url("../img/glyphicons-halflings.png"); background-position: 14px 14px; background-repeat: no-repeat;}
<?php echo $m ?> [class^="icon-"]:last-child,
<?php echo $m ?> [class*=" icon-"]:last-child { *margin-left: 0;}
<?php echo $m ?> .icon-white { background-image: url("../img/glyphicons-halflings-white.png");}
<?php echo $m ?> .icon-glass { background-position: 0      0;}
<?php echo $m ?> .icon-music { background-position: -24px 0;}
<?php echo $m ?> .icon-search { background-position: -48px 0;}
<?php echo $m ?> .icon-envelope { background-position: -72px 0;}
<?php echo $m ?> .icon-heart { background-position: -96px 0;}
<?php echo $m ?> .icon-star { background-position: -120px 0;}
<?php echo $m ?> .icon-star-empty { background-position: -144px 0;}
<?php echo $m ?> .icon-user { background-position: -168px 0;}
<?php echo $m ?> .icon-film { background-position: -192px 0;}
<?php echo $m ?> .icon-th-large { background-position: -216px 0;}
<?php echo $m ?> .icon-th { background-position: -240px 0;}
<?php echo $m ?> .icon-th-list { background-position: -264px 0;}
<?php echo $m ?> .icon-ok { background-position: -288px 0;}
<?php echo $m ?> .icon-remove { background-position: -312px 0;}
<?php echo $m ?> .icon-zoom-in { background-position: -336px 0;}
<?php echo $m ?> .icon-zoom-out { background-position: -360px 0;}
<?php echo $m ?> .icon-off { background-position: -384px 0;}
<?php echo $m ?> .icon-signal { background-position: -408px 0;}
<?php echo $m ?> .icon-cog { background-position: -432px 0;}
<?php echo $m ?> .icon-trash { background-position: -456px 0;}
<?php echo $m ?> .icon-home { background-position: 0 -24px;}
<?php echo $m ?> .icon-file { background-position: -24px -24px;}
<?php echo $m ?> .icon-time { background-position: -48px -24px;}
<?php echo $m ?> .icon-road { background-position: -72px -24px;}
<?php echo $m ?> .icon-download-alt { background-position: -96px -24px;}
<?php echo $m ?> .icon-download { background-position: -120px -24px;}
<?php echo $m ?> .icon-upload { background-position: -144px -24px;}
<?php echo $m ?> .icon-inbox { background-position: -168px -24px;}
<?php echo $m ?> .icon-play-circle { background-position: -192px -24px;}
<?php echo $m ?> .icon-repeat { background-position: -216px -24px;}
<?php echo $m ?> .icon-refresh { background-position: -240px -24px;}
<?php echo $m ?> .icon-list-alt { background-position: -264px -24px;}
<?php echo $m ?> .icon-lock { background-position: -287px -24px;}
<?php echo $m ?> .icon-flag { background-position: -312px -24px;}
<?php echo $m ?> .icon-headphones { background-position: -336px -24px;}
<?php echo $m ?> .icon-volume-off { background-position: -360px -24px;}
<?php echo $m ?> .icon-volume-down { background-position: -384px -24px;}
<?php echo $m ?> .icon-volume-up { background-position: -408px -24px;}
<?php echo $m ?> .icon-qrcode { background-position: -432px -24px;}
<?php echo $m ?> .icon-barcode { background-position: -456px -24px;}
<?php echo $m ?> .icon-tag { background-position: 0 -48px;}
<?php echo $m ?> .icon-tags { background-position: -25px -48px;}
<?php echo $m ?> .icon-book { background-position: -48px -48px;}
<?php echo $m ?> .icon-bookmark { background-position: -72px -48px;}
<?php echo $m ?> .icon-print { background-position: -96px -48px;}
<?php echo $m ?> .icon-camera { background-position: -120px -48px;}
<?php echo $m ?> .icon-font { background-position: -144px -48px;}
<?php echo $m ?> .icon-bold { background-position: -167px -48px;}
<?php echo $m ?> .icon-italic { background-position: -192px -48px;}
<?php echo $m ?> .icon-text-height { background-position: -216px -48px;}
<?php echo $m ?> .icon-text-width { background-position: -240px -48px;}
<?php echo $m ?> .icon-align-left { background-position: -264px -48px;}
<?php echo $m ?> .icon-align-center { background-position: -288px -48px;}
<?php echo $m ?> .icon-align-right { background-position: -312px -48px;}
<?php echo $m ?> .icon-align-justify { background-position: -336px -48px;}
<?php echo $m ?> .icon-list { background-position: -360px -48px;}
<?php echo $m ?> .icon-indent-left { background-position: -384px -48px;}
<?php echo $m ?> .icon-indent-right { background-position: -408px -48px;}
<?php echo $m ?> .icon-facetime-video { background-position: -432px -48px;}
<?php echo $m ?> .icon-picture { background-position: -456px -48px;}
<?php echo $m ?> .icon-pencil { background-position: 0 -72px;}
<?php echo $m ?> .icon-map-marker { background-position: -24px -72px;}
<?php echo $m ?> .icon-adjust { background-position: -48px -72px;}
<?php echo $m ?> .icon-tint { background-position: -72px -72px;}
<?php echo $m ?> .icon-edit { background-position: -96px -72px;}
<?php echo $m ?> .icon-share { background-position: -120px -72px;}
<?php echo $m ?> .icon-check { background-position: -144px -72px;}
<?php echo $m ?> .icon-move { background-position: -168px -72px;}
<?php echo $m ?> .icon-step-backward { background-position: -192px -72px;}
<?php echo $m ?> .icon-fast-backward { background-position: -216px -72px;}
<?php echo $m ?> .icon-backward { background-position: -240px -72px;}
<?php echo $m ?> .icon-play { background-position: -264px -72px;}
<?php echo $m ?> .icon-pause { background-position: -288px -72px;}
<?php echo $m ?> .icon-stop { background-position: -312px -72px;}
<?php echo $m ?> .icon-forward { background-position: -336px -72px;}
<?php echo $m ?> .icon-fast-forward { background-position: -360px -72px;}
<?php echo $m ?> .icon-step-forward { background-position: -384px -72px;}
<?php echo $m ?> .icon-eject { background-position: -408px -72px;}
<?php echo $m ?> .icon-chevron-left { background-position: -432px -72px;}
<?php echo $m ?> .icon-chevron-right { background-position: -456px -72px;}
<?php echo $m ?> .icon-plus-sign { background-position: 0 -96px;}
<?php echo $m ?> .icon-minus-sign { background-position: -24px -96px;}
<?php echo $m ?> .icon-remove-sign { background-position: -48px -96px;}
<?php echo $m ?> .icon-ok-sign { background-position: -72px -96px;}
<?php echo $m ?> .icon-question-sign { background-position: -96px -96px;}
<?php echo $m ?> .icon-info-sign { background-position: -120px -96px;}
<?php echo $m ?> .icon-screenshot { background-position: -144px -96px;}
<?php echo $m ?> .icon-remove-circle { background-position: -168px -96px;}
<?php echo $m ?> .icon-ok-circle { background-position: -192px -96px;}
<?php echo $m ?> .icon-ban-circle { background-position: -216px -96px;}
<?php echo $m ?> .icon-arrow-left { background-position: -240px -96px;}
<?php echo $m ?> .icon-arrow-right { background-position: -264px -96px;}
<?php echo $m ?> .icon-arrow-up { background-position: -289px -96px;}
<?php echo $m ?> .icon-arrow-down { background-position: -312px -96px;}
<?php echo $m ?> .icon-share-alt { background-position: -336px -96px;}
<?php echo $m ?> .icon-resize-full { background-position: -360px -96px;}
<?php echo $m ?> .icon-resize-small { background-position: -384px -96px;}
<?php echo $m ?> .icon-plus { background-position: -408px -96px;}
<?php echo $m ?> .icon-minus { background-position: -433px -96px;}
<?php echo $m ?> .icon-asterisk { background-position: -456px -96px;}
<?php echo $m ?> .icon-exclamation-sign { background-position: 0 -120px;}
<?php echo $m ?> .icon-gift { background-position: -24px -120px;}
<?php echo $m ?> .icon-leaf { background-position: -48px -120px;}
<?php echo $m ?> .icon-fire { background-position: -72px -120px;}
<?php echo $m ?> .icon-eye-open { background-position: -96px -120px;}
<?php echo $m ?> .icon-eye-close { background-position: -120px -120px;}
<?php echo $m ?> .icon-warning-sign { background-position: -144px -120px;}
<?php echo $m ?> .icon-plane { background-position: -168px -120px;}
<?php echo $m ?> .icon-calendar { background-position: -192px -120px;}
<?php echo $m ?> .icon-random { background-position: -216px -120px;}
<?php echo $m ?> .icon-comment { background-position: -240px -120px;}
<?php echo $m ?> .icon-magnet { background-position: -264px -120px;}
<?php echo $m ?> .icon-chevron-up { background-position: -288px -120px;}
<?php echo $m ?> .icon-chevron-down { background-position: -313px -119px;}
<?php echo $m ?> .icon-retweet { background-position: -336px -120px;}
<?php echo $m ?> .icon-shopping-cart { background-position: -360px -120px;}
<?php echo $m ?> .icon-folder-close { background-position: -384px -120px;}
<?php echo $m ?> .icon-folder-open { background-position: -408px -120px;}
<?php echo $m ?> .icon-resize-vertical { background-position: -432px -119px;}
<?php echo $m ?> .icon-resize-horizontal { background-position: -456px -118px;}
<?php echo $m ?> .icon-hdd { background-position: 0 -144px;}
<?php echo $m ?> .icon-bullhorn { background-position: -24px -144px;}
<?php echo $m ?> .icon-bell { background-position: -48px -144px;}
<?php echo $m ?> .icon-certificate { background-position: -72px -144px;}
<?php echo $m ?> .icon-thumbs-up { background-position: -96px -144px;}
<?php echo $m ?> .icon-thumbs-down { background-position: -120px -144px;}
<?php echo $m ?> .icon-hand-right { background-position: -144px -144px;}
<?php echo $m ?> .icon-hand-left { background-position: -168px -144px;}
<?php echo $m ?> .icon-hand-up { background-position: -192px -144px;}
<?php echo $m ?> .icon-hand-down { background-position: -216px -144px;}
<?php echo $m ?> .icon-circle-arrow-right { background-position: -240px -144px;}
<?php echo $m ?> .icon-circle-arrow-left { background-position: -264px -144px;}
<?php echo $m ?> .icon-circle-arrow-up { background-position: -288px -144px;}
<?php echo $m ?> .icon-circle-arrow-down { background-position: -312px -144px;}
<?php echo $m ?> .icon-globe { background-position: -336px -144px;}
<?php echo $m ?> .icon-wrench { background-position: -360px -144px;}
<?php echo $m ?> .icon-tasks { background-position: -384px -144px;}
<?php echo $m ?> .icon-filter { background-position: -408px -144px;}
<?php echo $m ?> .icon-briefcase { background-position: -432px -144px;}
<?php echo $m ?> .icon-fullscreen { background-position: -456px -144px;}
<?php echo $m ?> .dropup,
<?php echo $m ?> .dropdown { position: relative;}
<?php echo $m ?> .dropdown-toggle { *margin-bottom: -3px;}
<?php echo $m ?> .dropdown-toggle:active,
<?php echo $m ?> .open .dropdown-toggle { outline: 0;}
<?php echo $m ?> .caret { display: inline-block; width: 0; height: 0; vertical-align: top; border-top: 4px solid #000000; border-right: 4px solid transparent; border-left: 4px solid transparent; content: ""; opacity: 0.3; filter: alpha(opacity=30);}
<?php echo $m ?> .dropdown .caret { margin-top: 8px; margin-left: 2px;}
<?php echo $m ?> .dropdown:hover .caret,
<?php echo $m ?> .open .caret { opacity: 1; filter: alpha(opacity=100);}
<?php echo $m ?> .dropdown-menu { position: absolute; top: 100%; left: 0; z-index: 1000; display: none; float: left; min-width: 160px; padding: 4px 0; margin: 1px 0 0; list-style: none; background-color: #ffffff; border: 1px solid #ccc; border: 1px solid rgba(0, 0, 0, 0.2); *border-right-width: 2px; *border-bottom-width: 2px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); -webkit-background-clip: padding-box; -moz-background-clip: padding; background-clip: padding-box;}
<?php echo $m ?> .dropdown-menu.pull-right { right: 0; left: auto;}
<?php echo $m ?> .dropdown-menu .divider { *width: 100%; height: 1px; margin: 8px 1px; *margin: -5px 0 5px; overflow: hidden; background-color: #e5e5e5; border-bottom: 1px solid #ffffff;}
<?php echo $m ?> .dropdown-menu a { display: block; padding: 3px 15px; clear: both; font-weight: normal; line-height: 18px; color: #333333; white-space: nowrap;}
<?php echo $m ?> .dropdown-menu li > a:hover,
<?php echo $m ?> .dropdown-menu .active > a,
<?php echo $m ?> .dropdown-menu .active > a:hover { color: #ffffff; text-decoration: none; background-color: #0088cc;}
<?php echo $m ?> .open { *z-index: 1000;}
<?php echo $m ?> .open > .dropdown-menu { display: block;}
<?php echo $m ?> .pull-right > .dropdown-menu { right: 0; left: auto;}
<?php echo $m ?> .dropup .caret,
<?php echo $m ?> .navbar-fixed-bottom .dropdown .caret { border-top: 0; border-bottom: 4px solid #000000; content: "\2191";}
<?php echo $m ?> .dropup .dropdown-menu,
<?php echo $m ?> .navbar-fixed-bottom .dropdown .dropdown-menu { top: auto; bottom: 100%; margin-bottom: 1px;}
<?php echo $m ?> .typeahead { margin-top: 2px; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .well { min-height: 20px; padding: 19px; margin-bottom: 20px; background-color: #f5f5f5; border: 1px solid #eee; border: 1px solid rgba(0, 0, 0, 0.05); -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .well blockquote { border-color: #ddd; border-color: rgba(0, 0, 0, 0.15);}
<?php echo $m ?> .well-large { padding: 24px; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px;}
<?php echo $m ?> .well-small { padding: 9px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;}
<?php echo $m ?> .fade { opacity: 0; -webkit-transition: opacity 0.15s linear; -moz-transition: opacity 0.15s linear; -ms-transition: opacity 0.15s linear; -o-transition: opacity 0.15s linear; transition: opacity 0.15s linear;}
<?php echo $m ?> .fade.in { opacity: 1;}
<?php echo $m ?> .collapse { position: relative; height: 0; overflow: hidden; -webkit-transition: height 0.35s ease; -moz-transition: height 0.35s ease; -ms-transition: height 0.35s ease; -o-transition: height 0.35s ease; transition: height 0.35s ease;}
<?php echo $m ?> .collapse.in { height: auto;}
<?php echo $m ?> .close { float: right; font-size: 20px; font-weight: bold; line-height: 18px; color: #000000; text-shadow: 0 1px 0 #ffffff; opacity: 0.2; filter: alpha(opacity=20);}
<?php echo $m ?> .close:hover { color: #000000; text-decoration: none; cursor: pointer; opacity: 0.4; filter: alpha(opacity=40);}
<?php echo $m ?> button.close { padding: 0; cursor: pointer; background: transparent; border: 0; -webkit-appearance: none;}
<?php echo $m ?> .btn { display: inline-block; *display: inline; padding: 4px 10px 4px; margin-bottom: 0; *margin-left: .3em; font-size: 13px; line-height: 18px; *line-height: 20px; color: #333333; text-align: center; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; cursor: pointer; background-color: #f5f5f5; *background-color: #e6e6e6; background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x; border: 1px solid #cccccc; *border: 0; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); border-color: #e6e6e6 #e6e6e6 #bfbfbf; border-bottom-color: #b3b3b3; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffff', endColorstr='#e6e6e6', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false); *zoom: 1; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .btn:hover,
<?php echo $m ?> .btn:active,
<?php echo $m ?> .btn.active,
<?php echo $m ?> .btn.disabled,
<?php echo $m ?> .btn[disabled] { background-color: #e6e6e6; *background-color: #d9d9d9;}
<?php echo $m ?> .btn:active,
<?php echo $m ?> .btn.active { background-color: #cccccc \9;}
<?php echo $m ?> .btn:first-child { *margin-left: 0;}
<?php echo $m ?> .btn:hover { color: #333333; text-decoration: none; background-color: #e6e6e6; *background-color: #d9d9d9;   background-position: 0 -15px; -webkit-transition: background-position 0.1s linear; -moz-transition: background-position 0.1s linear; -ms-transition: background-position 0.1s linear; -o-transition: background-position 0.1s linear; transition: background-position 0.1s linear;}
<?php echo $m ?> .btn:focus { outline: thin dotted #333; outline: 5px auto -webkit-focus-ring-color; outline-offset: -2px;}
<?php echo $m ?> .btn.active,
<?php echo $m ?> .btn:active { background-color: #e6e6e6; background-color: #d9d9d9 \9; background-image: none; outline: 0; -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .btn.disabled,
<?php echo $m ?> .btn[disabled] { cursor: default; background-color: #e6e6e6; background-image: none; opacity: 0.65; filter: alpha(opacity=65); -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;}
<?php echo $m ?> .btn-large { padding: 9px 14px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
<?php echo $m ?> .btn-large [class^="icon-"] { margin-top: 1px;}
<?php echo $m ?> .btn-small { padding: 5px 9px; font-size: 11px; line-height: 16px;}
<?php echo $m ?> .btn-small [class^="icon-"] { margin-top: -1px;}
<?php echo $m ?> .btn-mini { padding: 2px 6px; font-size: 11px; line-height: 14px;}
<?php echo $m ?> .btn-primary,
<?php echo $m ?> .btn-primary:hover,
<?php echo $m ?> .btn-warning,
<?php echo $m ?> .btn-warning:hover,
<?php echo $m ?> .btn-danger,
<?php echo $m ?> .btn-danger:hover,
<?php echo $m ?> .btn-success,
<?php echo $m ?> .btn-success:hover,
<?php echo $m ?> .btn-info,
<?php echo $m ?> .btn-info:hover,
<?php echo $m ?> .btn-inverse,
<?php echo $m ?> .btn-inverse:hover { color: #ffffff; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);}
<?php echo $m ?> .btn-primary.active,
<?php echo $m ?> .btn-warning.active,
<?php echo $m ?> .btn-danger.active,
<?php echo $m ?> .btn-success.active,
<?php echo $m ?> .btn-info.active,
<?php echo $m ?> .btn-inverse.active { color: rgba(255, 255, 255, 0.75);}
<?php echo $m ?> .btn { border-color: #ccc; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);}
<?php echo $m ?> .btn-primary { background-color: #0074cc; *background-color: #0055cc; background-image: -ms-linear-gradient(top, #0088cc, #0055cc); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0055cc)); background-image: -webkit-linear-gradient(top, #0088cc, #0055cc); background-image: -o-linear-gradient(top, #0088cc, #0055cc); background-image: -moz-linear-gradient(top, #0088cc, #0055cc); background-image: linear-gradient(top, #0088cc, #0055cc); background-repeat: repeat-x; border-color: #0055cc #0055cc #003580; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc', endColorstr='#0055cc', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-primary:hover,
<?php echo $m ?> .btn-primary:active,
<?php echo $m ?> .btn-primary.active,
<?php echo $m ?> .btn-primary.disabled,
<?php echo $m ?> .btn-primary[disabled] { background-color: #0055cc; *background-color: #004ab3;}
<?php echo $m ?> .btn-primary:active,
<?php echo $m ?> .btn-primary.active { background-color: #004099 \9;}
<?php echo $m ?> .btn-warning { background-color: #faa732; *background-color: #f89406; background-image: -ms-linear-gradient(top, #fbb450, #f89406); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406)); background-image: -webkit-linear-gradient(top, #fbb450, #f89406); background-image: -o-linear-gradient(top, #fbb450, #f89406); background-image: -moz-linear-gradient(top, #fbb450, #f89406); background-image: linear-gradient(top, #fbb450, #f89406); background-repeat: repeat-x; border-color: #f89406 #f89406 #ad6704; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#fbb450', endColorstr='#f89406', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-warning:hover,
<?php echo $m ?> .btn-warning:active,
<?php echo $m ?> .btn-warning.active,
<?php echo $m ?> .btn-warning.disabled,
<?php echo $m ?> .btn-warning[disabled] { background-color: #f89406; *background-color: #df8505;}
<?php echo $m ?> .btn-warning:active,
<?php echo $m ?> .btn-warning.active { background-color: #c67605 \9;}
<?php echo $m ?> .btn-danger { background-color: #da4f49; *background-color: #bd362f; background-image: -ms-linear-gradient(top, #ee5f5b, #bd362f); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#bd362f)); background-image: -webkit-linear-gradient(top, #ee5f5b, #bd362f); background-image: -o-linear-gradient(top, #ee5f5b, #bd362f); background-image: -moz-linear-gradient(top, #ee5f5b, #bd362f); background-image: linear-gradient(top, #ee5f5b, #bd362f); background-repeat: repeat-x; border-color: #bd362f #bd362f #802420; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ee5f5b', endColorstr='#bd362f', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-danger:hover,
<?php echo $m ?> .btn-danger:active,
<?php echo $m ?> .btn-danger.active,
<?php echo $m ?> .btn-danger.disabled,
<?php echo $m ?> .btn-danger[disabled] { background-color: #bd362f; *background-color: #a9302a;}
<?php echo $m ?> .btn-danger:active,
<?php echo $m ?> .btn-danger.active { background-color: #942a25 \9;}
<?php echo $m ?> .btn-success { background-color: #5bb75b; *background-color: #51a351; background-image: -ms-linear-gradient(top, #62c462, #51a351); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351)); background-image: -webkit-linear-gradient(top, #62c462, #51a351); background-image: -o-linear-gradient(top, #62c462, #51a351); background-image: -moz-linear-gradient(top, #62c462, #51a351); background-image: linear-gradient(top, #62c462, #51a351); background-repeat: repeat-x; border-color: #51a351 #51a351 #387038; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#62c462', endColorstr='#51a351', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-success:hover,
<?php echo $m ?> .btn-success:active,
<?php echo $m ?> .btn-success.active,
<?php echo $m ?> .btn-success.disabled,
<?php echo $m ?> .btn-success[disabled] { background-color: #51a351; *background-color: #499249;}
<?php echo $m ?> .btn-success:active,
<?php echo $m ?> .btn-success.active { background-color: #408140 \9;}
<?php echo $m ?> .btn-info { background-color: #49afcd; *background-color: #2f96b4; background-image: -ms-linear-gradient(top, #5bc0de, #2f96b4); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#2f96b4)); background-image: -webkit-linear-gradient(top, #5bc0de, #2f96b4); background-image: -o-linear-gradient(top, #5bc0de, #2f96b4); background-image: -moz-linear-gradient(top, #5bc0de, #2f96b4); background-image: linear-gradient(top, #5bc0de, #2f96b4); background-repeat: repeat-x; border-color: #2f96b4 #2f96b4 #1f6377; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#5bc0de', endColorstr='#2f96b4', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-info:hover,
<?php echo $m ?> .btn-info:active,
<?php echo $m ?> .btn-info.active,
<?php echo $m ?> .btn-info.disabled,
<?php echo $m ?> .btn-info[disabled] { background-color: #2f96b4; *background-color: #2a85a0;}
<?php echo $m ?> .btn-info:active,
<?php echo $m ?> .btn-info.active { background-color: #24748c \9;}
<?php echo $m ?> .btn-inverse { background-color: #414141; *background-color: #222222; background-image: -ms-linear-gradient(top, #555555, #222222); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#555555), to(#222222)); background-image: -webkit-linear-gradient(top, #555555, #222222); background-image: -o-linear-gradient(top, #555555, #222222); background-image: -moz-linear-gradient(top, #555555, #222222); background-image: linear-gradient(top, #555555, #222222); background-repeat: repeat-x; border-color: #222222 #222222 #000000; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#555555', endColorstr='#222222', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false);}
<?php echo $m ?> .btn-inverse:hover,
<?php echo $m ?> .btn-inverse:active,
<?php echo $m ?> .btn-inverse.active,
<?php echo $m ?> .btn-inverse.disabled,
<?php echo $m ?> .btn-inverse[disabled] { background-color: #222222; *background-color: #151515;}
<?php echo $m ?> .btn-inverse:active,
<?php echo $m ?> .btn-inverse.active { background-color: #080808 \9;}
<?php echo $m ?> button.btn,
<?php echo $m ?> input[type="submit"].btn { *padding-top: 2px; *padding-bottom: 2px;}
<?php echo $m ?> button.btn::-moz-focus-inner,
<?php echo $m ?> input[type="submit"].btn::-moz-focus-inner { padding: 0; border: 0;}
<?php echo $m ?> button.btn.btn-large,
<?php echo $m ?> input[type="submit"].btn.btn-large { *padding-top: 7px; *padding-bottom: 7px;}
<?php echo $m ?> button.btn.btn-small,
<?php echo $m ?> input[type="submit"].btn.btn-small { *padding-top: 3px; *padding-bottom: 3px;}
<?php echo $m ?> button.btn.btn-mini,
<?php echo $m ?> input[type="submit"].btn.btn-mini { *padding-top: 1px; *padding-bottom: 1px;}
<?php echo $m ?> .btn-group { position: relative; *margin-left: .3em; *zoom: 1;}
<?php echo $m ?> .btn-group:before,
<?php echo $m ?> .btn-group:after { display: table; content: "";}
<?php echo $m ?> .btn-group:after { clear: both;}
<?php echo $m ?> .btn-group:first-child { *margin-left: 0;}
<?php echo $m ?> .btn-group + .btn-group { margin-left: 5px;}
<?php echo $m ?> .btn-toolbar { margin-top: 9px; margin-bottom: 9px;}
<?php echo $m ?> .btn-toolbar .btn-group { display: inline-block; *display: inline;   *zoom: 1;}
<?php echo $m ?> .btn-group > .btn { position: relative; float: left; margin-left: -1px; -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0; z-index: inherit;}
<?php echo $m ?> .btn-group > .btn:first-child { margin-left: 0; -webkit-border-bottom-left-radius: 4px; border-bottom-left-radius: 4px; -webkit-border-top-left-radius: 4px; border-top-left-radius: 4px; -moz-border-radius-bottomleft: 4px; -moz-border-radius-topleft: 4px;}
<?php echo $m ?> .btn-group > .btn:last-child,
<?php echo $m ?> .btn-group > .dropdown-toggle { -webkit-border-top-right-radius: 4px; border-top-right-radius: 4px; -webkit-border-bottom-right-radius: 4px; border-bottom-right-radius: 4px; -moz-border-radius-topright: 4px; -moz-border-radius-bottomright: 4px;}
<?php echo $m ?> .btn-group > .btn.large:first-child { margin-left: 0; -webkit-border-bottom-left-radius: 6px; border-bottom-left-radius: 6px; -webkit-border-top-left-radius: 6px; border-top-left-radius: 6px; -moz-border-radius-bottomleft: 6px; -moz-border-radius-topleft: 6px;}
<?php echo $m ?> .btn-group > .btn.large:last-child,
<?php echo $m ?> .btn-group > .large.dropdown-toggle { -webkit-border-top-right-radius: 6px; border-top-right-radius: 6px; -webkit-border-bottom-right-radius: 6px; border-bottom-right-radius: 6px; -moz-border-radius-topright: 6px; -moz-border-radius-bottomright: 6px;}
/*
<?php echo $m ?> .btn-group > .btn:hover,
<?php echo $m ?> .btn-group > .btn:focus,
<?php echo $m ?> .btn-group > .btn:active,
<?php echo $m ?> .btn-group > .btn.active { z-index: 2;} */
<?php echo $m ?> .btn-group .dropdown-toggle:active,
<?php echo $m ?> .btn-group.open .dropdown-toggle { outline: 0;}
<?php echo $m ?> .btn-group > .dropdown-toggle { *padding-top: 4px; padding-right: 8px; *padding-bottom: 4px; padding-left: 8px; -webkit-box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.125), inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.125), inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 1px 0 0 rgba(255, 255, 255, 0.125), inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .btn-group > .btn-mini.dropdown-toggle { padding-right: 5px; padding-left: 5px;}
<?php echo $m ?> .btn-group > .btn-small.dropdown-toggle { *padding-top: 4px; *padding-bottom: 4px;}
<?php echo $m ?> .btn-group > .btn-large.dropdown-toggle { padding-right: 12px; padding-left: 12px;}
<?php echo $m ?> .btn-group.open .dropdown-toggle { background-image: none; -webkit-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.15), 0 1px 2px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .btn-group.open .btn.dropdown-toggle { background-color: #e6e6e6;}
<?php echo $m ?> .btn-group.open .btn-primary.dropdown-toggle { background-color: #0055cc;}
<?php echo $m ?> .btn-group.open .btn-warning.dropdown-toggle { background-color: #f89406;}
<?php echo $m ?> .btn-group.open .btn-danger.dropdown-toggle { background-color: #bd362f;}
<?php echo $m ?> .btn-group.open .btn-success.dropdown-toggle { background-color: #51a351;}
<?php echo $m ?> .btn-group.open .btn-info.dropdown-toggle { background-color: #2f96b4;}
<?php echo $m ?> .btn-group.open .btn-inverse.dropdown-toggle { background-color: #222222;}
<?php echo $m ?> .btn .caret { margin-top: 7px; margin-left: 0;}
<?php echo $m ?> .btn:hover .caret,
<?php echo $m ?> .open.btn-group .caret { opacity: 1; filter: alpha(opacity=100);}
<?php echo $m ?> .btn-mini .caret { margin-top: 5px;}
<?php echo $m ?> .btn-small .caret { margin-top: 6px;}
<?php echo $m ?> .btn-large .caret { margin-top: 6px; border-top-width: 5px; border-right-width: 5px; border-left-width: 5px;}
<?php echo $m ?> .dropup .btn-large .caret { border-top: 0; border-bottom: 5px solid #000000;}
<?php echo $m ?> .btn-primary .caret,
<?php echo $m ?> .btn-warning .caret,
<?php echo $m ?> .btn-danger .caret,
<?php echo $m ?> .btn-info .caret,
<?php echo $m ?> .btn-success .caret,
<?php echo $m ?> .btn-inverse .caret { border-top-color: #ffffff; border-bottom-color: #ffffff; opacity: 0.75; filter: alpha(opacity=75);}
<?php echo $m ?> .alert { padding: 8px 35px 8px 14px; margin-bottom: 18px; color: #c09853; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); background-color: #fcf8e3; border: 1px solid #fbeed5; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .alert-heading { color: inherit;}
<?php echo $m ?> .alert .close { position: relative; top: -2px; right: -21px; line-height: 18px;}
<?php echo $m ?> .alert-success { color: #468847; background-color: #dff0d8; border-color: #d6e9c6;}
<?php echo $m ?> .alert-danger,
<?php echo $m ?> .alert-error { color: #b94a48; background-color: #f2dede; border-color: #eed3d7;}
<?php echo $m ?> .alert-info { color: #3a87ad; background-color: #d9edf7; border-color: #bce8f1;}
<?php echo $m ?> .alert-block { padding-top: 14px; padding-bottom: 14px;}
<?php echo $m ?> .alert-block > p,
<?php echo $m ?> .alert-block > ul { margin-bottom: 0;}
<?php echo $m ?> .alert-block p + p { margin-top: 5px;}
<?php echo $m ?> .nav { margin-bottom: 18px; margin-left: 0; list-style: none;}
<?php echo $m ?> .nav > li > a { display: block;}
<?php echo $m ?> .nav > li > a:hover { text-decoration: none; background-color: #eeeeee;}
<?php echo $m ?> .nav > .pull-right { float: right;}
<?php echo $m ?> .nav .nav-header { display: block; padding: 3px 15px; font-size: 11px; font-weight: bold; line-height: 18px; color: #999999; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5); text-transform: uppercase;}
<?php echo $m ?> .nav li + .nav-header { margin-top: 9px;}
<?php echo $m ?> .nav-list { padding-right: 15px; padding-left: 15px; margin-bottom: 0;}
<?php echo $m ?> .nav-list > li > a,
<?php echo $m ?> .nav-list .nav-header { margin-right: -15px; margin-left: -15px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);}
<?php echo $m ?> .nav-list > li > a { padding: 3px 15px;}
<?php echo $m ?> .nav-list > .active > a,
<?php echo $m ?> .nav-list > .active > a:hover { color: #ffffff; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2); background-color: #0088cc;}
<?php echo $m ?> .nav-list [class^="icon-"] { margin-right: 2px;}
<?php echo $m ?> .nav-list .divider { *width: 100%; height: 1px; margin: 8px 1px; *margin: -5px 0 5px; overflow: hidden; background-color: #e5e5e5; border-bottom: 1px solid #ffffff;}
<?php echo $m ?> .nav-tabs,
<?php echo $m ?> .nav-pills { *zoom: 1;}
<?php echo $m ?> .nav-tabs:before,
<?php echo $m ?> .nav-pills:before,
<?php echo $m ?> .nav-tabs:after,
<?php echo $m ?> .nav-pills:after { display: table; content: "";}
<?php echo $m ?> .nav-tabs:after,
<?php echo $m ?> .nav-pills:after { clear: both;}
<?php echo $m ?> .nav-tabs > li,
<?php echo $m ?> .nav-pills > li { float: left;}
<?php echo $m ?> .nav-tabs > li > a,
<?php echo $m ?> .nav-pills > li > a { padding-right: 12px; padding-left: 12px; margin-right: 2px; line-height: 14px;}
<?php echo $m ?> .nav-tabs { border-bottom: 1px solid #ddd;}
<?php echo $m ?> .nav-tabs > li { margin-bottom: -1px;}
<?php echo $m ?> .nav-tabs > li > a { padding-top: 8px; padding-bottom: 8px; line-height: 18px; border: 1px solid transparent; -webkit-border-radius: 4px 4px 0 0; -moz-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;}
<?php echo $m ?> .nav-tabs > li > a:hover { border-color: #eeeeee #eeeeee #dddddd;}
<?php echo $m ?> .nav-tabs > .active > a,
<?php echo $m ?> .nav-tabs > .active > a:hover { color: #555555; cursor: default; background-color: #ffffff; border: 1px solid #ddd; border-bottom-color: transparent;}
<?php echo $m ?> .nav-pills > li > a { padding-top: 8px; padding-bottom: 8px; margin-top: 2px; margin-bottom: 2px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
<?php echo $m ?> .nav-pills > .active > a,
<?php echo $m ?> .nav-pills > .active > a:hover { color: #ffffff; background-color: #0088cc;}
<?php echo $m ?> .nav-stacked > li { float: none;}
<?php echo $m ?> .nav-stacked > li > a { margin-right: 0;}
<?php echo $m ?> .nav-tabs.nav-stacked { border-bottom: 0;}
<?php echo $m ?> .nav-tabs.nav-stacked > li > a { border: 1px solid #ddd; -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;}
<?php echo $m ?> .nav-tabs.nav-stacked > li:first-child > a { -webkit-border-radius: 4px 4px 0 0; -moz-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;}
<?php echo $m ?> .nav-tabs.nav-stacked > li:last-child > a { -webkit-border-radius: 0 0 4px 4px; -moz-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;}
<?php echo $m ?> .nav-tabs.nav-stacked > li > a:hover { z-index: 2; border-color: #ddd;}
<?php echo $m ?> .nav-pills.nav-stacked > li > a { margin-bottom: 3px;}
<?php echo $m ?> .nav-pills.nav-stacked > li:last-child > a { margin-bottom: 1px;}
<?php echo $m ?> .nav-tabs .dropdown-menu { -webkit-border-radius: 0 0 5px 5px; -moz-border-radius: 0 0 5px 5px; border-radius: 0 0 5px 5px;}
<?php echo $m ?> .nav-pills .dropdown-menu { -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .nav-tabs .dropdown-toggle .caret,
<?php echo $m ?> .nav-pills .dropdown-toggle .caret { margin-top: 6px; border-top-color: #0088cc; border-bottom-color: #0088cc;}
<?php echo $m ?> .nav-tabs .dropdown-toggle:hover .caret,
<?php echo $m ?> .nav-pills .dropdown-toggle:hover .caret { border-top-color: #005580; border-bottom-color: #005580;}
<?php echo $m ?> .nav-tabs .active .dropdown-toggle .caret,
<?php echo $m ?> .nav-pills .active .dropdown-toggle .caret { border-top-color: #333333; border-bottom-color: #333333;}
<?php echo $m ?> .nav > .dropdown.active > a:hover { color: #000000; cursor: pointer;}
<?php echo $m ?> .nav-tabs .open .dropdown-toggle,
<?php echo $m ?> .nav-pills .open .dropdown-toggle,
<?php echo $m ?> .nav > li.dropdown.open.active > a:hover { color: #ffffff; background-color: #999999; border-color: #999999;}
<?php echo $m ?> .nav li.dropdown.open .caret,
<?php echo $m ?> .nav li.dropdown.open.active .caret,
<?php echo $m ?> .nav li.dropdown.open a:hover .caret { border-top-color: #ffffff; border-bottom-color: #ffffff; opacity: 1; filter: alpha(opacity=100);}
<?php echo $m ?> .tabs-stacked .open > a:hover { border-color: #999999;}
<?php echo $m ?> .tabbable { *zoom: 1;}
<?php echo $m ?> .tabbable:before,
<?php echo $m ?> .tabbable:after { display: table; content: "";}
<?php echo $m ?> .tabbable:after { clear: both;}
<?php echo $m ?> .tab-content { overflow: auto;}
<?php echo $m ?> .tabs-below > .nav-tabs,
<?php echo $m ?> .tabs-right > .nav-tabs,
<?php echo $m ?> .tabs-left > .nav-tabs { border-bottom: 0;}
<?php echo $m ?> .tab-content > .tab-pane,
<?php echo $m ?> .pill-content > .pill-pane { display: none;}
<?php echo $m ?> .tab-content > .active,
<?php echo $m ?> .pill-content > .active { display: block;}
<?php echo $m ?> .tabs-below > .nav-tabs { border-top: 1px solid #ddd;}
<?php echo $m ?> .tabs-below > .nav-tabs > li { margin-top: -1px; margin-bottom: 0;}
<?php echo $m ?> .tabs-below > .nav-tabs > li > a { -webkit-border-radius: 0 0 4px 4px; -moz-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;}
<?php echo $m ?> .tabs-below > .nav-tabs > li > a:hover { border-top-color: #ddd; border-bottom-color: transparent;}
<?php echo $m ?> .tabs-below > .nav-tabs > .active > a,
<?php echo $m ?> .tabs-below > .nav-tabs > .active > a:hover { border-color: transparent #ddd #ddd #ddd;}
<?php echo $m ?> .tabs-left > .nav-tabs > li,
<?php echo $m ?> .tabs-right > .nav-tabs > li { float: none;}
<?php echo $m ?> .tabs-left > .nav-tabs > li > a,
<?php echo $m ?> .tabs-right > .nav-tabs > li > a { min-width: 74px; margin-right: 0; margin-bottom: 3px;}
<?php echo $m ?> .tabs-left > .nav-tabs { float: left; margin-right: 19px; border-right: 1px solid #ddd;}
<?php echo $m ?> .tabs-left > .nav-tabs > li > a { margin-right: -1px; -webkit-border-radius: 4px 0 0 4px; -moz-border-radius: 4px 0 0 4px; border-radius: 4px 0 0 4px;}
<?php echo $m ?> .tabs-left > .nav-tabs > li > a:hover { border-color: #eeeeee #dddddd #eeeeee #eeeeee;}
<?php echo $m ?> .tabs-left > .nav-tabs .active > a,
<?php echo $m ?> .tabs-left > .nav-tabs .active > a:hover { border-color: #ddd transparent #ddd #ddd; *border-right-color: #ffffff;}
<?php echo $m ?> .tabs-right > .nav-tabs { float: right; margin-left: 19px; border-left: 1px solid #ddd;}
<?php echo $m ?> .tabs-right > .nav-tabs > li > a { margin-left: -1px; -webkit-border-radius: 0 4px 4px 0; -moz-border-radius: 0 4px 4px 0; border-radius: 0 4px 4px 0;}
<?php echo $m ?> .tabs-right > .nav-tabs > li > a:hover { border-color: #eeeeee #eeeeee #eeeeee #dddddd;}
<?php echo $m ?> .tabs-right > .nav-tabs .active > a,
<?php echo $m ?> .tabs-right > .nav-tabs .active > a:hover { border-color: #ddd #ddd #ddd transparent; *border-left-color: #ffffff;}
<?php echo $m ?> .navbar { *position: relative; *z-index: 2; margin-bottom: 18px; overflow: visible;}
<?php echo $m ?> .navbar-inner { min-height: 40px; padding-right: 20px; padding-left: 20px; background-color: #2c2c2c; background-image: -moz-linear-gradient(top, #333333, #222222); background-image: -ms-linear-gradient(top, #333333, #222222); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#333333), to(#222222)); background-image: -webkit-linear-gradient(top, #333333, #222222); background-image: -o-linear-gradient(top, #333333, #222222); background-image: linear-gradient(top, #333333, #222222); background-repeat: repeat-x; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0); -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1); -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1); box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), inset 0 -1px 0 rgba(0, 0, 0, 0.1);}
<?php echo $m ?> .navbar .container { width: auto;}
<?php echo $m ?> .nav-collapse.collapse { height: auto;}
<?php echo $m ?> .navbar { color: #999999;}
<?php echo $m ?> .navbar .brand:hover { text-decoration: none;}
<?php echo $m ?> .navbar .brand { display: block; float: left; padding: 8px 20px 12px; margin-left: -20px; font-size: 20px; font-weight: 200; line-height: 1; color: #999999;}
<?php echo $m ?> .navbar .navbar-text { margin-bottom: 0; line-height: 40px;}
<?php echo $m ?> .navbar .navbar-link { color: #999999;}
<?php echo $m ?> .navbar .navbar-link:hover { color: #ffffff;}
<?php echo $m ?> .navbar .btn,
<?php echo $m ?> .navbar .btn-group { margin-top: 5px;}
<?php echo $m ?> .navbar .btn-group .btn { margin: 0;}
<?php echo $m ?> .navbar-form { margin-bottom: 0; *zoom: 1;}
<?php echo $m ?> .navbar-form:before,
<?php echo $m ?> .navbar-form:after { display: table; content: "";}
<?php echo $m ?> .navbar-form:after { clear: both;}
<?php echo $m ?> .navbar-form input,
<?php echo $m ?> .navbar-form select,
<?php echo $m ?> .navbar-form .radio,
<?php echo $m ?> .navbar-form .checkbox { margin-top: 5px;}
<?php echo $m ?> .navbar-form input,
<?php echo $m ?> .navbar-form select { display: inline-block; margin-bottom: 0;}
<?php echo $m ?> .navbar-form input[type="image"],
<?php echo $m ?> .navbar-form input[type="checkbox"],
<?php echo $m ?> .navbar-form input[type="radio"] { margin-top: 3px;}
<?php echo $m ?> .navbar-form .input-append,
<?php echo $m ?> .navbar-form .input-prepend { margin-top: 6px; white-space: nowrap;}
<?php echo $m ?> .navbar-form .input-append input,
<?php echo $m ?> .navbar-form .input-prepend input { margin-top: 0;}
<?php echo $m ?> .navbar-search { position: relative; float: left; margin-top: 6px; margin-bottom: 0;}
<?php echo $m ?> .navbar-search .search-query { padding: 4px 9px; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; font-weight: normal; line-height: 1; color: #ffffff; background-color: #626262; border: 1px solid #151515; -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(255, 255, 255, 0.15); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(255, 255, 255, 0.15); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(255, 255, 255, 0.15); -webkit-transition: none; -moz-transition: none; -ms-transition: none; -o-transition: none; transition: none;}
<?php echo $m ?> .navbar-search .search-query:-moz-placeholder { color: #cccccc;}
<?php echo $m ?> .navbar-search .search-query:-ms-input-placeholder { color: #cccccc;}
<?php echo $m ?> .navbar-search .search-query::-webkit-input-placeholder { color: #cccccc;}
<?php echo $m ?> .navbar-search .search-query:focus,
<?php echo $m ?> .navbar-search .search-query.focused { padding: 5px 10px; color: #333333; text-shadow: 0 1px 0 #ffffff; background-color: #ffffff; border: 0; outline: 0; -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.15); -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.15); box-shadow: 0 0 3px rgba(0, 0, 0, 0.15);}
<?php echo $m ?> .navbar-fixed-top,
<?php echo $m ?> .navbar-fixed-bottom { position: fixed; right: 0; left: 0; z-index: 1030; margin-bottom: 0;}
<?php echo $m ?> .navbar-fixed-top .navbar-inner,
<?php echo $m ?> .navbar-fixed-bottom .navbar-inner { padding-right: 0; padding-left: 0; -webkit-border-radius: 0; -moz-border-radius: 0; border-radius: 0;}
<?php echo $m ?> .navbar-fixed-top .container,
<?php echo $m ?> .navbar-fixed-bottom .container { width: 940px;}
<?php echo $m ?> .navbar-fixed-top { top: 0;}
<?php echo $m ?> .navbar-fixed-bottom { bottom: 0;}
<?php echo $m ?> .navbar .nav { position: relative; left: 0; display: block; float: left; margin: 0 10px 0 0;}
<?php echo $m ?> .navbar .nav.pull-right { float: right;}
<?php echo $m ?> .navbar .nav > li { display: block; float: left;}
<?php echo $m ?> .navbar .nav > li > a { float: none; padding: 9px 10px 11px; line-height: 19px; color: #999999; text-decoration: none; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);}
<?php echo $m ?> .navbar .btn { display: inline-block; padding: 4px 10px 4px; margin: 5px 5px 6px; line-height: 18px;}
<?php echo $m ?> .navbar .btn-group { padding: 5px 5px 6px; margin: 0;}
<?php echo $m ?> .navbar .nav > li > a:hover { color: #ffffff; text-decoration: none; background-color: transparent;}
<?php echo $m ?> .navbar .nav .active > a,
<?php echo $m ?> .navbar .nav .active > a:hover { color: #ffffff; text-decoration: none; background-color: #222222;}
<?php echo $m ?> .navbar .divider-vertical { width: 1px; height: 40px; margin: 0 9px; overflow: hidden; background-color: #222222; border-right: 1px solid #333333;}
<?php echo $m ?> .navbar .nav.pull-right { margin-right: 0; margin-left: 10px;}
<?php echo $m ?> .navbar .btn-navbar { display: none; float: right; padding: 7px 10px; margin-right: 5px; margin-left: 5px; background-color: #2c2c2c; *background-color: #222222; background-image: -ms-linear-gradient(top, #333333, #222222); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#333333), to(#222222)); background-image: -webkit-linear-gradient(top, #333333, #222222); background-image: -o-linear-gradient(top, #333333, #222222); background-image: linear-gradient(top, #333333, #222222); background-image: -moz-linear-gradient(top, #333333, #222222); background-repeat: repeat-x; border-color: #222222 #222222 #000000; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); filter: progid:dximagetransform.microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0); filter: progid:dximagetransform.microsoft.gradient(enabled=false); -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1), 0 1px 0 rgba(255, 255, 255, 0.075);}
<?php echo $m ?> .navbar .btn-navbar:hover,
<?php echo $m ?> .navbar .btn-navbar:active,
<?php echo $m ?> .navbar .btn-navbar.active,
<?php echo $m ?> .navbar .btn-navbar.disabled,
<?php echo $m ?> .navbar .btn-navbar[disabled] { background-color: #222222; *background-color: #151515;}
<?php echo $m ?> .navbar .btn-navbar:active,
<?php echo $m ?> .navbar .btn-navbar.active { background-color: #080808 \9;}
<?php echo $m ?> .navbar .btn-navbar .icon-bar { display: block; width: 18px; height: 2px; background-color: #f5f5f5; -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px; -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25); -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25); box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25);}
<?php echo $m ?> .btn-navbar .icon-bar + .icon-bar { margin-top: 3px;}
<?php echo $m ?> .navbar .dropdown-menu:before { position: absolute; top: -7px; left: 9px; display: inline-block; border-right: 7px solid transparent; border-bottom: 7px solid #ccc; border-left: 7px solid transparent; border-bottom-color: rgba(0, 0, 0, 0.2); content: '';}
<?php echo $m ?> .navbar .dropdown-menu:after { position: absolute; top: -6px; left: 10px; display: inline-block; border-right: 6px solid transparent; border-bottom: 6px solid #ffffff; border-left: 6px solid transparent; content: '';}
<?php echo $m ?> .navbar-fixed-bottom .dropdown-menu:before { top: auto; bottom: -7px; border-top: 7px solid #ccc; border-bottom: 0; border-top-color: rgba(0, 0, 0, 0.2);}
<?php echo $m ?> .navbar-fixed-bottom .dropdown-menu:after { top: auto; bottom: -6px; border-top: 6px solid #ffffff; border-bottom: 0;}
<?php echo $m ?> .navbar .nav li.dropdown .dropdown-toggle .caret,
<?php echo $m ?> .navbar .nav li.dropdown.open .caret { border-top-color: #ffffff; border-bottom-color: #ffffff;}
<?php echo $m ?> .navbar .nav li.dropdown.active .caret { opacity: 1; filter: alpha(opacity=100);}
<?php echo $m ?> .navbar .nav li.dropdown.open > .dropdown-toggle,
<?php echo $m ?> .navbar .nav li.dropdown.active > .dropdown-toggle,
<?php echo $m ?> .navbar .nav li.dropdown.open.active > .dropdown-toggle { background-color: transparent;}
<?php echo $m ?> .navbar .nav li.dropdown.active > .dropdown-toggle:hover { color: #ffffff;}
<?php echo $m ?> .navbar .pull-right .dropdown-menu,
<?php echo $m ?> .navbar .dropdown-menu.pull-right { right: 0; left: auto;}
<?php echo $m ?> .navbar .pull-right .dropdown-menu:before,
<?php echo $m ?> .navbar .dropdown-menu.pull-right:before { right: 12px; left: auto;}
<?php echo $m ?> .navbar .pull-right .dropdown-menu:after,
<?php echo $m ?> .navbar .dropdown-menu.pull-right:after { right: 13px; left: auto;}
<?php echo $m ?> .breadcrumb { padding: 7px 14px; margin: 0 0 18px; list-style: none; background-color: #fbfbfb; background-image: -moz-linear-gradient(top, #ffffff, #f5f5f5); background-image: -ms-linear-gradient(top, #ffffff, #f5f5f5); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#f5f5f5)); background-image: -webkit-linear-gradient(top, #ffffff, #f5f5f5); background-image: -o-linear-gradient(top, #ffffff, #f5f5f5); background-image: linear-gradient(top, #ffffff, #f5f5f5); background-repeat: repeat-x; border: 1px solid #ddd; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffff', endColorstr='#f5f5f5', GradientType=0); -webkit-box-shadow: inset 0 1px 0 #ffffff; -moz-box-shadow: inset 0 1px 0 #ffffff; box-shadow: inset 0 1px 0 #ffffff;}
<?php echo $m ?> .breadcrumb li { display: inline-block; *display: inline; text-shadow: 0 1px 0 #ffffff; *zoom: 1;}
<?php echo $m ?> .breadcrumb .divider { padding: 0 5px; color: #999999;}
<?php echo $m ?> .breadcrumb .active a { color: #333333;}
<?php echo $m ?> .pagination { height: 36px; margin: 18px 0;}
<?php echo $m ?> .pagination ul { display: inline-block; *display: inline; margin-bottom: 0; margin-left: 0; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; *zoom: 1; -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);}
<?php echo $m ?> .pagination li { display: inline;}
<?php echo $m ?> .pagination a { float: left; padding: 0 14px; line-height: 34px; text-decoration: none; border: 1px solid #ddd; border-left-width: 0;}
<?php echo $m ?> .pagination a:hover,
<?php echo $m ?> .pagination .active a { background-color: #f5f5f5;}
<?php echo $m ?> .pagination .active a { color: #999999; cursor: default;}
<?php echo $m ?> .pagination .disabled span,
<?php echo $m ?> .pagination .disabled a,
<?php echo $m ?> .pagination .disabled a:hover { color: #999999; cursor: default; background-color: transparent;}
<?php echo $m ?> .pagination li:first-child a { border-left-width: 1px; -webkit-border-radius: 3px 0 0 3px; -moz-border-radius: 3px 0 0 3px; border-radius: 3px 0 0 3px;}
<?php echo $m ?> .pagination li:last-child a { -webkit-border-radius: 0 3px 3px 0; -moz-border-radius: 0 3px 3px 0; border-radius: 0 3px 3px 0;}
<?php echo $m ?> .pagination-centered { text-align: center;}
<?php echo $m ?> .pagination-right { text-align: right;}
<?php echo $m ?> .pager { margin-bottom: 18px; margin-left: 0; text-align: center; list-style: none; *zoom: 1;}
<?php echo $m ?> .pager:before,
<?php echo $m ?> .pager:after { display: table; content: "";}
<?php echo $m ?> .pager:after { clear: both;}
<?php echo $m ?> .pager li { display: inline;}
<?php echo $m ?> .pager a { display: inline-block; padding: 5px 14px; background-color: #fff; border: 1px solid #ddd; -webkit-border-radius: 15px; -moz-border-radius: 15px; border-radius: 15px;}
<?php echo $m ?> .pager a:hover { text-decoration: none; background-color: #f5f5f5;}
<?php echo $m ?> .pager .next a { float: right;}
<?php echo $m ?> .pager .previous a { float: left;}
<?php echo $m ?> .pager .disabled a,
<?php echo $m ?> .pager .disabled a:hover { color: #999999; cursor: default; background-color: #fff;}
<?php echo $m ?> .modal-open .dropdown-menu { z-index: 2050;}
<?php echo $m ?> .modal-open .dropdown.open { *z-index: 2050;}
<?php echo $m ?> .modal-open .popover { z-index: 2060;}
<?php echo $m ?> .modal-open .tooltip { z-index: 2070;}
<?php echo $m ?> .modal-backdrop { position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 1040; background-color: #000000;}
<?php echo $m ?> .modal-backdrop.fade { opacity: 0;}
<?php echo $m ?> .modal-backdrop,
<?php echo $m ?> .modal-backdrop.fade.in { opacity: 0.8; filter: alpha(opacity=80);}
<?php echo $m ?> .modal { position: fixed; top: 50%; left: 50%; z-index: 1050; width: 560px; margin: -250px 0 0 -280px; overflow: auto; background-color: #ffffff; border: 1px solid #999; border: 1px solid rgba(0, 0, 0, 0.3); *border: 1px solid #999; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); -webkit-background-clip: padding-box; -moz-background-clip: padding-box; background-clip: padding-box;}
<?php echo $m ?> .modal.fade { top: -25%; -webkit-transition: opacity 0.3s linear, top 0.3s ease-out; -moz-transition: opacity 0.3s linear, top 0.3s ease-out; -ms-transition: opacity 0.3s linear, top 0.3s ease-out; -o-transition: opacity 0.3s linear, top 0.3s ease-out; transition: opacity 0.3s linear, top 0.3s ease-out;}
<?php echo $m ?> .modal.fade.in { top: 50%;}
<?php echo $m ?> .modal-header { padding: 9px 15px; border-bottom: 1px solid #eee;}
<?php echo $m ?> .modal-header .close { margin-top: 2px;}
<?php echo $m ?> .modal-body { max-height: 400px; padding: 15px; overflow-y: auto;}
<?php echo $m ?> .modal-form { margin-bottom: 0;}
<?php echo $m ?> .modal-footer { padding: 14px 15px 15px; margin-bottom: 0; text-align: right; background-color: #f5f5f5; border-top: 1px solid #ddd; -webkit-border-radius: 0 0 6px 6px; -moz-border-radius: 0 0 6px 6px; border-radius: 0 0 6px 6px; *zoom: 1; -webkit-box-shadow: inset 0 1px 0 #ffffff; -moz-box-shadow: inset 0 1px 0 #ffffff; box-shadow: inset 0 1px 0 #ffffff;}
<?php echo $m ?> .modal-footer:before,
<?php echo $m ?> .modal-footer:after { display: table; content: "";}
<?php echo $m ?> .modal-footer:after { clear: both;}
<?php echo $m ?> .modal-footer .btn + .btn { margin-bottom: 0; margin-left: 5px;}
<?php echo $m ?> .modal-footer .btn-group .btn + .btn { margin-left: -1px;}
<?php echo $m ?> .tooltip { position: absolute; z-index: 1020; display: block; padding: 5px; font-size: 11px; opacity: 0; filter: alpha(opacity=0); visibility: visible;}
<?php echo $m ?> .tooltip.in { opacity: 0.8; filter: alpha(opacity=80);}
<?php echo $m ?> .tooltip.top { margin-top: -2px;}
<?php echo $m ?> .tooltip.right { margin-left: 2px;}
<?php echo $m ?> .tooltip.bottom { margin-top: 2px;}
<?php echo $m ?> .tooltip.left { margin-left: -2px;}
<?php echo $m ?> .tooltip.top .tooltip-arrow { bottom: 0; left: 50%; margin-left: -5px; border-top: 5px solid #000000; border-right: 5px solid transparent; border-left: 5px solid transparent;}
<?php echo $m ?> .tooltip.left .tooltip-arrow { top: 50%; right: 0; margin-top: -5px; border-top: 5px solid transparent; border-bottom: 5px solid transparent; border-left: 5px solid #000000;}
<?php echo $m ?> .tooltip.bottom .tooltip-arrow { top: 0; left: 50%; margin-left: -5px; border-right: 5px solid transparent; border-bottom: 5px solid #000000; border-left: 5px solid transparent;}
<?php echo $m ?> .tooltip.right .tooltip-arrow { top: 50%; left: 0; margin-top: -5px; border-top: 5px solid transparent; border-right: 5px solid #000000; border-bottom: 5px solid transparent;}
<?php echo $m ?> .tooltip-inner { max-width: 200px; padding: 3px 8px; color: #ffffff; text-align: center; text-decoration: none; background-color: #000000; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .tooltip-arrow { position: absolute; width: 0; height: 0;}
<?php echo $m ?> .popover { position: absolute; top: 0; left: 0; z-index: 1010; display: none; padding: 5px;}
<?php echo $m ?> .popover.top { margin-top: -5px;}
<?php echo $m ?> .popover.right { margin-left: 5px;}
<?php echo $m ?> .popover.bottom { margin-top: 5px;}
<?php echo $m ?> .popover.left { margin-left: -5px;}
<?php echo $m ?> .popover.top .arrow { bottom: 0; left: 50%; margin-left: -5px; border-top: 5px solid #000000; border-right: 5px solid transparent; border-left: 5px solid transparent;}
<?php echo $m ?> .popover.right .arrow { top: 50%; left: 0; margin-top: -5px; border-top: 5px solid transparent; border-right: 5px solid #000000; border-bottom: 5px solid transparent;}
<?php echo $m ?> .popover.bottom .arrow { top: 0; left: 50%; margin-left: -5px; border-right: 5px solid transparent; border-bottom: 5px solid #000000; border-left: 5px solid transparent;}
<?php echo $m ?> .popover.left .arrow { top: 50%; right: 0; margin-top: -5px; border-top: 5px solid transparent; border-bottom: 5px solid transparent; border-left: 5px solid #000000;}
<?php echo $m ?> .popover .arrow { position: absolute; width: 0; height: 0;}
<?php echo $m ?> .popover-inner { width: 280px; padding: 3px; overflow: hidden; background: #000000; background: rgba(0, 0, 0, 0.8); -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px; -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3); box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);}
<?php echo $m ?> .popover-title { padding: 9px 15px; line-height: 1; background-color: #f5f5f5; border-bottom: 1px solid #eee; -webkit-border-radius: 3px 3px 0 0; -moz-border-radius: 3px 3px 0 0; border-radius: 3px 3px 0 0;}
<?php echo $m ?> .popover-content { padding: 14px; background-color: #ffffff; -webkit-border-radius: 0 0 3px 3px; -moz-border-radius: 0 0 3px 3px; border-radius: 0 0 3px 3px; -webkit-background-clip: padding-box; -moz-background-clip: padding-box; background-clip: padding-box;}
<?php echo $m ?> .popover-content p,
<?php echo $m ?> .popover-content ul,
<?php echo $m ?> .popover-content ol { margin-bottom: 0;}
<?php echo $m ?> .thumbnails { margin-left: -20px; list-style: none; *zoom: 1;}
<?php echo $m ?> .thumbnails:before,
<?php echo $m ?> .thumbnails:after { display: table; content: "";}
<?php echo $m ?> .thumbnails:after { clear: both;}
<?php echo $m ?> .row-fluid .thumbnails { margin-left: 0;}
<?php echo $m ?> .thumbnails > li { float: left; margin-bottom: 18px; margin-left: 20px;}
<?php echo $m ?> .thumbnail { display: block; padding: 4px; line-height: 1; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075); -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075); box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075);}
<?php echo $m ?> a.thumbnail:hover { border-color: #0088cc; -webkit-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25); -moz-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25); box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);}
<?php echo $m ?> .thumbnail > img { display: block; max-width: 100%; margin-right: auto; margin-left: auto;}
<?php echo $m ?> .thumbnail .caption { padding: 9px;}
<?php echo $m ?> .label,
<?php echo $m ?> .badge { font-size: 10.998px; font-weight: bold; line-height: 14px; color: #ffffff; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); white-space: nowrap; vertical-align: baseline; background-color: #999999;}
<?php echo $m ?> .label { padding: 1px 4px 2px; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;}
<?php echo $m ?> .badge { padding: 1px 9px 2px; -webkit-border-radius: 9px; -moz-border-radius: 9px; border-radius: 9px;}
<?php echo $m ?> a.label:hover,
<?php echo $m ?> a.badge:hover { color: #ffffff; text-decoration: none; cursor: pointer;}
<?php echo $m ?> .label-important,
<?php echo $m ?> .badge-important { background-color: #b94a48;}
<?php echo $m ?> .label-important[href],
<?php echo $m ?> .badge-important[href] { background-color: #953b39;}
<?php echo $m ?> .label-warning,
<?php echo $m ?> .badge-warning { background-color: #f89406;}
<?php echo $m ?> .label-warning[href],
<?php echo $m ?> .badge-warning[href] { background-color: #c67605;}
<?php echo $m ?> .label-success,
<?php echo $m ?> .badge-success { background-color: #468847;}
<?php echo $m ?> .label-success[href],
<?php echo $m ?> .badge-success[href] { background-color: #356635;}
<?php echo $m ?> .label-info,
<?php echo $m ?> .badge-info { background-color: #3a87ad;}
<?php echo $m ?> .label-info[href],
<?php echo $m ?> .badge-info[href] { background-color: #2d6987;}
<?php echo $m ?> .label-inverse,
<?php echo $m ?> .badge-inverse { background-color: #333333;}
<?php echo $m ?> .label-inverse[href],
<?php echo $m ?> .badge-inverse[href] { background-color: #1a1a1a;}
<?php echo $m ?> @-webkit-keyframes progress-bar-stripes { from { background-position: 40px 0; } to { background-position: 0 0; }}
<?php echo $m ?> @-moz-keyframes progress-bar-stripes { from { background-position: 40px 0; } to { background-position: 0 0; }}
<?php echo $m ?> @-ms-keyframes progress-bar-stripes { from { background-position: 40px 0; } to { background-position: 0 0; }}
<?php echo $m ?> @-o-keyframes progress-bar-stripes { from { background-position: 0 0; } to { background-position: 40px 0; }}
<?php echo $m ?> @keyframes progress-bar-stripes { from { background-position: 40px 0; } to { background-position: 0 0; }}
<?php echo $m ?> .progress { height: 18px; margin-bottom: 18px; overflow: hidden; background-color: #f7f7f7; background-image: -moz-linear-gradient(top, #f5f5f5, #f9f9f9); background-image: -ms-linear-gradient(top, #f5f5f5, #f9f9f9); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f5f5f5), to(#f9f9f9)); background-image: -webkit-linear-gradient(top, #f5f5f5, #f9f9f9); background-image: -o-linear-gradient(top, #f5f5f5, #f9f9f9); background-image: linear-gradient(top, #f5f5f5, #f9f9f9); background-repeat: repeat-x; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#f5f5f5', endColorstr='#f9f9f9', GradientType=0); -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);}
<?php echo $m ?> .progress .bar { width: 0; height: 18px; font-size: 12px; color: #ffffff; text-align: center; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); background-color: #0e90d2; background-image: -moz-linear-gradient(top, #149bdf, #0480be); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#149bdf), to(#0480be)); background-image: -webkit-linear-gradient(top, #149bdf, #0480be); background-image: -o-linear-gradient(top, #149bdf, #0480be); background-image: linear-gradient(top, #149bdf, #0480be); background-image: -ms-linear-gradient(top, #149bdf, #0480be); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#149bdf', endColorstr='#0480be', GradientType=0); -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15); -moz-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15); box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.15); -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box; -webkit-transition: width 0.6s ease; -moz-transition: width 0.6s ease; -ms-transition: width 0.6s ease; -o-transition: width 0.6s ease; transition: width 0.6s ease;}
<?php echo $m ?> .progress-striped .bar { background-color: #149bdf; background-image: -o-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -ms-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent)); background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); -webkit-background-size: 40px 40px; -moz-background-size: 40px 40px; -o-background-size: 40px 40px; background-size: 40px 40px;}
<?php echo $m ?> .progress.active .bar { -webkit-animation: progress-bar-stripes 2s linear infinite; -moz-animation: progress-bar-stripes 2s linear infinite; -ms-animation: progress-bar-stripes 2s linear infinite; -o-animation: progress-bar-stripes 2s linear infinite; animation: progress-bar-stripes 2s linear infinite;}
<?php echo $m ?> .progress-danger .bar { background-color: #dd514c; background-image: -moz-linear-gradient(top, #ee5f5b, #c43c35); background-image: -ms-linear-gradient(top, #ee5f5b, #c43c35); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ee5f5b), to(#c43c35)); background-image: -webkit-linear-gradient(top, #ee5f5b, #c43c35); background-image: -o-linear-gradient(top, #ee5f5b, #c43c35); background-image: linear-gradient(top, #ee5f5b, #c43c35); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ee5f5b', endColorstr='#c43c35', GradientType=0);}
<?php echo $m ?> .progress-danger.progress-striped .bar { background-color: #ee5f5b; background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent)); background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -ms-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -o-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
<?php echo $m ?> .progress-success .bar { background-color: #5eb95e; background-image: -moz-linear-gradient(top, #62c462, #57a957); background-image: -ms-linear-gradient(top, #62c462, #57a957); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#57a957)); background-image: -webkit-linear-gradient(top, #62c462, #57a957); background-image: -o-linear-gradient(top, #62c462, #57a957); background-image: linear-gradient(top, #62c462, #57a957); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#62c462', endColorstr='#57a957', GradientType=0);}
<?php echo $m ?> .progress-success.progress-striped .bar { background-color: #62c462; background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent)); background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -ms-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -o-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
<?php echo $m ?> .progress-info .bar { background-color: #4bb1cf; background-image: -moz-linear-gradient(top, #5bc0de, #339bb9); background-image: -ms-linear-gradient(top, #5bc0de, #339bb9); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#339bb9)); background-image: -webkit-linear-gradient(top, #5bc0de, #339bb9); background-image: -o-linear-gradient(top, #5bc0de, #339bb9); background-image: linear-gradient(top, #5bc0de, #339bb9); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#5bc0de', endColorstr='#339bb9', GradientType=0);}
<?php echo $m ?> .progress-info.progress-striped .bar { background-color: #5bc0de; background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent)); background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -ms-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -o-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
<?php echo $m ?> .progress-warning .bar { background-color: #faa732; background-image: -moz-linear-gradient(top, #fbb450, #f89406); background-image: -ms-linear-gradient(top, #fbb450, #f89406); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fbb450), to(#f89406)); background-image: -webkit-linear-gradient(top, #fbb450, #f89406); background-image: -o-linear-gradient(top, #fbb450, #f89406); background-image: linear-gradient(top, #fbb450, #f89406); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr='#fbb450', endColorstr='#f89406', GradientType=0);}
<?php echo $m ?> .progress-warning.progress-striped .bar { background-color: #fbb450; background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent)); background-image: -webkit-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -moz-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -ms-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: -o-linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent); background-image: linear-gradient(-45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);}
<?php echo $m ?> .accordion { margin-bottom: 18px;}
<?php echo $m ?> .accordion-group { margin-bottom: 2px; border: 1px solid #e5e5e5; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;}
<?php echo $m ?> .accordion-heading { border-bottom: 0;}
<?php echo $m ?> .accordion-heading .accordion-toggle { display: block; padding: 8px 15px;}
<?php echo $m ?> .accordion-toggle { cursor: pointer;}
<?php echo $m ?> .accordion-inner { padding: 9px 15px; border-top: 1px solid #e5e5e5;}
<?php echo $m ?> .carousel { position: relative; margin-bottom: 18px; line-height: 1;}
<?php echo $m ?> .carousel-inner { position: relative; width: 100%; overflow: hidden;}
<?php echo $m ?> .carousel .item { position: relative; display: none; -webkit-transition: 0.6s ease-in-out left; -moz-transition: 0.6s ease-in-out left; -ms-transition: 0.6s ease-in-out left; -o-transition: 0.6s ease-in-out left; transition: 0.6s ease-in-out left;}
<?php echo $m ?> .carousel .item > img { display: block; line-height: 1;}
<?php echo $m ?> .carousel .active,
<?php echo $m ?> .carousel .next,
<?php echo $m ?> .carousel .prev { display: block;}
<?php echo $m ?> .carousel .active { left: 0;}
<?php echo $m ?> .carousel .next,
<?php echo $m ?> .carousel .prev { position: absolute; top: 0; width: 100%;}
<?php echo $m ?> .carousel .next { left: 100%;}
<?php echo $m ?> .carousel .prev { left: -100%;}
<?php echo $m ?> .carousel .next.left,
<?php echo $m ?> .carousel .prev.right { left: 0;}
<?php echo $m ?> .carousel .active.left { left: -100%;}
<?php echo $m ?> .carousel .active.right { left: 100%;}
<?php echo $m ?> .carousel-control { position: absolute; top: 40%; left: 15px; width: 40px; height: 40px; margin-top: -20px; font-size: 60px; font-weight: 100; line-height: 30px; color: #ffffff; text-align: center; background: #222222; border: 3px solid #ffffff; -webkit-border-radius: 23px; -moz-border-radius: 23px; border-radius: 23px; opacity: 0.5; filter: alpha(opacity=50);}
<?php echo $m ?> .carousel-control.right { right: 15px; left: auto;}
<?php echo $m ?> .carousel-control:hover { color: #ffffff; text-decoration: none; opacity: 0.9; filter: alpha(opacity=90);}
<?php echo $m ?> .carousel-caption { position: absolute; right: 0; bottom: 0; left: 0; padding: 10px 15px 5px; background: #333333; background: rgba(0, 0, 0, 0.75);}
<?php echo $m ?> .carousel-caption h4,
<?php echo $m ?> .carousel-caption p { color: #ffffff;}
<?php echo $m ?> .hero-unit { padding: 60px; margin-bottom: 30px; background-color: #eeeeee; -webkit-border-radius: 6px; -moz-border-radius: 6px; border-radius: 6px;}
<?php echo $m ?> .hero-unit h1 { margin-bottom: 0; font-size: 60px; line-height: 1; letter-spacing: -1px; color: inherit;}
<?php echo $m ?> .hero-unit p { font-size: 18px; font-weight: 200; line-height: 27px; color: inherit;}
<?php echo $m ?> .pull-right { float: right;}
<?php echo $m ?> .pull-left { float: left;}
<?php echo $m ?> .hide { display: none;}
<?php echo $m ?> .show { display: block;}
<?php echo $m ?> .invisible { visibility: hidden;}