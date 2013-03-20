<?

class ZippyHelper extends AppHelper {
    
    
    public function exam_link($link) {        
        $pattern = '/http:\/\/www(\d+)\.zippyshare\.com\/downloadMusic\?key=(\d+)/';
        
        
        if (preg_match($pattern, $link,$m)) {
            return array('www'=>$m[1],'file'=>$m[2]);
        } 
        
        
        return false;
    }
    
    public function embed($link) {
        $info = $this->exam_link($link);
        if ($info) {
            return sprintf('<script type="text/javascript">var zippywww="%d";var zippyfile="%d";var zippytext="#000000";var zippyback="#e8e8e8";var zippyplay="#ff6600";var zippywidth=700;var zippyauto=false;var zippyvol=80;var zippywave = "#000000";var zippyborder = "#cccccc";</script><script type="text/javascript" src="http://api.zippyshare.com/api/embed_new.js"></script>',$info['www'],$info['file']);
        }
    }
    
    
}