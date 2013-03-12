<div class='row filter'>
                        
                        <?
                        
                        // пришлось добавтиь этот кусок, для правильного чека инпутов
                        
                        $source_selected = array();
                        if (isset($this->request->query['source_id']) && is_array($this->request->query['source_id'])) {
                            
                            $source_selected = array_map('intval', $this->request->query['source_id']);
                            
                        }
                        
                        $genre_selected = array();
                        if (isset($this->request->query['genre_id']) && is_array($this->request->query['genre_id'])) {
                            
                            $genre_selected = array_map('intval', $this->request->query['genre_id']);
                            
                        }
                        
                        
                        ?>
                        
                        
                        <?echo $this->Form->create('Track',array('type'=>'get'));?>
                            <fieldset>
                                <div class='span3'>
                                    <?
                                    
                                    echo $this->Form->input('source_id',array('multiple'=>'checkbox','label'=>'Источники','selected'=> $source_selected));
                                    
                                   
                                    ?>
                                     
                                    
                                </div>
                                <div class='span3'>
                                    <?
                                    echo $this->Form->input('genre_id',array('multiple'=>'checkbox','label'=>'Жанры','selected'=> $genre_selected));
                                    ?>                                     
                                </div>
                                <div class='span3'>
                                    <?
                                    $checked = isset($this->request->query['favorite']) && !empty($this->request->query['favorite']);                                    
                                    
                                    echo '<div class="checkbox">';
                                    echo $this->Form->checkbox('favorite',array('value'=>'1','hiddenField' => false,'checked'=>$checked));
                                    
                                    echo '<label for="TrackFavorite">Избранное</label>';
                                    
                                    echo '</div>';
                                    
                                    ?>
                                </div>    
                            </fieldset> 
                            <button class="btn btn-small pull-right btn btn-warning" type="submit">Фильтровать</button>             
                        </form>
                    </div>
                    
                    <div class='row results'>
                        <div class='span9'>
                            <h2>Результаты поиска</h2>
                            <p><small>Найдено треков: <?=$count;?></small></p>
                            
                            <div class='track-list'>
                                <ul class='unstyled scrollable'>
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