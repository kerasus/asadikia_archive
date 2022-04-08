<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/vendor/autoload.php';

// mail:
// asadikia.programs@gmail.com

// Your Client ID
//564532714143-fsosffgahbts5qpvmju4iplctqdj9h16.apps.googleusercontent.com

// Your Client Secret
//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

// developerKey:
// AIzaSyDFCn0SKIgvaJkk6fEcVG40Wu6aKPvR2jQ

class GoogleDrive
{
    private $service = null;
    private $client = null;
    private $host = null;
    private $port = null;
    private $user = null;
    private $pass = null;
    private $ftpTimeout = null;

    /**
     * Constructor, initialize with service email and name of private key file.
     *
     * @param string $developerKey
     */
    public function __construct($developerKey = '')
    {
        $this->client = new Google\Client();
        $this->client->setApplicationName('asadikia_archive');
        $this->client->setDeveloperKey($developerKey);
        $this->service = new Google_Service_Drive($this->client);
    }

    public function setFtp ($host, $port, $user, $pass, $ftpTimeout = 30000) {
      $this->host = $host;
      $this->port = $port;
      $this->user = $user;
      $this->pass = $pass;
      $this->ftpTimeout = $ftpTimeout;
    }

    public function getFileInfo ($fileId) {
        try {
            $file = $this->service->files->get($fileId, array('supportsTeamDrives' => 'true'));
            $fileName = $file->getName();
            $fileMimeType = $file->getMimeType();

            return [
                'name'=> $fileName,
                'mime_type'=> $fileMimeType,
            ];
        } catch (Exception $e) {
            return [
                'error'=> true,
                'message'=> "An error occurred: " . $e->getMessage()
            ];
        }
    }

    public function saveFile ($fileId, $path ,$fileName) {
        try {
            $file = $this->service->files->get($fileId, array('alt'=>'media','supportsTeamDrives' => 'true'));

            $content = $file->getBody()->getContents();

            if (!is_dir($path)) {
                // dir doesn't exist, make it
                mkdir($path, 0777, true);
            }

            file_put_contents($path . '/' . $fileName, $content);

            return true;
        } catch (Exception $e) {
            return [
                'error'=> true,
                'message'=> "An error occurred: " . $e->getMessage()
            ];
        }
    }

    public function uploadToFtp ($dest_file, $source_file) {
      $ftp = ftp_connect($this->host, $this->port, $this->ftpTimeout);
      ftp_login($ftp, $this->user, $this->pass);

      $ret = ftp_nb_put($ftp, $dest_file, $source_file, FTP_BINARY, FTP_AUTORESUME);

      while (FTP_MOREDATA == $ret)
      {
        // display progress bar, or something
        $ret = ftp_nb_continue($ftp);
      }

      // all done :-)

    }

}
