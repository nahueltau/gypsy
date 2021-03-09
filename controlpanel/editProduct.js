/* COLOR INPUT */
let numberOfColorInputs = document.getElementById("colornumber");
let colorInputContainer = document.getElementById("colorinputs");
let imgInputContainer = document.getElementById("imginputs");
let createColorInput = (index)=>{
    let currentNameID = `colorname${index}`;
    let currentColorID = `color${index}`;
    /* Creating elements */
    let container = document.createElement("div");
    let p = document.createElement("p");
    let label =  document.createElement("label");
    let inputName = document.createElement("input");
    let inputColor = document.createElement("input");
    /* Label setup */
    label.for = currentNameID;
    /* Title setup */
    p.innerHTML = `Color Name ${index}`;
    /* Input name setup */
    inputName.name = currentNameID;
    inputName.id = currentNameID;
    inputName.type = "text";
    inputName.required = true;
    /* Input color setup */
    inputColor.name = currentColorID;
    inputColor.id = currentColorID;
    inputColor.type = "color";
    /* Appends */
    label.appendChild(p);
    label.appendChild(inputName);
    container.appendChild(label);
    container.appendChild(inputColor);
    return container;
}
let createImgInput = (index) =>{
    /* Creating elements */
    let container = document.createElement("div");
    let inputsContainer = document.createElement("div");
    let title = document.createElement("h5");
    /* Creating 4 Image inputs */
    for(let i = 1; i<=4;i++){
        let label = document.createElement("label");
        let input = document.createElement("input");
        let p = document.createElement("p");
        label.for=`image${i}color${index}`;
        switch(i){
            case 1:
                p.innerHTML = `Image Front`;
                break;
            case 2:
                p.innerHTML = `Image Back`;
                break;
            case 3:
                p.innerHTML = `Image Side`;
                break;
            case 4:
                p.innerHTML = `Image Extra`;
                break;

        }
        input.type = "file";
        input.id=`image${i}color${index}`;
        input.name= `image${i}color${index}`;
        label.appendChild(p);
        label.appendChild(input);
        inputsContainer.appendChild(label);
    }
    /* Creating multiple color sets */
    title.innerHTML = `Images for color ${index}`;
    container.appendChild(title);
    container.appendChild(inputsContainer);
    return container;
}


numberOfColorInputs.addEventListener("change",()=>{
    let numberOfColors = numberOfColorInputs.value;
    let currentNumberOfInputs = colorInputContainer.childElementCount;
    if(currentNumberOfInputs>numberOfColors){
        let childs = document.querySelectorAll("#colorinputs div");
        let imgsChilds = document.querySelectorAll("#imginputs>div");
        colorInputContainer.removeChild(childs[numberOfColors]);
        imgInputContainer.removeChild(imgsChilds[numberOfColors]);
    }else if(currentNumberOfInputs<numberOfColors){
        let i = numberOfColors;
        while(i<=numberOfColors){
            let newColorInput = createColorInput(i);
            let newImgInput = createImgInput(i);
            colorInputContainer.appendChild(newColorInput);
           imgInputContainer.appendChild(newImgInput);
            i++;
        }
    }       
})
