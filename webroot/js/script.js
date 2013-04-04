jQuery(function ($) {
  
    
    soundManager.setup({
      url: 'swf/',   
      useHTML5Audio: false,
      flashVersion : 9,
      useHighPerformance: true
    });
    
    
    var gSound = 'ElectroHouseSound';

    // set volume to default or to cookie
    setVolume(getVolume());

    // add listener to plugin only for chrome browser
    var isChrome = /chrome/.test(navigator.userAgent.toLowerCase()); 
    if (isChrome) {
      console.log("Register event handler for plugin");
      window.addEventListener("message", function(event) {
          // We only accept messages from ourselves
          if (event.source != window)
            return;

          if (event.data.type && (event.data.type == "FROM_PAGE")) {

            if (event.data.text == "PLAY_NEXT") {
              playNext();  
              soundManager._writeDebug("PLAY_NEXT Received from plugin");
            }

          }
      }, false);
    }
    
    
    
    $(document).on("click", "a.play", function(){      
      var id = $(this).attr('rel');
      var state = $(this).data('state');
      
      if (state) {        
        soundManager.getSoundById(gSound).togglePause();
      } else {
        initPlayer(id);
      }
      
      return false;
    });
    
    
    $(document).on("click", "a.favorite", function(){
      var el = $(this);
      var id = $(this).attr('rel');
      setTrackStatus(id,'favorite',function(r){
        if (r) {
          el.addClass('already');
        } else {
          el.removeClass('already');
        }
      });
      return false;
    });
    
    /*$('a.favorite').click(function(){
      var el = $(this);
      var id = $(this).attr('rel');
      setTrackStatus(id,'favorite',function(r){
        if (r) {
          el.addClass('already');
        } else {
          el.removeClass('already');
        }
      });
      return false;
    });

    $('a.play').click(function(){      
      var id = $(this).attr('rel');
      var state = $(this).data('state');
      
      if (state) {        
        soundManager.getSoundById(gSound).togglePause();
      } else {
        initPlayer(id);
      }
      
      return false;
    }); */
    
    $('#next').click(function(){
      playNext();      
      return false;
    });
    
    $('#prev').click(function(){
      playPrev();
      return false;
    });


    
    
    
    
    /* buttons and positions top player */
    $('.progress.duration').click(function(e){
      var pos = Math.round(e.offsetX * 100 / $(this).width() );
      
      var s = soundManager.getSoundById(gSound);
      
      if (s) {
        
         var cduration = Math.round(s.duration * pos / 100);
         soundManager._writeDebug(s.setPosition(cduration));
         s.setPosition(cduration);
         soundManager._writeDebug(pos + 'duration: ' + s.duration + ' cduration '+ cduration);
      }
     
    });

    $('.progress.volume').click(function(e){

      var pos = Math.round(e.offsetX * 100 / $(this).width() );
      
      var s = soundManager.getSoundById(gSound);

      if (s) {
         setVolume(pos);
         soundManager.setVolume(gSound,getVolume());
         soundManager._writeDebug('Adjust volume to '+pos);
      }



    });
    
    $('#play').click(function(){
      var s = soundManager.getSoundById(gSound);
      if (s) {
        s.togglePause();
      }
      
      return false;      
    });
    
    
   function initPlayer(id) {
      var container = $('#track_'+id);
      
      // destroy Sound
      soundManager.destroySound(gSound);
      
      // reset all state
      $('#progress').css('width','0%');
      $('#load-progress').css('width','0%');
      $('a.play').children('i').attr('class','icon-play'); 
      $('a.play').data('state',null);
      $('.track-list li').removeClass('current');
      
      
      $(container).closest('li').addClass('current');
      var clink = $(container).children('a.play');
      var mp3 = $(clink).attr('href');
      
      
      var track_title = $(clink).siblings('.title').text();
      var track_href = $(clink).siblings('.title').attr('href');
      //$('#player .title').html('<a href="'+track_href+'">'+track_title+'</a>');
      // сделал только тексь
      $('#player .title').text(track_title);
      
      // статус + убираем стиль
      setTrackStatus(id,'listen',function(r){
        container.addClass('listened');
          soundManager._writeDebug(r);
      });
      
      
      
      soundManager.createSound({
         id: gSound, 
         url: mp3,                   
         autoPlay: true,
         isMovieStar:true,
         type: 'audio/mpeg',
         volume: getVolume(),

         //type: 'application/octet-stream',
         whileplaying: function() {
          //soundManager._writeDebug('sound '+this.id+' playing, '+this.position+' of '+this.duration);
          var pos = Math.round(this.position * 100 / this.duration);
          $('#progress').css('width',pos+'%');
          
          var time = getTime(this.position,true);
          $('#time-elapsed').text(time);
          
         },
         whileloading: function() {
          var pos = Math.round(this.bytesLoaded * 100 / this.bytesTotal);
          $('#load-progress').css('width',pos+'%');
         },
         onplay: function() {
                    
          // css for play buttons
           $('#play').addClass('paused');
           $(clink).children('i').attr('class','icon-pause');   
           $(clink).data('state','play');
         },
         
         onpause: function() {
           // css for play buttons
           $('#play').removeClass('paused');
           $(clink).children('i').attr('class','icon-play');
           $(clink).data('state','pause');
         },
         onresume: function() {
          // css for play buttons
           $('#play').addClass('paused');
           $(clink).children('i').attr('class','icon-pause');  
           $(clink).data('state','play');        
         },
         onload: function(success) {
          if (!success) {playNext();}
          
          var time = getTime(this.duration,true);
          $('#time-total').text(time);
          soundManager._writeDebug(this.duration+' load event////////////////');
          
         },        
         onfinish: function() {
          playNext();
         }
      }); 
     
   }
   
   
   function playNext() {      
      var c =  $('.track-list li.current').next().find('a.play').attr('rel');
      if (c)   {
        initPlayer(c);        
      }     
   }
   
   function playPrev() {
      var c =  $('.track-list li.current').prev().find('a.play').attr('rel');
      if (c) {
        initPlayer(c);
      }
   }
      
    
    
   function getTime(nMSec, bAsString) {
    // convert milliseconds to mm:ss, return as object literal or string
    var nSec = Math.floor(nMSec/1000),
        min = Math.floor(nSec/60),
        sec = nSec-(min*60);
    // if (min === 0 && sec === 0) return null; // return 0:00 as null
    return (bAsString?(min+':'+(sec<10?'0'+sec:sec)):{'min':min,'sec':sec});
  };
    
    
  function setTrackStatus(id,status,onsuccess)   {
    $.ajax({
      cache : false,
      method: 'post',
      url: 'tracks/set_status/'+id+'/'+status,
      dataType : 'json',      
      success: onsuccess
    });
  }

  function getVolume() {
    var val = 100;
    if ($.cookie('dj_volume') != undefined) {
      val  = parseInt($.cookie('dj_volume'));
    } else {
      $.cookie('dj_volume',100,{ expires: 30 });            
    }
    return val;
  }

  function setVolume(vol) {
    //var vol = getVolume();
    $('#volume').css('width', vol +  '%');
    $.cookie('dj_volume',vol,{ expires: 30 });            
  }


  // live ajax load tracks
   if ($('ul.scrollable').size()>0) {
      var alreadyPageLoad = false;

      
      function isScrollBottom() { 
        var documentHeight = $(document).height(); 
        var scrollPosition = $(window).height() + $(window).scrollTop(); 
        return (documentHeight == scrollPosition); 
      } 
      
      $(window).scroll(function(){ 
          //console.log('scroll');
        if (isScrollBottom()) {
          var last_track_id = $('ul.scrollable').children('li').last().find('a.play').attr('rel');
          

          var sdata =$('#TrackIndexForm').serialize() + '&from_track='+last_track_id;

          $.ajax({
              url: '/'
              ,data: sdata
              ,method: 'get'
              ,dataType : 'json'
              ,cache: false
              ,success: function(r) {                
                  $('ul.scrollable').append(r.html);                
              }
          });  

        }               
      });
      
      
      function loadOtherTracks(station_id,from) {
        $.post('ajax.php',{station_id:station_id,from:from,action:'load_tracks'},function(html){
          //console.log(html);
          
          $('ul.scrollable').append(html);
        });
      }
      
    }



    
    
    
});