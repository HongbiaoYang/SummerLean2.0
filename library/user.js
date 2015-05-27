// JavaScript Document
function checkAddUserForm()
{
	with (window.document.frmAddUser) {
		
		if (isEmpty(txtEmail, 'Enter Email!')) {
			return;
		} else if (isEmpty(txtPassword, 'Enter password')) {
			return;
		} else if (isEmpty(txtFname, 'Enter First name')) {
			return;
		} else if (isEmpty(txtLname, 'Enter Last name')) {
			return;
		} else if (isEmpty(txtFullname, 'Enter Full name')) {
			return;
		} else if (isEmpty(cname, 'Enter Your Country Name')) {
			return;
		} else if (isEmpty(dob, 'Enter Date of Birth')) {
			return;
		} else if (isEmpty(sem, 'Enter Your Semester')) {
			return;
		} else if (isEmpty(univ, 'Enter Your University')) {
			return;
		} else if (isEmpty(maj, 'Enter Your Major')) {
			return;
		} else if (isEmpty(gpa, 'Enter Your GPA')) {
			return;					
		} else if (isNaN(gpa.value) || (gpa.value > 4.0) || gpa.value < 0.0) {			
			alert('GPA should be a numnber between 0.0 and 4.0');
		  return;
		} else if (isEmpty(choice1, 'Choose Your 1st Project')) {
			return;						
		} else if (isEmpty(choice2, 'Choose Your 2nd Project')) {
			return;	
		} else if (isEmpty(choice3, 'Choose Your 3rd Project')) {
			return;	
		} else if (isEmpty(choice4, 'Choose Your 4th Project')) {
			return;	
		}else {
			submit();
		}
	}
}

function checkPassword()
{
	with (window.document.frmAddUser) {

		if (newpass1.value == newpass2.value) {
			submit();
		}
		else {
			alert('Two passwords does not match!');
			return;
		}
		
	}
}

function showPic(e,sUrl){ 
    var x,y; 
    x = e.clientX; 
    y = e.clientY; 
    document.getElementById("Layer1").style.left = x+2+'px'; 
    document.getElementById("Layer1").style.top = y+2+'px'; 
    document.getElementById("Layer1").innerHTML = "<img border='0' src=\"" + sUrl + "\">"; 
    document.getElementById("Layer1").style.display = ""; 
} 

function hiddenPic(){ 
    document.getElementById("Layer1").innerHTML = ""; 
    document.getElementById("Layer1").style.display = "none"; 
} 

function changeColor(newColor) {
    var elem = document.getElementById("para1");
    elem.style.color = newColor;
}

function verifyName()
{
  
   var r = confirm("Are you absolutely SURE your Name on Certificate is correct?");
    if (r == true) {
        alert('You have just authorized your Name on Certificate!');
        return true;
    } else {
        alert('You can still modify your name and verify again!');
        return false;
    } 
}

function toggle(thisname) {
 tr=document.getElementsByTagName('tr')
 for (i=0;i<tr.length;i++){
  if (tr[i].getAttribute(thisname)){
   if ( tr[i].style.display=='none' ){
     tr[i].style.display = '';
   }
   else {
    tr[i].style.display = 'none';
   }
  }
 } 
 
 if (thisname == 'nameit')
 {
    span=document.getElementById('hid1');
 }
 else if (thisname == 'nameit2')
 {
    span=document.getElementById('hid2');
 }
 else if (thisname == 'nameit3')
 {
    span=document.getElementById('hid3');
 }
 else if (thisname == 'nameit4')
 {
    span=document.getElementById('hid4');
 }

 if (span.getAttribute("hide") == 0)
 {
    span.innerHTML = "<font size=\"3\" color=\"blue\"><u>Show</u></font></span>";
    span.setAttribute("hide", 1);
 }
 else 
 {
    span.innerHTML = "<font size=\"3\" color=\"blue\"><u>Hide</u></font></span>";
    span.setAttribute("hide", 0);
 }   
    
 
} 


function changefullname()
{
	with (window.document.frmAddUser) {

	  if (isEmpty(oldpass, 'Enter Password!')) {
	    return;
	  } else if (isEmpty(newname, 'Name cannot be empty!')) {
	    return;
	  } else {
			submit();
		}
		
	}
}

function addUser()
{
	window.location.href = 'view.php?v=adduser';
}

function editUser(id)
{
	window.location.href = 'user/index.php?view=edit&id=' + id;
	//alert(id);
}

function deleteUser(userId)
{
	if (confirm('Delete this user?')) {
		window.location.href = 'user/processUser.php?action=delete&userId=' + userId;
	}
}

