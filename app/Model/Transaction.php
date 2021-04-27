<?php
	class Transaction extends AppModel{
		public $hasMany = array('TransactionItem');
	}