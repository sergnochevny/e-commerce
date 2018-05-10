<?php
/**
 * Date: 02.03.2018
 * Time: 15:32
 */
/**
 * @var string $site_name
 * @var array $data
 */

$body = "Dear Admin!\n\n";
$body .= "You`ve received a new request from your website.\n";
$body .= "Below are the details that we have captured:\n";
$body .= "\n";
$body .= "From: " . $data['name'] . "(email: " . $data['email'] . ", tel.: " . $data['phone'] . ")\n";
$body .= "Subject: " . $data['subject'] . "\n";
$body .= $data['comments'];
$body .= "\n\n";
$body .= "Sincerely,\n";
$body .= $site_name . " Team!\n";

echo $body;