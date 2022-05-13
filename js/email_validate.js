
/*highlight Text*/
function doHighlight(bodyText, searchTerm, highlightStartTag, highlightEndTag) 
{
  // the highlightStartTag and highlightEndTag parameters are optional
  if ((!highlightStartTag) || (!highlightEndTag)) {
    highlightStartTag = "<font style='color:blue; background-color:yellow;'>";
    highlightEndTag = "</font>";
  }
  
  // find all occurences of the search term in the given text,
  // and add some "highlight" tags to them (we're not using a
  // regular expression search, because we want to filter out
  // matches that occur within HTML tags and script blocks, so
  // we have to do a little extra validation)
  var newText = "";
  var i = -1;
  var lcSearchTerm = searchTerm.toLowerCase();
  var lcBodyText = bodyText.toLowerCase();
    
  while (bodyText.length > 0) {
    i = lcBodyText.indexOf(lcSearchTerm, i+1);
    if (i < 0) {
      newText += bodyText;
      bodyText = "";
    } else {
      // skip anything inside an HTML tag
      if (bodyText.lastIndexOf(">", i) >= bodyText.lastIndexOf("<", i)) {
        // skip anything inside a <script> block
        if (lcBodyText.lastIndexOf("/script>", i) >= lcBodyText.lastIndexOf("<script", i)) {
          newText += bodyText.substring(0, i) + highlightStartTag + bodyText.substr(i, searchTerm.length) + highlightEndTag;
          bodyText = bodyText.substr(i + searchTerm.length);
          lcBodyText = bodyText.toLowerCase();
          i = -1;
        }
      }
    }
  }
  
  return newText;
}


function highlightSearchTerms(searchText, treatAsPhrase, warnOnFailure, highlightStartTag, highlightEndTag)
{
  // if the treatAsPhrase parameter is true, then we should search for 
  // the entire phrase that was entered; otherwise, we will split the
  // search string so that each word is searched for and highlighted
  // individually
  if (treatAsPhrase) {
    searchArray = [searchText];
  } else {
    searchArray = searchText.split(" ");
  }
  
  if (!document.myform.mailaddresses || typeof(document.myform.mailaddresses.value) == "undefined") {
    if (warnOnFailure) {
      alert("Sorry, for some reason the text of this page is unavailable. Searching will not work.");
    }
    return false;
  }
  
  var bodyText = document.myform.mailaddresses.value;
  for (var i = 0; i < searchArray.length; i++) {
    bodyText = doHighlight(bodyText, searchArray[i], highlightStartTag, highlightEndTag);
  }
  //alert(document.myform.mailaddresses.value);
  
  document.myform.mailaddresses.innerHTML = bodyText;
  alert(bodyText);
  return true;
}

/*end highlight function*/


function validate(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   return reg.test(email);
}

function trim(str){
	var	str = str.replace(/^\s\s*/,''),
		ws = /\s/,
		i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

function checkAll(){
	var status = true;
	var i = 0;
	highlightStartTag = "<font style='color:green; background-color:pink;'>";
    highlightEndTag = "</font>";
	var emails = document.myform.mailaddresses.value.split(",");
	for(i=0; i<emails.length; i++){
		if(!validate(trim(emails[i]))){			
			alert("Incorrect format: "+emails[i]);
			status = false;
			//highlightSearchTerms(emails[i], true, false, highlightStartTag, highlightEndTag);
			//return false;
			break;
		}
	}
	
	if(status){
		if(!validate(document.myform.sender.value))
		{
			alert("Enter your email address.");
			document.myform.sender.focus();
			status = false;	
		}
		//alert("List validated, "+i+" emails found");
		//return true;
	}
//	else
		return status;
}

function replaceCharacters() {
  //alert(document.myform.mailaddresses.value);
  var origString = document.myform.mailaddresses.value;
  var inChar = ';';
  var outChar = ',';
  var newString = origString.split(inChar);
  newString = newString.join(outChar);
  document.myform.mailaddresses.value = newString;
}
