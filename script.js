"use strict"

// Note to Maunu: this method used to do stuff, but then I discovered the "required" keyword for html forms; I've just left it here for your enjoyment, but it doesn't ever get called
function validateInput(elements) {
  for(let i = 0; i < elements.length; i++) {
    let field = elements[i];
    let entry = document.getElementById(field).value
    if(entry == "") {
      let errorHTML = "<h2> Input not recognized. Field left blank. </h2>";
      showResults(errorHTML);
      return false;
    }
  }
  return true;
}

function sendQuery(formID, filename, elements) {
  // See note on line 3
  // let valid = validateInput(elements);
  // if(!valid) return;

  let url = filename + "?"
  for(let i = 0; i < elements.length; i++) {
    if(i != 0) url += "&";
    let key = elements[i];
    url += key + "=" + document.getElementById(key).value;
  }
  httpGetAsync(url, showResults);
  console.log("Query sent to", url);
  document.getElementById(formID).reset();
}

function httpGetAsync(theUrl, callbackFunctionWhenPageLoaded) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
            callbackFunctionWhenPageLoaded(xmlHttp.responseText);
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}

function showResults(content) {
  document.getElementById("reportArea").innerHTML = content;
}
