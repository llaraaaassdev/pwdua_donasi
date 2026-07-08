const hero=document.querySelector(".hero-animation");

document.addEventListener("mousemove",(e)=>{

const x=(window.innerWidth/2-e.pageX)/35;

const y=(window.innerHeight/2-e.pageY)/35;

hero.style.transform=`translate(${x}px,${y}px)`;

});