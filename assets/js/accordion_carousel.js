let acc = Array.from(document.querySelectorAll(".accordion"));
let car = Array.from(document.querySelectorAll(".carousel"));
let panels = document.getElementsByClassName("panel");
let touchstartX = 0;
let touchstartY = 0;
let touchendX = 0;
let touchendY = 0;

////////////////////////////////////////
///           Add Listeners          ///
////////////////////////////////////////
/// Button listeners for carrousel and accordion
var i;
for (i = 0; i < car.length; i++) {
  acc[i].setAttribute('data-img-number', i);
  acc[i].addEventListener("click", function() {
    ListenerFunction(this);
  });
  
  car[i].setAttribute('data-img-number', i);
  car[i].addEventListener("click", function() {
    ListenerFunction(this);
  });
}
/// Gesture Listeners for carrousel and accordion on mobile
const gestureZone = document.getElementsByClassName('accordion-grandparent')[0];
gestureZone.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
    touchstartY = event.changedTouches[0].screenY;
}, false);
gestureZone.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    touchendY = event.changedTouches[0].screenY;
    handleGesture(touchstartX, touchstartY, touchendX, touchendY)
}, false); 
/// Listener to handle height of carrousel on mobile. Executed once on load.
handleCarouselHeight();
window.addEventListener('resize', () => {
  handleCarouselHeight();
});

function ListenerFunction(button){
  let isAccordeon = button.classList.contains("accordion") ? true:false;
  let imgNumber = Number(button.getAttribute('data-img-number'));

  if(imgNumber < panels.length){     
      let isOpen = panels[imgNumber].classList.contains("open-panel") === true;
      /// If panel is not already open we open it.
      if(!isOpen){
        OpenClosePanel(imgNumber, isAccordeon, true)
      }/// If type accordeon, to close a panel, we open its sibling (which closes the initial panel).
      else if (isAccordeon) {
        let siblingNumber = imgNumber +1;
        siblingNumber < panels.length ? OpenClosePanel(siblingNumber, isAccordeon, true) : CloseAllPanelsSafe(isAccordeon, null);

      }
  }
}
function OpenClosePanel(number, isAccordeon, activate){
  let panel = panels.item(number);
  var buttons = GetButtonsByNumber(number);

  if(activate === true){
    //We make sure all other panels are closed
    CloseAllPanelsSafe(isAccordeon, panel);
    panel.style.maxWidth = "100%";
    panel.style.width = "100vw";
    panel.classList.add("open-panel");
    buttons.forEach(function(button) {
      button.classList.add("active");
      button.style.fontSize = "1.5em"; 
    });

  }else {
    panel.style.maxWidth = null;
    panel.style.width = "";
    buttons.forEach(function(button) {
      button.classList.remove("active");
      button.style.fontSize = ""; 
    });
    panel.classList.remove("open-panel");
  }
}
function CloseAllPanelsSafe(isAccordeon, excludePanel){
      //We make sure all other panels are closed
      for (let i = 0; i < panels.length; i++) {
        if(panels[i] != excludePanel && panels[i].classList.contains("open-panel") ){
          OpenClosePanel(i, isAccordeon, false, null)
        }
      }
}
function GetButtonsByNumber(number){
  let result = document.querySelectorAll('[data-img-number="'+ number +'"]');
  return result;
}

function handleGesture(touchstartX, touchstartY, touchendX, touchendY) {
    const delx = touchendX - touchstartX;
    const dely = touchendY - touchstartY;
    if(Math.abs(delx) > Math.abs(dely)){
        let activePanelNum = Number(document.querySelector(".carousel.active").getAttribute('data-img-number'));
        if(delx > 0){
          // swipe from the left of screen to the right
          panelToOpen = activePanelNum - 1;
          if(panelToOpen < panels.length && panelToOpen >= 0){
            OpenClosePanel(panelToOpen, false, true, null)
          }
        }else{ 
          panelToOpen = activePanelNum + 1;
          if(panelToOpen < panels.length && panelToOpen >= 0){
            OpenClosePanel(panelToOpen, false, true, null)
          }
        }
    }
}


function handleCarouselHeight(){
  let vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--bugs-vh', `${vh}px`);
}