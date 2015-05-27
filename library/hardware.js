// JavaScript Document
function checkHardwareForm()
{
	with (window.document.frmAddUser) {
		if (isEmpty(txtCategory, 'Choose a Category')) {
			return;
		}
		  else if (isEmpty(txtQty, 'Enter Product Size')) {
			return;
		} else if (isEmpty(txtUnit, 'Enter Size Unit')) {
			return;
		} else if (isEmpty(txtPrice, 'Enter Product Price')) {
			return;
		} else {
			submit();
		}
	}
}

function addHardware()
{
	//alert('addHardware');
	window.location.href = 'view.php?v=addhardware';
}

function changePassword(userId)
{
	window.location.href = 'index.php?view=modify&userId=' + userId;
}

function deleteHw(id)
{
	if (confirm('Delete this Hardware?')) {
		window.location.href = 'hardware/processHardware.php?action=delete&id=' + id;
	}
}

