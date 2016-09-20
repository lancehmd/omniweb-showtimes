<?php

class Omniweb_Showtimes_FTP
{
    private function logMessage($message)
    {
        $this->messageArray[] = $message;
    }

    public function getMessages()
    {
        return $this->messageArray;
    }

    public function connect($server, $ftpUser, $ftpPassword, $isPassive = true)
    {
        $this->connection = ftp_connect($server);

        // Login with username and password
        $loginResult = ftp_login($this->connection, $ftpUser, $ftpPassword);

        // Sets passive mode on/off (default off)
        ftp_pasv($this->connection, $isPassive);

        // Check connection
        if ((!$this->connection) || (!$loginResult)) {
            $this->logMessage('Could not connect to FTP.');
            $this->logMessage("Attempt to connect to $ftpUser@$server has failed.");

            return false;
        } else {
            $this->logMessage("Successfully connected to $ftpUser@$server.");
            $this->loginOk = true;

            return true;
        }
    }

    public function cd($directory)
    {
        if (ftp_chdir($this->connection, $directory)) {
            $this->logMessage("Current directory is now: $directory.");

            return true;
        } else {
            $this->logMessage("Couldn\'t change directory");

            return false;
        }
    }

    public function ls($path = '.', $hiddenFiles = false)
    {
        if (is_array($children = @ftp_rawlist($this->connection, $path))) {
            $items = [];

            foreach ($children as $name => $child) {
                $chunks = preg_split('/\s+/', $child);

                // Convert each chunk into a named variable.
                list(
                    $item['rights'],
                    $item['number'],
                    $item['user'],
                    $item['group'],
                    $item['size'],
                    $item['month'],
                    $item['day'],
                    $item['time']
                ) = $chunks;

                $item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';

                array_splice($chunks, 0, 8);

                $pathName = implode(' ', $chunks);

                if ($pathName === '.' || $pathName === '..' && !$hiddenFiles) {
                    continue;
                }

                $items[$pathName] = $item;
            }

            return $items;
        }

        return false;
    }

    public function cp($fileFrom, $fileTo)
    {
        $asciiExts = ['txt', 'csv'];
        $fileArray = explode('.', $fileFrom);
        $fileExt   = end($fileArray);

        if (in_array($fileExt, $asciiExts)) {
            $transferMode = FTP_ASCII;
        } else {
            $transferMode = FTP_BINARY;
        }

        // Attempt to download the file.
        if (ftp_get($this->connection, $fileTo, $fileFrom, $transferMode, 0)) {
            $this->logMessage("File $fileTo successfully downloaded.");

            return true;
        } else {
            $this->logMessage("There was an error downloading file $fileFrom to $fileTo.");

            return false;
        }
    }

    public function __deconstruct()
    {
        if ($this->connection) {
            ftp_close($this->connection);
        }
    }
}
