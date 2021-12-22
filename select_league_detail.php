<?
include "../dbconn.php";
$league_years_result = mysqli_query($conn,'SELECT years FROM league JOIN league_info WHERE league.no = league_info.league AND league ='.$_POST['num'].' ORDER BY years DESC ');
mysqli_close($conn);
$league_years = "$no";
while($league_years_row = mysqli_fetch_array($league_years_result)){
	$league_years .= "<option value='".$league_years_row['years']."'>".$league_years_row['years']." 년</option>";
}
echo $league_years;
?>