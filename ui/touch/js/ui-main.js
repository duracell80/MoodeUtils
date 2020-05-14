$( document ).ready(function() {
        
    currentTime("ui-lcd-clock");


    $( ".playbar .icon-more" ).click(function() {
        $( ".playbar .playbar-more" ).show();
        $( ".playbar .playbar-meta" ).hide();
        $( ".playbar .playbar-controls" ).hide();
    });

    $( ".playbar .icon-meta" ).click(function() {
        $( ".playbar .playbar-more" ).hide();
        $( ".playbar .playbar-meta" ).show();
        $( ".playbar .playbar-controls" ).hide();
    });

    $( ".playbar .icon-close" ).click(function() {
        $( ".playbar .playbar-more" ).hide();
        $( ".playbar .playbar-meta" ).hide();
        $( ".playbar .playbar-controls" ).show();
    });
    

    
    // Check play status for the correct icon upon refresh
    $.ajax({
        type: 'GET',
        url: '/command/remote/?dir=tx&mod=mpc&cmd=status',
        dataType: 'json',
        async: true,
        cache: false,
        success: function(mpd) {    


            if(mpd.status == "playing"){
                $( ".playbar .act-toggle" ).text("pause_circle_filled");
            } else {
                $( ".playbar .act-toggle" ).text("play_circle_filled");
            }
        }
    });
    
    
    
    
    // Station unknown request lookup upon tapping station field ...
    $( ".play-type-radio .album" ).click(function() {
        $.ajax({
            type: 'GET',
            url: '/command/remote/?dir=rx&mod=stationstream',
            dataType: 'json',
            async: true,
            cache: false,
            success: function(radio) {    
                $('.album').text(radio.streamfile);
            }
        });
    });


    // Total session data used upon tapping station field ...
    $( ".play-type-radio .elapsed" ).click(function() {
        $.ajax({
            type: 'GET',
            url: '/command/remote/?dir=rx&mod=status&cmd=datausage',
            dataType: 'json',
            async: true,
            cache: false,
            success: function(usage) {    
                $('.elapsed').text(usage.dataformat + " in total");
            }
        });
    });
    
    
    
    // Playback and volume ...
    $( ".playbar .act-toggle" ).click(function() {
        $.ajax({
            type: 'GET',
            url: '/command/remote/?dir=tx&mod=mpc&cmd=toggle',
            dataType: 'json',
            async: true,
            cache: false,
            success: function(mpd) {    
                
                
                if(mpd.status == "playing"){
                    $( ".playbar .act-toggle" ).text("pause_circle_filled");
                } else {
                    $( ".playbar .act-toggle" ).text("play_circle_filled");
                }
            }
        });
       
    });
    
    
    $( ".playbar .act-next" ).click(function() {
        $.get( "/command/remote/?dir=tx&mod=mpc&cmd=next", function( data ) {
            
        });
       
    });
    
    $( ".playbar .act-prev" ).click(function() {
        $.get( "/command/remote/?dir=tx&mod=mpc&cmd=prev", function( data ) {
            
        });
       
    });
    
    $( ".playbar .act-fwd" ).click(function() {
        $.get( "/command/remote/?dir=tx&mod=mpc&cmd=fwd30", function( data ) {
            
        });
       
    });
    
    $( ".playbar .act-bck" ).click(function() {
        $.get( "/command/remote/?dir=tx&mod=mpc&cmd=bck30", function( data ) {
            
        });
       
    });
    
    $( ".playbar .act-mute" ).click(function() {
        $.get( "/command/remote/?dir=tx&mod=mpc&cmd=mute", function( data ) {
            
        });
       
    });
    
    
});