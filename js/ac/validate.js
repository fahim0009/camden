// JavaScript Document

 function forgot_pwd() {
 	window.open('/camden/signin/forgotpwd.php','ForgotPassword','width=500,height=250');
 }
 function verify_login() {
		if(document.lfrm.email.value.length==0) {
			alert("Please enter Email");
			document.lfrm.email.focus();
			return false;
			
		}
		if(document.lfrm.email.value.search('@')==-1) {
			alert("Invalid Email Format");
			document.lfrm.email.focus();
			return false;
			
		}
		if(document.lfrm.email.value.lastIndexOf('.')==-1) {
			alert("Invalid Email Format");
			document.lfrm.email.focus();
			return false;
			
		}
		if(document.lfrm.pwd.value.length==0) {
			alert("Please enter password");
			document.lfrm.pwd.focus();
			return false;
			
		}
		return true;
 }