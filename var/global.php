<?php
define('CL_USER', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'user.php');
define('CL_ANNOUNCEMENT', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'announcement.php');
define('CL_CATEGORY', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'category.php');
define('CL_OPERATION', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'operation.php');
define('CL_COMMENT', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'comment.php');
define('CONNECT', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'ops'.DIRECTORY_SEPARATOR.'connect.php');
define('DIR_USER', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'perfil'.DIRECTORY_SEPARATOR);
define('DIR_ADS', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'ads'.DIRECTORY_SEPARATOR);
define('DIR_COMMENT', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'comment'.DIRECTORY_SEPARATOR);
require_once CL_USER;
require_once CL_ANNOUNCEMENT;
require_once CL_CATEGORY;
require_once CL_OPERATION;
require_once CL_COMMENT;
require_once CONNECT;
?>
