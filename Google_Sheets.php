<?php

require DIR . '/vendor/autoload.php';

class GoogleSpreadSheet
{
    private $spreadsheetId;
    private $client;
    private $service;
    private $response;
    
    function construct($spreadsheetId)
    {
        $this->spreadsheetId = $spreadsheetId;
        $googleAccountKeyFilePath = __DIR . '/account.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);
        $this->client = new Google_Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->addScope('https://www.googleapis.com/auth/spreadsheets');
        $this->service = new Google_Service_Sheets($this->client);
        $this->response = $this->service->spreadsheets->get($spreadsheetId);
    }
    
     public function getSheets() #Get spreadsheet
    {
        $sheets = $this->response->getSheets();

        foreach ($sheets as $sheet) {
            $sheetProperties = $sheet->getProperties();
            $sheetsList[] = array($sheetProperties->title => $sheetProperties->sheetId);

        }
        return $sheetsList;
    }
    
      public function run()
    {
        // список листів
        $sheetsList = $this->getSheets();
      
    }
}
$googleSpreadSheet = new GoogleSpreadSheet('spreadsheetID');
$googleSpreadSheet->run();

