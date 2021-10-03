var myArgs = process.argv;
var weblink = myArgs[2]; 
var image_name = myArgs[3]; 
var upload_path = myArgs[4]; 

const puppeteer = require("puppeteer");

// we're using async/await - so we need an async function, that we can run
const run = async () => {
  // open the browser and prepare a page
  const browser = await puppeteer.launch()
  const page = await browser.newPage()

  // set the size of the viewport, so our screenshot will have the desired size
  await page.setViewport({
      width: 1280,
      height: 800
  })

  await page.goto(weblink)
  await page.screenshot({
      path: upload_path+"/"+image_name,
      fullPage: true
  })

  // close the browser 
  await browser.close();
};

// run the async function
if(run()){
  console.log("success");
}else{
  console.log("failed");
}