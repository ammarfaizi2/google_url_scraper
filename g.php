<?php 

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com> https://www.facebook.com/ammarfaizi2
 * @license MIT
 * @version 0.0.1
 */

require __DIR__."/GoogleUrlScraper.php";

use IceTea\Google\GoogleUrlScraper;

$query = "es teh";
$limit = 30;

$st = new GoogleUrlScraper($query, $limit);
$st->exec();

print_r($st->getResult());