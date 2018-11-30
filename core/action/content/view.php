<?php
	
	$content = Content::getContentByUrl(Cheese::$data->url->path);

	Cheese::$data->content = $content->getData();

?>