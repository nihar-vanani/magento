<?php
class Nv_Process_Model_Process extends Mage_Core_Model_Abstract
{
	const TYPE_ID_IMPORT = "1";
	const TYPE_ID_EXPORT = "2";
	const TYPE_ID_CRON = "3";
    protected $headers = [];
    protected $data = [];

	public function _construct()
	{
		$this->_init('process/process');
	}

    public function uploadFile()
    {
        $fileName = $this->getFileName();
        $uploader = new Varien_File_Uploader('file_name');
    	$uploader->setAllowCreateFolders(true)
        ->setAllowRenameFiles(true)
        ->setAllowedExtensions(['CSV'])
        ->save($this->getFilePath(), $fileName);

        return $fileName;
    }

    public function getFilePath()
    {
        return Mage::getBaseDir('media'). DS .'process'. DS .'import';
    }

    public function readFile()
    {
        $filePathName = $this->getFilePath(). DS .$this->getFileName();
        $handler = fopen($filePathName,"r");
        $row = fgetcsv($handler);
        $headerFlag = false;
        while($row = fgetcsv($handler))
        {
        	if ($headerFlag == false) {
                $this->headers = $row;
                $headerFlag = true;
            }
            else
            {
                $this->data[] = array_combine($headers, $row);
            }
        }
    	echo $filePathName;
        echo "<pre>";
        print_r($this->$data);
        die();
    }

    public function verify()
    {
        $this->readFile();
        $this->verifyData();
    }
}