<?php
    $oristring = "<li><div class=\"media\">
    <i class=\" mr-3 fas fa-spinner\"></i>
    <div class=\"media-body\">
      <h5 class=\"mt-0\">불러오는 중...</h5>
      데이터를 가져오는 중입니다...
    </div>
  </div>
  </li>";
    $string = $oristring;
    $files = scandir('/var/www/html/timeline');
    
    usort($files, function($a, $b) {
        if(endsWith($a, '.jpg') && endsWith($b, '.jpg')) {
            $adt = date_create_from_format('Y-m-d-H:i', str_replace(".jpg", "", explode("_", $a)[1]));
            $ats = $adt->format('U');
            $bdt = date_create_from_format('Y-m-d-H:i', str_replace(".jpg", "", explode("_", $b)[1]));
            $bts = $bdt->format('U');
            return $ats - $bts;
        }
        return 0;
    });
    foreach($files as $file) {
        if(endsWith($file, '.jpg')) {
            if($oristring == $string) {
                $string = "";
            }
            $rawdata = explode("_", $file);
            $type = $rawdata[0];
            $date = str_replace(".jpg", "", $rawdata[1]);
            $description = "원인을 알 수 없음.";
            if($type == "fire") {
                $description = "불꽃 센서 감지";
            } else if($type == "vive") {
                $description = "진동 센서 감지";
            } else if($type == "sound") {
                $description = "소리 센서 감지";
            }
            $string .= "<li><div class=\"media\">
        <img class=\"mr-3\" src=\"timeline/".$file."\" alt=\"".$date."\" width=\"180\">
        <div class=\"media-body\">
          <h5 class=\"mt-0\">".$date."</h5>
          ".$description."
        </div>
      </div>
      </li>
            ";
        }
    }
    function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
    echo $string;
?>