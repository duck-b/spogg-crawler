<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
<?
session_start();
if($_SESSION['admin']){
    $created_at = date('Y-m-d H:i:s',time());
	include "../dbconn.php";
    require_once('lib/Snoopy.class.php');
    $snoopy = new Snoopy;
    $snoopy->agent = $_SERVER['HTTP_USER_AGENT'];
    if($_POST['hitpit'] == 1){
		if($_POST['league_name'] == 1){
			if($_POST['league_name_detail'] == 1){
				$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-매직%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=16&mGubun=4";
			}else if($_POST['league_name_detail'] == 4){
				$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-아메리칸%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=28&mGubun=4";
			}else if($_POST['league_name_detail'] == 5){
				$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-내셔널%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
			}else if($_POST['league_name_detail'] == 6){
				$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-드림%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
				$main_url = "http://www.gdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
			}
			$league_result = mysqli_query($conn,$league_query);
			$league_row = mysqli_fetch_array($league_result);
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
				$query= "INSERT INTO crawling_record_hit  
				(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
				VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
				mysqli_query($conn, $query);
			}
		}else if($_POST['league_name'] == 2){
			$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%금정%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
			$league_result = mysqli_query($conn,$league_query);
			$league_row = mysqli_fetch_array($league_result);
			$main_url = "http://www.gjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B1%DD%C1%A4%B8%AE%B1%D7&limitCount=35&mGubun=4";
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
         }   
      }else if($_POST['league_name'] == 3){
         if($_POST['league_name_detail'] == 7){
            $main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-내셔널%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 8){
            $main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-매직%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 9){
            $main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-드림%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 10){
            $main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%BF%B8%B0%C1%F6%B8%AE%B1%D7&limitCount=20&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-첼린지%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 11){
            $main_url = "http://sdbl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&limitCount=30&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-아메리칸%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	 	 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$x/11]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 4){
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%안양%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
		 $league_result = mysqli_query($conn,$league_query);
	 	 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".trim(strip_tags($matches3[1][$i]))."', '$num', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".(strip_tags($matches2[0][$x+11])-strip_tags($matches2[0][$x+12])-strip_tags($matches2[0][$x+13])-strip_tags($matches2[0][$x+14]))."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+17])."', '$created_at')";
			mysqli_query($conn, $query);
         }   
      }else if($_POST['league_name'] == 5){
         if($_POST['league_name_detail'] == 12){
            $main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=201&limitCount=22&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 13){
            $main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=202&limitCount=26&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 14){
            $main_url = "http://www.ksbbl.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=203&limitCount=24&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	     $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 6){
         if($_POST['league_name_detail'] == 15){
            $main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=38&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-토요리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 16){
            $main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=1%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 17){
            $main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=2%BA%CE%B8%AE%B1%D7&limitCount=26&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 18){
            $main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=3%BA%CE%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요3부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 19){
            $main_url = "http://www.kjba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B7%E7%C5%B0%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요루키리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '9999', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 7){
         if($_POST['league_name_detail'] == 20){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%AE%B1%D7&limitCount=20&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 21){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=25&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-토요리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 22){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=36&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%BE%DF%B0%A3%B8%AE%B1%D7&limitCount=24&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-평일리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 23){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E41%BA%CE&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 24){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B5%E5%B8%B2%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 25){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%C5%C1%F7%B8%AE%B1%D7&limitCount=28&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 26){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B5%E5%B8%B2&limitCount=26&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-드림리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 27){
            $main_url = "http://www.mybl.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B8%C5%C1%F7&limitCount=26&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-매직리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	     $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 8){
         if($_POST['league_name_detail'] == 28){
            $main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=34&mGubun=1";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-선수%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 29){
            $main_url = "http://www.byba.or.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&limitCount=28&mGubun=2";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-비선수%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 9){
         $main_url = "http://shi-baseball.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=24&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C1%DF%BF%EC%C8%B8%C0%E5%B9%E8%B8%AE%B1%D7&limitCount=36&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%삼성중공업%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 10){
         $main_url = "http://www.bspil.net/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=11&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%B8%AE%B1%D7&limitCount=28&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%부산평일리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 11){
         if($_POST['league_name_detail'] == 33){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20A&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그A' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 34){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20B&limitCount=37&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그B' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 35){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 36){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BC%AD%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-서부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 37){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BA%CF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-북부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 38){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20A&limitCount=38&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그A' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 39){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20B&limitCount=34&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그B' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 40){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 41){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AE%BC%F6%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-문수리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 42){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-태화리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 43){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%BF%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-동부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 44){
            $main_url = "http://www.usba.kr/batRankDetail.asp?yy=".$_GET['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%B2%BA%CE%B8%AE%B1%D7&limitCount=36&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-남부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	 	 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 14){
         $main_url = "http://www.sukdaeba.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=12&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C7%D1%BB%F5%B9%FA%B8%AE%B1%D7&limitCount=40&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '한새벌리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 15){
         $main_url = "http://www.bpabaseball.kr/batRankDetail.asp?yy=".$_POST['league_year']."&groupCode=27&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=BPA%B8%AE%B1%D7&limitCount=17&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'BPA리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO league_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+19])."', '".strip_tags($matches2[0][$x+20])."', '".strip_tags($matches2[0][$x+21])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 16){
         if($_POST['league_name_detail'] == 61){
            $main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=1&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-선수' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 62){
            $main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=2&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-비선수' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 63){
            $main_url = "http://www.psba.or.kr/detailBatRank.asp?gubun=4&yy=".$_POST['league_year']."&league=%B5%E5%B8%B2%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-드림리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_hit  
			(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999', '9999', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '9999', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."','$created_at')";
			mysqli_query($conn, $query);
         }
      }
  }else{
      if($_POST['league_name'] == 1){
         if($_POST['league_name_detail'] == 1){
            $main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-매직%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 4){
            $main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-아메리칸%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 5){
            $main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-내셔널%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 6){
            $main_url = "http://www.gdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=29&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%골드-드림%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+8]))*3 + ((strip_tags($matches2[0][$x+8])) - floor(strip_tags($matches2[0][$x+8])))*10)."', '".strip_tags($matches2[0][$x+9])."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 2){
         $main_url = "http://www.gjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=21&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B1%DD%C1%A4%B8%AE%B1%D7&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%금정%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 3){
         if($_POST['league_name_detail'] == 7){
            $main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%BB%BC%C5%B3%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-내셔널%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 8){
            $main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-매직%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 9){
            $main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-드림%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 10){
            $main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%BF%B8%B0%C1%F6%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-첼린지%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 11){
            $main_url = "http://sdbl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=30&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BE%C6%B8%DE%B8%AE%C4%AD%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%상동-아메리칸%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+8]))*3 + ((strip_tags($matches2[0][$x+8])) - floor(strip_tags($matches2[0][$x+8])))*10)."', '".strip_tags($matches2[0][$x+9])."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 4){
         $main_url = "http://alb.or.kr/s/stand_pit/index.php?id=stats&league=%BF%AC%C7%D5%C8%B8%C0%E5%B1%E2&sc=2&gyear=".$_POST['league_year']."&division=&order=win&sort=desc&mode=total";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%안양%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".trim(strip_tags($matches3[1][$i]))."', '$num', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+8])."', '".strip_tags($matches2[0][$x+9])."', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+7])."',	'".(floor(strip_tags($matches2[0][$x+5]))*3 + ((strip_tags($matches2[0][$x+5])) - floor(strip_tags($matches2[0][$x+5])))*10)."', '".strip_tags($matches2[0][$x+18])."', '".strip_tags($matches2[0][$x+17])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 5){
         if($_POST['league_name_detail'] == 12){
            $main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 13){
            $main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7%201%BA%CE&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 14){
            $main_url = "http://www.ksbbl.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=17&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B0%B3%BC%BA%B8%AE%B1%D7%202%BA%CE&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%개성-2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result); 
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".$inning."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 6){
         if($_POST['league_name_detail'] == 15){
            $main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=38&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-토요리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 16){
            $main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=1%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 17){
            $main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=2%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 18){
            $main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=3%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요3부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 19){
            $main_url = "http://www.kjba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=37&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B7%E7%C5%B0%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%거제-일요루키리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	     $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".$inning."', '".strip_tags($matches2[0][$x+9])."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 7){
         if($_POST['league_name_detail'] == 20){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 21){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=25&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%E4%BF%E4%B3%AA%B3%EB%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-토요리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 22){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=36&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%BE%DF%B0%A3%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-평일리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 23){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E41%BA%CE&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요1부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 24){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B5%E5%B8%B2%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요2부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 25){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E4%B8%C5%C1%F7%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 26){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B5%E5%B8%B2&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-드림리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 27){
            $main_url = "http://www.mybl.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=23&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C0%CF%BF%E43%BA%CE%20%B8%C5%C1%F7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%밀양-일요3부-매직리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
	 	 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999',	'".$inning."', '".strip_tags($matches2[0][$x+11])."', '9999', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 8){
         if($_POST['league_name_detail'] == 28){
            $main_url = "http://www.byba.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&mGubun=1";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-선수%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 29){
            $main_url = "http://www.byba.or.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=06&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%E9%BE%E7%B8%AE%B1%D7&mGubun=2";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%백양리그-비선수%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
        $league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999',	'".$inning."', '9999', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
			mysqli_query($conn, $query);
        }
    }else if($_POST['league_name'] == 9){
         $main_url = "http://shi-baseball.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=24&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C1%DF%BF%EC%C8%B8%C0%E5%B9%E8%B8%AE%B1%D7&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%삼성중공업%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."', '".strip_tags($matches2[0][$x+10])."', '9999', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 10){
         $main_url = "http://www.bspil.net/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=11&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C6%F2%C0%CF%B8%AE%B1%D7&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name LIKE '%부산평일리그%' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
		 $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 11){
         if($_POST['league_name_detail'] == 33){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20A&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그A' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 34){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7%20B&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그B' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 35){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AB%B7%E6%B8%AE%B1%D7&mGubun=4";
           $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-무룡리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 36){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BC%AD%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-서부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 37){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=15&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%BA%CF%BA%CE%B8%AE%B1%D7&mGubun=4";
           $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-북부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 38){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20A&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그A' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 39){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C3%B3%BF%EB%B8%AE%B1%D7%20B&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그B' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 40){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-처용리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 41){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B9%AE%BC%F6%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-문수리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 42){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C5%C2%C8%AD%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-태화리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 43){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B5%BF%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-동부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 44){
            $main_url = "http://www.usba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=16&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%B3%B2%BA%CE%B8%AE%B1%D7&mGubun=4";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'UBBA-남부리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999',	'".(floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10)."', '".strip_tags($matches2[0][$x+11])."', '9999', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 14){
         $main_url = "http://www.sukdaeba.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=12&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=%C7%D1%BB%F5%B9%FA%B8%AE%B1%D7&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = '한새벌리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
				$query= "INSERT INTO crawling_record_pit  
                (league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
                VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+3]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x+1])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+2])))."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '".strip_tags($matches2[0][$x+8])."', '9999',	'".(floor(strip_tags($matches2[0][$x+10]))*3 + ((strip_tags($matches2[0][$x+10])) - floor(strip_tags($matches2[0][$x+10])))*10)."', '9999', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
                mysqli_query($conn, $query);
			}
		}else if($_POST['league_name'] == 15){
         $main_url = "http://www.bpabaseball.kr/pitcherRankDetail.asp?yy=".$_POST['league_year']."&groupCode=27&gameName=%C1%A4%B1%D4%B8%AE%B1%D7&league=BPA%B8%AE%B1%D7&mGubun=4";
         $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'BPA리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&amp;','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+12])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '".strip_tags($matches2[0][$x+15])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }else if($_POST['league_name'] == 16){
         if($_POST['league_name_detail'] == 61){
            $main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=1&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-선수' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 62){
            $main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=2&yy=".$_POST['league_year']."&league=%B8%C5%C1%F7%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-매직리그-비선수' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }else if($_POST['league_name_detail'] == 63){
            $main_url = "http://www.psba.or.kr/detailPitcherRank.asp?gubun=4&yy=".$_POST['league_year']."&league=%B5%E5%B8%B2%B8%AE%B1%D7&kind=Sun";
            $league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.name = 'PSBA-드림리그' AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
         }
         $league_result = mysqli_query($conn,$league_query);
		 $league_row = mysqli_fetch_array($league_result);
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
            $query= "INSERT INTO crawling_record_pit  
			(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
			VALUES ('".$league_row['no']."', '".trim(strip_tags($matches2[0][$x+2]))."', '".str_replace('&','',strip_tags($matches3[1][$i*2]))."', '".strip_tags($matches2[0][$x])."', '".trim(str_replace('*','',strip_tags($matches2[0][$x+1])))."', '".strip_tags($matches2[0][$x+3])."', '".strip_tags($matches2[0][$x+4])."', '".strip_tags($matches2[0][$x+5])."', '".strip_tags($matches2[0][$x+6])."', '".strip_tags($matches2[0][$x+7])."', '9999',	'".(floor(strip_tags($matches2[0][$x+9]))*3 + ((strip_tags($matches2[0][$x+9])) - floor(strip_tags($matches2[0][$x+9])))*10)."', '9999', '".strip_tags($matches2[0][$x+10])."', '".strip_tags($matches2[0][$x+11])."', '".strip_tags($matches2[0][$x+13])."', '".strip_tags($matches2[0][$x+14])."', '9999', '".strip_tags($matches2[0][$x+16])."', '$created_at')"; 
			mysqli_query($conn, $query);
         }
      }
   }
   mysqli_close($conn);
}
echo "<script>alert('입력되었습니다.');</script>";
echo ("<meta http-equiv='Refresh' content='1; URL=crawling.html'>");
?>
<style>
body
    {
     text-align: center;
     margin: 0 auto;
    }
#box
    {
     position: absolute;
     width: 50px;
     height: 50px;
     left: 50%;
     top: 50%;
     margin-left: -25px;
     margin-top: -25px;
    }
</style>
</head>
<body>
	<img id="box" src="../img/loading.gif" alt="loading">
</body>
</html>