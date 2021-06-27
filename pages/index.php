<?php

/** @var rex_addon $this */

$currentPage = rex_be_controller::getCurrentPageObject();
echo rex_view::title( $this->getProperty('page')['title'].' &mdash; '.$currentPage->getTitle() );
include $currentPage->getSubPath();
