<?
$css_listened = in_array($track['Track']['id'], $listened) ? 'listened' : NULL;
$css_favorite = in_array($track['Track']['id'], $favorites) ? 'already' : NULL;
?>

<li>
<div class='track <?=$css_listened;?>' id='track_<?=$track['Track']['id'];?>'>
    <a href='<?=$track['Track']['mp3'];?>' rel='<?=$track['Track']['id'];?>' class='play'><i class='icon-play'></i></a>
    <a href='' class='title'><?=$track['Track']['artist'];?> - <?=$track['Track']['song'];?></a>
    
    
    <? echo $this->Html->link("<i class='icon-star'></i>",array('controller'=>'user_favorites','action'=>'add',$track['Track']['id']),array('class'=>'favorite '.$css_favorite,'escape'=>false,'rel'=>$track['Track']['id'])); ?>
    
    <? echo $this->Html->link("<i class='icon-download'></i>",array('controller'=>'tracks','action'=>'download',$track['Track']['id']),array('class'=>'download','escape'=>false,'target'=>'_blank')); ?>
</div>
<div class='info'>
    <small>
        <? echo $this->Html->link($track['Source']['name'] , array('controller'=>'tracks','action'=>'index','?'=>array('source_id[]'=>$track['Source']['id'])));?>,    
        <? echo $this->Html->link($track['Genre']['name'] , array('controller'=>'tracks','action'=>'index','?'=>array('genre_id[]'=>$track['Genre']['id'])));?>,   
        <?=$this->Ru->date($track['Track']['created']);?>
    </small>
</div>

</li>