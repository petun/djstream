<li>
<div class='track' id='track_<?=$track['Track']['id'];?>'>
    <a href='<?=$track['Track']['mp3'];?>' rel='<?=$track['Track']['id'];?>' class='play'><i class='icon-play'></i></a>
    <a href='' class='title'><?=$track['Track']['artist'];?> - <?=$track['Track']['song'];?></a>
    
    
    <? echo $this->Html->link("<i class='icon-star'></i>",array('controller'=>'user_favorites','action'=>'add',$track['Track']['id']),array('class'=>'favorite','escape'=>false)); ?>
    
    <? echo $this->Html->link("<i class='icon-download'></i>",array('controller'=>'track_downloads','action'=>'download',$track['Track']['id']),array('class'=>'download','escape'=>false)); ?>
</div>
<div class='info'>
    <small><?=$track['Track']['created'];?></small>
</div>

</li>