<?php
	App::import('Helper', 'Number'); 

	App::import('Vendor', 'PHPExcel', array('file' => 'PHPExcel/Classes/PHPExcel.php'));
	class MigrationController extends AppController{
		public $uses = array(
			'Member',
			'Transaction',
			'TransactionItem',
		);

		public function q1(){
			
			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}
		
		public function q1_instruction(){

			$this->setFlash('Question: Migration of data to multiple DB table');
				
			
			
// 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
		}

		public function q1_answer() {
			$inputFileName = 'files/migration_sample_1.xlsx';

			if ($inputFileName!='') {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
				$objReader = PHPExcel_IOFactory::createReader($inputFileType); 
				$objReader->setReadDataOnly(true);
				$objPHPExcel = $objReader->load($inputFileName);   
				$objWorksheet = $objPHPExcel->setActiveSheetIndex(0); 
				$highestRow = $objWorksheet->getHighestRow(); 

				for ($row = 2; $row <= $highestRow; ++$row) {
					/*
					0 => date
					1 => ref no.
					2 => member name
					3 => member no.
					4 => member pay type
					5 => member company
					6 => payment by
					7 => batch no
					8 => receipt no
					9 => cheque no
					10 => payment description
					11 => renewal year
					12 => subtotal
					13 => totaltax 
					14 => total
					*/

					$member_no = explode(" ", $objWorksheet->getCellByColumnAndRow(3, $row)->getValue());
					$memberdata['Member'] = array(
						'type' => $member_no[0],
						'no' => $member_no[1],
						'name' => $objWorksheet->getCellByColumnAndRow(2, $row)->getValue(),
						'company' => $objWorksheet->getCellByColumnAndRow(5, $row)->getValue(),
					);

					$this->Member->create();
					$this->Member->save($memberdata);

					$member_id = $this->Member->id;

					$dateraw = PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(0, $row)->getValue()); //unix date
					$date = date('Y-m-d', $dateraw);
					$month = date('m', $dateraw);
					$transactiondata["Transaction"] = array(
						'member_id' => $member_id,
						'member_name' => $objWorksheet->getCellByColumnAndRow(2, $row)->getValue(),
						'member_paytype' => $objWorksheet->getCellByColumnAndRow(4, $row)->getValue(),
						'date' => $date,
						'year' => $objWorksheet->getCellByColumnAndRow(11, $row)->getValue(),
						'month' => $month,
						'ref_no' => $objWorksheet->getCellByColumnAndRow(1, $row)->getValue(),
						'receipt_no' => $objWorksheet->getCellByColumnAndRow(8, $row)->getValue(),
						'payment_method' => $objWorksheet->getCellByColumnAndRow(10, $row)->getValue(),
						'batch_no' => $objWorksheet->getCellByColumnAndRow(7, $row)->getValue(),
						'cheque_no' => $objWorksheet->getCellByColumnAndRow(9, $row)->getValue(),
						'payment_type' => $objWorksheet->getCellByColumnAndRow(6, $row)->getValue(),
						'renewal_year' => $objWorksheet->getCellByColumnAndRow(11, $row)->getValue(),
						'subtotal' => $objWorksheet->getCellByColumnAndRow(12, $row)->getValue(),
						'tax' => $objWorksheet->getCellByColumnAndRow(13, $row)->getValue(),
						'total' => $objWorksheet->getCellByColumnAndRow(14, $row)->getValue()
					);
					
					$this->Transaction->create();
					$this->Transaction->save($transactiondata);

					$transaction_id = $this->Transaction->id;
					$description = "Being Payment for : \n".$objWorksheet->getCellByColumnAndRow(10, $row)->getValue()." : ".$objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
					$trans_detaildata["TransactionItem"] = array(
						'transaction_id' => $transaction_id,
						'description' => $description,
						'quantity' => 1,
						'unit_price' => $objWorksheet->getCellByColumnAndRow(12, $row)->getValue(),
						'sum' => $objWorksheet->getCellByColumnAndRow(12, $row)->getValue(),
						'table' => "Member",
						'table_id' => $member_id
					);

					$this->TransactionItem->create();
					$this->TransactionItem->save($trans_detaildata);
				} 
			}

			// $memberdata['Member'] = array(
			// 	'type' => 'FEL',
			// 	'no' => '16045',
			// 	'name' => 'Member Name 1',
			// 	'company' => '',
			// );

			// $this->Member->create();
			// $this->Member->save($memberdata);

			$this->setFlash('Success: Successfully Migrated Data!');
		}
		
	}