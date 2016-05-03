<?php
/*
* Author: Aditya
* date: 21-Aug-2014
* Description: This has some common function required to update the subscription logic. Like the features in database has some specific format, it is maintained via this script
*
*/
class getFeaturesList {
	
	//Format	:-	ApplicationFeatures;ProductSubversion;ProductType(PulsarControllerType);Number General VU; Number Rapid VU; Support Expiry date
	public	$OrderFeaturesString	=	array('ApplicationFeatures', 'ProductSubversion', 'ProductType', 'GeneralVU', 'RapidVU', 'SupportExpiry');	// The array should contain the exact function name for order
	public  $Features	=	"";

	//The input should be an array of elements that correspond to the arguments required for corresponding functions in same order as stated above in Format array
	public function getFeaturesList($ArgumentsList)
	{
		$Features	=	'';
		foreach($this->OrderFeaturesString as $key=>$value) {
			$Results[]	=	call_user_func (array($this, $value), $ArgumentsList[$key]);
		}
		
		if(count($Results)	==	count($this->OrderFeaturesString))	{	//All functions have returned output successfully
			$Features	=	implode(';', $Results);
		}

		$this->Features	=	$Features;	
	}
	
	public function ApplicationFeatures($FeaturesListRequested)
	{
		global $FeaturesList;
		$Bitset	=	"";
		if($FeaturesListRequested	==	"")	{

		}	
		else {
			$FeaturesListRequested	=	explode(',', $FeaturesListRequested);
			foreach($FeaturesListRequested as $key=>$value) {
				$featuresBitArray[]	=	$FeaturesList[$value];
			}
		
			$Bitset	=	$this->BitwiseOr($featuresBitArray);
		}
		return $Bitset;
	}
	
	public function ProductSubversion($ProductFamily)
	{
		if($ProductFamily	==	"")
			$ProductFamily	=	5;	//Default PPU
			
		global $ProductSubversion;
			$ProVersion	=	$ProductSubversion[$ProductFamily];			
					
		return $ProVersion;
	}
	
	public function ProductType($ControllerType)
	{
		if($ControllerType	==	"")
			$ControllerType	=	1;	//Default General
			
		global $ProductType;
			$ProType	=	$ProductType[$ControllerType];			
					
		return $ProType;
	}
		
	public function GeneralVU($VUInput)
	{
		global $GeneralVU;
		return $GeneralVU;
	}
		
	public function RapidVU($VUInput)
	{
		global $RapidVU;
		return $RapidVU;
	}
		
	public function SupportExpiry($ExpiryDate)
	{
		global $SupportExpiry;
		return $SupportExpiry;
	}
	
	private function BitwiseOr($featuresBitArray)
	{
		$BitSet	=	0;
		for($i=0; $i<count($featuresBitArray);$i++)
		{
			$BitSet	=	$BitSet | $featuresBitArray[$i];  
		}
		return $BitSet;
	}
	
};

function Get_EndValidityOfPackage($Packagecode)
{
	global $PackageName;
	$Package	=	$PackageName[$Packagecode];
	$EndValidity	=	date('Y-m-d', strtotime('+'.$Package.' days'));
	return $EndValidity;
}

function PackageCostPerMonth($features)
{
	global $FeaturesPricePerMonth;
	$Cost	=	$FeaturesPricePerMonth[0];

	//Add Base price (p.m.) of Selected FeaturesBasePrice
	$features	=	explode(',', $features);
	foreach($features as $key=>$value) {
		$Cost	+=	$FeaturesPricePerMonth[$value];
	}
	
	return $Cost;
}

function CalculatePriceByFeaturesAndPackage($features, $Packagecode)
{
	global $PackageName;
	$Cost	=	0;
	//Find package cost for 1 month
	$CostPerMonth	=	PackageCostPerMonth($features);
		
	//Multiply cost by respective months duration. so month corresponds to 30 days, and the user interface will send package code as 1 month 2 month 3 month, which is the package code
	$Cost	=	$CostPerMonth	*	$Packagecode;
	
	return $Cost;
}
?>