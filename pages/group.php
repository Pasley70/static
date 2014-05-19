<?php
/**
 * List the top statics of this group
 */

elgg_gatekeeper();
elgg_group_gatekeeper();

$group = elgg_get_page_owner_entity();
if (empty($group) || !elgg_instanceof($group, "group")) {
	forward(REFERER);
}

$can_write = $group->canWriteToContainer(0, "object", "static");

$options = array(
	"type" => "object",
	"subtype" => "static",
	"limit" => false,
	"container_guid" => $group->getGUID()
);

$entities = elgg_get_entities($options);
if ($entities) {
	$body = "<table class='elgg-table-alt' id='static-pages-list'>";
	$body .= "<thead><tr>";
	$body .= "<th>" . elgg_echo("title") . "</th>";
	
	if ($can_write) {
		$body .= "<th class='center'>" . elgg_echo("edit") . "</th>";
		$body .= "<th class='center'>" . elgg_echo("delete") . "</th>";
	}
	$body .= "</tr></thead>";

	foreach ($entities as $entity) {

		$body .= elgg_view_entity($entity, array("full_view" => false));

	}
	$body .= "</table>";
}

if (empty($body)) {
	$body = elgg_echo("static:admin:empty");
}

if ($can_write) {
	elgg_register_title_button();
}

$title_text = elgg_echo("static:groups:title");
$body = elgg_view_layout("content", array(
	"content" => $body, 
	"title" => $title_text,
	"filter" => ""
));

echo elgg_view_page($title_text, $body);