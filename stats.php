<?php
// Load Linkage Variables //
$dir = dirname(__FILE__);
$req 		= $dir."/req/";
$functions	= $req."functions.php";

//Include hashing functions
include($functions);

//Include bitcoind functions
include($bitcoind);

//Set user details for userInfo box
$rawCookie		= "";
if(isSet($_COOKIE[$cookieName])){
	$rawCookie	= $_COOKIE[$cookieName];
}
$getCredientials	= new getCredientials;
$loginValid	= $getCredientials->checkLogin($rawCookie);
?>
<!--?xml version="1.0" encoding="iso-8859-1"?-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo outputPageTitle();?> - <?php echo gettext("Main Page");?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link href="/css/mainstyle.css" rel="stylesheet" type="text/css">
	</head> 
	<body>
	<br/><br/>
		<div id="content">
			
				<?php
				//Include the header & slogan
				include($header);
				////////////////////////////
				
				?>
			<br/><br/>
			<div id="mainbox">
				<!--Pool-->
				<table align="center" cellpadding="0" cellspacing="0" class="bigContent">
					<tbody>
						<tr>
							<td class="contTL">
							&nbsp;
							</td>
							<td class="contTC">
								Blocks Found
							</td>
							<td class="contTR">
							&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="3" class="contContent">
								<img src="/images/graphIcons/blockFound.png"/> = Block Found<br/>
								<img src="/images/graphIcons/currentTime.png"/> = Current network block<br/>
								<img src="/images/graphIcons/estimatedBlockFound.png"/> = ETA till next block is found
								<br/><br/>
								<?php
									//Open a bitcoind connection
										$bitcoinController = new BitcoinClient($rpcType, $rpcUsername, $rpcPassword, $rpcHost);
									//Get current block number
										$currentBlockNumber = $bitcoinController->getblocknumber();
										
									//Get blocks found
										$blocksFoundQ = mysql_query("SELECT `blockNumber`, `timestamp` FROM `networkBlocks` ORDER BY `blockNumber` ASC");
										$blockArray = "";
										$timeArray = "";
										$i=0;
										
										//Tmp vars
										$totalDifference = 0;
										$lastDifference = 0;
										$lastBlockNumber = 0;
										while($block = mysql_fetch_array($blocksFoundQ)){
											if($i > 0){
												$blockArray .=",";
												$timeArray .=",";
											}
											$i++;
											$blockArray .="{y: ".$block["blockNumber"].",
														marker: {
															symbol: 'url(/images/graphIcons/blockFound.png)'
														}
													}";
											$timeArray .= "'".date("m/d/Y g:i:s a", $block["timestamp"])."'";
											
											if(!$lastDifference){
												$lastDifference = $block["timestamp"];
											}
											
											if($lastDifference){
												$totalDifference += ($block["timestamp"]-$lastDifference);
												$lastDifference = $block["timestamp"];
											}
											
											$lastBlockNumber = $block["blockNumber"];
										}
										$averageDifference = ($totalDifference/$i);
										$estimatedFindTimestamp = $lastDifference+$averageDifference;
										$estimatedBlockNumber = $lastBlockNumber+(($averageDifference/60)/10);
										
										//Add current time here if its before estimated block finding
											if($estimatedFindTimestamp > time()){
												//Add currentime time
													$timeArray .=",'".date("m/d/y g:i:s a", time())."'";
													$blockArray .=",{
																y: ".time().",
																marker: {
																symbol: 'url(/images/graphIcons/currentTime.png)'
																}
															}";
											}
										
										//Add expected block found
											$timeArray .= ",'".date("m/d/Y g:i:s a", $estimatedFindTimestamp)."'";
											$blockArray .=",{
														y: ".$estimatedBlockNumber.",
														marker: {
														symbol: 'url(/images/graphIcons/estimatedBlockFound.png)'
														}
													}";
													
										//Add current time here if it is after the estimated block finding
											if($estimatedFindTimestamp < time()){
												//Add currentime time
													$timeArray .=",'".date("m/d/y g:i:s a", time())."'";
													$blockArray .=",{
																y: ".$currentBlockNumber.",
																marker: {
																symbol: 'url(/images/graphIcons/currentTime.png)'
																}
															}";
											}
								
		
								?>
								<script type="text/javascript">
									var chart1; // globally available
									$(document).ready(function() {
										chart1 = new Highcharts.Chart({
											chart: {
												renderTo: 'blocksFound',
												defaultSeriesType: 'line',
												width:750,
												height:250
											},
											title: {
												text: 'Overall Blocks Found'
											},
											xAxis: {
												categories: [<?php echo $timeArray;?>]
											},
											yAxis: {
												title: {
													text: 'Block Number'
												}
											},
											series: [{
												name: 'Block Number',
												data: [
													<?php echo $blockArray; ?>
														
													]
												}]
										});
									});
								</script>
								<div id="blocksFound" align="center">
									<img src="/images/placeholder.jpg" alt="placeholder">
								</div><br/><br/>
							</td>
						</td>
					</tbody>
				</table>

			</div><br/>
			<?php
			//Include Footer
			////////////////////
			include($footer);
			?>
		</div>
		<br/><Br/>

	</body>
</html>