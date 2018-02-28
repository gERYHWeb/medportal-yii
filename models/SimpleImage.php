<?php

namespace app\models;

class SimpleImage {

	private static $image;
	private static $image_type;

	public static function load( $filename ) {
		$image_info       = getimagesize( $filename );
		self::$image_type = $image_info[2];
		if ( self::$image_type == IMAGETYPE_JPEG ) {
			self::$image = imagecreatefromjpeg( $filename );
		} elseif ( self::$image_type == IMAGETYPE_GIF ) {
			self::$image = imagecreatefromgif( $filename );
		} elseif ( self::$image_type == IMAGETYPE_PNG ) {
			self::$image = imagecreatefrompng( $filename );
		}
	}

	public  function save( $filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null ) {
		if ( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg( self::$image, $filename, $compression );
		} elseif ( $image_type == IMAGETYPE_GIF ) {
			imagegif( self::$image, $filename );
		} elseif ( $image_type == IMAGETYPE_PNG ) {
			imagepng( self::$image, $filename );
		}
		if ( $permissions != null ) {
			chmod( $filename, $permissions );
		}
	}

	public function output( $image_type = IMAGETYPE_JPEG ) {
		if ( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg( self::$image );
		} elseif ( $image_type == IMAGETYPE_GIF ) {
			imagegif( self::$image );
		} elseif ( $image_type == IMAGETYPE_PNG ) {
			imagepng( self::$image );
		}
	}

	public function getWidth() {
		return imagesx( self::$image );
	}

	public function getHeight() {
		return imagesy( self::$image );
	}

	public function resizeToHeight( $height ) {
		$ratio = $height / self::getHeight();
		$width = self::getWidth() * $ratio;
		self::resize( $width, $height );
	}

	public function resizeToWidth( $width ) {
		$ratio  = $width / self::getWidth();
		$height = self::getheight() * $ratio;
		self::resize( $width, $height );
	}

	public function scale( $scale ) {
		$width  = self::getWidth() * $scale / 100;
		$height = self::getheight() * $scale / 100;
		self::resize( $width, $height );
	}

	public static function resize( $width, $height ) {
		$new_image = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $new_image, self::$image, 0, 0, 0, 0, $width, $height, self::getWidth(), self::getHeight() );
		self::$image = $new_image;
	}

	public function getImage() {
		return self::$image;
	}
}

?>