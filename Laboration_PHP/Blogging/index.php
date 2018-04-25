<?php
require ('resources/includes/view.php');
require ('resources/includes/model.php');
// Set header correct without using HTML
header("Content-type: text/html; charset=utf-8");

// Get value from url for key page
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);

if(empty($page)) {
	$header = 'Start';
	$content = '<div class="content">
		Välkommen till Labb 2! Här övar vi på PHP för att bli duktiga webbserverprogrammerare. Detta är andra labben men första labben i en serie labbar som tillsammans bygger vidare på detta projekt som vi påbörjar här. Ett enkelt PHP-projekt men väl strukturerat och genomtänkt konstruerat.
	</div>';
	require ('resources/templates/page-template.php');
}
else if($page=="blogg") {
	$header = 'Blogg';
	$post = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_URL);
	$template = 'all-blog-posts';

	if (!empty($post)) {
		foreach ($model as $key => $slug) {
			if ($model[$key]['slug'] == $post) {
				$template = 'single-blog-post';
				$title = $model[$key]['title'];
				$author = $model [$key]['author'];
				$date = $model[$key]['date'];
				$text = $model[$key]['text'];
			}
		}
	}

	elseif (empty($post)) {}

	else {}


	require ('resources/templates/' . $template . '-template.php');
}
else if($page=="kontakt") {
	$header = 'Kontakt';
    $content = '<div class="content">Du når oss på epost@labb2.se</div>';
    include ('resources/templates/page-template.php');
}
else {
	echo "Den sökta sidan finns inte";
}


?>
