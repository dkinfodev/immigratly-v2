var page = require('webpage').create();

var system = require('system');
var address = system.args[1]; 
var image_name = system.args[2]; 
console.log(address);
page.viewportSize = {
  width: "1920",
  height: "1080"
};
// page.settings.loadImages = true;
// page.open(address);
// page.onLoadFinished = function() {
//    page.render("public/uploads/screen-capture/"+image_name);
//    phantom.exit();
// }
// page.open(address, function () {
//     window.setTimeout(function () {
//       page.render("public/uploads/screen-capture/"+image_name);
//       phantom.exit();
//   }, 10000);
// }); 
// page.open(address, function (status) {
//   if (status !== 'success') {
//       console.log('Unable to load the address!');
//       phantom.exit();
//   } else {
//       window.setTimeout(function () {
//           page.render("public/uploads/screen-capture/"+image_name);
//           phantom.exit();
//       }, 1500); // Change timeout as required to allow sufficient time 
//   }
// });


page.open(address, function (status) {
  function checkReadyState() {
      var readyState = page.evaluate(function () {
          return document.readyState;
      });
      setTimeout(function () {
          if("complete" === readyState) {
            page.render("public/uploads/screen-capture/"+image_name);
            phantom.exit();
            // window.setTimeout(function () {
                
            // }, 5000); // Change timeout as required to allow sufficient time 
          } else {
              checkReadyState();
          }
      },1500);
  }
  checkReadyState();
});