<?
$css_listened = in_array($track['Track']['id'], $listened) ? 'listened' : NULL;
$css_favorite = in_array($track['Track']['id'], $favorites) ? 'already' : NULL;
?>

<li>
<div class='track <?=$css_listened;?>' id='track_<?=$track['Track']['id'];?>'>
    <a href='<?=$track['Track']['mp3'];?>' rel='<?=$track['Track']['id'];?>' class='play'><i class='icon-play'></i></a>
    
    <?
    
    echo $this->Html->link($track['Track']['artist'] . ' - '. $track['Track']['song'],
                           array('action'=>'view',$track['Track']['id']),array('class'=>'title')
                           );
                           
    
    
    ?>
    
    
    
    <? echo $this->Html->link("<i class='icon-star'></i>",array('controller'=>'user_favorites','action'=>'add',$track['Track']['id']),array('class'=>'favorite '.$css_favorite,'escape'=>false,'rel'=>$track['Track']['id'])); ?>
    
    <? echo $this->Html->link("<i class='icon-download'></i>",array('controller'=>'tracks','action'=>'download',$track['Track']['id']),array('class'=>'download','escape'=>false,'target'=>'_blank')); ?>
</div>
<div class='info'>
    <small>
        <? echo $this->element('track_info',array('track'=>$track)); ?>        
    </small>
</div>

</li>