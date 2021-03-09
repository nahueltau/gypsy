let rotateColors = (colorshow, color1=null,color2=null,color3=null)=>{
   let colorToDisplay = document.querySelectorAll(`.${colorshow}-display-img`);
   let colorToHide1;
   let colorToHide2;
   let colorToHide3;
   
   if(color1!==null){
   colorToHide1 = document.querySelectorAll(`.${color1}-display-img`);
   colorToHide1.forEach(element => {
    element.style = "display:none;";
    });
   }
   if(color2!==null){
   colorToHide2 = document.querySelectorAll(`.${color2}-display-img`);
   colorToHide2.forEach(element => {
    element.style = "display:none;";
    });
   }
   if(color3!==null){
   colorToHide3 = document.querySelectorAll(`.${color3}-display-img`);
   colorToHide3.forEach(element => {
    element.style = "display:none;";
    });
   }
   colorToDisplay.forEach(element => {
       element.style = "display: inline;";
   });
   
  
}
let getView = (e,currentColor)=>{
    let targetElement = document.querySelector(`.current-view.${currentColor}-display-img`);
    let newSrc =  e.target.src;
    targetElement.src = newSrc;
}

let arrowView = [0,-200,-100];
let arrowGetView = (dir)=>{

    let sourceArray = document.querySelectorAll(`.img-thumb`);
    console.log(sourceArray)
    if(dir===0){
        let value = arrowView.pop();
        arrowView.unshift(value);
        for(let i = 0;i<sourceArray.length;i++){
            sourceArray[i].style.left=arrowView[i]+"%";
        }
    }
    
    if(dir===1){
        let value = arrowView.shift();
        arrowView.push(value);
        for(let i = 0;i<sourceArray.length;i++){
            sourceArray[i].style.left=arrowView[i]+"%";
        }
    }


}
let selectCategory = (categoria=null)=>{
    let newLocation;
    if(categoria!==null){
    newLocation = `/?categoria=${categoria}`; 
    }else{
    newLocation = "/"
    }
    window.location.replace(newLocation);
}
let goUp = ()=>{
    window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth'
      });
}