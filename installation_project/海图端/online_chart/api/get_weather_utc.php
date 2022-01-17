<?PHP


class Weather {

    // Variables
    $_response = "";                          // Server response that will be send to client
    $_url = "http://www.openportguide.org";   // Url of the OSM dev server

    function getWeatherUtc($time) {
        // Send to the OSM-Api
        $fp = @fsockopen($_url, 80, $errno, $errstr);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            fputs($fp, "GET /api/0.6/node/" .$_node_id ." HTTP/1.1\r\n");
            fputs($fp, "Host: " .$_url ."\r\n");
            fputs($fp, "Authorization: Basic " .$login ."\r\n");
            fputs($fp, "Content-type:  text/xml; charset=utf-8\r\n");
            fputs($fp, "Connection: Keep-Alive\r\n\r\n");

            $header = "not yet";
            while (!feof($fp)) {
                $line = fgets($fp, 1024);
                if( $line == "\r\n" && $header == "not yet" ) {
                    $header = "passed";
                }
                if( $header == "passed" ) {
                    $_response .= $line;
                }
            }
        }
        fclose($fp);
        //$_response = $response;

        echo trim($_response);
    }
}

?>
