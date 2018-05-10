<?php
/**
 * Date: 02.03.2018
 * Time: 15:32
 */
/**
 * @var string $site_name
 * @var array $data
 */

$body = "Dear " . $data['name'] . "\n\n";
$body .= "We have received your message. Thank you for your interest in our company.\n";
$body .= "We will email you the answer to your question.\n";
$body .= "\n\n";
$body .= "Sincerely,\n";
$body .= $site_name . " Team!\n";

echo $body;
