<?                                    
$html = '';
if ($tracks) {                                        
    foreach ($tracks as $track) {
        $html .= $this->element('track',array('track'=>$track));
    }
}

echo json_encode(array('html'=>$html));