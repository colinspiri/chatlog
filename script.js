"use strict"

function sendQuery(filename, elements) {
  let url = filename + "?"
  for(let i = 0; i < elements.length; i++) {
    if(i != 0) url += "&";
    url += elements[i] + "=" + document.getElementById(elements[i]).value;
  }
  console.log("Query sent to", url);
  httpGetAsync(url, showResults);
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
