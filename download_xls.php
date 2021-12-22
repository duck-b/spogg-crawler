<?
$filename = $_POST['file_names'];
header("Content-type: application/vnd.ms-excel" );
header("Content-Disposition: attachment; filename=".$filename);
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<?
session_start();
if($_SESSION['admin']){
	require_once('lib/Snoopy.class.php');
	$snoopy = new Snoopy;
	$snoopy->agent = $_SERVER['HTTP_USER_AGENT'];
	$table_body = "";
	if($_POST['hitpit'] == 1){
		$table_head = '<tr><th>name</th><th>name_detail</th><th>address</th><th>years</th><th>player_code</th><th>num</th><th>player_name</th><th>team_name</th><th>at_game</th><th>at_play</th><th>at_bat</th><th>hit</th><th>hit1</th><th>hit2</th><th>hit3</th><th>hr</th><th>rbi</th><th>rs</th><th>sb</th><th>bb</th><th>hbp</th><th>so</th><th>sf</th></tr>';
		if($_POST['league_name'] == 1){
			$league_name = '골드리그';
			$league_url = "http://www.gdbl.or.kr";
			if($_POST['league_name_detail'] == 1){
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=16&mGubun=4";
				$league_detail = "골드-매직리그";
			}else if($_POST['league_name_detail'] == 4){
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "골드-아메리칸리그";
			}else if($_POST['league_name_detail'] == 5){
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "골드-내셔널리그";
			}else if($_POST['league_name_detail'] == 6){
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "골드-드림리그";
			}
			$snoopy->referer = "http://www.gdbl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<count($matches2[0])/22; $i++){
				$x = $i * 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 2){
			$league_name = '금정리그';
			$league_url = "http://www.gdbl.or.kr";
			$main_url = "http://www.gjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B1%DD%C1%A4%B8%AE%B1%D7&limitCount=35&mGubun=4";
			$league_detail = "금정리그";
			$snoopy->referer = "http://http://www.gjba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-22)/22; $i++){
				$x = $i * 22 + 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td></tr>";
			}	
		}else if($_POST['league_name'] == 3){
			$league_name = '상동리그';
			$league_url = "http://sdbl.or.kr";
			if($_POST['league_name_detail'] == 7){
				$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "상동-내셔널리그";
			}else if($_POST['league_name_detail'] == 8){
				$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "상동-매직리그";
			}else if($_POST['league_name_detail'] == 9){
				$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "상동-드림리그";
			}else if($_POST['league_name_detail'] == 10){
				$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%BF%B8%B0%C1%F6%B8%AE%B1%D7&limitCount=20&mGubun=4";
				$league_detail = "상동-챌린지리그";
			}else if($_POST['league_name_detail'] == 11){
				$main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=30&mGubun=4";
				$league_detail = "상동-아메리칸리그";
			}
			$snoopy->referer = "http://sdbl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<count($matches2[0])/22; $i++){
				$x = $i * 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 4){
			$league_name = '안양리그';
			$league_url = "http://www.alb.or.kr";
			$main_url = "http://www.alb.or.kr/s/stand_bat/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_POST['league_year']."&division=&order=avg&sort=desc&mode=total";
			$league_detail = "안양-토요리그";
			$snoopy->referer = "http://www.alb.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table cellspacing=0 cellpadding=0 width=98% align=center border=0>(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/no=(.*?)target=/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			$plus_num = 0;
			for($i=0; $i<(count($matches2[0])-29)/26; $i++){
				$x = $i * 26 + 29;
				if(strip_tags($matches2[0][$x]) > strip_tags($matches2[0][$x+26])){
					$plus_num = strip_tags($matches2[0][$x]);
				}
				$num = strip_tags($matches2[0][$x]) + $plus_num;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>안양</td>
				<td>".$_POST['league_year']."</td>
				<td>".trim(strip_tags($matches3[1][$i]))."</td>
				<td>".$num."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".(strip_tags($matches2[0][$x+11])-strip_tags($matches2[0][$x+12])-strip_tags($matches2[0][$x+13])-strip_tags($matches2[0][$x+14]))."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td></tr>";
			}	
		}else if($_POST['league_name'] == 5){
			$league_name = '개성리그';
			$league_url = "http://www.ksbbl.kr";
			if($_POST['league_name_detail'] == 12){
				$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=201&limitCount=22&mGubun=4";
				$league_detail = "개성리그";
			}else if($_POST['league_name_detail'] == 13){
				$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=202&limitCount=26&mGubun=4";
				$league_detail = "개성-1부리그";
			}else if($_POST['league_name_detail'] == 14){
				$main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=203&limitCount=24&mGubun=4";
				$league_detail = "개성-2부리그";
			}
			$snoopy->referer = "http://www.ksbbl.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-22)/22; $i++){
				$x = $i * 22 + 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td></tr>";
			}
		}else if($_POST['league_name'] == 6){
			$league_name = '거제리그';
			$league_url = "http://www.kjba.kr";
			if($_POST['league_name_detail'] == 15){
				$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=38&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "거제-토요리그";
			}else if($_POST['league_name_detail'] == 16){
				$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=1%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "거제-일요1부리그";
			}else if($_POST['league_name_detail'] == 17){
				$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=2%BA%CE%B8%AE%B1%D7&limitCount=26&mGubun=4";
				$league_detail = "거제-일요2부리그";
			}else if($_POST['league_name_detail'] == 18){
				$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=3%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "거제-일요3부리그";
			}else if($_POST['league_name_detail'] == 19){
				$main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B7%E7%C5%B0%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "거제-루키리그";
			}
			$snoopy->referer = "http://www.kjba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]))/22; $i++){
				$x = $i * 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>거제</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 7){
			$league_name = '밀양리그';
			$league_url = "http://www.mybl.or.kr";
			if($_POST['league_name_detail'] == 20){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%AE%B1%D7&limitCount=20&mGubun=4";
				$league_detail = "밀양리그";
			}else if($_POST['league_name_detail'] == 21){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=25&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "밀양-토요리그";
			}else if($_POST['league_name_detail'] == 22){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=36&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%BE%DF%B0%A3%B8%AE%B1%D7&limitCount=24&mGubun=4";
				$league_detail = "밀양-평일리그";
			}else if($_POST['league_name_detail'] == 23){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E41%BA%CE&limitCount=28&mGubun=4";
				$league_detail = "밀양-일요1부리그";
			}else if($_POST['league_name_detail'] == 24){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "밀양-일요2부리그";
			}else if($_POST['league_name_detail'] == 25){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
				$league_detail = "밀양-일요3부리그";
			}else if($_POST['league_name_detail'] == 26){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B5%E5%B8%B2&limitCount=26&mGubun=4";
				$league_detail = "밀양-일요3부-드림리그";
			}else if($_POST['league_name_detail'] == 27){
				$main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B8%C5%C1%F7&limitCount=26&mGubun=4";
				$league_detail = "밀양-일요3부-매직리그";
			}
			$snoopy->referer = "http://www.mybl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
				$x = $i * 22 + 21;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>밀양</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 8){
			$league_name = '백양리그';
			$league_url = "http://www.byba.or.kr";
			if($_POST['league_name_detail'] == 28){
				$main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=34&mGubun=1";
				$league_detail = "백양리그-선수";
			}else if($_POST['league_name_detail'] == 29){
				$main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=28&mGubun=2";
				$league_detail = "백양리그-비선수";
			}
			$snoopy->referer = "http://www.byba.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]) - 21)/22; $i++){
				$x = $i * 22 + 21;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 9){
			$league_name = '삼성중공업야구리그';
			$league_url = "http://shi-baseball.kr";
			$main_url = "http://shi-baseball.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=24&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C1%DF%BF%EC%C8%B8%C0%E5%B9%E8%B8%AE%B1%D7&limitCount=36&mGubun=4";
			$league_detail = "삼성중공업야구리그";
			$snoopy->referer = "http://shi-baseball.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-22)/22; $i++){
				$x = $i * 22 + 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td></tr>";
			}
		}else if($_POST['league_name'] == 10){
			$league_name = '부산평일리그';
			$league_url = "http://www.bspil.net";
			$main_url = "http://www.bspil.net/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=11&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%B8%AE%B1%D7&limitCount=28&mGubun=4";
			$league_detail = '부산평일리그';
			$snoopy->referer = "http://www.bspil.net";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-22)/22; $i++){
				$x = $i * 22 + 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td></tr>";
			}
		}else if($_POST['league_name'] == 11){
			$league_name = 'UBBA리그';
			$league_url = "http://www.usba.kr";
			if($_POST['league_name_detail'] == 33){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20A&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-무룡리그A";
			}else if($_POST['league_name_detail'] == 34){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20B&limitCount=37&mGubun=4";
				$league_detail = "UBBA리그-무룡리그B";
			}else if($_POST['league_name_detail'] == 35){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-무룡리그";
			}else if($_POST['league_name_detail'] == 36){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BC%AD%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-서부리그";
			}else if($_POST['league_name_detail'] == 37){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BA%CF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-북부리그";
			}else if($_POST['league_name_detail'] == 38){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20A&limitCount=38&mGubun=4";
				$league_detail = "UBBA리그-처용리그A";
			}else if($_POST['league_name_detail'] == 39){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20B&limitCount=34&mGubun=4";
				$league_detail = "UBBA리그-처용리그B";
			}else if($_POST['league_name_detail'] == 40){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-처용리그";
			}else if($_POST['league_name_detail'] == 41){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AE%BC%F6%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-문수리그";
			}else if($_POST['league_name_detail'] == 42){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-태화리그";
			}else if($_POST['league_name_detail'] == 43){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%BF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-동부리그";
			}else if($_POST['league_name_detail'] == 44){
				$main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%B2%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
				$league_detail = "UBBA리그-남부리그";
			}
			$snoopy->referer = "http://www.usba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-21)/22 -1; $i++){
				$x = $i * 22 + 21;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>울산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 14){
			$league_name = '한새벌리그';
			$league_url = "http://www.sukdaeba.kr";
			$main_url = "http://www.sukdaeba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=12&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C7%D1%BB%F5%B9%FA%B8%AE%B1%D7&limitCount=40&mGubun=4";
			$league_detail = '한새벌리그';
			$snoopy->referer = "http://www.sukdaeba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-21)/22; $i++){
				$x = $i * 22 + 21;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 15){
			$league_name = 'BPA리그';
			$league_url = "http://www.bpabaseball.kr";
			$main_url = "http://www.bpabaseball.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=27&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=BPA%B8%AE%B1%D7&limitCount=17&mGubun=4";
			$league_detail = 'BPA리그';
			$snoopy->referer = "http://www.bpabaseball.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:5px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]))/22; $i++){
				$x = $i * 22;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+19])."</td>
				<td>".strip_tags($matches2[0][$x+20])."</td>
				<td>".strip_tags($matches2[0][$x+21])."</td></tr>";
			}
		}else if($_POST['league_name'] == 16){
			$league_name = 'PSBA리그';
			$league_url = "http://www.psba.or.kr";
			if($_POST['league_name_detail'] == 61){
				$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=1&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-매직리그-선수';
			}else if($_POST['league_name_detail'] == 62){
				$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=2&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-매직리그-비선수';
			}else if($_POST['league_name_detail'] == 63){
				$main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=4&yy=".$_POST['league_year']."&league=%B5%E5%B8%B2%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-드림리그';
			}
			$snoopy->referer = "http://www.psba.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="1"  class="tablecss">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-17)/17; $i++){
				$x = $i * 17 + 17;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>9999</td>
				<td>9999</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}
	}else{
		$table_head = '<tr><th>name</th><th>name_detail</th><th>address</th><th>years</th><th>player_code</th><th>num</th><th>player_name</th><th>team_name</th><th>at_game</th><th>win_games</th><th>lose_games</th><th>hold_games</th><th>save_games</th><th>pitcher_count</th><th>inning</th><th>er</th><th>rs</th><th>hit</th><th>hr</th><th>bb</th><th>hbp</th><th>so</th></tr>';
		if($_POST['league_name'] == 1){
			$league_name = '골드리그';
			$league_url = "http://www.gdbl.or.kr";
			if($_POST['league_name_detail'] == 1){
				$main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
				$league_detail = "골드-매직리그";
			}else if($_POST['league_name_detail'] == 4){
				$main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&mGubun=4";
				$league_detail = "골드-아메리칸리그";
			}else if($_POST['league_name_detail'] == 5){
				$main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "골드-내셔널리그";
			}else if($_POST['league_name_detail'] == 6){
				$main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
				$league_detail = "골드-드림리그";
			}
			$snoopy->referer = "http://www.gdbl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<count($matches2[0])/17; $i++){
				$x = $i * 17;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+8]))*3 + ((strip_tags($matches2[0][$x+8])) - floor(strip_tags($matches2[0][$x+8])))*10)."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td></tr>";
			}
		}else if($_POST['league_name'] == 2){
			$league_name = '금정리그';
			$league_url = "http://www.gdbl.or.kr";
			$main_url = "http://www.gjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B1%DD%C1%A4%B8%AE%B1%D7&mGubun=4";
			$league_detail = "금정리그";
			$snoopy->referer = "http://http://www.gjba.kr";			
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-19)/19; $i++){
				$x = $i * 19 + 19;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td></tr>";
			}
		}else if($_POST['league_name'] == 3){
			$league_name = '상동리그';
			$league_url = "http://sdbl.or.kr";
			if($_POST['league_name_detail'] == 7){
				$main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "상동-내셔널리그";
			}else if($_POST['league_name_detail'] == 8){
				$main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
				$league_detail = "상동-매직리그";
			}else if($_POST['league_name_detail'] == 9){
				$main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
				$league_detail = "상동-드림리그";
			}else if($_POST['league_name_detail'] == 10){
				$main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%BF%B8%B0%C1%F6%B8%AE%B1%D7&mGubun=4";
				$league_detail = "상동-챌린지리그";
			}else if($_POST['league_name_detail'] == 11){
				$main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&mGubun=4";
				$league_detail = "상동-아메리칸리그";
			}
			$snoopy->referer = "http://sdbl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<count($matches2[0])/17; $i++){
				$x = $i * 17;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+8]))*3 + ((strip_tags($matches2[0][$x+8])) - floor(strip_tags($matches2[0][$x+8])))*10)."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td></tr>";
			}
		}else if($_POST['league_name'] == 4){
			$league_name = '안양리그';
			$league_url = "http://www.alb.or.kr";
			$main_url = "http://alb.or.kr/s/stand_pit/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_POST['league_year']."&division=&order=win&sort=desc&mode=total";
			$league_detail = "안양-토요리그";
			$snoopy->referer = "http://www.alb.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table cellspacing=0 cellpadding=0 width=98% align=center border=0>(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/no=(.*?)target=/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			$plus_num = 0;
			for($i=0; $i<(count($matches2[0])-26)/24; $i++){
				$x = $i * 24 + 26;
				if(strip_tags($matches2[0][$x]) > strip_tags($matches2[0][$x+24])){
					$plus_num = strip_tags($matches2[0][$x]);
				}
				$num = strip_tags($matches2[0][$x]) + $plus_num;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>안양</td>
				<td>".$_POST['league_year']."</td>
				<td>".trim(strip_tags($matches3[1][$i]))."</td>
				<td>".$num."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".(floor(strip_tags($matches2[0][$x+5]))*3 + ((strip_tags($matches2[0][$x+5])) - floor(strip_tags($matches2[0][$x+5])))*10)."</td>
				<td>".strip_tags($matches2[0][$x+18])."</td>
				<td>".strip_tags($matches2[0][$x+17])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}else if($_POST['league_name'] == 5){
			$league_name = '개성리그';
			$league_url = "http://www.ksbbl.kr";
			if($_POST['league_name_detail'] == 12){
				$main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7&mGubun=4";
				$league_detail = "개성리그";
			}else if($_POST['league_name_detail'] == 13){
				$main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7%201%BA%CE&mGubun=4";
				$league_detail = "개성-1부리그";
			}else if($_POST['league_name_detail'] == 14){
				$main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7%202%BA%CE&mGubun=4";
				$league_detail = "개성-2부리그";
			}
			$snoopy->referer = "http://www.ksbbl.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-19)/19; $i++){
				$x = $i * 19 + 19;
				$inning = (floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10);
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".$inning."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td></tr>";
			}
		}else if($_POST['league_name'] == 6){
			$league_name = '거제리그';
			$league_url = "http://www.kjba.kr";
			if($_POST['league_name_detail'] == 15){
				$main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=38&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&mGubun=4";
				$league_detail = "거제-토요리그";
			}else if($_POST['league_name_detail'] == 16){
				$main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=1%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "거제-일요1부리그";
			}else if($_POST['league_name_detail'] == 17){
				$main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=2%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "거제-일요2부리그";
			}else if($_POST['league_name_detail'] == 18){
				$main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=3%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "거제-일요3부리그";
			}else if($_POST['league_name_detail'] == 19){
				$main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B7%E7%C5%B0%B8%AE%B1%D7&mGubun=4";
				$league_detail = "거제-루키리그";
			}
			$snoopy->referer = "http://www.kjba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]))/17; $i++){
				$x = $i * 17;
				$inning = (floor(strip_tags($matches2[0][$x+8]))*3 + ((strip_tags($matches2[0][$x+8])) - floor(strip_tags($matches2[0][$x+8])))*10);
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>거제</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".$inning."</td>
				<td>".strip_tags($matches2[0][$x+9])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td></tr>";
			}
		}else if($_POST['league_name'] == 7){
			$league_name = '밀양리그';
			$league_url = "http://www.mybl.or.kr";
			if($_POST['league_name_detail'] == 20){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%AE%B1%D7&mGubun=4";
				$league_detail = "밀양리그";
			}else if($_POST['league_name_detail'] == 21){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=25&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B3%AA%B3%EB%B8%AE%B1%D7&mGubun=4";
				$league_detail = "밀양-토요리그";
			}else if($_POST['league_name_detail'] == 22){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=36&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%BE%DF%B0%A3%B8%AE%B1%D7&mGubun=4";
				$league_detail = "밀양-평일리그";
			}else if($_POST['league_name_detail'] == 23){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E41%BA%CE&mGubun=4";
				$league_detail = "밀양-일요1부리그";
			}else if($_POST['league_name_detail'] == 24){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
				$league_detail = "밀양-일요2부리그";
			}else if($_POST['league_name_detail'] == 25){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
				$league_detail = "밀양-일요3부리그";
			}else if($_POST['league_name_detail'] == 26){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B5%E5%B8%B2&mGubun=4";
				$league_detail = "밀양-일요3부-드림리그";
			}else if($_POST['league_name_detail'] == 27){
				$main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B8%C5%C1%F7&mGubun=4";
				$league_detail = "밀양-일요3부-매직리그";
			}
			$snoopy->referer = "http://www.mybl.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]) - 18)/19 -1; $i++){
				$x = $i * 19 + 18;
				$inning = (floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10);
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>밀양</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>9999</td>
				<td>".$inning."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}else if($_POST['league_name'] == 8){
			$league_name = '백양리그';
			$league_url = "http://www.byba.or.kr";
			if($_POST['league_name_detail'] == 28){
				$main_url = "http://www.byba.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&mGubun=1";
				$league_detail = "백양리그-선수";
			}else if($_POST['league_name_detail'] == 29){
				$main_url = "http://www.byba.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&mGubun=2";
				$league_detail = "백양리그-비선수";
			}
            $snoopy->referer = "http://www.byba.or.kr";
            $snoopy->fetch($main_url);
            $html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
            $pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
            preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
            $pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
            preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
            $pattern3 = '/memID=(.*?)teamName/is';
            preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
            for($i=0; $i<(count($matches2[0]) - 18)/19 -1; $i++){
                $x = $i * 19 + 18;
                $inning = (floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10);                
                $table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>9999</td>
				<td>".$inning."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
            }
        }else if($_POST['league_name'] == 9){
			$league_name = '삼성중공업야구리그';
			$league_url = "http://shi-baseball.kr";
			$main_url = "http://shi-baseball.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=24&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C1%DF%BF%EC%C8%B8%C0%E5%B9%E8%B8%AE%B1%D7&mGubun=4";
			$league_detail = "삼성중공업야구리그";
			$snoopy->referer = "http://shi-baseball.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-20)/20; $i++){
				$x = $i * 20 + 20;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td></tr>";
			}
		}else if($_POST['league_name'] == 10){
			$league_name = '부산평일리그';
			$league_url = "http://www.bspil.net";
			$main_url = "http://www.bspil.net/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=11&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%B8%AE%B1%D7&mGubun=4";
			$league_detail = '부산평일리그';
			$snoopy->referer = "http://www.bspil.net";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="730" border="0" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-19)/19; $i++){
				$x = $i * 19 + 19;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td></tr>";
			}
		}else if($_POST['league_name'] == 11){
			$league_name = 'UBBA리그';
			$league_url = "http://www.usba.kr";
			if($_POST['league_name_detail'] == 33){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20A&mGubun=4";
				$league_detail = "UBBA리그-무룡리그A";
			}else if($_POST['league_name_detail'] == 34){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20B&mGubun=4";
				$league_detail = "UBBA리그-무룡리그B";
			}else if($_POST['league_name_detail'] == 35){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-무룡리그";
			}else if($_POST['league_name_detail'] == 36){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BC%AD%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-서부리그";
			}else if($_POST['league_name_detail'] == 37){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BA%CF%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-북부리그";
			}else if($_POST['league_name_detail'] == 38){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20A&mGubun=4";
				$league_detail = "UBBA리그-처용리그A";
			}else if($_POST['league_name_detail'] == 39){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20B&mGubun=4";
				$league_detail = "UBBA리그-처용리그B";
			}else if($_POST['league_name_detail'] == 40){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-처용리그";
			}else if($_POST['league_name_detail'] == 41){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AE%BC%F6%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-문수리그";
			}else if($_POST['league_name_detail'] == 42){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-태화리그";
			}else if($_POST['league_name_detail'] == 43){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%BF%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-동부리그";
			}else if($_POST['league_name_detail'] == 44){
				$main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%B2%BA%CE%B8%AE%B1%D7&mGubun=4";
				$league_detail = "UBBA리그-남부리그";
			}
			$snoopy->referer = "http://www.usba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-18)/19 -1; $i++){
				$x = $i * 19 + 18;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>울산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10)."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}else if($_POST['league_name'] == 14){
			$league_name = '한새벌리그';
			$league_url = "http://www.sukdaeba.kr";
			$main_url = "http://www.sukdaeba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=12&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C7%D1%BB%F5%B9%FA%B8%AE%B1%D7&mGubun=4";
			$league_detail = '한새벌리그';
			$snoopy->referer = "http://www.sukdaeba.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-18)/19 -1; $i++){
				$x = $i * 19 + 18;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x+1])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+3]))."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>".strip_tags($matches2[0][$x+8])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10)."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}else if($_POST['league_name'] == 15){
			$league_name = 'BPA리그';
			$league_url = "http://www.bpabaseball.kr";
			$main_url = "http://www.bpabaseball.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=27&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=BPA%B8%AE%B1%D7&mGubun=4";
			$league_detail = 'BPA리그';
			$snoopy->referer = "http://www.bpabaseball.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="750" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:3px;" class="tblTopBorder">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0]))/18; $i++){
				$x = $i * 18;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+12])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>".strip_tags($matches2[0][$x+15])."</td></tr>";
			}
		}else if($_POST['league_name'] == 16){
			$league_name = 'PSBA리그';
			$league_url = "http://www.psba.or.kr";
			if($_POST['league_name_detail'] == 61){
				$main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=1&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-매직리그-선수';
			}else if($_POST['league_name_detail'] == 62){
				$main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=2&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-매직리그-비선수';
			}else if($_POST['league_name_detail'] == 63){
				$main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=4&yy=".$_POST['league_year']."&league=%B5%E5%B8%B2%B8%AE%B1%D7&kind=Sun";
				$league_detail = 'PSBA-드림리그';
			}
			$snoopy->referer = "http://www.psba.or.kr";
			$snoopy->fetch($main_url);
			$html = iconv('EUC-KR', 'UTF-8', $snoopy->results);
			$pattern = '/<table width="740" border="0" cellspacing="1" cellpadding="0" align="center"  class="tablecss">(.*?)<\/table>/is';
			preg_match_all($pattern, $html, $matches, PREG_PATTERN_ORDER);
			$pattern2 = '/<td(.*?)>(.*?)<\/td>/is';
			preg_match_all($pattern2, $matches[0][0], $matches2, PREG_PATTERN_ORDER);
			$pattern3 = '/memID=(.*?)teamName/is';
			preg_match_all($pattern3, $matches[0][0], $matches3, PREG_PATTERN_ORDER);
			for($i=0; $i<(count($matches2[0])-19)/19; $i++){
				$x = $i * 19 + 19;
				$table_body .= "<tr><td>".$league_name."</td>
				<td>".$league_detail."</td>
				<td>부산</td>
				<td>".$_POST['league_year']."</td>
				<td>".str_replace('&','',strip_tags($matches3[1][$i*2]))."</td>
				<td>".strip_tags($matches2[0][$x])."</td>
				<td>".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."</td>
				<td>".trim(strip_tags($matches2[0][$x+2]))."</td>
				<td>".strip_tags($matches2[0][$x+3])."</td>
				<td>".strip_tags($matches2[0][$x+4])."</td>
				<td>".strip_tags($matches2[0][$x+5])."</td>
				<td>".strip_tags($matches2[0][$x+6])."</td>
				<td>".strip_tags($matches2[0][$x+7])."</td>
				<td>9999</td>
				<td>".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+10])."</td>
				<td>".strip_tags($matches2[0][$x+11])."</td>
				<td>".strip_tags($matches2[0][$x+13])."</td>
				<td>".strip_tags($matches2[0][$x+14])."</td>
				<td>9999</td>
				<td>".strip_tags($matches2[0][$x+16])."</td></tr>";
			}
		}
	}
	mysqli_close($conn);
}
?>
<body>
    <table>
        <thead>
            <?=$table_head?>
        </thead>
        <tbody>
            <?=$table_body?>
        </tbody>
    </table>
</body>
</html>