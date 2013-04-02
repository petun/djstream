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
        echo $this->Html->script('jquery.cookie');   
        echo $this->Html->script('modernizr.custom.27312');           
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
                                <div class='progress-wrap'>
                                    <div class='progress duration'>
                                        <div class="bar loading" id='load-progress'></div>
                                        <div class="bar" id='progress'></div>                            
                                    </div>
                                    <div class='volume progress'>
                                        <div class="bar" id='volume'></div>                                        
                                    </div>

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
                      <li><? echo $this->Html->link('Плагины',array('controller'=>'pages','action'=>'display', 'plugin'));?></li>
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
                
                    <? echo $this->element('ya_metrika'); ?>
 
 
                
                </div>
                <div class='pull-right'><a href='http://petrmarochkin.ru/' target='_blank'>Petr Marochkin</a></div>        
            </div>
    </div>        
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
