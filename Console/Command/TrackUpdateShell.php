<?



/*App::uses('Shell', 'Console');
App::uses('ComponentCollection', 'Controller');
App::uses('VkPublicationsController', 'Controller');
App::uses('VkPublishComponent', 'Controller/Component');*/

///App::import('Model','Track'); 

class TrackUpdateShell extends AppShell {
    
    public $uses = array('Track');

    function main() {
        CakeLog::write('cron', 'Startup tracks update');               
        
        $last_id = $this->Track->getMaxId();  
        
        echo 'Last id is '.$last_id . "\n";
        
        
        $url = sprintf(UPDATE_URL,$last_id);
        echo 'URL is '. $url . "\n";
        
        $result_data = array();
        
        $content = file_get_contents($url);
        if ($content)         {
            echo 'XML exists.. try load' . "\n";
            $xml = simplexml_load_string($content);
            
            if ($xml->tracks) {
                echo 'Tracks exists. Total is ' .  count($xml->tracks->track) . "\n";
                                                
                foreach ($xml->tracks->track as $track) {
                    $result_data[] = array(
                                           'id'=>(string)$track->id
                                           ,'source_id'=>(string)$track->source_id
                                           ,'genre_id'=>(string)$track->genre_id
                                           ,'url'=>(string)$track->url
                                           ,'mp3'=>(string)$track->mp3
                                           ,'artist'=>(string)$track->artist
                                           ,'song'=>(string)$track->song
                                           ,'failed_attempts'=>(string)$track->failed_attempts
                                           ,'created'=>(string)$track->created
                                           ,'modified'=>(string)$track->modified
                    );                                        
                }
                
                echo "Data to import is: ".print_r($result_data,true) . "\n";
                
                
                if ($this->Track->saveAll($result_data)) {
                    echo "Import complite successfully! \n";
                } else {
                    echo "err while save data";
                    echo print_r($this->Track->invalidFields());
                }
                
                
                
                
            } else {
                echo "Error.. Need tree is not found.. ";                
            }
            
        }
        
        
        
    }
    
}