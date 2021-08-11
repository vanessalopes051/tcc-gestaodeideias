<?php

class IrPara {

	public static function link($param){
		header('location:'.BASE_URL.$param);
		die();
	}

}