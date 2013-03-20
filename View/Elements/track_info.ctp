<? echo $this->Html->link($track['Source']['name'] , array('controller'=>'tracks','action'=>'index','?'=>array('source_id[]'=>$track['Source']['id'])));?>,    
        <? echo $this->Html->link($track['Genre']['name'] , array('controller'=>'tracks','action'=>'index','?'=>array('genre_id[]'=>$track['Genre']['id'])));?>,   
        <?=$this->Ru->date($track['Track']['created']);?>