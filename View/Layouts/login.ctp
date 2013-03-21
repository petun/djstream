<!DOCTYPE html>
<html>
<head>
    <base href='<?=Router::url('/');?>' />
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
    
    
    <script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
    
</head>
<body class='login'>	
	<div id='login'>    
        <? echo $this->fetch('content'); ?>
        
        <p>
            <? echo $this->element('ya_metrika'); ?>
        </p>
    </div>
    
    
    
</body>
</html>
