<!doctype html>
<html lang="ko">
<head>
	<meta charset="utf-8">
</head>
<body>
<?
session_start();
if($_SESSION['admin']){
	include "../dbconn.php";
	if($_POST['hitpit'] == 1){
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.no = ".$_POST['league_name_detail']." AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$data = $_POST['data'];
		$data = explode(',', $data);
		if($_POST['league_name'] == 1 || $_POST['league_name'] == 3){
			for($i = 0; $i<count($data)/18; $i++){
				$x = $i*18;
				$team = $data[$x];
				$num = $data[$x+1];
				$player = trim(str_replace('*','',strip_tags($data[$x+2])));
				$at_game = $data[$x+3];
				$at_play = $data[$x+4];
				$at_bat = $data[$x+5];
				$hit = $data[$x+6];
				$hit1 = $data[$x+7];
				$hit2 = $data[$x+8];
				$hit3 = $data[$x+9];
				$hr = $data[$x+10];
				$rbi = $data[$x+11];
				$rs = $data[$x+12];
				$sb = $data[$x+13];
				$bb = $data[$x+14];
				$hbp = $data[$x+15];
				$so = $data[$x+16];
				$sf = $data[$x+17];
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO crawling_record_hit  
				(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
				VALUES ('".$league_row['no']."','$team','-','$num','$player','$at_game','$at_play','$at_bat','$hit','$hit1','$hit2','$hit3','$hr','$rbi','$rs','$sb','$bb','$hbp','$so','$sf','$created_at')";
				mysqli_query($conn, $query);
			}
		}else if($_POST['league_name'] == 4 || $_POST['league_name'] == 5){
			for($i = 0; $i<count($data)/25; $i++){
				$x = $i*25;
				$num = trim($data[$x]);
				$player = trim(str_replace('*','',strip_tags($data[$x+1])));
				$team = trim($data[$x+2]);
				$at_game = $data[$x+3];
				$at_play = $data[$x+4];
				$at_bat = $data[$x+9];
				$hit = $data[$x+10];
				$hit1 = $data[$x+12];
				$hit2 = $data[$x+13];
				$hit3 = $data[$x+14];
				$hr = $data[$x+15];
				$rbi = $data[$x+18];
				$rs = $data[$x+19];
				$sb = $data[$x+20];
				$bb = $data[$x+21];
				$hbp = $data[$x+22];
				$so = $data[$x+23];
				$sf = $data[$x+24];
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO crawling_record_hit  
				(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
				VALUES ('".$league_row['no']."','$team','-','$num','$player','$at_game','$at_play','$at_bat','$hit','$hit1','$hit2','$hit3','$hr','$rbi','$rs','$sb','$bb','$hbp','$so','$sf','$created_at')";
				mysqli_query($conn, $query);
			}
		}else if($_POST['league_name'] == 6 || $_POST['league_name'] == 7){
			for($i = 0; $i<count($data)/16; $i++){
				$x = $i*16;
				$num = trim($data[$x]);
				$player =  trim(preg_replace("/[0-9]/","",strip_tags($data[$x+1])));
				$player = str_replace('()','',$player);
				$team = trim($data[$x+2]);
				$at_game = $data[$x+3];
				$at_play = $data[$x+5];
				$at_bat = $data[$x+6];
				$hit = $data[$x+7];
				$hit1 = "9999";
				$hit2 = "9999";
				$hit3 = "9999";
				$hr = $data[$x+8];
				$rbi = $data[$x+9];
				$rs = "9999";
				$sb = $data[$x+10];
				$bb = $data[$x+12];
				$hbp = "9999";
				$so = $data[$x+11];
				$sf = "9999";
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO crawling_record_hit  
				(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
				VALUES ('".$league_row['no']."','$team','-','$num','$player','$at_game','$at_play','$at_bat','$hit','$hit1','$hit2','$hit3','$hr','$rbi','$rs','$sb','$bb','$hbp','$so','$sf','$created_at')";
				mysqli_query($conn, $query);
			}
		}else if($_POST['league_name'] == 2){
			for($i = 0; $i<count($data)/20; $i++){
				$x = $i*20;
				$league_no = trim($data[$x]);
				$player_code = $data[$x+1];
				$num = $data[$x+2];
				$player = trim(str_replace('*','',strip_tags($data[$x+3])));
				$team = trim($data[$x+4]);
				$at_game = $data[$x+5];
				$at_play = $data[$x+6];
				$at_bat = $data[$x+7];
				$hit = $data[$x+8];
				$hit1 = $data[$x+9];
				$hit2 = $data[$x+10];
				$hit3 = $data[$x+11];
				$hr = $data[$x+12];
				$rbi = $data[$x+13];
				$rs = $data[$x+14];
				$sb = $data[$x+15];
				$bb = $data[$x+16];
				$hbp = $data[$x+17];
				$so = $data[$x+18];
				$sf = $data[$x+19];
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO crawling_record_hit  
				(league_info, team_name, player_code, num, player_name, at_game, at_play, at_bat, hit, hit1, hit2, hit3, hr, rbi, rs, sb, bb, hbp, so, sf, created_at) 
				VALUES ('$league_no','$team','$player_code','$num','$player','$at_game','$at_play','$at_bat','$hit','$hit1','$hit2','$hit3','$hr','$rbi','$rs','$sb','$bb','$hbp','$so','$sf','$created_at')";
				mysqli_query($conn, $query);
			}
		}
	}else{
		$league_query = "SELECT league_info.no as no FROM league_info JOIN league WHERE league.no = ".$_POST['league_name_detail']." AND league_info.years = '".$_POST['league_year']."' AND league_info.league= league.no";
		$league_result = mysqli_query($conn,$league_query);
		$league_row = mysqli_fetch_array($league_result);
		$data = $_POST['data'];
		$data = explode(',', $data);
		if($_POST['league_name'] == 1){
			for($i = 0; $i<count($data)/14; $i++){
				$x = $i*14;
				$num = trim($data[$x]);
				$player_name = trim(str_replace('*','',strip_tags($data[$x+1])));
				$team_name = $data[$x+2];
				$inning_h = floor($data[$x+3])*3;
				if(round($data[$x+3] - floor($data[$x+3]),2) == 0){
					$inning_f = 0;
				}else if(round($data[$x+3] - floor($data[$x+3]),2) == 0.33){
					$inning_f = 1;
				}else if(round($data[$x+3] - floor($data[$x+3]),2) == 0.67){
					$inning_f = 2;
				}
				$inning = $inning_h + $inning_f;
				$at_game = "9999";
				$win_games = $data[$x+4];
				$lose_games = $data[$x+5];
				$hold_games = $data[$x+6];
				$save_games = $data[$x+7];
				$pitcher_count = "9999";
				$hit = $data[$x+8];
				$hr = $data[$x+9];
				$bb = $data[$x+10];
				$so = $data[$x+11];
				$er = $data[$x+12];
				$rs = "9999";
				$hbp = "9999";
				$player_code = "-";
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO league_record_pit  
				(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
				VALUES ('".$league_row['no']."','$team_name','$player_code','$num','$player_name','$at_game','$win_games','$lose_games','$hold_games','$save_games','$pitcher_count','$inning','$er','$rs','$hit','$hr','$bb','$hbp','$so','$created_at')";
				//mysqli_query($conn, $query);
				echo $query."<br>";
			}
		}else if($_POST['league_name'] == 4 || $_POST['league_name'] == 5){
			for($i = 0; $i<count($data)/22; $i++){
				$x = $i*22;
				$num = trim($data[$x]);
				$player_name = trim(str_replace('*','',strip_tags($data[$x+1])));
				$team_name = $data[$x+2];
				$at_game = $data[$x+3];
				$win_games = $data[$x+4];
				$lose_games = $data[$x+5];
				$hold_games = $data[$x+6];
				$save_games = $data[$x+7];
				$inning_h = floor($data[$x+11])*3;
				if(round($data[$x+11] - floor($data[$x+11]),2) == 0){
					$inning_f = 0;
				}else if(round($data[$x+11] - floor($data[$x+11]),2) == 0.1){
					$inning_f = 1;
				}else if(round($data[$x+11] - floor($data[$x+11]),2) == 0.2){
					$inning_f = 2;
				}
				$inning = $inning_h + $inning_f;
				$pitcher_count = "9999";
				$rs = $data[$x+12];
				$er = "9999";
				$hit = $data[$x+13];
				$hr = $data[$x+14];
				$bb = $data[$x+17];
				$hbp = $data[$x+18];
				$so = $data[$x+19];
				$player_code = "-";
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO league_record_pit  
				(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
				VALUES ('".$league_row['no']."','$team_name','$player_code','$num','$player_name','$at_game','$win_games','$lose_games','$hold_games','$save_games','$pitcher_count','$inning','$er','$rs','$hit','$hr','$bb','$hbp','$so','$created_at')";
				//mysqli_query($conn, $query);
				echo $query."<br>";
			}
		}else if($_POST['league_name'] == 6 || $_POST['league_name'] == 7){
			for($i = 0; $i<count($data)/13; $i++){
				$x = $i*13;
				$num = trim($data[$x]);
				$player =  trim(preg_replace("/[0-9]/","",strip_tags($data[$x+1])));
				$player_name = str_replace('()','',$player);
				$team_name = $data[$x+2];
				$at_game = "9999";
				$win_games = $data[$x+4];
				$lose_games = $data[$x+5];
				$hold_games = "9999";
				$save_games = $data[$x+6];
				$inning_h = floor($data[$x+3])*3;
				if(round($data[$x+3] - floor($data[$x+3]),2) == 0){
					$inning_f = 0;
				}else if(round($data[$x+3] - floor($data[$x+3]),2) == 0.1){
					$inning_f = 1;
				}else if(round($data[$x+3] - floor($data[$x+3]),2) == 0.2){
					$inning_f = 2;
				}
				$inning = $inning_h + $inning_f;
				$pitcher_count = "9999";
				$rs = $data[$x+9];
				$er = $data[$x+10];
				$hit = "9999";
				$hr = $data[$x+8];
				$bb = "9999";
				$hbp = "9999";
				$so = $data[$x+11];
				$player_code = "-";
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO league_record_pit  
				(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
				VALUES ('".$league_row['no']."','$team_name','$player_code','$num','$player_name','$at_game','$win_games','$lose_games','$hold_games','$save_games','$pitcher_count','$inning','$er','$rs','$hit','$hr','$bb','$hbp','$so','$created_at')";
				//mysqli_query($conn, $query);
				echo $query."<br>";
			}
		}else if($_POST['league_name'] == 2){
			for($i = 0; $i<count($data)/19; $i++){
				$x = $i*19;
				$league_no = trim($data[$x]);
				$player_code = $data[$x+1];
				$num = $data[$x+2];
				$player_name = trim(str_replace('*','',strip_tags($data[$x+3])));
				$team_name = $data[$x+4];
				$at_game = $data[$x+5];
				$win_games = $data[$x+6];
				$lose_games = $data[$x+7];
				$hold_games = $data[$x+8];
				$save_games = $data[$x+9];
				$pitcher_count = $data[$x+10];
				$inning = $data[$x+11];
				$er = $data[$x+12];
				$rs = $data[$x+13];
				$hit = $data[$x+14];
				$hr = $data[$x+15];
				$bb = $data[$x+16];
				$hbp = $data[$x+17];
				$so = $data[$x+18];
				$created_at = date('Y-m-d H:i:s',time());
				$query = "INSERT INTO league_record_pit  
				(league_info, team_name, player_code, num, player_name, at_game, win_games, lose_games, hold_games, save_games, pitcher_count, inning, er, rs, hit, hr, bb, hbp, so, created_at) 
				VALUES ('".$league_no."','$team_name','$player_code','$num','$player_name','$at_game','$win_games','$lose_games','$hold_games','$save_games','$pitcher_count','$inning','$er','$rs','$hit','$hr','$bb','$hbp','$so','$created_at')";
				//mysqli_query($conn, $query);
				echo $query."<br>";
			}
		}
	}
	mysqli_close($conn);
}
echo "<script>alert('입력되었습니다.');</script>";
echo ("<meta http-equiv='Refresh' content='1; URL=directing.html'>");
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