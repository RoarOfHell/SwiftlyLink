class OnUpdate extends HTMLElement {
    constructor() {
      super();
    }
  
    connectedCallback() {
        this.style.display = "none";
        var target_id = this.getAttribute("target_id");

        var elem = document.getElementById(target_id);
        if (elem) {
            const observer = new MutationObserver((mutationsList) => {
              for (let mutation of mutationsList) {
                if (mutation.type === 'attributes' || mutation.type === 'childList' || mutation.type === 'subtree') {
                  this.handleUpdate(mutation);
                }
              }
            });

            observer.observe(elem, { attributes: true, childList: true, subtree: true });

            elem.addEventListener('change', (event) => {
              this.handleUpdate(event);
            });
            this.handleUpdate({ target: elem });
          } else {
            console.warn(`Элемент с id="${target_id}" не найден`);
          }
    }

    handleUpdate(mutation) {
        AnyAction(this, mutation);
    }
  
    disconnectedCallback() {
        console.log("disconnectedCallback");
    }
  
    static get observedAttributes() {
      return [];
    }
  
    attributeChangedCallback(name, oldValue, newValue) {
        console.log("attributeChangedCallback");
    }
  
    adoptedCallback() {
        console.log("adoptedCallback");
    }
  }

  customElements.define("on-update", OnUpdate);


function SetVisible(self, updatedObject) {
    var target_value = self.getAttribute("value");
    
    if(updatedObject.target.value == target_value){
        self.parentElement.classList.remove("collapse");
    }
    else{
        self.parentElement.classList.add("collapse");
    }
}

function SetCollapse(self, updatedObject) {
  var target_value = self.getAttribute("value");
    
  if(updatedObject.target.value == target_value){
    self.parentElement.classList.add("collapse");
  }
  else{
    self.parentElement.classList.remove("collapse");
  }
}

function AnyAction(self, updatedObject) {
    var action = self.getAttribute("action");

    switch (action) {
        case "visible":
            SetVisible(self, updatedObject);
            break;
        case "collapse":
            SetCollapse(self, updatedObject);
            break;
    
        default:
            break;
    }
}