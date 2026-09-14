// Teachable Machine
// The Coding Train / Daniel Shiffman
// https://thecodingtrain.com/TeachableMachine/1-teachable-machine.html
// https://editor.p5js.org/codingtrain/sketches/PoZXqbu4v

let video;
let label = "waiting...";
let classifier;
let modelURL = 'https://teachablemachine.withgoogle.com/models/IdhCetPUq/';

// Add variables for your images
let imgMonkey;
let imgApple;
let imgBlack;

// STEP 1: Load the model!
function preload() {
  classifier = ml5.imageClassifier(modelURL + 'model.json');
  
  // Replace these URLs with your actual image paths or links
  imgMonkey = loadImage('images/monkey.png'); 
  imgApple = loadImage('images/apple.png');
  imgBlack = loadImage('images/black.png');
}


function setup() {
  createCanvas(640, 520);
  // Create the video
  video = createCapture(VIDEO);
  video.hide();
  // STEP 2: Start classifying
  classifyVideo();
}

// STEP 2 classify the video!
function classifyVideo() {
  classifier.classify(video, gotResults);
}

function draw() {
  background(0);
  image(video, 0, 0);

  // Determine which image to show based on the label
  if (label == "monkey") {
    image(imgMonkey, width / 2 - 100, height / 2 - 100, 200, 200);
  } else if (label == "black") {
    image(imgBlack, width / 2 - 100, height / 2 - 100, 200, 200);
  } else if (label == "apple") {
    image(imgApple, width / 2 - 100, height / 2 - 100, 200, 200);
  }

  // Draw the text label at the bottom for reference
  textSize(32);
  textAlign(CENTER, CENTER);
  fill(255);
  text(label, width / 2, height - 16);
}

// STEP 3: Get the classification!
function gotResults(error, results) {
  // Something went wrong!
  if (error) {
    console.error(error);
    return;
  }
  // Store the label and classify again!
  label = results[0].label;
  classifyVideo();
}
