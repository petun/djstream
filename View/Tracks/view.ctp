<p><small>
<? echo $this->element('track_info'); ?>        
</small>	
</p>

<div class='zippy'>
<?
echo $this->Zippy->embed($track['Track']['mp3']);
?>
</div>