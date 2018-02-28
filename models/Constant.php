<?php

namespace app\models;

use Yii;

class Constant {

	public static $root_rest_url = "http://adminboard.local/";

	public static $url_client_site = "http://board.local";
	public static $folder_images = "images";

	public static $folder_images_server = "E:/Development/OpenServer/domains/board.local/web/images/";

	public static $allowed_filetypes = array( 'jpg', 'jpeg', 'gif', 'png' );

	public static $media_width = 150;
	public static $media_height = 150;
	public static $small_width = 50;
	public static $small_height = 50;

	public static $count_advert_in_page = 8;
}
