<?php
	class Member extends AppModel{
		public $hasMany = array('Transaction');
	}