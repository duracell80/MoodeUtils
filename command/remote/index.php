<?php 
/** MOODE REMOTE API
  *
  * Lee Jordan @duracell80
  * 05/01/2020

    

*/


header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Main Params
$dir        = $_GET["dir"];
$mod        = $_GET["mod"];
$cmd        = $_GET["cmd"];
$src        = $_GET["src"];
$ch         = $_GET["ch"];
$name       = $_GET["name"];


$apiPath        = "/var/www/command/remote";
$cmdPath        = "/var/www/command/";
$playlistPath   = "/var/lib/mpd/playlists";
$radioList      = $playlistPath . "/Radio_Play.m3u";

$db             = new SQLite3('/var/local/www/db/moode-sqlite3.db');






// FIGURE OUT SIGNAL DIRECTION
if(isset($dir) && !empty($dir)){
    
    
    switch ($dir) { 
        // TRANSMIT
        case "tx":
            
            switch ($mod) {      
            
            case "system":
                if(isset($cmd) && !empty($cmd)){
                    switch ($cmd) {
                        case "reboot":
                            echo(shell_exec("sudo reboot"));
                            break;

                         case "off":
                            //echo(shell_exec("sudo poweroff"));
                            break;

                        default:
                            break;
                    }
                }
            break;       
                
                
            case "display":
                if(isset($cmd) && !empty($cmd)){
                    switch ($cmd) {


                        // OFF
                        case "off":
                            $runcmd = shell_exec("xset -display :0 s activate");
                            break;
                        // ON   
                        case "on":
                            $runcmd = shell_exec("xset -display :0 s reset");
                            break;
                        // PEEK   
                        case "peek":
                            $runcmd = shell_exec("xset -display :0 s reset; sleep 10; xset -display :0 s activate");
                            break;

                        // BRIGHTNESS SET
                        case "night":
                            $runcmd = shell_exec("sudo chmod 777 /sys/class/backlight/rpi_backlight/brightness");
                            $runcmd = shell_exec("echo 16 > /sys/class/backlight/rpi_backlight/brightness");
                            break;
                        // BRIGHTNESS SET
                        case "day":
                            $runcmd = shell_exec("echo 255 > /sys/class/backlight/rpi_backlight/brightness");
                            break;


                        default:
                            break;
                    }
                }    

            case "mpc":
                if(isset($cmd) && !empty($cmd)){
                    switch ($cmd) {

                        // UPDATE DATABASE
                        case "update":
                            $runcmd = "mpc update";
                            echo(shell_exec($runcmd));
                            break;

                        // STATUS
                        case "status":
                            $runcmd = "mpc status";
                            echo(shell_exec($runcmd));
                            break;

                        // VOLUME + 5
                        case "volup":
                            $runcmd = "/var/www/vol.sh -up 5";
                            echo(shell_exec($runcmd));
                            break;

                        // VOLUME -5
                        case "voldown":
                            $runcmd = "/var/www/vol.sh -dn 5";
                            echo(shell_exec($runcmd));
                            break;

                        // VOLUME MUTE
                        case "mute":
                            $runcmd = "/var/www/vol.sh -mute";
                            echo(shell_exec($runcmd));
                            break;


                        // LIST Playlists
                        case "list":
                            $runcmd = "mpc lsplaylists";
                            $runrst = shell_exec($runcmd); 
                            echo($runrst);
                            break;

                        // CROP Playlist
                        case "crop":
                            $runcmd = "mpc crop";
                            $runrst = shell_exec($runcmd); 
                            echo($runrst);
                            break;

                        // CLEAR Playlist
                        case "clear":
                            $runcmd = "mpc clear";
                            $runrst = shell_exec($runcmd); 
                            echo($runrst);
                            break;    

                        // LOAD Playlist
                        case "load":
                            $runcmd = "mpc load " . $name;
                            $runrst = shell_exec($runcmd); 
                            echo($runrst);
                            break;

                        // LOAD and PLAY Playlist
                        case "playlist":
                            shell_exec("mpc clear");
                            $runcmd = "mpc load " . $name;
                            $runrst = shell_exec($runcmd);
                            shell_exec("mpc play");

                            echo($runrst);
                            break;

                        // SHUFFLE
                        case "shuffle":
                            $runcmd = "mpc shuffle";
                            echo(shell_exec($runcmd));
                            break;

                        // CONSUME
                        case "consume":
                            $runcmd = "mpc consume";
                            echo(shell_exec($runcmd));
                            break;


                        // STOP
                        case "stop":
                            $runcmd = "mpc stop";
                            echo(shell_exec($runcmd));
                            break;

                        // PLAY
                        case "play":
                            $runcmd = "mpc play";
                            echo(shell_exec($runcmd));
                            break;

                        // PAUSE
                        case "pause":
                            $runcmd = "mpc pause-if-playing";
                            echo(shell_exec($runcmd));
                            break;

                        // TOGGLE
                        case "pause":
                            $runcmd = "mpc toggle";
                            echo(shell_exec($runcmd));
                            break;    

                        // PREV
                        case "prev":
                            $runcmd = "mpc prev";
                            echo(shell_exec($runcmd));
                            break;

                        // NEXT
                        case "next":
                            $runcmd = "mpc next";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP FORWARD 15s
                        case "fwd15":
                            $runcmd = "mpc seek +15";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP FORWARD 30s
                        case "fwd30":
                            $runcmd = "mpc seek +30";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP FORWARD 60s
                        case "fwd60":
                            $runcmd = "mpc seek +60";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP FORWARD 5m
                        case "fwd5m":
                            $runcmd = "mpc seek +300";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP BACK 15s
                        case "bck15":
                            $runcmd = "mpc seek -15";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP BACK 30s
                        case "bck30":
                            $runcmd = "mpc seek -30";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP BACK 60s
                        case "bck60":
                            $runcmd = "mpc seek -60";
                            echo(shell_exec($runcmd));
                            break;

                        // SKIP BACK 5m
                        case "bck5m":
                            $runcmd = "mpc seek -300";
                            echo(shell_exec($runcmd));
                            break;




                        default:
                            break;
                    }
                }
                break;

            case "cast":

                // EXAMPLE http://moode/command/remote/?dir=tx&mod=cast&src=http://ice55.securenetsystems.net/DASH7
                $m3u_content  = "#EXTM3U\n";
                $m3u_content .= "#EXTINF:-1,Cast To Moode Audio\n";
                $m3u_content .= $src;

                shell_exec("sudo touch /var/lib/mpd/playlists/Radio_Play.m3u");
                shell_exec("sudo chmod 777 /var/lib/mpd/playlists/Radio_Play.m3u");
                file_put_contents($radioList, $m3u_content); 

                $runcmd = "mpc clear; mpc load Radio_Play"; shell_exec($runcmd);
                $runcmd = "mpc play";
                echo(shell_exec($runcmd));

                sleep(2);
                break;        

            case "radio":
                // EXAMPLE http://moode/command/remote/?dir=tx&mod=radio&ch=1
                if(!$ch || $ch == ""){
                    $ch = 1;
                }

                $m3u_content    = "#EXTM3U\n";
                $stationfound   = 0;
                $results        = $db->query('SELECT station,name FROM cfg_radio WHERE id =' . $ch);

                while ($row = $results->fetchArray()) {

                    $m3u_content .= "#EXTINF:-1," . $row['name'] . "\n";
                    $m3u_content .= $row['station'];
                    $stationfound = 1;
                }



                if($stationfound == 1){
                    shell_exec("sudo touch /var/lib/mpd/playlists/Radio_Play.m3u");
                    shell_exec("sudo chmod 777 /var/lib/mpd/playlists/Radio_Play.m3u");
                    file_put_contents($radioList, $m3u_content); 

                    $runcmd = "mpc clear; mpc load Radio_Play"; shell_exec($runcmd);
                    $runcmd = "mpc play";
                    echo(shell_exec($runcmd));
                    //header("Location: /");    
                } else {
                    echo("Error: Station ID Not Found");
                }

                break;        


            exit();
            default:
                break;
            } // END TRANSMISSION
            exit();

        // RECEIVE
        case "rx":
            
            switch ($mod) {      
            
            
            case "status":
                if(!$cmd || $cmd == ""){$cmd = "device";}
                
                    
                $sysinfo = explode("\n", shell_exec("sudo " . $cmdPath . "sysinfo.sh | awk '/\t/'"));
                foreach ($sysinfo as $a) {
                    $b = explode("=", $a);
                    $device[strtolower(trim($b[0]))]=strtolower($b[1]);
                }    
                    
                if(isset($cmd) && !empty($cmd)){
                    //header("Content-Type: application/json");
                    
                    switch ($cmd) {
                        case "temp":
                           $json_out = '
                            {"status": {
                              "temp": "'.$device["soc temperature"].'"
                            }}';
                            echo($json_out);
                        break;
                        
                        case "mem":
                           $json_out = '
                            {"status": {
                              "mem": "'.$device["memory free"].'"
                            }}';
                            echo($json_out);
                        break;
                            
                        case "vol":
                           $json_out = '
                            {"status": {
                              "vol": "'.$device["volume knob"].'"
                            }}';
                            echo($json_out);
                        break;
                        
                        case "net":
                           $json_out = '
                            {"status": {
                              "wifi": "'.$device["wlan address"].'",
                              "eth0": "'.$device["ethernet address"].'",
                              "btctrl": "'.$device["bluetooth controller"].'",
                              "btpair": "'.$device["pairing agent"].'"
                            }}';
                            echo($json_out);
                        break;
                            
                        case "services":
                           $json_out = '
                            {"status": {
                              "spotify": "'.$device["spotify receiver"].'",
                              "airplay": "'.$device["airplay receiver"].'",
                              "squeezelite": "'.$device["squeezelite"].'",
                              "upnp": "'.$device["upnp client"].'"
                            }}';
                            echo($json_out);
                        break;
                            
                        case "display":
                           $json_out = '
                            {"status": {
                              "localui": "'.$device["local ui display"].'",
                              "brightness": "'.$device["brightness"].'"
                            }}';
                            echo($json_out);
                        break;
                            
                        default:
                            
                            $json_out = '
                            {"status": {
                              "mem": "'.$device["memory free"].'",
                              "temp": "'.$device["soc temperature"].'",
                              "vol": "'.$device["volume knob"].'",
                              "wifi": "'.$device["wlan address"].'",
                              "eth0": "'.$device["ethernet address"].'",
                              "btctrl": "'.$device["bluetooth controller"].'",
                              "btpair": "'.$device["pairing agent"].'",
                              "spotify": "'.$device["spotify receiver"].'",
                              "airplay": "'.$device["airplay receiver"].'",
                              "squeezelite": "'.$device["squeezelite"].'",
                              "upnp": "'.$device["upnp client"].'"
                            }}';
                            
                            echo($json_out);
                            
                        
                            
                        break;
                    }
                }
            break;          
                    
                    
                    
            case "system":
                if(isset($cmd) && !empty($cmd)){
                    switch ($cmd) {
                        case "temp":
                            echo(shell_exec("sudo usermod -G video www-data"));
                            echo(shell_exec("sudo /opt/vc/bin/vcgencmd measure_temp"));
                            break;
                        case "players":
                            require_once('../../inc/playerlib.php');

                            $array = sdbquery("SELECT value FROM cfg_system WHERE param='hostname'", cfgdb_connect());
                            $thishost = strtolower($array[0]['value']);

                            $result = shell_exec("avahi-browse -a -t -r -p | awk -F '[;.]' '/IPv4/ && /moOde/ && /audio/ && /player/ && /=/ {print $7\",\"$9\".\"$10\".\"$11\".\"$12}' | sort");
                            $line = strtok($result, "\n");
                            $players = '{"players": [';
                            $c = 0;
                            echo(sizeof($line));
                            
                            while ($line) {
                                list($host, $ipaddr) = explode(",", $line);
                                if (strtolower($host) != $thishost) {
                                    if($c < 1 ){
                                        $players .= sprintf('{"ipaddr": "http://%s", "host": "%s" } ', $ipaddr, $host);
                                    } else {
                                        $players .= sprintf('{"ipaddr": "http://%s", "host": "%s" }, ', $ipaddr, $host);
                                    }
                                }
                                $c++;
                                $line = strtok("\n");
                            }
                            $players .= "]}";
                            echo($players);
                            
                            break;
                        default:
                            break;
                    }
                }
            break;           
                    
                
            case "mpc":
                if(isset($cmd) && !empty($cmd)){
                    switch ($cmd) {
                        
                            
                        // LOAD and return the contents of a playlist as a download
                        case "playlist":
                            
                            $playlistFile = $playlistPath . "/" . $name . ".m3u";
                            $playlistName = $name . ".m3u";
        
                            if (file_exists($playlistFile)) {
                                header("Content-type: text/plain");
                                header("Content-Disposition: attachment; filename=".$playlistName);
                                echo(file_get_contents($playlistFile));
                            } else {
                                header("HTTP/1.0 404 Not Found");
                            }
                            break;

                        default:
                            break;
                    }
                }    
            break;
                    
                    
                    
            case "radio":
                    
                
                // RETURN a radio station via channel number to the browser as a playable stream   
                
                if(!$ch || $ch == ""){$ch = 1;}  
                if(!$cmd || $cmd == ""){$cmd = "listen";}  
                    
                $m3u_content    = "#EXTM3U\n";
                $stationfound   = 0;
                $results        = $db->query('SELECT station,name FROM cfg_radio WHERE id =' . $ch);
                

                while ($row = $results->fetchArray()) {
                    $m3u_content .= "#EXTINF:-1," . $row['name'] . "\n";
                    $m3u_content .= $row['station'];
                    $stationfound = 1;
                    $playlistName = $row['name'] . ".m3u";
                    $playfileURL  = $row['station'];
                    
                    // GET THE HEADERS
                    print_r(get_headers($playfileURL, 1));
                    $stationHeaders = get_headers($playfileURL, 1);
                    
                    
                    if (in_array("audio/mpeg", $stationHeaders)) {
                        $playfileName = $row['name'] . ".mp3";
                        $playfileType = "audio/mpeg";
                    }
                    
                    if (in_array("audio/aac", $stationHeaders)) {
                        $playfileName = $row['name'] . ".aac";
                        $playfileType = "audio/aac";
                    }
                    
                    if (in_array("audio/flac", $stationHeaders)) {
                        $playfileName = $row['name'] . ".flac";
                        $playfileType = "audio/flac";
                    }
                    
                    if (in_array("audio/vorbis", $stationHeaders)) {
                        $playfileName = $row['name'] . ".ogg";
                        $playfileType = "audio/vorbis";
                    }
                    
                    if (in_array("audio/ogg", $stationHeaders)) {
                        $playfileName = $row['name'] . ".ogg";
                        $playfileType = "audio/ogg";
                    }
            
                    
                    
                }
                    
    
                if($stationfound == 1){    
                    
                    if(isset($cmd) && !empty($cmd)){
                        
                        
                        switch ($cmd) {
                            case "download":
                                header("Content-type: text/plain");
                                header("Content-Disposition: attachment; filename=". $playlistName);
                                echo($m3u_content);  
                                break;

                            default:
                                // STREAM THE RADIO (So Simple it's brilliant)
                                header("Content-Type: " . $playfileType);
                                header("Location: ". $playfileURL,TRUE,302);
                                break;
                        }
                    }
                    
                    
                
                   
                } else {
                    header("HTTP/1.0 404 Not Found");
                }
                    
                

                break;          







        exit();
        default:
            break;
        } // END RECEPTION

    default:
        break;                
    } // END SIGNAL CASE        
            
            
} // END DIRECTION CHECK
exit();
?>