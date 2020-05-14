// mpd state and metadata
var interval = 3000;
var MPD = {
    json: 0
};
var STA = {
    json: 0
};


function formatSizeUnits(bytes){
  if      (bytes >= 1073741824) { bytes = (bytes / 1073741824).toFixed(2) + " gb"; }
  else if (bytes >= 1048576)    { bytes = (bytes / 1048576).toFixed(2) + " mb"; }
  else if (bytes >= 1024)       { bytes = (bytes / 1024).toFixed(2) + " kb"; }
  else if (bytes > 1)           { bytes = bytes + " bytes"; }
  else if (bytes == 1)          { bytes = bytes + " byte"; }
  else                          { bytes = "0 bytes"; }
  return bytes;
}

function formatBandwidthUnits(dataused){
  if      (dataused < 1000) { dataused = dataused + " mb"; }
  else if (dataused > 1000) { dataused = dataused + " gb"; }
  else if (dataused >= 10000)    { dataused = dataused + " tb"; }
  else                          { dataused = "bandwidth"; }
  return dataused;
}

function secondsToTime(secs) {
    secs = Math.round(secs);
    var hours = Math.floor(secs / (60 * 60));

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);

    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}

function lookupHeader(src) {    
$.ajax({
    type: 'GET',
    url: src,
    dataType: 'json',
    async: true,
    cache: false,
    success: function(data) {    


        alert(data.Location);


    },
complete: function (data) {

},
error: function(data) {

}
});
}



function engineMpd() {

$.ajax({
    type: 'GET',
    url: '/engine-mpd.php',
    async: true,
    cache: false,
    success: function(data) {

        //console.log('engineMpd: success branch: data=(' + data + ')');

        // always have valid json
        try {
            MPD.json = JSON.parse(data);
        }
        catch (e) {
            MPD.json['error'] = e;
        }

        if (typeof(MPD.json['error']) === 'undefined') {

            //var elapsedpc = (( MPD.json['elapsed'] / MPD.json['time'] ) * 100);
            var elapsedpc = MPD.json['song_percent'];

            if(elapsedpc > 90){
                interval = 500;
                elapsedpc = elapsedpc + 10;
            } else if (elapsedpc == 0) {


                // Radio (Perpeptual) ...
                if(MPD.json['artist'].indexOf('Radio') !== -1){
                    interval    = 5000;
                    $('.icon-radio').show();
                    $('.play-type').removeClass().addClass("play-type play-type-radio");

                    var seconds = MPD.json['elapsed'];
                    var hours   = MPD.json['elapsed'] / 3600;
                    var hourqtr = (Math.round(minutes/15) * 15) % 60;
                    var minutes = Math.floor(MPD.json['elapsed'] / 60);
                    var timeobj = secondsToTime(seconds);

                    // Beautify elapsed time for radio for hours long playback, which is different to listening to a song
                    if(minutes < 1) {
                        if(MPD.json['state'] == "stop"){
                            timetext = "Player Inactive";
                        } else {
                            timetext = "Welcome Back";
                        }
                    } else if(minutes < 2) {
                        timetext = minutes + " Minute";
                    } else if(minutes < 60)  {
                        timetext = minutes + " Minutes";
                    } else {
                        var disphours       = timeobj.h > 0 ? Math.floor(timeobj.h) + (timeobj.h < 2 ? " Hour " : " Hours ") : "";
                        var dispminutes     = timeobj.m > 0 ? Math.floor(timeobj.m) + (timeobj.m < 2 ? " Minute " : " Minutes ") : "";
                        if(timeobj.m < 1){
                            dispminutes = "Welcome Back";
                        }
                        timetext = disphours + dispminutes;
                    }
                    $('.elapsed').text(timetext);


                    // Do some cool stuff with estimating data usage of current playback listening based on bitrate
                    // Start displaying data usage after 100Mb.
                    if(MPD.json['bitrate'].indexOf('kbps') !== -1){
                        var datarate    = MPD.json['bitrate'].split("kbps");
                        var dataused    = Math.floor((datarate[0] / 8000) * MPD.json['elapsed']);
                        
                        $('.bandwidth').text(formatBandwidthUnits(dataused));
                        
                        $('.bitrate').text(MPD.json['bitrate']);
                    } else {
                        $('.bitrate').text("VBR");
                    }

                    // Do a nice trick on title change to bring progress bar to zero then back to 100
                    var last_title = $('.title').text();

                    if(last_title == MPD.json['title']){
                        elapsedpc   = 100;
                        $('.icon-radio .icon-label').text("RADIO");
                    } else {
                        elapsedpc   = 0;
                        $('.icon-radio .icon-label').text("RADIO TUNE");
                    }





                    //var station_name = lookupHeader('http://telstar1/command/remote/?dir=rx&mod=lookup&src=http://streams.fluxfm.de/event04/mp3-320/audio/play.m3');


                // Not Radio (Not Perpetual) ...   
                } else {
                    $('.icon-radio').hide();
                    $('.elapsed').text(MPD.json['elapsed']);
                }
            }


            var elapsed = elapsedpc + "%";




            $('#hidden').text(elapsedpc);
            $('.artist').text(MPD.json['artist']);
            $('.album').text(MPD.json['album']);

            $('.title').text(MPD.json['title']);





            $('.playbar-progress').css('width', elapsed);

        }
        // error of some sort
        else {



        }
    },
    complete: function (data) {
        // Schedule the next
        if(MPD.json['state'] != 'stop'){
            setTimeout(engineMpd, interval);    
        } else {
            setTimeout(engineMpd, 60000);
        }

    },
    // network connection interrupted or client network stack timeout
    error: function(data) {



    }
});
}  



//http://telstar1/command/remote/?dir=rx&mod=status   
function engineSys() {    
$.ajax({
    type: 'GET',
    url: '/command/remote/?dir=rx&mod=status',
    dataType: 'json',
    async: true,
    cache: false,
    success: function(pistatus) {    


        $('.sys_mem').text(pistatus.mem);
        $('.sys_temp').text(pistatus.temp);
        $('.sys_vol').text(pistatus.vol);
        $('.sys_wifi').text(pistatus.wirelessip);
        $('.sys_eth0').text(pistatus.wiredip);
        $('.sys_wifi-mac').text(pistatus.wirelessmac);
        $('.sys_eth0-mac').text(pistatus.wiredmac);

        if(pistatus.btctrl == "on" && pistatus.btpair == "on"){
            pistatus.bt = "on";
            $('.sys_bt').text(pistatus.bt);
        } else {
            pistatus.bt = "off";
            $('.sys_bt').text(pistatus.bt);
        }

        $('.sys_lcd').text(pistatus.lcd);
        $('.sys_lcdbr').text(pistatus.lcdbr);


        $('.sys_spotify').text(pistatus.spotify);
        $('.sys_airplay').text(pistatus.airplay);
        $('.sys_squeezelite').text(pistatus.squeezelite);
        $('.sys_upnp').text(pistatus.upnp);


    },
complete: function (pistatus) {
    setTimeout(engineSys, 60000);    
},
error: function(pistatus) {
     setTimeout(engineSys, 10000);   
}
});
}