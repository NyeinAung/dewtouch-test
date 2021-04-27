<?php
class FileUploadController extends AppController {
	public function index() {

		if (!empty($this->data)) {
			if (is_file($this->data['FileUpload']['file']['tmp_name'])) {
				$filename = $this->data['FileUpload']['file']['tmp_name'];
				
				// open the file
				$handle = fopen($filename, "r");

				// read the 1st row as headings
 				$header = fgetcsv($handle);

				// read each data row in the file
				$i = 0;
				while (($row = fgetcsv($handle)) !== FALSE) {
					$i++;
					$data = array();
					// for each header field 
					foreach ($header as $k=>$head) {
						// get the data field from field
						$data['FileUpload'][$head]=(isset($row[$k])) ? $row[$k] : '';
					}

					$this->FileUpload->create();
					$this->FileUpload->save($data);
				}

				// close the file
				fclose($handle);
			}
		}
	
		$this->set('title', __('File Upload Answer'));

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
	}
}