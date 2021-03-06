<?php
/*
 * Author: Ankit
 * Date: 31-jul-2014
 * Description: This page will be displayed when sales person or reseller click on the Vouchers menu option
 * 				
 */
?>

<div id="VoucherTab" align="center" class="tabDiV" style="display: none;float: left;margin-top:10px">

	<table id="VoucherTable" class="convertTojqGrid ui-grid-Font" url="Structures/ppuGridData.php?data=1" colNames=", , Voucher ID, Amount($), Type, Status, Generated On, Validity End Date, Generated By, Used By, User Notes, Assigned To, " colModel="voucherColModel" sortBy="voucherIndex" gridComplete="voucherColModelFormatterFunction"></table>
	<div id="gridpager_VoucherTable"></div>
	<script src="../js/VoucherTable.js" type="text/javascript"></script>
	<script src="../js/InvoiceGeneration.js" type="text/javascript"></script>

	<div id="addNewVoucherButton" class="minimumMargins">
		<button type="button" class="mediumButton" title="Click to add new voucher" id="jqgridaddvoucherbutton">Add</button>
    </div>    
    <div id="NewVoucherdiv" style="display:none;float: left; width:100%" align="center">
        <table class="column1_MyTable">
            <tr>
                <td align="right">Voucher Type</td>
                <td>
                    <div title='<?php echo TITLE21 ;?>' id="voucherType"></div>
                </td>
            </tr>
            <tr>
                <td align="right">Amount</td>
                <td>
                    <input class="mediumInputBox" title = '<?php echo TITLE22 ;?>'  type="text" id="voucherAmount" name="voucherAmount" maxlength="8"/><div id="fixedVoucher" style="height:'14px'; padding:9px; display:none"><?php echo $demoAmount ;?></div>
                </td>
            </tr>
<!--        <tr>
                <td>
                    Validity Start date &nbsp;&nbsp;
                </td>
                <td>
                    <div id="voucherStart" style="float: left"></div>
                </td>
            </tr>  -->
            <tr>
                <td align="right">Voucher Expiry</td>
                <td>
                    <div title = '<?php echo TITLE23 ;?>' id="voucherEnd" style="float:left"></div>
                </td>
            </tr>
            <tr>
            	<td align="right">Notes</td>
            	<td rowspan="5">
            		<textarea maxlength="150" title='<?php echo TITLE24 ;?>' class="textAreaBox" style="resize:none;width:175px" id="voucherNotes"></textarea>
            	</td>
            </tr>
        </table>        
        <div align="center" style="position:absolute; bottom:10; margin-left:22%">
            <button class="mediumButton" id="generateVoucher" type="button" onclick="GenerateVoucher();">Generate</button>
            <button class="mediumButton" id="cancelVoucherGenerate" type="button">Cancel</button>
        </div>
	</div>
	<div id="CancelVoucherDiv" style="display: none; float: left; width:100%" align="center">
		<span style="font-size:14px; font-style:Arial">Are you sure you want to cancel this voucher ?</span><br /><br />
	    <button id="YesButton" class="mediumButton" type="button" onclick="cancelVoucher();">Yes</button>
	    <button id="NoButton" class="mediumButton" type="button">No</button>
 	</div>
</div>
<script type="text/javascript" src="../js/GenerateVoucher.js" ></script>