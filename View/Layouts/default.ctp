<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>		
		<?php echo $title_for_layout; ?>
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
                      <li><a href="#">О кроекте</a></li>
                      <li><a href="#">Источники</a></li>
                      <li><a href="#">Жанры</a></li>
                    </ul>                
                </div>
                <div class='span6'>
                    <ul class="nav nav-pills pull-right">
                      <li><a href="#">Избранное</a></li>
                      <li><a href="#">Профиль</a></li>
                      <li><a href="#">Выйти</a></li>
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
                        <li><?=$this->Html->link($source,array('controller'=>'sources','action'=>'view',$source_id));?></li>
                        <?}?>
                        
                        <li class="nav-header">Жанры</li>
                         <? foreach ($genres as $genre_id => $genre) {?>
                        <li><?=$this->Html->link($genre,array('controller'=>'genres','action'=>'view',$genre_id));?></li>
                        <?}?>
                        
                    </ul>
                    
                   <!--  <div class="input-append">
                      <input class="span2" id="appendedInputButtons" type="text">
                      <button class="btn btn-warning" type="button">Search</button>                     
                    </div> -->
                    
                
                </div>
                
                <div class='span9' id='main'>
                    <h2>Треки</h2>                    
                    
                    
                    <div class='row filter'>
                        <?echo $this->Form->create('Track',array('type'=>'get'));?>
                            <fieldset>
                                <div class='span3'>
                                    <?
                                    
                                    echo $this->Form->input('source_id',array('multiple'=>'checkbox','label'=>'Источники','selected'=> $this->request->query['source_id']));
                                    
                                   
                                    ?>
                                     
                                    
                                </div>
                                <div class='span3'>
                                    <?
                                    echo $this->Form->input('genre_id',array('multiple'=>'checkbox','label'=>'Жанры','selected'=> $this->request->query['genre_id']));
                                    ?>                                     
                                </div>
                                <div class='span3'>
                                    <h4>Календарь</h4>
                                
                                </div>    
                            </fieldset> 
                            <button class="btn btn-small pull-right btn btn-warning" type="submit">Фильтровать</button>             
                        </form>
                    </div>
                    
                    <div class='row results'>
                        <div class='span9'>
                            <h2>Результаты поиска</h2>
                            <p><small>Найдено 202761 треков. Источники - <a href=''>clubkings.ua</a>, <a href=''>clubbers.pl</a>, направления <a href=''>house</a>, <a href=''>electrohouse</a></small></p>
                            
                            <div class='track-list'>
                                <ul class='unstyled'>
                                    <?
                                    
                                    if ($tracks) {
                                        foreach ($tracks as $track) {
                                            echo $this->element('track',array('track'=>$track));
                                        }
                                    }
                                    
                                    ?>                                
                                </ul>    
                            
                            
                            </div>
                            
                        </div>
                    
                    
                    </div>
                
                </div>
            
            </div>                    
        </div> <!--  #content -->    
    </div>
    
    <div id='footer'>
            <div class='container'>
                <div class='pull-left'>2013</div>
                <div class='pull-right'>Petr Marochkin</div>        
            </div>
    </div>        
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
