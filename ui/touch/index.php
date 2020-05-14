<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Moode Touch</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

    <script src="/js/jquery-1.8.2.min.js"></script>
    <script src="js/playerlib.js"></script>
    <style>
        .bar {
            background : black;
            height :2px;
            width: 0%;
            transition: width 3s;
            transition-timing-function: linear;
        }
        
        
    </style>
</head>

<body>

    <script>
        
        engineMpd();
        engineSys();    
      
        
    </script>
    
    <div class="icon-radio"><span class="icon-label">RADIO</span></div>
    
    <div class="play-type play-type-radio">
        <div class="bar"></div>
        <div class="meta">
            <ul>
                <li><span class="elapsed"></span> <span class="bandwidth"></span></li>
                <li><span class="title"></span></li>
                <li><span class="album"></span> - <span class="bitrate"></span></li>
            </ul>

            <h2>System:</h2>
            <ul>
                <li>RAM: <span class="sys_mem"></span></li>
                <li>CPU: <span class="sys_temp"></span></li>
                <li>VOL: <span class="sys_vol"></span></li>
                <li>LCD: <span class="sys_lcdbr"></span> ( <span class="sys_lcd"></span> )</li>
                <li>NET:<span class="sys_wifi"></span> <span class="sys_wifi-mac"></span></li>
                <li>ETH:<span class="sys_eth0"></span> <span class="sys_eth0-mac"></span></li>
                <li>BLT:<span class="sys_bt"></span></li>
                <li>SPT:<span class="sys_spotify"></span></li>
                <li>ARP:<span class="sys_airplay"></span></li>
                <li>SQZ:<span class="sys_squeezelite"></span></li>
                <li>PNP:<span class="sys_upnp"></span></li>

            </ul>
        </div>
    </div>
    
</body>
</html>