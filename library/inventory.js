// JavaScript Document
function checkInventory()
{
	with (window.document.frmAddUser) {
		if (isEmpty(txtCategory, 'Choose a Category')) {
			return;
		} else {
			submit();
		}
	}
}

function checkAvailable(maxAmt)
{
	
	
	with (window.document.frmAddUser) {
		var vamount = amount.value;
		var trueMax = parseFloat(maxAmt.split('-')[1]);
		
		// alert('vamount='+vamount + " maxAmt="+trueMax + " amount=" + amount);
		
		if (isEmpty(txtCategory, 'Choose a Category')) {
			return;
		} else if (vamount == '') {
			alert('Input the Amount');
			return;
		} else if (vamount > trueMax) {
			alert('Invalid: Exceed the Maximum inventory!');
			return;
		} else {
			submit();
		}
	}
}

/*
function testfunc1(inp1, inp2)
{
	echo $inp1;
}
*/

function Replenish()
{
	//alert('addHardware');
	window.location.href = 'view.php?v=addinventory';
	
}

function SendOrder(isEmpty)
{

	with (window.document.frmAddUser)
	{	
		if (isEmpty == 1)
		{
			alert('The list is empty currently!');
			
			return;
		}
		submit();
	}
}

function ConfirmOrder(sumPrice)
{
	with (window.document.frmAddUser)
	{
		alert('Are you sure to submit the order?\n------------Total: $'+sumPrice+'------------');
		submit();
	}
}

function BacktoList()
{

	// alert('head back?');
	window.location.href = 'index.php';

}

function refineResult()
{
	window.location.href = 'menu.php?v=HISTORYORDER';
}


function HistoryOrder()
{
	window.location.href = 'menu.php?v=HISTORYORDER';
	// window.location.href = 'shoplist/history.php';
}


function Consume()
{
	// alert('consume!');
	window.location.href = 'view.php?v=consumeinventory';
}

function BatchConsume()
{
	$var = $.get("ajaxBatch.php");	
	
	$varText = $var.responseText;
	alert("empty?1"+ $varText +"end");	

	window.location.href = 'menu.php?v=INVR';
}



function deleteHw(id)
{
	if (confirm('Delete this Hardware?')) {
		window.location.href = 'inventory/processInventory.php?action=delete&id=' + id;
	}
}

