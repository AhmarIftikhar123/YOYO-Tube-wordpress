<?php
/*
Template Name: Video Player
*/

use Stripe\stripe_payment;


$video_player_page = new stripe_payment();
$video_player_page->render_page();