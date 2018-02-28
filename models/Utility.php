<?php

	namespace app\models;

	@define( CODE_WORD, "K7CqjirjCV" );
	@define( "FACTOR", "K7CqjirjCV" );
	@define( KEY_XOR, "S2gcfC5ed" );

	class Utility {

        //Получить описание декодировонное
        public static function preText($str){
            return htmlspecialchars_decode(str_replace(['\n', '\r', "\\"], "", $str));
        }

        // Альтернатива mysql_real_escape_string()
        public static function mysqlEscapeString($data) {
            $data = str_replace("\\", "\\\\", $data);
            $data = str_replace("'", "\\'", $data);
            $data = str_replace('"', '\\"', $data);
            $data = str_replace("\x00", "\\x00", $data);
            $data = str_replace("\x1a", "\\x1a", $data);
            $data = str_replace("\r", "\\r", $data);
            $data = str_replace("\n", "\\n", $data);
            return($data);
        }

        public static function clearString($string){
            $string = strip_tags($string);
            $string = htmlspecialchars($string);
            return self::mysqlEscapeString($string);
        }

		public static function getGUID() {
			if ( function_exists( 'com_create_guid' ) ) {
				return com_create_guid();
			} else {
				mt_srand( (double) microtime() * 10000 ); //optional for php 4.2.0 and up.
				$charid = strtoupper( md5( uniqid( rand(), true ) ) );
				$hyphen = chr( 45 ); // "-"
				$uuid   = substr( $charid, 0, 8 ) . $hyphen . substr( $charid, 8, 4 ) . $hyphen . substr( $charid, 12, 4 ) . $hyphen . substr( $charid, 16, 4 ) . $hyphen . substr( $charid, 20, 12 );
				return $uuid;
			}
		}

		public static function encodePassword( $source, $key = CODE_WORD ) {
			//return md5($passwd);
			$result = '';
			if ( $source == '' ) {
				$result = '';
			} else {
				$s = "";
				// Открывает модуль
				$td      = mcrypt_module_open( 'des', '', 'ecb', '' );
				$key     = substr( $key, 0, mcrypt_enc_get_key_size( $td ) );
				$iv_size = mcrypt_enc_get_iv_size( $td );
				$iv      = mcrypt_create_iv( $iv_size, MCRYPT_RAND );
				// Инициализирует дескриптор шифрования и шифруем
				if ( mcrypt_generic_init( $td, $key, $iv ) != - 1 ) {
					$s = mcrypt_generic( $td, $source );
					mcrypt_generic_deinit( $td );
					mcrypt_module_close( $td );
				}
				$result = base64_encode( $s );
			}

			return $result;
		}

		public static function decodePassword( $source, $key = CODE_WORD )
        {
            $s = "";
            $source = base64_decode($source);
            //var_dump($source);
            // Открывает модуль
            $td = mcrypt_module_open('des', '', 'ecb', '');
            $key = substr($key, 0, mcrypt_enc_get_key_size($td));
            $iv_size = mcrypt_enc_get_iv_size($td);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            // Инициализирует дескриптор шифрования и дешифруем
            if (mcrypt_generic_init($td, $key, $iv) != -1) {
                $s = mdecrypt_generic($td, $source);
                mcrypt_generic_deinit($td);
                mcrypt_module_close($td);
            }

            return trim($s);
        }

		public static function generateRndString( $length = 8, $referal = false ) {
			if ( $referal ) {
				$chars = 'abdef123456789';
			} else {
				$chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
			}
			$numChars = strlen( $chars );
			$string   = '';
			for ( $i = 0; $i < $length; $i ++ ) {
				$string .= substr( $chars, rand( 1, $numChars ) - 1, 1 );
			}

			return $string;
		}

		public static function setPrice($val){
            $symbol_currency = isset( $val['cur_symbol'] ) ? $val['cur_symbol'] : '';
            $price = isset( $val['price'] ) ? $val['price'] : 0;
            echo ($price > 0) ? $symbol_currency . $price : "";
            echo ($val['is_contract_price']) ?
                (
                    ($price > 0) ?
                        "<span class='is-contract-price'> (Договорная цена)</span>" :
                        "<span class='is-contract-price'>Договорная цена</span>"
                ) : "";

        }

		public static function xorEncrypt( $InputString, $KeyString = KEY_XOR ) {
			$KeyStringLength   = mb_strlen( $KeyString );
			$InputStringLength = mb_strlen( $InputString );
			for ( $i = 0; $i < $InputStringLength; $i ++ ) {
				// Если входная строка длиннее строки-ключа
				$rPos = $i % $KeyStringLength;
				// Побитовый XOR ASCII-кодов символов
				$r = ord( $InputString[ $i ] ) ^ ord( $KeyString[ $rPos ] );
				// Записываем результат - символ, соответствующий полученному ASCII-коду
				$InputString[ $i ] = chr( $r );
			}

			return $InputString;
		}

		/**
		 * Вспомогательная функция для шифрования в строку, удобную для использования в ссылках
		 *
		 * @param string $InputString
		 *
		 * @return string
		 */
		public static function encrypt( $InputString ) {
			$str = self::xorEncrypt( $InputString, KEY_XOR );
			$str = self::base64EncodeUrl( $str );

			return $str;
		}

		/**
		 * Вспомогательная функция для дешифрования из строки, удобной для использования в ссылках (парный к @link self::encrypt())
		 *
		 * @param string $InputString
		 *
		 * @return string
		 */
		public static function decrypt( $InputString ) {
			$str = self::base64DecodeUrl( $InputString );
			$str = self::xorEncrypt( $str, KEY_XOR );

			return $str;
		}

		/**
		 * Кодирование в base64 с заменой url-несовместимых символов
		 *
		 * @param string $Str
		 *
		 * @return string
		 */
		public static function base64EncodeUrl( $Str ) {
			return strtr( base64_encode( $Str ), '+/=', '-_,' );
		}

		/**
		 * Декодирование из base64 с заменой url-несовместимых символов (парный к @link self::base64EncodeUrl())
		 *
		 * @param string $Str
		 *
		 * @return string
		 */
		public static function base64DecodeUrl( $Str ) {
			return base64_decode( strtr( $Str, '-_,', '+/=' ) );
		}

		public static function getData( $url = false, $user = false, $password = false ) {

			$ch = curl_init();
			if ( $ch === false ) {
				throw new Exception( 'Can\'t initialize curl session' );
			}
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 15 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 90 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_USERPWD, $user . ":" . $password );

			$res      = curl_exec( $ch );
			$err_curl = curl_error( $ch );
			curl_close( $ch );

			return array( 'res' => $res, 'err' => $err_curl );
		}

		public static function postData( $url = false, $post_string = false, $user = false, $password = false ) {
			$ch = curl_init();
			if ( $ch === false ) {
				throw new Exception( 'Can\'t initialize curl session' );
			}

			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 15 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 90 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_string );
                        curl_setopt($ch,CURLOPT_USERAGENT,'REST API Client v.1.1');
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/x-www-form-urlencoded',
					'Content-Length: ' . strlen( $post_string )
				)
			);
			curl_setopt( $ch, CURLOPT_USERPWD, $user . ":" . $password );
			$res      = curl_exec( $ch );
			$err_curl = curl_error( $ch );
			curl_close( $ch );

			return array( 'res' => $res, 'err' => $err_curl );
		}

        public static function translit( $s ) {
            $s = (string) $s; // преобразуем в строковое значение
            $s = strip_tags( $s ); // убираем HTML-теги
            $s = str_replace( array( "\n", "\r" ), " ", $s ); // убираем перевод каретки
            $s = preg_replace( "/\s+/", ' ', $s ); // удаляем повторяющие пробелы
            $s = trim( $s ); // убираем пробелы в начале и конце строки
            $s = function_exists( 'mb_strtolower' ) ? mb_strtolower( $s ) : strtolower( $s ); // переводим строку в нижний регистр (иногда надо задать локаль)
            $s = strtr( $s, array(
                'а' => 'a',
                'б' => 'b',
                'в' => 'v',
                'г' => 'g',
                'д' => 'd',
                'е' => 'e',
                'ё' => 'e',
                'ж' => 'j',
                'з' => 'z',
                'и' => 'i',
                'й' => 'y',
                'к' => 'k',
                'л' => 'l',
                'м' => 'm',
                'н' => 'n',
                'о' => 'o',
                'п' => 'p',
                'р' => 'r',
                'с' => 's',
                'т' => 't',
                'у' => 'u',
                'ф' => 'f',
                'х' => 'h',
                'ц' => 'c',
                'ч' => 'ch',
                'ш' => 'sh',
                'щ' => 'shch',
                'ы' => 'y',
                'э' => 'e',
                'ю' => 'yu',
                'я' => 'ya',
                'ъ' => '',
                'ь' => ''
            ) );
            $s = preg_replace( "/[^0-9a-z-_ ]/i", "", $s ); // очищаем строку от недопустимых символов
            $s = str_replace( " ", "-", $s ); // заменяем пробелы знаком минус

            return $s; // возвращаем результат
        }

	}
