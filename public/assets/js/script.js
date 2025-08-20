var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});

function updateTimer() {
  future = '1691708220712';
  now = new Date().getTime();
  diff = future - now;

  days = Math.floor(diff / (1000 * 60 * 60 * 24));
  hours = Math.floor(diff / (1000 * 60 * 60));
  mins = Math.floor(diff / (1000 * 60));
  secs = Math.floor(diff / 1000);

  d = days;
  h = hours - days * 24;
  m = mins - hours * 60;
  s = secs - mins * 60;

  document.getElementById("timer")
      .innerHTML =
      '<div>' + d + '<span>روز</span></div>' +
      '<div>' + h + '<span>ساعت</span></div>' +
      '<div>' + m + '<span>دقیقه</span></div>' +
      '<div>' + s + '<span>ثانیه</span></div>';
}
// setInterval('updateTimer()', 1000);

var i = 0,
    a = 0,
    isBackspacing = false,
    isParagraph = false;

// Typerwrite text content. Use a pipe to indicate the start of the second line "|".  
var textArray = [
  "What do you call an alligator wearing a vest?|An Investigator", 
  "What do you call a fake noodle?|An Impasta", 
  "Why shouldn't you write with a broken pencil?|Because it's pointless",
  "Why couldn't the pirate finish the alphabet?|He kept getting lost a C",
  "What's brown and sticky?|A stick",
  "What starts with an E, ends with an E and has one letter in it?|An Envelope",
  "What has four wheels, and flies?|A Garbage truck",
  "What do you call a pig that knows Karate?|Pork Chop",
  "Why did the scarecrow get promoted?|He was out standing in his field.",
  "I have a step ladder|I never knew my real ladder.",
  "What kind of shoes do ninjas wear?|Sneakers"
];

$(window).scroll(function() {
  if ($(this).scrollTop() > 60) {
    $('header').addClass('scrolled');
  } else {
    $('header').removeClass('scrolled');
  }
});