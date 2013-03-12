<?php

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class RuHelper extends AppHelper {

    private $months = array(
        1=>"января"
        ,2=>"февраля"
        ,3=>"марта"
        ,4=>"апреля"
        ,5=>"мая"
        ,6=>"июня"
        ,7=>"июля"
        ,8=>"августа"
        ,9=>"сентября"
        ,10=>"октября"
        ,11=>"ноября"
        ,12=>"декабря"
    );
    
    
    private $days = array('Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресенье');
    
    
    /**
        * Русская дата, включая день недели - (%B или %b) - месяц, %A - день недели
    */
    private function unix_date($ctime = "", $format = "%d %B %Y, %H:%M") {

        $ctime = empty($ctime) ? time() : $ctime;

        // если дата в формате mysql - делаем обратное преобразование
        if (!preg_match('/^\d+$/',$ctime)) {
            $ctime = strtotime ($ctime);
        }

        // добаялем тег для обработки и замены в будущем
        $format = str_replace('%B','--%m--',$format);
        
        // добаялем тег для обработки и замены в будущем
        $format = str_replace('%b','-+%m+-',$format);

        // для дня недели
        $format = str_replace('%A','++%u++',$format);


        // формируем время
        if (date('d.m.Y',$ctime) === date('d.m.Y')) {
            
            // есил в формате было время...
            if (strpos($format, '%H:%M') !== false) {
                $r = 'cегодня в '.strftime('%H:%M',$ctime);                
            } else {
                $r = 'cегодня';
            }
            
        } else {
            $r = strftime($format,$ctime);
            // заменяем месяц на русское название
            $r = preg_replace_callback("/--(\d{1,2})--/",array($this,'get_rus_month'),$r);
            
             // заменяем месяц на русское название
            $r = preg_replace_callback("/-\+(\d{1,2})\+-/",array($this,'get_rus_month_short'),$r);

            // заменяем название дня недели на русское название
            $r = preg_replace_callback("/\+\+(\d{1,2})\+\+/",array($this,'_get_rus_day'),$r);    
        }
        
        return $r;

    }

   /* private function unix_date($ctime = "", $format = "%d %m %Y, %H:%M") {
        $ctime = empty($ctime) ? time() : $ctime;

        // добаялем тег для обработки и замены в будущем
        $format = str_replace('%m','--%m--',$format);
        // формируем время
        if (date('d.m.Y',$ctime) === date('d.m.Y')) {
            $r = 'cегодня в '.strftime('%H:%M',$ctime);
        } else {
            $r = strftime($format,$ctime);
            // заменяем месяц на русское название
            $r = preg_replace_callback("/--(\d{1,2})--/",array($this,'get_rus_month'),$r);    
        }        

        return $r;
    } */

    private function mysql_date($ctime,$format = "%d %B %Y, %H:%M") {
        $r = strtotime ($ctime);
        if ($r) {
            return $this->unix_date($r,$format);
        } else {
            return false;
        }
    }

    private function get_rus_month($num) {
        $num = $num[1]*1;
        return $this->months[$num];
    }
    
    private function get_rus_month_short($num) {
        $month = $this->get_rus_month($num);
        
        $end = '';
        if (mb_strlen($month) > 3) {$end = '.';}
        
        return mb_substr($this->get_rus_month($num), 0,3) . $end;
    }
    
    private function _get_rus_day($num) {
        $days = $this->days;
        return $days[ (int)$num + 1 ];
    }

    // %d - 01 , %e - 1
    public function date($date,$format = "%e %B %Y, %H:%M") {
       return $this->mysql_date($date,$format);
    }


}
