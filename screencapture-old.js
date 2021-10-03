var page = require('webpage').create();
var system = require('system');

var address = system.args[1]; 
var image_name = system.args[2]; 
console.log("URL: "+address);
page.viewportSize = {
  width: "1440",
  height: "767"
};

// HTML Code 

function onPageReady() {
  console.log("trigger page ready");
  var htmlContent = page.evaluate(function () {
      return document.documentElement.outerHTML;
  });

  // console.log(htmlContent);

  phantom.exit();
}


// Page Capture code

page.open(address, function (status) {
  function checkReadyState() {
      setTimeout(function () {
          console.log("trigger page ready");
          var readyState = page.evaluate(function () {
              return document.readyState;
          });
          
          if("complete" === readyState) {
              onPageReady();
          } else {
              checkReadyState();
          }
      });
  }

  checkReadyState();
});

// page.open(address, function () {
//   window.setTimeout(function () {
      

//       page.render("public/uploads/screen-capture/"+image_name);
//       phantom.exit();
//   }, 3000);
// }); 





var requestsArray = [];

page.onResourceRequested = function(requestData, networkRequest) {
  requestsArray.push(requestData.id);
};

page.onResourceReceived = function(response) {
  var index = requestsArray.indexOf(response.id);
  if (index > -1 && response.stage === 'end') {
    requestsArray.splice(index, 1);
  }
};

page.open(address, function(status) {

  var interval = setInterval(function () {

    if (requestsArray.length === 0) {

      clearInterval(interval);
      // var content = page.content;
      // console.log(content);
      page.render("public/uploads/screen-capture/"+image_name);
      phantom.exit();
    }
  }, 5000);
});




// "use strict";
// function waitFor(testFx, onReady, timeOutMillis) {
//     var maxtimeOutMillis = timeOutMillis ? timeOutMillis : 3000, //< Default Max Timout is 3s
//         start = new Date().getTime(),
//         condition = false,
//         interval = setInterval(function() {
//             if ( (new Date().getTime() - start < maxtimeOutMillis) && !condition ) {
//                 // If not time-out yet and condition not yet fulfilled
//                 condition = (typeof(testFx) === "string" ? eval(testFx) : testFx()); //< defensive code
//             } else {
//                 if(!condition) {
//                     // If condition still not fulfilled (timeout but condition is 'false')
//                     console.log("'waitFor()' timeout");
//                     phantom.exit(1);
//                 } else {
//                     // Condition fulfilled (timeout and/or condition is 'true')
//                     console.log("'waitFor()' finished in " + (new Date().getTime() - start) + "ms.");
//                     typeof(onReady) === "string" ? eval(onReady) : onReady(); //< Do what it's supposed to do once the condition is fulfilled
//                     clearInterval(interval); //< Stop this interval
//                 }
//             }
//         }, 250); //< repeat check every 250ms
// };


// var page = require('webpage').create();

// // Open Twitter on 'sencha' profile and, onPageLoad, do...
// page.open(address, function (status) {
//     // Check for page load success
//     if (status !== "success") {
//         console.log("Unable to access network");
//     } else {
//         // Wait for 'signin-dropdown' to be visible
//         waitFor(function() {
//             // Check in the page if a specific element is now visible
//             return page.evaluate(function() {
//                 return $("#signin-dropdown").is(":visible");
//             });
//         }, function() {
//            console.log("The sign-in dialog should be visible now.");
//            phantom.exit();
//         });
//     }
// });