<!DOCTYPE html>
<html>
<head>
    <base href='<?=Router::url('/');?>' />
	<?php echo $this->Html->charset(); ?>
	<title>		
		<?php echo $title_for_layout; ?> | DjStream
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('style');
        
        echo $this->Html->script('jquery-1.9.1.min');
        echo $this->Html->script('bootstrap.min');        
        echo $this->Html->script('soundmanager2-jsmin');              
        echo $this->Html->script('script');
    
    
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
        
        
        
	?>
    
    
    <script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
    
</head>
<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
        <div class='navbar-inner'>
            <div class='container'>
                <div class='row'>
                    <div class='span3'><a href='<?=Router::url('/');?>'><img src='img/logo.png' alt=''/></a></div>
                    <div class='span9'>
                        <div id='player'>
                            <div class='ctrls'>
                                <a href='' class='ctrl-play' id='play'></a>
                                <a href='' class='ctrl-prev' id='prev'></a>
                                <a href='' class='ctrl-next' id='next'></a>
                                                                
                            </div>
                            <div class='info'>
                                <div class='name-duration mb5'>
                                    <span class='title fl-l'>Трек не загружен</span>
                                    <span class='duration fl-r'> <span id='time-elapsed'>-:--</span> / <span id='time-total'>-:--</span> </span>
                                </div>
                                <div class='progress'>
                                    <div class="bar loading" id='load-progress'></div>
                                    <div class="bar" id='progress'></div>                            
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>                
        </div>        
    </div>    
    
     <div class='container main-wr'>
        <div id='header'>
            <div class='row'>
                <div class='span6'>
                    <ul class="nav nav-pills">
                      <li><? echo $this->Html->link('О проекте',array('controller'=>'pages','action'=>'display', 'about'));?></li>
                     <!-- <li><a href="#">Источники</a></li>
                      <li><a href="#">Жанры</a></li> -->
                    </ul>                
                </div>
                <div class='span6'>
                    <ul class="nav nav-pills pull-right">
                      <li><?=$this->Html->link('Избранное',array('controller'=>'tracks','action'=>'index','?'=>array('favorite'=>1) ));?></li>
                      <!--<li><a href="#">Профиль</a></li> -->
                      <li><? echo $this->Html->link('Выйти ('.AuthComponent::user('name').')',array('controller'=>'users','action'=>'logout'));?></li>
                    </ul>   
                </div>            
            </div>
        </div>
        
        <div id='content'>
            <div class='row'>
                <div class='span3' id='sidebar'>
                    <ul class="nav nav-list menu">
                        <li class="nav-header">Источники</li>
                        <? foreach ($sources as $source_id => $source) {?>
                        <li><?=$this->Html->link($source,array('controller'=>'tracks','action'=>'index','?'=>array('source_id[]'=>$source_id) ));?></li>
                        <?}?>
                        
                        <li class="nav-header">Жанры</li>
                         <? foreach ($genres as $genre_id => $genre) {?>
                        <li><?=$this->Html->link($genre,array('controller'=>'tracks','action'=>'index','?'=>array('genre_id[]'=>$genre_id) ));?></li>
                        <?}?>
                        
                    </ul>
                    
                   <!--  <div class="input-append">
                      <input class="span2" id="appendedInputButtons" type="text">
                      <button class="btn btn-warning" type="button">Search</button>                     
                    </div> -->
                    
                
                </div>
                
                
                
                
                <div class='span9' id='main'>
                    <h2><?=$title_for_layout;?></h2>                    
                    
                    <? echo $this->fetch('content'); ?>
                </div>
            
            </div>                    
        </div> <!--  #content -->    
    </div>
    
    <div id='footer'>
            <div class='container'>
                <div class='pull-left'>
                    <small> @ 2013</small>
                
                <!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=20676043&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/20676043/1_0_FFB920FF_FF9900FF_0_pageviews"
style="width:80px; height:15px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры)" onclick="try{Ya.Metrika.informer({i:this,id:20676043,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter20676043 = new Ya.Metrika({id:20676043,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/20676043" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
 
 
                
                </div>
                <div class='pull-right'><a href='http://petrmarochkin.ru/' target='_blank'>Petr Marochkin</a></div>        
            </div>
    </div>        
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
